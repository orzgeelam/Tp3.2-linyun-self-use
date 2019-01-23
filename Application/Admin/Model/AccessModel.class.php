<?php
namespace Admin\Model;

use Common\Model\ModelModel;

/**
 * 管理员与用户组对应关系模型
 */
class AccessModel extends ModelModel
{
	/**
	 * 数据库表名
	 */
	protected $tableName = 'admin_access';
	/**
	 * 自动验证规则
	 */
	protected $_validate
		= [
			['uid', 'require', 'UID不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			['group', 'require', '部门不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			['uid', 'checkUser', '该用户不存在', self::MUST_VALIDATE, 'callback', self::MODEL_BOTH],
		];
	/**
	 * 自动完成规则
	 */
	protected $_auto
		= [
			['create_time', 'time', self::MODEL_INSERT, 'function'],
			['update_time', 'time', self::MODEL_BOTH, 'function'],
			['sort', '0', self::MODEL_INSERT],
			['status', '1', self::MODEL_INSERT],
		];

	/**
	 * 检查用户是否存在
	 */
	protected function checkUser($uid)
	{
		$user_info = D('User')->find($uid);
		if ($user_info) {
			return true;
		}
		return false;
	}
}
