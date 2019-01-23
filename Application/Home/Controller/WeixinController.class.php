<?php
namespace Home\Controller;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as EasyOrder;
use EasyWeChat\Message\News;
use Think\Controller;


class WeixinController extends Controller
{
    private $option       = []; //微信配置参数
    private $wxpay_config = [];
    private $wechat       = []; //微信配置参数

    protected function _initialize()
    {
        C('SHOW_PAGE_TRACE', false);

        $TMPL_PARSE_STRING = C('TMPL_PARSE_STRING');
        $TMPL_PARSE_STRING += [
            '__HTML__'      => __ROOT__ . '/html',
            '__HTML_CSS__'  => __ROOT__ . '/html/css',
            '__HTML_JS__'   => __ROOT__ . '/html/js',
            '__HTML_IMG__'  => __ROOT__ . '/html/images',
            '__HTML_WEUI__' => __ROOT__ . '/html/weui',
        ];
        C('TMPL_PARSE_STRING', $TMPL_PARSE_STRING);

        // $course_config = C('course_config');
        $options = [
            'debug'  => true,
            'app_id' => C('wechat_appid'),
            'secret' => C('wechat_appsecret'),
            'token'  => C('wechat_apptoken'),
            'log'    => [
                'level' => 'debug',
                'file'  => LOG_PATH . 'easywechat.log', // XXX: 绝对路径！！！！
            ],
        ];
        $this->wxpay_config =
            array_merge($options,
            [
                'payment' => [
                    'merchant_id' => C('wechat_merchant_id'),
                    'key'         => C('wechat_key'),
                ],
            ]
        );

        $this->wechat_social_config =
            array_merge([
            'wechat' => [
                'client_id'     => C('wechat_appid'),
                'client_secret' => C('wechat_appsecret'),
            ],
        ], $options
        )
        ;
        $this->options = $options;
        try {
            $this->app = new Application($options);
        } catch (\Exception $e) {
            pubu('初始化失败：' . $e->getMessage());
        }
    }

    public function run()
    {
        // exit($_GET['echostr']);
        $server = $this->app->server;
        $server->setMessageHandler(function ($message) {
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            // ptrace($message);
            if ($message->MsgType == 'event') {
                $this->openid = $message->FromUserName;
                switch (strtolower($message->Event)) {
                    case 'subscribe':
                        $userModel = M('user');
                        $has       = $userModel->where(['openid' => $this->openid])->find();
                        if (!$has) {
                            //ptrace('未关注扫码后插入用户');
                            $userService = $this->app->user;
                            try {
                                $wechat_userinfo = $userService->get($this->openid);
                                // ptrace($wechat_userinfo);
                                $nickname   = isset($wechat_userinfo['nickname']) ? $wechat_userinfo['nickname'] : '';
                                $sex        = isset($wechat_userinfo['sex']) ? $wechat_userinfo['sex'] : '';
                                $headimgurl = isset($wechat_userinfo['headimgurl']) ? $wechat_userinfo['headimgurl'] : '';
                                $data       = [
                                    'openid'     => $this->openid,
                                    'sex'        => $sex,
                                    'nickname'   => $nickname,
                                    'headimgurl' => $headimgurl,
                                    'avatar'     => 0,
                                    'recUid'     => 0,
                                    'time'       => datetime(),
                                ];
                                $newid = M('user')->add($data);
                            } catch (\exception $e) {
                                pubu("获取openid为{$this->openid}的关注用户信息失败，原因：{$e->getMessage()}");
                                return true;
                            }
                        }
                        if (!empty($message->EventKey) && false === stripos($message->EventKey, 'last_trade_no_')) {
                            $num = trim($message->EventKey, 'qrscene_');
                            return $this->after_scan($num, $this->openid);
                        }
                        return C('wechat_first_subscribe');
                        break;
                    case 'scan':
                        $num = $message->EventKey;
                        // ptrace($num);
                        return $this->after_scan($num, $this->openid);
                        break;
                    case 'click':
                        $openid = $message->FromUserName;
                        $num = $message->EventKey;
                        switch ($num) {
                            case '订单计算':
                                 $info = M('imgtext')->where(['status'=>1])->select();
                                 ptrace('info = ');
                                 ptrace($info);
                                 foreach ($info as $key => $value) {
                                    $news[] = new News([
                                        'title'       => $value['title'],
                                        'description'=> $value['describe'],
                                        'url'         => $value['url'],
                                        'image'       => C('WEB_URL').get_cover($value['pics']),
                                    ]);
                                 }
                                 
                                ptrace($news);
                                return $news;
                                break;
                                
                            default:

                                break;
                        }
                    default:
                        # code...
                        break;
                }
            } else {
                switch ($message->MsgType) {
                    case 'text':
                        if ('wechat_debug' == $message->Content) {
                            return U('/Home/Weixin/debug', [], '', true);
                        } else {
                            // return "hello, I'm wechat";
                        }
                        break;
                        // ....
                        break;
                    case 'image':
                        // ...
                        break;
                    default:
                        return "未处理的回复类型:{$message->MsgType}";
                }
            }
        });
        $response = $server->serve();
        $response->send();exit;
    }

