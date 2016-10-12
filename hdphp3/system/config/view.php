<?php
return [
	//模板目录（只对路由调用有效）
	'path'      => 'view',
	//模板后缀
	'prefix'    => '.php',
	//标签
	'tags'      => [ 'system\tag\Tag' ],
	//消息模板
	'message'   => ROOT_PATH . '/resource/view/message.php',
	//有确定提示的模板页面
	'confirm'   => ROOT_PATH . '/resource/view/confirm.php',
	//404页面
	'404'       => ROOT_PATH . '/resource/view/404.php',
	//错误提示页面
	'bug'       => ROOT_PATH . '/resource/view/bug.php',
	//左标签
	'tag_left'  => '<',
	//右标签
	'tag_right' => '>',
	//blade 模板功能开关
	'blade'     => TRUE
];