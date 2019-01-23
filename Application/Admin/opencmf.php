<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
// 模块信息配置
return [
	'info'       =>
		[
			'name'        => 'Admin',
			'title'       => '系统',
			'icon'        => 'fa fa-cog',
			'icon_color'  => '#3CA6F1',
			'description' => '核心系统',
			'developer'   => '西陆科技',
			'website'     => 'http://www.lingyun.net',
			'version'     => '1.0.0',
		],
	'admin_menu' =>
		[
			1  =>
				[
					'pid'   => '0',
					'title' => '系统',
					'icon'  => 'fa fa-cog',
					'level' => 'system',
					'id'    => 1,
				],
			2  =>
				[
					'pid'   => '1',
					'title' => '系统功能',
					'icon'  => 'fa fa-folder-open-o',
					'id'    => 2,
				],
			3  =>
				[
					'pid'   => '2',
					'title' => '系统设置',
					'icon'  => 'fa fa-wrench',
					'url'   => 'Admin/Config/group',
					'id'    => 3,
				],
			4  =>
				[
					'pid'   => '3',
					'title' => '修改设置',
					'url'   => 'Admin/Config/groupSave',
					'id'    => 4,
				],
			5  =>
				[
					'pid'   => '2',
					'title' => '导航管理',
					'icon'  => 'fa fa-map-signs',
					'url'   => 'Admin/Nav/index',
					'id'    => 5,
				],
			6  =>
				[
					'pid'   => '5',
					'title' => '新增',
					'url'   => 'Admin/Nav/add',
					'id'    => 6,
				],
			7  =>
				[
					'pid'   => '5',
					'title' => '编辑',
					'url'   => 'Admin/Nav/edit',
					'id'    => 7,
				],
			13 =>
				[
					'pid'   => '2',
					'title' => '配置管理',
					'icon'  => 'fa fa-cogs',
					'url'   => 'Admin/Config/index',
					'id'    => 13,
				],
			14 =>
				[
					'pid'   => '13',
					'title' => '新增',
					'url'   => 'Admin/Config/add',
					'id'    => 14,
				],
			15 =>
				[
					'pid'   => '13',
					'title' => '编辑',
					'url'   => 'Admin/Config/edit',
					'id'    => 15,
				],
			17 =>
				[
					'pid'   => '2',
					'title' => '上传管理',
					'icon'  => 'fa fa-upload',
					'url'   => 'Admin/Upload/index',
					'id'    => 17,
				],
			18 =>
				[
					'pid'   => '17',
					'title' => '上传文件',
					'url'   => 'Admin/Upload/upload',
					'id'    => 18,
				],
			19 =>
				[
					'pid'   => '17',
					'title' => '删除文件',
					'url'   => 'Admin/Upload/delete',
					'id'    => 19,
				],
			21 =>
				[
					'pid'   => '17',
					'title' => '下载远程图片',
					'url'   => 'Admin/Upload/downremoteimg',
					'id'    => 21,
				],
			22 =>
				[
					'pid'   => '17',
					'title' => '文件浏览',
					'url'   => 'Admin/Upload/fileManager',
					'id'    => 22,
				],
			23 =>
				[
					'pid'   => '1',
					'title' => '系统权限',
					'icon'  => 'fa fa-folder-open-o',
					'id'    => 23,
				],
			24 =>
				[
					'pid'   => '23',
					'title' => '用户管理',
					'icon'  => 'fa fa-user',
					'url'   => 'Admin/User/index',
					'id'    => 24,
				],
			25 =>
				[
					'pid'   => '24',
					'title' => '新增',
					'url'   => 'Admin/User/add',
					'id'    => 25,
				],
			26 =>
				[
					'pid'   => '24',
					'title' => '编辑',
					'url'   => 'Admin/User/edit',
					'id'    => 26,
				],
			28 =>
				[
					'pid'   => '23',
					'title' => '管理员管理',
					'icon'  => 'fa fa-lock',
					'url'   => 'Admin/Access/index',
					'id'    => 28,
				],
			29 =>
				[
					'pid'   => '28',
					'title' => '新增',
					'url'   => 'Admin/Access/add',
					'id'    => 29,
				],
			30 =>
				[
					'pid'   => '28',
					'title' => '编辑',
					'url'   => 'Admin/Access/edit',
					'id'    => 30,
				],
			32 =>
				[
					'pid'   => '23',
					'title' => '用户组管理',
					'icon'  => 'fa fa-sitemap',
					'url'   => 'Admin/Group/index',
					'id'    => 32,
				],
			33 =>
				[
					'pid'   => '32',
					'title' => '新增',
					'url'   => 'Admin/Group/add',
					'id'    => 33,
				],
			34 =>
				[
					'pid'   => '32',
					'title' => '编辑',
					'url'   => 'Admin/Group/edit',
					'id'    => 34,
				],
			36 =>
				[
					'pid'   => '1',
					'title' => '扩展中心',
					'icon'  => 'fa fa-folder-open-o',
					'id'    => 36,
				],
			44 =>
				[
					'pid'   => '36',
					'title' => '功能模块',
					'icon'  => 'fa fa-th-large',
					'url'   => 'Admin/Module/index',
					'id'    => 44,
				],
			45 =>
				[
					'pid'   => '44',
					'title' => '安装',
					'url'   => 'Admin/Module/install',
					'id'    => 45,
				],
			46 =>
				[
					'pid'   => '44',
					'title' => '卸载',
					'url'   => 'Admin/Module/uninstall',
					'id'    => 46,
				],
			47 =>
				[
					'pid'   => '44',
					'title' => '更新信息',
					'url'   => 'Admin/Module/updateInfo',
					'id'    => 47,
				],
			49 =>
				[
					'pid'   => '36',
					'title' => '插件管理',
					'icon'  => 'fa fa-th',
					'url'   => 'Admin/Addon/index',
					'id'    => 49,
				],
			50 =>
				[
					'pid'   => '49',
					'title' => '安装',
					'url'   => 'Admin/Addon/install',
					'id'    => 50,
				],
			51 =>
				[
					'pid'   => '49',
					'title' => '卸载',
					'url'   => 'Admin/Addon/uninstall',
					'id'    => 51,
				],
			52 =>
				[
					'pid'   => '49',
					'title' => '运行',
					'url'   => 'Admin/Addon/execute',
					'id'    => 52,
				],
			53 =>
				[
					'pid'   => '49',
					'title' => '设置',
					'url'   => 'Admin/Addon/config',
					'id'    => 53,
				],
			54 =>
				[
					'pid'   => '49',
					'title' => '后台管理',
					'url'   => 'Admin/Addon/adminList',
					'id'    => 54,
				],
			55 =>
				[
					'pid'   => '54',
					'title' => '新增数据',
					'url'   => 'Admin/Addon/adminAdd',
					'id'    => 55,
				],
			56 =>
				[
					'pid'   => '54',
					'title' => '编辑数据',
					'url'   => 'Admin/Addon/adminEdit',
					'id'    => 56,
				],
			58 =>
				[
					'id'    => 58,
					'pid'   => '5',
					'title' => '禁用',
					'url'   => 'Admin/Nav/setStatus/status/forbid',
					'icon'  => 'fa ',
				],
			59 =>
				[
					'pid'   => '5',
					'title' => '启用',
					'url'   => 'Admin/Nav/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 59,
				],
			60 =>
				[
					'pid'   => '5',
					'title' => '删除',
					'url'   => 'Admin/Nav/setStatus/status/delete',
					'icon'  => 'fa ',
					'id'    => 60,
				],
			61 =>
				[
					'pid'   => '13',
					'title' => '禁用',
					'url'   => 'Admin/Config/setStatus/status/forbid',
					'icon'  => 'fa ',
					'id'    => 61,
				],
			62 =>
				[
					'pid'   => '13',
					'title' => '启用',
					'url'   => 'Admin/Config/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 62,
				],
			63 =>
				[
					'pid'   => '13',
					'title' => '删除',
					'url'   => 'Admin/Config/setStatus/status/delete',
					'icon'  => 'fa ',
					'id'    => 63,
				],
			64 =>
				[
					'pid'   => '17',
					'title' => '禁用',
					'url'   => 'Admin/Upload/setStatus/status/forbid',
					'icon'  => 'fa ',
					'id'    => 64,
				],
			65 =>
				[
					'pid'   => '17',
					'title' => '启用',
					'url'   => 'Admin/Upload/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 65,
				],
			66 =>
				[
					'pid'   => '17',
					'title' => '删除',
					'url'   => 'Admin/Upload/setStatus/status/delete',
					'icon'  => 'fa ',
					'id'    => 66,
				],
			67 =>
				[
					'pid'   => '24',
					'title' => '禁用',
					'url'   => 'Admin/User/setStatus/status/forbid',
					'icon'  => 'fa ',
					'id'    => 67,
				],
			68 =>
				[
					'pid'   => '24',
					'title' => '启用',
					'url'   => 'Admin/User/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 68,
				],
			69 =>
				[
					'pid'   => '24',
					'title' => '删除',
					'url'   => 'Admin/User/setStatus/status/delete',
					'icon'  => 'fa ',
					'id'    => 69,
				],
			70 =>
				[
					'pid'   => '24',
					'title' => '回收',
					'url'   => 'Admin/User/setStatus/status/recyle',
					'icon'  => 'fa ',
					'id'    => 70,
				],
			71 =>
				[
					'pid'   => '28',
					'title' => '禁用',
					'url'   => 'Admin/Access/setStatus/status/forbid',
					'icon'  => 'fa ',
					'id'    => 71,
				],
			72 =>
				[
					'pid'   => '28',
					'title' => '启用',
					'url'   => 'Admin/Access/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 72,
				],
			73 =>
				[
					'pid'   => '28',
					'title' => '删除',
					'url'   => 'Admin/Access/setStatus/status/delete',
					'icon'  => 'fa ',
					'id'    => 73,
				],
			74 =>
				[
					'pid'   => '32',
					'title' => '禁用',
					'url'   => 'Admin/Group/setStatus/status/forbid',
					'icon'  => 'fa ',
					'id'    => 74,
				],
			75 =>
				[
					'pid'   => '32',
					'title' => '启用',
					'url'   => 'Admin/Group/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 75,
				],
			76 =>
				[
					'pid'   => '32',
					'title' => '删除',
					'url'   => 'Admin/Group/setStatus/status/delete',
					'icon'  => 'fa ',
					'id'    => 76,
				],
			77 =>
				[
					'pid'   => '44',
					'title' => '禁用',
					'url'   => 'Admin/Module/setStatus/status/forbid',
					'icon'  => 'fa ',
					'id'    => 77,
				],
			78 =>
				[
					'pid'   => '44',
					'title' => '启用',
					'url'   => 'Admin/Module/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 78,
				],
			79 =>
				[
					'pid'   => '54',
					'title' => '禁用',
					'url'   => 'Admin/Addon/setStatus/status/forbid',
					'icon'  => 'fa ',
					'id'    => 79,
				],
			80 =>
				[
					'pid'   => '54',
					'title' => '启用',
					'url'   => 'Admin/Addon/setStatus/status/resume',
					'icon'  => 'fa ',
					'id'    => 80,
				],
			81 =>
				[
					'id'    => 81,
					'pid'   => '85',
					'title' => '微信底部菜单',
					'url'   => 'Admin/Wxmenu/index',
					'icon'  => 'fa fa-comments-o',
					'sort'  => '',
				],
			82 =>
				[
					'pid'   => '81',
					'title' => '新增',
					'url'   => 'Admin/Wxmenu/add',
					'icon'  => 'fa ',
					'sort'  => '',
					'id'    => 82,
				],
			83 =>
				[
					'pid'   => '81',
					'title' => '编辑',
					'url'   => 'Admin/Wxmenu/edit',
					'icon'  => 'fa ',
					'sort'  => '',
					'id'    => 83,
				],
			84 =>
				[
					'pid'   => '81',
					'title' => '生成菜单',
					'url'   => 'Admin/Wxmenu/build',
					'icon'  => 'fa ',
					'sort'  => '',
					'id'    => 84,
				],
			85 =>
				[
					'id'    => '85',
					'pid'   => '1',
					'title' => '微信配置',
					'url'   => '',
					'icon'  => 'fa fa-folder-open-o',
					'sort'  => '',
				],
			87 =>
				[
					'id'    => 87,
					'pid'   => '85',
					'title' => '图文消息',
					'url'   => 'Admin/Wxmenu/indexit',
					'icon'  => 'fa fa-th-list',
					'sort'  => '',
				],
			88 =>
				[
					'id'    => 88,
					'pid'   => '87',
					'title' => '新增',
					'url'   => 'Admin/Wxmenu/addit',
					'icon'  => 'fa ',
					'sort'  => '',
				],
		],
];