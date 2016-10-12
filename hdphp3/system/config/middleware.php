<?php
//中间件配置
return [
	/**
	 * 控制器中间件指在控制器中执行的中间件
	 */
	'controller' => [ ],

	/**
	 * 中间件列表
	 */
	'middleware' => [
		//应用开始时执行的中间件
		'app_start' => [
			'hdphp\middleware\build\AppStart'
		],
		//应用结束后执行的中间件
		'app_end'   => [
			'hdphp\middleware\build\AppEnd'
		]
	]
];