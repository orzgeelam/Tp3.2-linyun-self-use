<?php
namespace Wxwap\Controller;
// use Think\Controller;
use Home\Controller\BaseController;//引入base控制器


/**
 * 默认控制器
 */
class IndexController extends BaseController
{
    /**
     * 默认方法
     */
    public function index()
    {
       $this->assign('meta_title','首页');
       $this->display();
    }
}