    // 下载微信上传的图片
    public function download_img($media_id)
    {
        $temporary = $this->app->material_temporary;
        $content   = $temporary->getStream($media_id);
        $ext       = 'jpg';
        //将远程图片保存到本地
        $tmp_name = tempnam(sys_get_temp_dir(), 'weixin_avatar') . '.' . $ext;
        file_put_contents($tmp_name, $content);
        $name = date('YmdHis');
        $file = [
            'savepath' => 'picture/',
            'savename' => $name . '.' . $ext,
            'tmp_name' => $tmp_name,
        ];
        // ptrace($media_id);
        // ptrace($tmp_name);
        $url = U('Home/Upload/upload', ['dir' => 'image'], true, true);
        // ptrace($url);
        $result = D('Admin/Upload')->curlUploadFile($url, $tmp_name, 'image');
        // ptrace('调试');
        // ptrace($result);
        if ($result === false) {
            $ret = ['status' => 0, 'info' => '上传失败'];

        } else {
            $res = json_decode($result, true);
            // ptrace($res);
            if ($res['status']) {
                $ret = ['status' => 1, 'info' => '上传成功', 'id' => $res['id'], 'src' => $res['url']];
            } else {
                ptrace($result);
                ptrace($res);
                $ret = ['status' => 0, 'info' => '上传失败，返回格式不对'];
            }
        }
        $this->ajaxReturn($ret);
    }

    //扫码之后的处理
    public function after_scan($id, $openid)
    {
        if ($record = D('wxqrcode')->find($id)) {
            // ptrace($record);
            $recUid = $record['relate_id'];
        } else {
            pubu("id 为 {$id}的二维码记录缺失");
            return '二维码记录缺失';
        }
        $userInfo = M('user')->where(['openid' => $openid])->find();
        message:
        switch ($record['type']) {
            case 'admin_user':
                if ($recUid) {
                    if ($userInfo['recUid'] == 0) {
                        $ret = M('user')->where(['openid' => $openid])->save(['recUid' => $recUid]);
                    }
                }
                return '请点击菜单里的“商城”访问';
                break;
            default:
                pubu("未处理的扫码类型: {$record['type']}");
                return "未处理的扫码类型: {$record['type']}";
                break;
        }
    }

    //授权登录
    public function auth($redirect_url, $scopes = 'snsapi_userinfo')
    {
        // ptrace($redirect_url);
        $this->option          = $this->options;
        $this->option['oauth'] = [
            'scopes'   => [$scopes],
            'callback' => $redirect_url,
        ];
        // ptrace($this->option);
        try {
            $app      = new Application($this->option);
            $response = $app->oauth->redirect();
            $response->send();
        } catch (\Exception $e) {
            ptrace("授权失败." . $e->getMessage());
        }
    }

