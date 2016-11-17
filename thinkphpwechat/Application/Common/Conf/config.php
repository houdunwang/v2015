<?php
//config   config
return array(
	/* 数据库设置 */
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  'thinkphpwechat.houdunren.com', // 服务器地址
	'DB_NAME'               =>  'thinkphpwechat',          // 数据库名
	'DB_USER'               =>  'thinkphpwechat',      // 用户名
	'DB_PWD'                =>  'admin888',          // 密码
	'DB_PORT'               =>  '',        // 端口
	'DB_PREFIX'             =>  'hd_',    // 数据库表前缀
	'DB_PARAMS'          	=>  array(), // 数据库连接参数
	'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
	'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
	'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
	'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
	'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
	'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
	'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
	'DEFAULT_MODULE'        =>  'Admin',  // 默认模块
	'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
	'DEFAULT_ACTION'        =>  'index', // 默认操作名称
	'DEFAULT_FILTER'        =>  '', // 默认参数过滤方法 用于I函数...
);