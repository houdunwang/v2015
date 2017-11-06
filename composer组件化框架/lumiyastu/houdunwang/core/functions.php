<?php
function p($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

//config('database.DB_NANA');
function config($path){
	$arr = explode('.',$path);
	//p($arr);
	$dirPath = '../system/config/' . $arr[0] . '.php';
	$config = include $dirPath;
	return isset($config[$arr[1]]) ? $config[$arr[1]] : NULL;
}
