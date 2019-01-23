<?php
namespace Common\Util;

class User
{

    private $type;
    private $member_table        = 'admin_user'; //管理员表
    private $weixin_table        = 'user'; //用户表
    private $encryption          = 'user_md5';
    private $sms_inteval         = 15; // 短信有效期 单位 分
    private $login_expire        = 7; // 登录过期天数
    private $user_model          = null;

    public function __construct($type = 'weixin')
    {
        $this->type = $type;
    }

    //__set()方法用来设置私有属性
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    //__get()方法用来获取私有属性
    public function __get($name)
    {
        return $this->$name;
    }

    // 检测登录
    public function is_login($check_field = 'uid')
    {
        if ($cookie_value = cookie($check_field)) {
            return AuthCode($cookie_value, 'DECODE');
        } else {
            return 0;
        }
    }

    // 发短信验证码
    public function sendSms($mobile)
    {
        if ($code = cookie('sms_code')) {
            $code = $code;
        } else {
            $code = rand(1000, 9999);
        }
        // $ret = TODO 自己实现发短信逻辑
        $ret = true;
        ptrace($code);
        $cookie_expire = 60 * $this->sms_inteval;
        cookie('sms_code', $code, $cookie_expire);
        return $ret;
    }

    // 检测登录表单
    public function checkLogin($data, $type = 'username')
    {
        switch ($type) {
            case 'username':
            case 'mobile_username':
                if (!isset($data['username']) || empty($data['username'])) {
                    return ['status' => 0, 'info' => '用户名不能为空'];
                }
                break;
            case 'email':
                if (!isset($data['email']) || empty($data['email'])) {
                    return ['status' => 0, 'info' => '邮箱不能为空'];
                }
                if (false == filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    return ['status' => 0, 'info' => '邮箱格式不正确'];
                }
                break;
            case 'mobile':
                if (!isset($data['mobile']) || empty($data['mobile'])) {
                    return ['status' => 0, 'info' => '手机号不能为空'];
                }
                if (!isMobileFormat($data['mobile'])) {
                    return ['status' => 0, 'info' => '手机号格式不正确'];
                }
                break;
            default:
                pubu("未支持的登录方式{$type}");
                return ['status' => 0, 'info' => '未支持的登录方式'];
                break;
        }
        if (!isset($data['password']) || empty($data['password'])) {
            return ['status' => 0, 'info' => '密码不能为空'];
        }

        if (isset($data['sms_code']) && in_array($type, ['mobile', 'mobile_username'])) {
            $sms_code = cookie('sms_code');
            if ($sms_code != $data['sms_code']) {
                return ['status' => '0', 'info' => '短信验证码不正确'];
            }
        }

        return ['status' => '1', '登录数据没有错误'];
    }

    // 登录
    public function login($data, $type = 'username')
    {
        $checkRet = $this->checkLogin($data, $type);
        if ($checkRet['status']) {
            switch ($type) {
                case 'username':
                    $username = $data['username'];
                    $where    = "`username`='{$username}'";
                    break;
                case 'mobile':
                    $mobile = $data['mobile'];
                    $where  = "`mobile`='{$mobile}'";
                    break;
                case 'email':
                    $email = $data['email'];
                    $where = "`email`='{$email}'";
                    break;
                case 'mobile_username':
                    $username = $data['username'];
                    $mobile   = $data['username'];
                    $where    = "`mobile`='{$mobile}' OR `username`='{$username}'";
                    break;
                default:
                    pubu("未支持的登录方式{$type}");
                    return ['status' => 0, 'info' => '未支持的登录方式'];
                    break;
            }
            $exist = M($this->member_table)->where($where)->find();
            if ($exist) {
                if ($exist['password'] == call_user_func($this->encryption, $data['password'])) {
                    if($exist['status']!=1){
                        return ['status' => 0, 'info' => '用户已被禁用'];
                    }else{
                        $this->after_login($exist, $type, $this->type);
                        return ['status' => 1, 'info' => '登录成功'];
                    }
                } else {
                    return ['status' => 0, 'info' => '密码不正确'];
                }
            } else {
                return ['status' => 0, 'info' => '用户不存在'];
            }
        } else {
            return $checkRet;
        }
    }

