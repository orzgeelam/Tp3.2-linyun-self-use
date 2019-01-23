<?php
namespace Admin\Controller;

use Common\Util\Think\Page;

/**
 * 管理员控制器
 */
class AccessController extends AdminController
{
	/**
	 * 管理员列表
	 * @param $tab 配置分组ID
	 */
	public function index()
	{
		// 搜索
		$keyword    = I('keyword', '', 'string');
		$condition  = ['like', '%'.$keyword.'%'];
		$map['uid'] = [
			$condition,
		];
		// 获取所有配置
		$map['status'] = ['neq', '0'];  // 禁用和正常状态
		if (session('user_auth.uid') != 1) {
			$map['id'] = ['neq', 1];
		}
		$p             = !empty($_GET["p"]) ? $_GET['p'] : 1;
		$access_object = D('Access');
		$data_list     = $access_object
			->page($p, C('ADMIN_PAGE_ROWS'))
			->where($map)
			->order('sort asc,id asc')
			->select();
		$page          = new Page(
			$access_object->where($map)->count(),
			C('ADMIN_PAGE_ROWS')
		);
		// 设置Tab导航数据列表
		$group_object = D('Group');
		$user_object  = D('User');
		foreach ($data_list as $key => &$val) {
			$val['username']    = $user_object->getFieldById($val['uid'], 'username');
			$val['nickname']    = $user_object->getFieldById($val['uid'], 'nickname');
			$val['group_title'] = $group_object->getFieldById($val['group'], 'title');
		}
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder();
		$builder->setMetaTitle('管理员列表')// 设置页面标题
		        ->addTopButton('addnew')// 添加新增按钮
		        ->addTopButton('resume')// 添加启用按钮
		        ->addTopButton('forbid')// 添加禁用按钮
		        ->addTopButton('delete')// 添加删除按钮
		// ->addSearchItem('keyword', 'text', '', 'UID')
		// ->addTableColumn('uid', 'UID')
		        ->addTableColumn('group_title', '用户组')
		        ->addTableColumn('username', '用户名')
		        ->addTableColumn('nickname', '昵称')
		        ->addTableColumn('status', '状态', 'status')
		        ->addTableColumn('right_button', '操作', 'btn')
		        ->setTableDataList($data_list)// 数据列表
		        ->setTableDataPage($page->show())// 数据列表分页
		        ->addRightButton('edit')// 添加编辑按钮
		        ->addRightButton('forbid')// 添加禁用/启用按钮
		        ->addRightButton('delete')// 添加删除按钮
		        ->display();
	}

	/**
	 * 新增
	 */
	public function add()
	{
		if (IS_POST) {
			$access_object = D('Access');
			$data          = $access_object->create();
			if ($data) {
				if ($access_object->add($data)) {
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败');
				}
			} else {
				$this->error($access_object->getError());
			}
		} else {
			//使用FormBuilder快速建立表单页面。
			$user    = M('admin_user')->where(['id' => ['notin', '1'], 'status' => 1])->getField('id,nickname');
			$builder = new \Common\Builder\FormBuilder();
			$builder->setMetaTitle('新增配置')//设置页面标题
			        ->setPostUrl(U('add'))//设置表单提交地址
			        ->addFormItem('uid', 'select', 'UID', '用户ID', $user)
			        ->addFormItem('group', 'select', '用户组', '不同用户组对应相应的权限', select_list_as_tree('Group'))
			        ->display();
		}
	}

	/**
	 * 编辑
	 */
	public function edit($id)
	{
		if (IS_POST) {
			$access_object = D('Access');
			$data          = $access_object->create();
			if ($data) {
				if ($access_object->save($data)) {
					$this->success('更新成功', U('index'));
				} else {
					$this->error('更新失败');
				}
			} else {
				$this->error($access_object->getError());
			}
		} else {
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder();
			$builder->setMetaTitle('编辑配置')// 设置页面标题
			        ->setPostUrl(U('edit'))// 设置表单提交地址
			        ->addFormItem('id', 'hidden', 'ID', 'ID')
			        ->addFormItem('uid', 'uid', 'UID', '用户ID')
			        ->addFormItem('group', 'select', '用户组', '不同用户组对应相应的权限', select_list_as_tree('Group'))
			        ->setFormData(D('Access')->find($id))
			        ->display();
		}
	}
}
