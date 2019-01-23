<?php

namespace Home\Controller;
use Common\Util\Think\Page;
/**
 * 前台默认控制器
 *
 */
class IndexController extends BaseController {
    /**
     * 默认方法
     *
     */
    public function index() {
        $this->assign('meta_title', "首页");
        $this->display();
    }
}
