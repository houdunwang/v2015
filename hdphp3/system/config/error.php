<?php
return [
	//应用错误处理
	'app'   => [
		/**
		 * 验证错误显示类型
		 * redirect 直接跳转,会分配$errors到前台
		 * show 直接显示错误信息
		 * default 由开发者自行处理
		 */
		'validate' => 'show',
	],

	//开启Trace
	'trace' => TRUE,
	//Trace选项卡
	'level' => [
		'view'  => '视图',
		'sql'   => 'sql语句',
		'file'  => '加载文件',
		'error' => '错误',
		'debug' => '调试',
	],
];