    // 授权登录后的回调页面
    public function auth_back()
    {
        $code = I('code');
        if (empty($code)) {
            $this->error('code 参数缺少');
        }

        $oauth = $this->app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user            = $oauth->user();
        $wechat_userinfo = $user->toArray();
        $wechat_userinfo = $wechat_userinfo['original'];
        // ptrace('微信授权后用户信息');
        // ptrace($wechat_userinfo);

        $openid     = $wechat_userinfo['openid'];
        $nickname   = $wechat_userinfo['nickname'];
        $sex        = $wechat_userinfo['sex'];
        $headimgurl = $wechat_userinfo['headimgurl'];
        $time       = datetime();

        if (!empty($openid)) {
            $userModel = M('user');
            $has       = $userModel->where(['openid' => $openid])->find();
            // ptrace($has);
            $data['openid']     = $openid;
            $data['headimgurl'] = $headimgurl;
            $data['time']       = $time;
            $cookie_time        = time() + 86400 * 7;

            if (empty($has)) {
                $data['avatar']   = 0;
                $data['nickname'] = $nickname;
                $data['sex']      = $sex;
                $res              = $userModel->add($data);
                // ptrace($res);
                if (!$res) {
                    ptrace($userModel->getError());
                }
                $uid = $res;
                // ptrace($userModel->_sql());
            } else {
                $res = $userModel->where(['openid' => $openid])->save($data);
                // ptrace($res);
                if ($res === false) {
                    ptrace(D('user')->getError());
                }
                $uid = $has['id'];
            }
            // ptrace("{$uid}|{$openid}");
            cookie('openid', $openid, $cookie_time);
            cookie('uid', $uid, $cookie_time);
            // ptrace(cookie('openid'));
            // ptrace(cookie('uid'));
        }

        // ptrace(cookie('target_url'));
        // session('wechat_user', $wechat_userinfo);
        $targetUrl = !cookie('target_url') ? U('Shoppingmall/index/index') : cookie('target_url');
        redirect($targetUrl);
    }

    //生成jsapi 配置
    public function jsapi($APIs, $url = '')
    {
        $js = $this->app->js;
        if ($url) {
            $js->setUrl($url);
        }
        return $js->config($APIs, $debug = false, $beta = false, $json = true);
    }

    //初始化需要支付的微信配置
    public function cert_pay_config()
    {
        $this->wxpay_config['payment']['cert_path'] = realpath('./cert/apiclient_cert.pem');
        $this->wxpay_config['payment']['key_path']  = realpath('./cert/apiclient_key.pem');
    }

    //生成二维码
    public function qrcode($code, $expire = 0)
    {
        $app    = $this->app;
        $qrcode = $app->qrcode;
        try {
            if ($expire) {
                $result        = $qrcode->temporary($code, $expire);
                $ticket        = $result->ticket; // 或者 $result['ticket']
                $expireSeconds = $result->expire_seconds; // 有效秒数
                $url           = $result->url; // 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
            } else {
                //创建永久二维码
                $result = $qrcode->forever($code); // 或者 $qrcode->forever("foo");
                $ticket = $result->ticket; // 或者 $result['ticket']
            }
            $url = $qrcode->url($ticket);
            return [
                'status' => 1,
                'info'   => '生成成功',
                'data'   => ['ticket' => $ticket, 'url' => $url],
            ];
        } catch (\Exception $e) {
            pubu("生成{$code}, 有效期为{$expire}秒的二维码失败");
            return ['status' => 0, 'info' => $e->getMessage()];
        }
    }

    //创建微信统一订单
    public function union_order($orderInfo)
    {
        // ptrace($this->wxpay_config);
        if ($orderInfo['money'] * 100 < 1) {
            ptrace($orderInfo);
            ptrace("创建订单前提失败，金额不足1分");
            return false;
        }

        $app        = new Application($this->wxpay_config);
        $order_no   = $orderInfo['ordernum'];
        $payment    = $app->payment;
        $attributes = [
            'openid'       => $orderInfo['openid'],
            'body'         => $orderInfo['body'],
            'detail'       => $orderInfo['detail'],
            'out_trade_no' => $order_no,
            // 'total_fee'    => $orderInfo['money'] * 100, //APP_DEBUG ? 1 :
            'total_fee'    => APP_DEBUG ? 1 : $orderInfo['money'] * 100, //APP_DEBUG ? 1 :
            'trade_type'   => 'JSAPI',
            'time_start'   => date('YmdHis'),
            'time_expire'  => date('YmdHis', strtotime('+1 year')),
            'notify_url'   => 'http://a.xilukeji.com/angelsbeauty/index.php/Home/Weixin/wxOrderNotify/slog_force_client_id/slog_b58071', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            // ...
        ];

        // ptrace(date('YmdHis', strtotime('+1 month')));

        $order = new EasyOrder($attributes);
        try {
            $result   = $payment->prepare($order);
            $prepayId = $result->prepay_id;
            if (!$prepayId) {
                ptrace($order);
                ptrace($attributes);
                pubu('prepayId为空');
                return false;
            }
            $json = $payment->configForPayment($prepayId);
            ptrace($json);
            return $json;
        } catch (\Exception $e) {
            pubu('创建微信订单失败');
            pubu($e->getMessage());
            D('cardcharge')->delete($orderInfo['id']);
            return false;
        }
    }

