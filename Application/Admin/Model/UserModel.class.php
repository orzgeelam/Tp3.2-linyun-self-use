<?php
namespace Admin\Model;

use Common\Model\ModelModel;

/**
 * 用户模型
 */
class UserModel extends ModelModel
{
	/**
	 * 数据库表名
	 */
	protected $tableName = 'admin_user';
	/**
	 * 自动验证规则
	 */
	protected $_validate
		= [
			//验证用户名
			['nickname', 'require', '昵称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			//验证用户名
			['username', 'require', '用户名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			['username', '3,32', '用户名长度为1-32个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH],
			['username', '', '用户名被占用', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH],
			['username', '/^(?!_)(?!\d)(?!.*?_$)[\w]+$/', '用户名只可含有数字、字母、下划线且不以下划线开头结尾，不以数字开头！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			//验证密码
			['password', 'require', '密码不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT],
			['password', '5,30', '密码长度为6-30位', self::MUST_VALIDATE, 'length', self::MODEL_INSERT],
			// ['password', '/(?!^(\d+|[a-zA-Z]+|[~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+)$)^[\w~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+$/', '密码至少由数字、字符、特殊字符三种中的两种组成', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT],
			['repassword', 'password', '两次输入的密码不一致', self::EXISTS_VALIDATE, 'confirm', self::MODEL_UPDATE],
			// 验证注册来源
			['reg_type', 'require', '注册来源不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT],
		];
	/**
	 * 自动完成规则
	 */
	protected $_auto
		= [
			['score', '0', self::MODEL_INSERT],
			['money', '0', self::MODEL_INSERT],
			['reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1],
			['password', 'user_md5', self::MODEL_BOTH, 'function'],
			['create_time', 'time', self::MODEL_INSERT, 'function'],
			['update_time', 'time', self::MODEL_BOTH, 'function'],
			['status', '1', self::MODEL_INSERT],
		];

	/**
	 * 查找后置操作
	 */
	protected function _after_find(&$result, $options)
	{
		$result['avatar_url'] = get_cover($result['avatar'], 'avatar');
		$cert_info            = false;
		// 用户识别label
		if (D('Admin/Module')->where('name="User" and status="1"')->count()) {
			$cert_info = D('User/Cert')->isCert($result['id']);
		}
		if ($cert_info) {
			$result['label'] = $cert_info['cert_title'].'('.$result['id'];
		} else {
			$result['label'] = $result['nickname'].'('.$result['id'];
		}
		if ($result['email']) {
			$result['label'] = $result['label'].'-'.$result['email'];
		}
		$result['label'] = $result['label'].')';
	}

	/**
	 * 查找后置操作
	 */
	protected function _after_select(&$result, $options)
	{
		foreach ($result as &$record) {
			$this->_after_find($record, $options);
		}
	}

	/**
	 * 根据用户ID获取用户信息
	 * @param  integer $id 用户ID
	 * @param  string  $field
	 * @return array  用户信息
	 */
	public function getUserInfo($id = null, $field = null)
	{
		if (!$id) {
			return false;
		}
		if (D('Admin/Module')->where('name="User" and status="1"')->count()) {
			$user_info = D('User/User')->detail($id);
		} else {
			$user_info = $this->find($id);
		}
		unset($user_info['password']);
		if (!$field) {
			return $user_info;
		}
		if ($user_info[$field]) {
			return $user_info[$field];
		} else {
			return false;
		}
	}

	/**
	 * 用户登录
	 */
	public function login($username, $password, $map = null)
	{
		//去除前后空格
		$username = trim($username);
		//匹配登录方式
		if (preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $username)) {
			$map['email'] = ['eq', $username]; // 邮箱登陆
		} else if (preg_match("/^1\d{10}$/", $username)) {
			$map['mobile'] = ['eq', $username]; // 手机号登陆
		} else {
			$map['username'] = ['eq', $username]; // 用户名登陆
		}
		$map['status'] = ['eq', 1];
		$user_info     = $this->where($map)->find(); //查找用户
		if (!$user_info) {
			$this->error = '用户不存在或被禁用！';
		} else {
			if (user_md5($password) !== $user_info['password']) {
				$this->error = '密码错误！';
			} else {
				return $user_info;
			}
		}
		return false;
	}

	/**
	 * 设置登录状态
	 */
	public function auto_login($user)
	{
		// 记录登录SESSION和COOKIES
		$auth = [
			'uid'      => $user['id'],
			'username' => $user['username'],
			'nickname' => $user['nickname'],
			'avatar'   => $user['avatar'],
		];
		session('user_auth', $auth);
		session('user_auth_sign', $this->data_auth_sign($auth));
		return $this->is_login();
	}

	/**
	 * 数据签名认证
	 * @param  array $data 被认证的数据
	 * @return string       签名
	 */
	public function data_auth_sign($data)
	{
		// 数据类型检测
		if (!is_array($data)) {
			$data = (array) $data;
		}
		ksort($data); //排序
		$code = http_build_query($data); // url编码并生成query字符串
		$sign = sha1($code); // 生成签名
		return $sign;
	}

	/**
	 * 检测用户是否登录
	 * @return integer 0-未登录，大于0-当前登录用户ID
	 */
	public function is_login()
	{
		$user = session('user_auth');
		if (empty($user)) {
			return 0;
		} else {
			if (session('user_auth_sign') == $this->data_auth_sign($user)) {
				return $user['uid'];
			} else {
				return 0;
			}
		}
	}
}
