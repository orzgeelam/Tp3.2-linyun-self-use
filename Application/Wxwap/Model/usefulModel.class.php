<?php
	
	namespace Wxwap\Model;
	
	use Think\Model;
	
	class usefulModel extends Model
	{
		protected $tableName        = '';
		public    $leveltext
		                            = [
				-1 => '游客',
				0  => '普通会员',
				1  => 'VIP会员',
				2  => '经销商',
				3  => '微BOSS',
			];
		protected $qualified_idsarr = [];
		/**
		 * 自动验证规则
		 */
		protected $_validate
			= [
				//验证用户名
				['username', 'require', '账号不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT],
				['username', '/^(13[0-9]|14[5-9]|15[012356789]|166|17[0-8]|18[0-9]|19[8-9])[0-9]{8}$/', '账号必须是手机号码', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT],
				['username', '', '账号被占用', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT],
				//验证密码
				['password', 'require', '密码不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT],
				['repassword', 'password', '两次输入的密码不一致', self::EXISTS_VALIDATE, 'confirm', self::MODEL_INSERT],
				['nickname', 'require', '昵称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT],
				['mobile', '/^(13[0-9]|14[5-9]|15[012356789]|166|17[0-8]|18[0-9]|19[8-9])[0-9]{8}$/', '手机号格式不正确', self::VALUE_VALIDATE, 'regex', self::MODEL_INSERT],
				['id_number', '/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/', '身份证格式不正确', self::VALUE_VALIDATE, 'regex', self::MODEL_INSERT],
				['usable', 'currency', '积分格式不正确', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH],
			];
		/**
		 * 自动完成规则
		 */
		protected $_auto
			= [
				['reg_type', 'admin', self::MODEL_INSERT],
				['create_time', 'datetime', self::MODEL_INSERT, 'function'],
				['status', '1', self::MODEL_INSERT],
				['password', 'user_md5', self::MODEL_BOTH, 'function'],
				['update_time', 'datetime', self::MODEL_BOTH, 'function'],
			];
		
		/**
		 * 查找后置操作
		 */
		protected function _after_find(&$result, $options)
		{
			if (isset($options['list'])) {
				$recInfo               = $this->field('nickname,avatar')->where(['id' => $result['recUid']])->find();
				$result['recUsername'] = $recInfo['nickname'];
				$result['recUserimg']  = $recInfo['avatar'];
				$result['reg_date']    = time_format($result['create_time']);
			}
			if (isset($options['timeformat'])) {
				$result['create_time'] = date('Y-m-d H:i:s', $result['create_time']);
			}
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
		
		// 获取分销等级  获取么某个人的几级分销
		
		/**
		 * 获取用户的一级、二级、1和2级分销
		 * @param  [type] $id   当前用户ID
		 * @param  string $type 类型
		 * @return [type]       分销的ID，admin_user表
		 */
		function getRecUid($id, $type = '1,2')
		{
			$result = null;
			$w      = ['id' => $id];
			switch ($type)
			{
				case '1':
					$result = $this->where($w)->getField('recUid');
					break;
				case '2':
					$result[] = $this->where($w)->getField('recUid');
					if (empty($result[0]) || $result[0] < 0)
					{
						$result[] = null;
					}
					else
					{
						$w['id']  = $result[0];
						$result[] = $this->where($w)->getField('recUid');
					}
					unset($result[0]);
					break;
				case '1,2':
					$result[] = $this->where($w)->getField('recUid');
					if (empty($result[0]) || $result[0] < 0)
					{
						$result[] = null;
					}
					else
					{
						$w['id']  = $result[0];
						$result[] = $this->where($w)->getField('recUid');
					}
					break;
			}
			return $result;
		}
		
		/**
		 * 获取指定id的分销商的uid admin_user中的ID
		 * @return [type] [description]
		 */
		function getDistributionUid($id, $level = '1,2')
		{
			$res = [];
			$map = ['recUid' => $id, 'status' => 1];
			switch ($level)
			{
				case '1':
					$res = $this->field('id')->where($map)->select();
					$res = array_column($res, 'id');
					break;
				case '2':
					$res = $this->field('id')->where($map)->select();
					$res = array_column($res, 'id');
					if (empty($res))
					{
						$res = null;
					}
					else
					{
						$map['recUid'] = ['in', implode(',', $res)];
						$res           = $this->field('id')->where($map)->select();
						$res           = array_column($res, 'id');
					}
					break;
				case '1,2':
					$res  = $this->field('id')->where($map)->select();
					$res  = array_column($res, 'id');
					$temp = [];
					if (empty($res))
					{
						$res = null;
					}
					else
					{
						foreach ($res as $value)
						{
							$map['recUid'] = $value;
							$t1            = $this->field('id')->where($map)->select();
							$t1            = array_column($t1, 'id');
							if (empty($t1))
							{
								$temp[] = null;
							}
							else
							{
								$temp[] = $t1;
							}
						}
						$res = array_combine($res, $temp);
						unset($temp, $t1);
					}
					break;
			}
			return $res;
		}
	}