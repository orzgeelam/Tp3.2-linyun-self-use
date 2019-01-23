<?php

namespace Home\Controller;
use Think\Controller;
/**
 * 跳转到后台控制器
 *
 */
class AdminController extends Controller {
    /**
     * 自动跳转到后台入口文件
     *
     */
    public function index() {
        redirect(C('HOME_PAGE').'/admin.php');
    }
}
