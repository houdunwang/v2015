<?php
return [
	//基于https协议
	'https'              => FALSE,
	//url重写模式
	'rewrite'            => FALSE,
	//URL变量
	'url_var'            => 's',
	//禁止使用的模块
	'deny_module'        => [ ],
	//默认模块
	'default_module'     => 'home',
	//默认控制器
	'default_controller' => 'entry',
	//默认方法
	'default_action'     => 'index',
	//缓存路由
	'route_cache'        => FALSE
];