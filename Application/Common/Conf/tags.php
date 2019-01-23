<?php

return [
	'app_init'     => ['Common\Behavior\InitModuleBehavior'], //初始化安装的模块行为扩展
	'app_begin'    => ['Common\Behavior\InitConfigBehavior'], //初始化系统配置行为扩展
	'action_begin' => ['Common\Behavior\InitHookBehavior'], //初始化插件钩子行为扩展
];
