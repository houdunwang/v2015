<?php
require 'vendor/autoload.php';
$obj = new \houdunwang\upload\Upload();
//初始化配置
$obj->init( [
	//允许上传类型
	'type' => 'jpg,jpeg,gif,png,zip,rar,doc,txt,pem',
	//允许上传大小单位KB
	'size' => 10000,
	//上传路径
	'path' => 'attachment',
] );
$obj->make();
echo $obj->getError();
