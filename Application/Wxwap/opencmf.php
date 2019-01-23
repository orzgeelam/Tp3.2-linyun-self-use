<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
// 模块信息配置
return array (
  'info' => 
  array (
    'name' => 'Wxwap',
    'title' => '微信站',
    'icon' => 'fa fa-comments',
    'icon_color' => '#F9B440',
    'description' => '微信站模块',
    'developer' => 'yangweijie',
    'website' => 'http://lingyun.net',
    'version' => '1.0.0',
    'dependences' => 
    array (
      'Admin' => '1.0.0',
    ),
  ),
  'user_nav' => 
  array (
  ),
  'config' => 
  array (
    'test' => 
    array (
      'title' => '可添加轮播数',
      'type' => 'text',
      'value' => '',
    ),
  ),
  'admin_menu' => 
  array (
    1 => 
    array (
      'id' => 1,
      'pid' => '0',
      'title' => '后台管理',
      'url' => '',
      'icon' => 'fa fa-comments',
      'sort' => '',
    ),
    2 => 
    array (
      'id' => '2',
      'pid' => '1',
      'title' => '用户管理',
      'url' => '',
      'icon' => 'fa fa-folder-open-o',
      'sort' => '',
    ),
    3 => 
    array (
      'id' => 3,
      'pid' => '2',
      'title' => '微信站',
      'url' => 'Wxwap/Index/index',
      'icon' => 'fa fa-comments',
    ),
    4 => 
    array (
      'pid' => '1',
      'title' => '微信站设置',
      'url' => '',
      'icon' => 'fa fa-wrench',
      'sort' => '',
      'id' => 4,
    ),
  ),
)
;