<?php
return [
	//引擎:file,mysql,memcache,redis
	'driver'   => 'file',
	//session_name
	'name'     => 'hdcmsid',
	//域名
	'domain'   => '',
	//过期时间 0 会话时间 3600 为一小时
	'expire'   => 0,
	#File
	'file'     => [
		'path' => 'storage/session',
	],
	#Mysql
	'mysql'    => [
		'table' => 'core_session',
	],
	#Memcache
	'memcache' => [
		'host' => 'localhost',
		'port' => 11211,
	],
	#Redis
	'redis'    => [
		'host'     => 'localhost',
		'port'     => 11211,
		'password' => '',
		'database' => 0,
	]
];