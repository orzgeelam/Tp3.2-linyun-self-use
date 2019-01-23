<?php

namespace Home\Controller;
use Common\Util\Think\Page;
/**
 * 导航控制器
 *
 */
class NavController extends HomeController {
    /**
     * 默认方法
     *
     */
    public function index() {
        $this->assign('meta_title', "首页");
        $this->display();
    }

    /**
     * 单页类型
     *
     */
    public function page($id) {
        $nav_object = D('Admin/Nav');
        $con['id']     = $id;
        $con['status'] = 1;
        $info = $nav_object->where($con)->find();

        $this->assign('info', $info);
        $this->assign('meta_title', $info['title']);
        $this->display();
    }

    /**
     * 文章列表
     *
     */
    public function lists($cid) {
        $nav_object = D('Admin/Nav');
        $con['id']     = $cid;
        $con['status'] = 1;
        $info = $nav_object->where($con)->find();

        // 文章列表
        $map['status'] = 1;
        $map['cid']    = $cid;
        $p = $_GET["p"] ? : 1;
        $post_object = D('Admin/Post');
        $data_list = $post_object
                   ->where($map)
                   ->page($p, C("ADMIN_PAGE_ROWS"))
                   ->order("sort desc,id desc")
                   ->select();
        $page = new Page(
            $post_object->where($map)->count(),
            C("ADMIN_PAGE_ROWS")
        );

        $this->assign('data_list', $data_list);
        $this->assign('page', $page->show());
        $this->assign('meta_title', $info['title']);
        $this->display();
    }

    /**
     * 文章详情
     *
     */
    public function post($id) {
        $post_object = D('Admin/Post');
        $con['id']     = $id;
        $con['status'] = 1;
        $info = $post_object->where($con)->find();

        // 阅读量加1
        $result = $post_object->where(array('id' => $id))->SetInc('view_count');

        $this->assign('info', $info);
        $this->assign('meta_title', $info['title']);
        $this->display('page');
    }

    /**
     * 系统配置
     *
     */
    public function config($name = '') {
        $data_list = C($name);
        $this->assign('data_list', $data_list);
        $this->assign('meta_title', '系统配置');
        $this->display();
    }

    /**
     * 导航
     *
     */
    public function nav($group = 'wap_bottom') {
        $data_list = D('Admin/Nav')->getNavTree(0, $group);
        $this->assign('data_list', $data_list);
        $this->assign('meta_title', '导航列表');
        $this->display();
    }

    /**
     * 模块
     *
     */
    public function module() {
        $map['status'] = 1;
        $data_list = D('Admin/MODULE')->where($map)->select();
        $this->assign('data_list', $data_list);
        $this->assign('meta_title', '模块列表');
        $this->display();
    }
}
