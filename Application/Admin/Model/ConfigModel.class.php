<?php
namespace Admin\Model;

use Common\Model\ModelModel;

/**
 * 配置模型
 */
class ConfigModel extends ModelModel
{
	/**
	 * 数据库表名
	 */
	protected $tableName = 'admin_config';
	/**
	 * 自动验证规则
	 */
	protected $_validate
		= [
			['group', 'require', '配置分组不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			['type', 'require', '配置类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			['name', 'require', '配置名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			['name', '1,32', '配置名称长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH],
			['name', '', '配置名称已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH],
			['title', 'require', '配置标题必须填写', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH],
			['title', '1,32', '配置标题长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH],
			['title', '', '配置标题已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH],
		];
	/**
	 * 自动完成规则
	 */
	protected $_auto
		= [
			['create_time', 'time', self::MODEL_INSERT, 'function'],
			['update_time', 'time', self::MODEL_BOTH, 'function'],
			['status', '1', self::MODEL_BOTH],
		];

	/**
	 * 获取配置列表与ThinkPHP配置合并
	 * @return array 配置数组
	 */
	public function lists()
	{
		$map['status'] = ['eq', 1];
		$list          = $this->where($map)->field('name,value,type')->select();
		foreach ($list as $key => $val) {
			switch ($val['type']) {
				case 'array':
					$config[$val['name']] = \Common\Util\Think\Str::parseAttr($val['value']);
					break;
				case 'checkbox':
					$config[$val['name']] = explode(',', $val['value']);
					break;
				default:
					$config[$val['name']] = $val['value'];
					break;
			}
		}
		return $config;
	}
}
