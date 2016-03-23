<?php
	// 引入函数库
	include "./functions.php";
	// 引入smarty核心类文件
	include "./smarty/Smarty.class.php";
	// 实例化smarty
	$smarty=new Smarty;
	// 模板目录
	$smarty->template_dir='tpl';
	// 编译目录
	$smarty->compile_dir='compile';

	// 配置定界符
	$smarty->left_delimiter="{{";
	$smarty->right_delimiter="}}";

	// 载入模板
	$smarty->display('index.html');
?>