<?php
namespace Wxwap\Admin;

use Admin\Controller\AdminController;
use Common\Util\Think\Page;

/**
 * 默认控制器
 */
class IndexAdmin extends AdminController
{
	/**
	 * 默认方法
	 */
	public function index()
	{
		$data_list = [
			['id' => 1, 'title' => '标题1', 'status' => 1],
			['id' => 2, 'title' => '标题2', 'status' => 1],
		];
		$builder   = new \Common\Builder\ListBuilder();
		$builder->setMetaTitle("列表")// 设置页面标题
		        ->addTopButton("addnew")// 添加新增按钮
		        ->addTopButton("resume")// 添加启用按钮
		        ->addTopButton("forbid")// 添加禁用按钮
		        ->setSearch("请输入ID/标题", U("index"))
		        ->addTableColumn("id", "ID")
		        ->addTableColumn("title", "标题")
		        ->addTableColumn("right_button", "操作", "btn")
		        ->setTableDataList($data_list)// 数据列表
		        ->addRightButton("edit")// 添加编辑按钮
		        ->addRightButton("forbid")// 添加禁用/启用按钮
		        ->addRightButton("delete")// 添加删除按钮
		        ->display();
	}
}