<?php
namespace Admin\Controller;

use Common\Util\Think\Page;

/**
 * 用户控制器
 */
class UserController extends AdminController
{
	/**
	 * 用户列表
	 */
	public function index()
	{
		// 搜索
		$keyword                     = I('keyword', '', 'string');
		$condition                   = ['like', '%'.$keyword.'%'];
		$map['username|nickname'] = [
			$condition,
			$condition,
			'_multi' => true,
		];
		// 获取所有用户
		// $map['status'] = ['neq', '0']; // 禁用和正常状态
		if (session('user_auth.uid') != 1) {
			$map['id'] = ['neq', 1];
		}
		$this->extendDates($map, 'create_time', 'timestamp');
		$p           = !empty($_GET["p"]) ? $_GET['p'] : 1;
		$user_object = D('User');
		$data_list   = $user_object
			->page($p, C('ADMIN_PAGE_ROWS'))
			->where($map)
			->order('id desc')
			->select();
		$page        = new Page(
			$user_object->where($map)->count(),
			C('ADMIN_PAGE_ROWS')
		);
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder();
		$builder->setMetaTitle('用户列表')// 设置页面标题
		        ->addTopButton('addnew')// 添加新增按钮
		        ->addTopButton('resume')// 添加启用按钮
		        ->addTopButton('forbid')// 添加禁用按钮
		        ->addTopButton('delete')// 添加删除按钮
		        // ->addSearchItem('keyword', 'text', '', '用户名')
		        ->addTableColumn('id', 'UID')
		        ->addTableColumn('nickname', '昵称')
		        ->addTableColumn('username', '用户名')
		        ->addTableColumn('create_time', '注册时间', 'time')
		        ->addTableColumn('status', '状态', 'status')
		        ->addTableColumn('right_button', '操作', 'btn')
		        ->setTableDataList($data_list)// 数据列表
		        ->setTableDataPage($page->show())// 数据列表分页
		        ->addRightButton('edit')// 添加编辑按钮
		        ->addRightButton('forbid')// 添加禁用/启用按钮
		        ->addRightButton('recycle')// 添加删除按钮
		        ->display();
	}

	/**
	 * 新增用户
	 */
	public function add()
	{
		if (IS_POST) {
			$user_object = D('User');
			$data        = $user_object->create();
			if ($data) {
				$id = $user_object->add($data);
				if ($id) {
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败');
				}
			} else {
				$this->error($user_object->getError());
			}
		} else {
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder();
			$builder->setMetaTitle('新增用户')//设置页面标题
			        ->setPostUrl(U('add'))//设置表单提交地址
			        ->addFormItem('reg_type', 'hidden', '注册方式', '注册方式')
			        ->addFormItem('nickname', 'text', '昵称', '昵称')
			        ->addFormItem('username', 'text', '用户名', '用户名')
			        ->addFormItem('password', 'password', '密码', '密码')
			        ->setFormData(['reg_type' => 'admin'])
			        ->display();
		}
	}

	/**
	 * 编辑用户
	 */
	public function edit($id)
	{
		if (IS_POST) {
			// 密码为空表示不修改密码
			if ($_POST['password'] === '') {
				unset($_POST['password']);
			}
			// 提交数据
			$user_object = D('User');
			$data        = $user_object->create();
			if ($data) {
				$result = $user_object
					->field('id,nickname,username,password,email,email_bind,mobile,mobile_bind,gender,avatar,update_time')
					->save($data);
				if ($result) {
					$this->success('更新成功', U('index'));
				} else {
					$this->error('更新失败', $user_object->getError());
				}
			} else {
				$this->error($user_object->getError());
			}
		} else {
			// 获取账号信息
			$info = D('User')->find($id);
			unset($info['password']);
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder();
			$builder->setMetaTitle('编辑用户')// 设置页面标题
			        ->setPostUrl(U('edit'))// 设置表单提交地址
			        ->addFormItem('id', 'hidden', 'ID', 'ID')
			        ->addFormItem('nickname', 'text', '昵称', '昵称')
			        ->addFormItem('username', 'text', '用户名', '用户名')
			        ->addFormItem('password', 'password', '密码', '密码')
			        ->setFormData($info)
			        ->display();
		}
	}

	/**
	 * 设置一条或者多条数据的状态
	 */
	public function setStatus($model = CONTROLLER_NAME, $script = false)
	{
		$ids = I('request.ids');
		if (is_array($ids)) {
			if (in_array('1', $ids)) {
				$this->error('超级管理员不允许操作');
			}
		} else {
			if ($ids === '1') {
				$this->error('超级管理员不允许操作');
			}
		}
		parent::setStatus($model);
	}
}
