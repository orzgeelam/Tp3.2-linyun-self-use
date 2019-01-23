<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;

use Common\Controller\ControllerController;
use Common\Util\Think\Page;
use Think\Verify;

/**
 * 微信前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用模块名
 *
 */
class BaseController extends ControllerController
{
    public $member;
    public $memberInfo;
    public $openid;
    public $uid;

    /**
     * 初始化方法
     *
     */
    protected function _initialize()
    {
        if (!APP_DEBUG) {
            C('SHOW_PAGE_TRACE', false);
        }

        C('SHOW_PAGE_TRACE', false);
        $this->cookie_expire = time() + 86400 * 7;

        if ($recUid = I('recUid')) {
            // 上级经销商 admin_user表的uid
            saveRecUser($recUid);
            saveURLUser($recUid);
        }

        $this->meta_title = C('WEB_SITE_TITLE');

        // debug
        cookie('openid', 'oRrvHs8YkeK0um5dXuKfd4Asf7_U', $this->cookie_expire); //本地调试cookie
        // cookie('openid', 'o9yzqsobyBU5cmn1FHmkAo9hCSwU', $this->cookie_expire); //线上调试cookie
        cookie('uid', 1, $this->cookie_expire);
        cookie('admin_uid', 1);
        // zhangyawei
        // cookie('openid', 'oJ9WswFgN5l59Eclq1YU-3sTHAPc', $this->cookie_expire); //线上调试cookie
        // cookie('admin_uid', 14);
        // cookie('uid', 56);
        // cookie('uid', 56, $this->cookie_expire);

        // cookie('openid', 'oJ9WswArhnDIcYYpv_wQTK_YoHz4', $this->cookie_expire); //线上调试cookie
        // cookie('admin_uid', 12);
        // cookie('uid', 58);
        // cookie('uid', 58, $this->cookie_expire);

        // 系统开关
        $this->assign('is_weixin', is_weixin() ? '1' : '0');
        if (!C('TOGGLE_WEB_SITE')) {
            $this->error('站点已经关闭，请稍后访问~');
        }

        $this->current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $this->assign('back_url', 'javascript:history.back(-1);');
        if (isset($_SERVER['HTTP_REFERER'])) {
            Cookie('__forward__', $_SERVER['HTTP_REFERER']);
        }
        $openid       = cookie('openid');
        $this->openid = $openid;
        $uid          = cookie('uid');
        $uid          = empty($uid) ? 0 : (int) $uid;
        $this->uid    = $uid;
        $userInfo     = M('user')->find($uid);
        if (empty($userInfo)) {
            $this->uid = 0;
            $userInfo  = [
                'id'         => 0,
                'admin_uid'  => 0,
                'user_type'  => 1,
                'avatar'     => 0,
                'headimgurl' => '',
                'mobile'     => '',
                'pay_pass'   => '',
                'recUid'     => 0,
            ];
        } else {
            $userInfo['user_type'] = 1;
        }
        $this->admin_uid = 0;
        if (!in_array(strtolower(ACTION_NAME), [
            'auth_back',
        ])) {
            $this->is_auth(); // 微信授权登录
        }
        $this->admin_uid = cookie('admin_uid') ?: 0;

        if ($this->admin_uid && isset($userInfo['admin_uid'])) {
            $admin_info = M('admin_user')->find($userInfo['admin_uid']);
            if (!$admin_info) {
                if ($userInfo['admin_uid']) {
                    $msg = "oc_user表{$uid} 对应 admin_user 用户表id为{$userInfo['admin_uid']}的记录查找不到";
                    pubu($msg);
                }
                $this->admin_uid = 0;
                // E("oc_user表{$uid} 对应 admin_user 用户表id为{$userInfo['admin_uid']}的记录查找不到");
            } else {
                if ($urlUid = cookie('urlUid')) {
                    if ($admin_info['id'] != $urlUid) {
                        M('admin_user')->where(['id' => $admin_info['id']])->save(['urlUid']);
                    }
                }
                $this->admin_uid = $userInfo['admin_uid'];
                cookie('admin_uid', $userInfo['admin_uid'], $this->cookie_expire);
                $userInfo              = $admin_info;
                $userInfo['admin_uid'] = $this->admin_uid;
            }
        } else {
            $userInfo['user_type'] = 1;
            $userInfo['pay_pass']  = '';
        }


        $userInfo['user_type'] = $userInfo['user_type'] == 1 ? 'normal' : 'beauty';
        $this->userInfo        = $userInfo;
        $this->assign('uid', $this->uid);
        $this->assign('userInfo', $this->userInfo);
        $this->assign('can_appointment', $this->userInfo['user_type'] == 'normal' ? 1 : 0);

        $score_exchange_rate       = C('SHOPPINGMALL_CONFIG.score_exchange_rate');
        $this->score_exchange_rate = $score_exchange_rate;
        $this->platform            = get_platform(); // 获取当前平台  pc、app、weixin
        $this->assign('platform', $this->platform);
        $this->assign('gl', 1);
        $this->assign('controller', CONTROLLER_NAME); //底部菜单高亮判断标志

        // 获取所有模块配置的用户导航
        $mod_con['status'] = 1;
        $TMPL_PARSE_STRING = C('TMPL_PARSE_STRING');
        $TMPL_PARSE_STRING += [
            '__HTML__'      => __ROOT__ . '/html',
            '__HTML_CSS__'  => __ROOT__ . '/html/css',
            '__HTML_JS__'   => __ROOT__ . '/html/js',
            '__HTML_IMG__'  => __ROOT__ . '/html/images',
            '__HTML_WEUI__' => __ROOT__ . '/html/weui',
            '__PUB_IMG__'  => __ROOT__ . '/Public/Home/images',
            '__PUB_JS__'  => __ROOT__ . '/Public/Home/js',
        ];
        C('TMPL_PARSE_STRING', $TMPL_PARSE_STRING);

        // 监听行为扩展
        \Think\Hook::listen('corethink_behavior');

        $this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
        $this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
        $this->assign('_home_public_layout', 'Public/layout'); // 页面公共继承模版

        if ($this->admin_uid) {
            $can_share = $this->admin_uid;
        } else {
            $can_share = 0;
        }
        $share_url = str_ireplace('.html', '', $this->current_url);
        if ($can_share) {
            $this->assign('share_url', $share_url . "/recUid/{$can_share}");
        } else {
            $this->assign('share_url', $share_url . "/recUid/0");
        }

        //非支付页面设置默认分享，上传图片页面也不默认指定分享
        // if (!in_array(strtolower(ACTION_NAME), ['confirm', 'order', 'setting'])) {
        //     // $jsapi = R('Home/Weixin/jsapi', [['onMenuShareAppMessage', 'onMenuShareTimeline']]);
        //     // $this->assign('jsapi', $jsapi);
        // } else {
        //     if (in_array(strtolower(ACTION_NAME), ['confirm', 'order'])) {
        //         $can_share = 0;
        //     }
        // }
        $this->assign('can_share', $can_share);
        $this->assign('current_nav', $this->getCurrenNav());

    }