    // 注册
    public function register($data, $type = 'username')
    {
        $checkRet = $this->checkLogin($data, $type);
        if ($checkRet['status']) {
            $data['password'] = call_user_func($this->encryption, $data['password']);
            switch ($type) {
                case 'username':
                    $username = $data['username'];
                    $where    = "`username`='{$username}'";
                    break;
                case 'mobile':
                    $mobile              = $data['mobile'];
                    $data['mobile_bind'] = 1;
                    $where               = "`mobile`='{$mobile}'";
                    break;
                case 'mobile_username':
                    $username = $data['username'];
                    $mobile   = $data['mobile'];
                    $where    = "`mobile` in ('{$mobile}', '{$username}') OR `username` in ('{$mobile}', '{$username}')";
                    break;
                default:
                    pubu("未支持的注册方式{$type}");
                    return ['status' => 0, 'info' => '未支持的注册方式'];
                    break;
            }
            $exist = M($this->member_table)->where($where)->find();
            if ($exist) {
                return ['status' => 0, 'info' => '用户已经存在了'];
            }

            $data['reg_ip']      = get_client_ip();
            $data['create_time'] = time();
            $data['status']      = 1;
            try {
                $id = M($this->member_table)->add($data);
                $this->after_register($data, $id);
                return ['status' => 1, 'info' => '注册成功'];
            } catch (\Exception $e) {
                return ['status' => 0, 'info' => $e->getMessage()];
            }
        } else {
            return $checkRet;
        }
    }

    // 登录之后
    public function after_login($member, $login_type)
    {
        $expire      = 3600 * 24 * $this->login_expire;
        $model       = M($this->member_table);
        $weixin_user = M($this->weixin_table);
        if ($this->type == 'weixin') {
            if ($openid = cookie('openid')) {
                $weixin_record = $weixin_user->where("`openid`='{$openid}'")->find();
                if ($weixin_record) {
                    $weixin_user->where(['id' => $weixin_record['id']])->save(['admin_uid' => $member['id']]);
                    $weixin_user->where(['id' => ['neq', $weixin_record['id']], 'admin_uid' => $member['id']])->save(['admin_uid' => 0]);
                }
                $member['openid'] = $openid;
            }
            // cookie('openid', $openid, $expire);
        }
        if ('mobile' == $login_type) {
            cookie('mobile', $member['mobile'], $expire);
        }
        cookie('admin_uid', $member['id'], $expire);
        $member['username'] = '';
        D('Admin/user')->auto_login($member);
    }

    // 注册之后
    public function after_register($data, $newid)
    {
        $expire = 3600 * 24 * $this->login_expire;
        if ($this->type == 'weixin') {
            $openid       = cookie('openid');
            $weixin_table = M($this->weixin_table);
            // 将要更新的其他绑定解除
            $weixin_table->where(['admin_uid' => $newid])->save(['admin_uid' => 0]);
            $weixin_headimgurl = $weixin_table->where(['openid' => $openid])->getField('headimgurl');
            //同步微信表头像
            if ($weixin_headimgurl) {
                M($this->member_table)->where(['id' => $newid])->save(['headimgurl' => $weixin_headimgurl]);
            }
            $ret = false !== $weixin_table->where("openid='{$openid}'")->save(['admin_uid' => $newid]);
        }
        $data['id'] = $newid;
        D('Admin/user')->auto_login($data);
        cookie('admin_uid', $newid, $expire);
    }

    // 登出
    public function logout($check_field = 'admin_uid')
    {
        cookie($check_field, null);
        return !cookie($check_field);
    }

    /**
     * 获取用户信息
     * @param  int      $uid   用户id
     * @param  string   $field
     * @return array    用户信息
     */
    public function GetUserInfo($uid, $field = '*')
    {
        return M($this->member_table)->where(['id' => $uid])->field($field)->find();
    }

    public function GetUserModel()
    {
        if (!$this->user_model) {
            $this->user_model = M($this->member_table);
        }
        return $this->user_model;
    }
}
