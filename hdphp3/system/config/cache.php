<?php
return [
	//类型:file memcache redis
	'type'     => 'file',
	//memcache缓存 , 多个服务器设置二维数组
	'memcache' => [
		'host' => '127.0.0.1',          //主机
		'port' => 11211,                //端口
	],
	//redis缓存 , 多个服务器设置二维数组
	'redis'    => [
		'host'     => '127.0.0.1',     //主机
		'port'     => 6379,            //端口
		'password' => '',              //密码
		'database' => 0,               //数据库
	], //mysql缓存
	'mysql'    => [
		'table' => 'core_cache'              //缓存表
	],
];