    /**
     * 用户登录检测
     *
     */
    protected function is_auth()
    {
        // if (is_weixin()) {
        if (empty($this->openid)) {
            cookie('openid', null);
            cookie('uid', null);
            $this->wechat();
            exit;
        } else {
            return $this->uid;
        }
    }

    protected function check_login()
    {
        $admin_uid = cookie('admin_uid');
        if (!$admin_uid || !$this->admin_uid) {
            if (IS_GET) {
                cookie('before_reg', $this->current_url, $this->cookie_expire);
            }
            $this->redirect('Home/Member/login');
        }
    }

    public function wechat()
    {
        $cookie_time = $this->cookie_expire;
        cookie('target_url', $this->current_url, $cookie_time);
        $back_url = U('Home/Weixin/auth_back', null, false, true);
        R('Home/Weixin/auth', [$back_url, 'snsapi_userinfo']);
    }

    //获取当前高亮索引
    public function getCurrenNav()
    {
        $match_url = CONTROLLER_NAME . '/' . ACTION_NAME;
        $match_url = strtolower($match_url);
        switch ($match_url) {
            case 'booking/recommend':
                return 0;
                break;
            case 'booking/index':
                return 1;
                break;
            case 'index/index':
                return 2;
                break;
            default:
                return 3;
                break;
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @param $script 严格模式要求处理的纪录的uid等于当前登陆用户UID
     *
     */
    public function setStatus($model = CONTROLLER_NAME, $script = true)
    {
        $ids    = I('request.ids');
        $status = I('request.status');
        if (empty($ids)) {
            $this->error('请选择要操作的数据');
        }
        $model_primary_key       = D($model)->getPk();
        $map[$model_primary_key] = array('in', $ids);
        if ($script) {
            $map['uid'] = array('eq', is_login());
        }
        switch ($status) {
            case 'forbid': // 禁用条目
                $data = array('status' => 0);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '禁用成功', 'error' => '禁用失败')
                );
                break;
            case 'resume': // 启用条目
                $data = array('status' => 1);
                $map  = array_merge(array('status' => 0), $map);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '启用成功', 'error' => '启用失败')
                );
                break;
            case 'hide': // 隐藏条目
                $data = array('status' => 2);
                $map  = array_merge(array('status' => 1), $map);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '隐藏成功', 'error' => '隐藏失败')
                );
                break;
            case 'show': // 显示条目
                $data = array('status' => 1);
                $map  = array_merge(array('status' => 2), $map);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '显示成功', 'error' => '显示失败')
                );
                break;
            case 'recycle': // 移动至回收站
                $data['status'] = -1;
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '成功移至回收站', 'error' => '删除失败')
                );
                break;
            case 'restore': // 从回收站还原
                $data = array('status' => 1);
                $map  = array_merge(array('status' => -1), $map);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '恢复成功', 'error' => '恢复失败')
                );
                break;
            case 'delete': // 删除条目
                $result = D($model)->where($map)->delete();
                if ($result) {
                    $this->success('删除成功，不可恢复！');
                } else {
                    $this->error('删除失败');
                }
                break;
            default:
                $this->error('参数错误');
                break;
        }
    }

    /**
     * ajax分页
     * @param  mixed $result       数组或文本 数据数组或者sql
     * @param  integer $listRows     每页显示多少条
     * @param  string $listvar      遍历时的变量
     * @param  array  $parameter    数组
     * @param  string $target       目标替换容器选择器
     * @param  string $pageSelector 分页选择器
     * @param  string $template     ajax加载时的模板
     * @return mixed               数组或字符串
     */
    public function ajaxPage($result, $listRows, $listvar, $parameter = [], $target = '', $pageSelector = '', $template = '')
    {
        //总记录数
        $is_sql  = is_string($result);
        $listvar = $listvar ?: 'list';
        if ($is_sql) {
            $totalRows = M()->table($result . ' a')->count();
        } else {
            $totalRows = ($result) ? count($result) : 1;
        }
        //创建分页对象
        if ($target && $pageSelector) {
            $p = new Page($totalRows, $listRows, $parameter);
        } else {
            $p = new Page($totalRows, $listRows, $parameter);
        }

        //抽取数据
        if ($is_sql) {
            $result .= " LIMIT {$p->firstRow},{$p->listRows}";
            $voList = M()->query($result);
        } else {
            $voList = array_slice($result, $p->firstRow, $p->listRows);
        }
        //分页显示
        $page = $p->show();

        if ($target && $pageSelector && !IS_AJAX && $page) {
            $page .= <<<JS
<script>
     jQuery(function($) {
        $('{$pageSelector} a').click(function(){
            $.ajax({
                url: $(this).attr('href'),
                dataType: "html",
                type: "GET",
                cache: false,
                async:true,
                success: function(html){
                    $("{$target}").html(html);
                    return false;
                }
            });
            return false;
        });
     });
 </script>
JS;
        }
        //模板赋值
        $this->assign($listvar, $voList);
        $this->assign('pageSelector', $pageSelector);
        $this->assign("table_data_page", $page);
        //判断ajax请求
        if (IS_AJAX) {
            layout(false);
            $template = $template ?: 'ajaxlist';
            exit($this->fetch($template));
        }
        return $voList;
    }
    //前端异常
    public function front_log()
    {
        $text = I('text');
        $res  = pubu($text, 'all');
        if ($res) {
            $this->success();
        } else {
            $this->error('发送瀑布消息失败');
        }
    }

    /**
     * 检测验证码
     * @param  integer $id 验证码ID
     * @return boolean 检测结果
     */
    public function check_verify($code, $vid = 1)
    {
        $verify = new Verify();
        return $verify->check($code, $vid);
    }

    //发送短信验证码
    public function send()
    {
        if (IS_AJAX) {
            $mobile = I('mobile', '');
            $rand   = rand(1000, 9999);
            $code   = I('post.code', '');
            if ($code && !$this->check_verify($code, 1)) {
                $this->error('图形验证码不正确');
            }
        } else {
            $this->error();
        }
        $cookie_time = time() + 60 * 5;
        cookie($mobile . '_codenum', $rand, $cookie_time);
        cookie('mobile', $mobile, $cookie_time);
        ptrace('短信' . $rand);
        // ptrace($rand);
        $data = sendTemplateSMS($mobile, [$rand, '5'], '105645');
        $this->ajaxReturn($data);
        exit;
    }

    /**
     * 图片验证码生成，用于登录和注册
     *
     */
    public function verify($vid = 1)
    {
        $verify = new Verify([
            'useCurve' => false,
            'useNoise' => false,
            'fontSize' => 36,
        ]);
        $verify->length = 4;
        $verify->entry($vid);
    }

}
