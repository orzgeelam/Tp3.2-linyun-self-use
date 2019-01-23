<?php
namespace Home\Controller;

use Common\Controller\ControllerController;
use Common\Util\Think\Page;
use Think\Verify;

/**
 * 微信前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用模块名
 */
class BaseController extends ControllerController
{
	public $member;
	public $openid;
	public $uid;
	public $userInfo;
	public $current_url;
	public $testUser;
	public $cookie_expire = 604800;

	/**
	 * 初始化方法
	 * @author jry <598821125@qq.com>
	 */
	protected function _initialize()
	{
		$this->setinfo();//设置全局uid openid
		$this->navigation();//设置用户导航地址
		//调试模式
		if (!APP_DEBUG) {
			C('SHOW_PAGE_TRACE', false);
		}
		// 系统开关
		if (!C('TOGGLE_WEB_SITE')) {
			$this->error('站点已经关闭，请稍后访问~');
		}
		if (isset($_SERVER['HTTP_REFERER'])) {
			Cookie('__forward__', $_SERVER['HTTP_REFERER']);
		}
		if (cookie('openid') != 'oRrvHs8YkeK0um5dXuKfd4Asf7_U') {
			if (get_platform() == 'weixin') {
			}
			$is_weixin = true;
		} else {
			$is_weixin = false;
		}
		if ($is_weixin) {
			//判断是否需要微信授权
			if (!in_array(strtolower(ACTION_NAME), ['auth_back'])) {
				$this->is_auth(); // 微信授权登录
			}
			//获取用户经纬度
			$jsapi = R('Home/Weixin/jsapi', [['onMenuShareAppMessage', 'onMenuShareTimeline']]);
			$this->assign('jsapi', $jsapi);
		} else {
			$this->localhost();//电脑访问微信公众号页面
		}
		// 监听行为扩展
		\Think\Hook::listen('corethink_behavior');
		$this->assign('share_conf', $this->wxshare());
		$this->assign('islogin', $this->is_login());
		$this->assign('is_weixin', is_weixin() ? '1' : '0');
		$this->assign('back_url', 'javascript:history.back(-1);');
		$this->assign('uid', $this->uid);
		$this->assign('current_url', $this->current_url);
		$this->assign('meta_title', C('WEB_SITE_TITLE'));
		$this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
		$this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
	}

	/**
	 * 设置用户导航地址
	 */
	public function navigation()
	{
		// 获取所有模块配置的用户导航
		$mod_con['status'] = 1;
		$TMPL_PARSE_STRING = C('TMPL_PARSE_STRING');
		$TMPL_PARSE_STRING += [
			'__HTML__'      => __ROOT__.'/html',
			'__HTML_CSS__'  => __ROOT__.'/html/css',
			'__HTML_JS__'   => __ROOT__.'/html/js',
			'__HTML_IMG__'  => __ROOT__.'/html/images',
			'__HTML_WEUI__' => __ROOT__.'/html/weui',
		];
		C('TMPL_PARSE_STRING', $TMPL_PARSE_STRING);
	}

	/**
	 * 设置全局uid openid
	 */
	protected function setinfo()
	{
		$openid            = cookie('openid');
		$this->openid      = $openid;
		$uid               = cookie('uid');
		$this->uid         = $uid;
		$this->current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];//获取当前链接地址
	}

	/**
	 * 判断是否登陆
	 */
	protected function is_login()
	{
		if (cookie('is_login') == "null" || !cookie('is_login')) {
			$islogin = 1;
		} else {
			$islogin = 2;
		}
		return $islogin;
	}

	/**
	 * 电脑访问微信页面使用openid
	 */
	protected function localhost()
	{
		cookie('openid', 'oRrvHs8YkeK0um5dXuKfd4Asf7_U', $this->cookie_expire); //本地调试cookie
		cookie('uid', 1, $this->cookie_expire);
	}

	/**
	 * 微信分享功能配置
	 */
	protected function wxshare()
	{
		$url = $this->current_url;
		// 分享简介
		$share_desc = C('WXWAP_CONFIG.share_desc');
		// 分享链接
		$share_link = C('share_link');
		$share_link = empty($share_link) ? $url : $share_link;
		// 分享标题
		//$share_title = C('share_title');
		$share_title = C('WXWAP_CONFIG.share_title');
		// 分享图片
		$share_image = 'http://'.$_SERVER['HTTP_HOST'].get_cover(C('WXWAP_CONFIG.share_img'));
		// 分享配置
		$share       = [
			'title'  => $share_title,
			'desc'   => $share_desc,
			'link'   => $share_link,
			'imgUrl' => $share_image,
		];
		$this->share = $share;
		return json_encode($share);
	}

	/**
	 * 用户登录检测
	 */
	protected function is_auth()
	{
		if (empty($this->openid)) {
			cookie('openid', null);
			cookie('uid', null);
			$this->wechat();
			exit;
		} else {
			return $this->uid;
		}
	}

	protected function wechat()
	{
		$cookie_time = $this->cookie_expire;
		cookie('target_url', $this->current_url, $cookie_time);
		$back_url = U('Home/Weixin/auth_back', null, false, true);
		R('Home/Weixin/auth', [$back_url, 'snsapi_userinfo']);
	}

	/**
	 * 发送短信验证码
	 */
	public function send()
	{
		if (IS_AJAX) {
			$mobile = I('mobile', '');
			$rand   = rand(100000, 999999);
			$code   = I('post.code', '');
			if ($code && !$this->check_verify($code, 1)) {
				$this->error('图形验证码不正确');
			}
		} else {
			$this->error();
		}
		$cookie_time = 60 * 15;
		cookie($mobile.'_codenum', $rand, $cookie_time);
		cookie('mobile', $mobile, $cookie_time);
		$data = sendTemplateSMS($mobile, [$rand, '5'], '396109');
		$this->ajaxReturn($data);
		exit;
	}
}
