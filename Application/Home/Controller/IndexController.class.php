<?php
namespace Home\Controller;

use Common\Util\Think\Page;

/**
 * 前台默认控制器
 */
class IndexController extends BaseController
{
	public function index()
	{
		redirect(U('Wxwap/Index/index'));
	}
}
