<?php
// .-------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |      Site: www.hdphp.com
// |-------------------------------------------------------------------
// |    Author: 向军 <2300071698@qq.com>
// |    WeChat: houdunwangxj
// | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
// '-------------------------------------------------------------------
header( "Content-type:text/html;charset=utf-8" );
if ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) {
	die( 'HDPHP 需要PHP版本大于php5.4,当前版本' . PHP_VERSION );
}
define( 'HDPHP_VERSION', '2.0.0' );
define( 'RELEASE_VERSION', '20160818' );
define( 'HDPHP_PATH', __DIR__ );
define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT_PATH', '.' );
defined( "DEBUG" ) or define( "DEBUG", FALSE );
define( 'IS_CGI', substr( PHP_SAPI, 0, 3 ) == 'cgi' ? TRUE : FALSE );
define( 'IS_WIN', strstr( PHP_OS, 'WIN' ) ? TRUE : FALSE );
define( 'IS_CLI', PHP_SAPI == 'cli' ? TRUE : FALSE );
define( 'NOW', $_SERVER['REQUEST_TIME'] );
define( 'NOW_MICROTIME', microtime( TRUE ) );
if ( IS_CLI ) {
	define( '__ROOT__', '' );
} else {
	define( 'IS_GET', $_SERVER['REQUEST_METHOD'] == 'GET' );
	define( 'IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST' );
	define( 'IS_DELETE', $_SERVER['REQUEST_METHOD'] == 'DELETE' ?: ( isset( $_POST['_method'] ) && $_POST['_method'] == 'DELETE' ) );
	define( 'IS_PUT', $_SERVER['REQUEST_METHOD'] == 'PUT' ?: ( isset( $_POST['_method'] ) && $_POST['_method'] == 'PUT' ) );
	define( 'IS_AJAX', isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );
	define( 'IS_WEIXIN', isset( $_SERVER['HTTP_USER_AGENT'] ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'MicroMessenger' ) !== FALSE );
	define( '__ROOT__', trim( 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['SCRIPT_NAME'] ), '/\\' ) );
	define( '__URL__', trim( 'http://' . $_SERVER['HTTP_HOST'] . '/' . trim( $_SERVER['REQUEST_URI'], '/\\' ), '/' ) );
	define( "__HISTORY__", isset( $_SERVER["HTTP_REFERER"] ) ? $_SERVER["HTTP_REFERER"] : '' );
}
require HDPHP_PATH . '/kernel/Functions.php';
require HDPHP_PATH . '/kernel/Loader.php';
\hdphp\kernel\Loader::register();
( new \hdphp\kernel\App() )->run();