    // 查询订单
    public function wxOrderQuery($out_trade_no)
    {
        $app     = new Application($this->wxpay_config);
        $payment = $app->payment;
        $result  = $payment->query($out_trade_no);
        return $result;
    }

    //订单支付回调
    public function wxOrderNotify()
    {
        $app      = new Application($this->wxpay_config);
        $response = $app->payment->handleNotify(function ($notify, $successful) {

            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = M('shoppingmall_goodsorder')->where(['ordernum' => $notify->out_trade_no])->find();
            if (!$order) {
                // 如果订单不存在
                return 'Order not exist.';
                // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if (1 != $order['checkinfo']) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                //更新订单的状态
                $orderObj = new \Common\Util\Order('weixin', 0);
                $result   = $orderObj->ChangeOrderStatus($order['id'], 'payed', ['transaction_id' => $notify->transaction_id]);
                if ($result['status']) {
                    return true;
                } else {
                    ptrace($result);
                    return false;
                }
            } else {
                ptrace($order);
                ptrace($notify);
                ptrace($successful);
                return false;
            }
        });
        $response->send();
    }

    //发送微信
    public function send_custom($openid, $message)
    {
        // ptrace($openid);
        // ptrace('发送的消息:' . $message);
        $staff = $this->app->staff;
        try {
            $ret = $staff->message($message)->to($openid)->send();
            return $ret->errcode == 0;
        } catch (\Exception $e) {
            pubu("发送客服消息失败，失败原因{$e->getMessage()}");
            return false;
        }
    }

    // 1. 所有服务号都可以在功能->添加功能插件处看到申请模板消息功能的入口，但只有认证后的服务号才可以申请模板消息的使用权限并获得该权限；
    // 2. 需要选择公众账号服务所处的2个行业，每月可更改1次所选行业；
    // 3. 在所选择行业的模板库中选用已有的模板进行调用；
    // 4. 每个账号可以同时使用15个模板。
    // 5. 当前每个模板的日调用上限为 10 万次【2014年11月18日将接口调用频率从默认的日1万次提升为日10万次，可在MP登录后的开发者中心查看】

    /**
     * 发送模板消息
     * @author yangweijie
     * @param openid openid
     * @param $templateId
     * @param $data = array(
    "first"    => "恭喜你购买成功！",
    "keynote1" => "巧克力",
    "keynote2" => "39.8元",
    "keynote3" => "2014年9月16日",
    "remark"   => "欢迎再次购买！",
    );
     * @param $link
     * @param $color
     */
    public function send_template($openid, $templateId, $data, $link = '', $color = '')
    {
        $notice = $this->app->notice;
        if ($color) {
            $notice->color($color);
        }
        if ($link) {
            $notice->url($link);
        }
        try {
            $messageId = $notice->to($openid)->template($templateId)->data($data)->send();
            return true;
        } catch (\Exception $e) {
            pubu("给{$openid} 发送templateId为{$templateId} 数据为" . var_export($data, true) . '的微信模板消息失败，失败原因:' . $e->getMessage());
            return false;
        }
    }

    //微信cookie调试
    public function debug()
    {
        $user_list = M('user')->where(['admin_uid' => ['neq', 0]])->order('id ASC')->select();
        if ($user_list) {
            $admin_users = M('admin_user')->where(['id' => ['in', array_column($user_list, 'admin_uid')]])->getField('id,username,mobile');
        }
        foreach ($user_list as $key => $value) {
            if (isset($admin_users[$value['admin_uid']])) {
                $user_list[$key]['username'] = $admin_users[$value['admin_uid']]['username'];
                $user_list[$key]['mobile']   = $admin_users[$value['admin_uid']]['mobile'];
            } else {
                $user_list[$key]['username'] = '未知';
                $user_list[$key]['mobile']   = '空';
            }
        }
        $this->assign('user_list', $user_list);
        $this->display();
    }
}
