<?php
header ('Content-type:text/html;charset=utf8');
session_start ();
/**
 * 自动加载
 * @param $className	类名
 */
function __autoload($className){
	//echo $className;
	include './controller/' . $className . '.php';
}