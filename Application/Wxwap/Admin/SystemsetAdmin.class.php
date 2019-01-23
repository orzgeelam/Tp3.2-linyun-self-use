<?php
namespace Wxwap\Admin;

use Admin\Controller\AdminController;
use Common\Util\Think\Page;
use Common\Builder\FormBuilder;
use Common\Builder\ListBuilder;

/**
 * 微信站系统设置
 */
class SystemsetAdmin extends AdminController
{
	/**
	 * 默认方法
	 */
	public function caseset()
	{
		$map = [];
		list($data_list, $page, $model_object) = $this->lists('cms_case', $map, 'id DESC');
		$builder = new ListBuilder();
		//  	 $attr['title'] = '新增';
		// $attr['class'] = 'btn btn-primary';
		// $attr['href']  = U('Admin/Article/add');
		$builder->setMetaTitle('商品规格列表')// 设置页面标题
		//前提数据库中必须有一个status的字段
		        ->addTopButton('addnew', ['href' => U('caseadd')])
		        ->addSearchItem('name', 'text', '名称', '')
		        ->addTableColumn('id', 'id')
		        ->addTableColumn('title', '案例名称')
			// ->addTableColumn('description', '描述')
			// ->addTableColumn('order', '排序')
			    ->addTableColumn('right_button', '操作管理', 'btn')
		        ->setTableDataList($data_list)// 数据列表
		        ->setTableDataPage($page->show())// 数据列表分页
		        ->addRightButton('edit')// 添加编辑按钮
		        ->addRightButton('delete')
		        ->display();
	}

	public function caseadd()
	{
		$model_object = M('cms_case');
		if (IS_POST) {
			$post = I('post.');
			if (!$data = $model_object->create($post)) {
				$this->error($model_object->getError());
			} else {
				if ($model_object->add($data)) {
					$this->success('添加成功', U('index'));
				} else {
					trace($model_object->getError());
					$this->error('添加失败');
				}
			}
		} else {
			// 使用FormBuilder快速建立表单页面
			$builder = new FormBuilder();
			$builder->setMetaTitle('新增')// 设置页面标题
			        ->setPostUrl(U())// 设置表单提交地址
			        ->addFormItem('title', 'text', '案例名称', '')
			        ->addFormItem('projectsite', 'text', '工程地点', '')
			        ->addFormItem('projectsite', 'text', '工程地点', '')
			        ->display();
		}
	}
}