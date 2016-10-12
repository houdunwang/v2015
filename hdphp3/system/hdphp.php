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
if ( version_compare( phpversion(), '5.4.0', '<' ) ) {
	die( '<h2 style=\'font:18px/1.5 "PingFang SC", Helvetica, "Helvetica Neue", "微软雅黑", Tahoma, Arial, sans-serif\'>HDPHP需要PHP版本大于php5.4,当前版本' . PHP_VERSION . "</h2>" );
}
//版本号
define( 'HDPHP_VERSION', '3.0.0' );
//composer自动加载
require __DIR__ . '/../vendor/autoload.php';
define( 'ROOT_PATH', dirname( __DIR__ ) );
//启动应用
$app = new \hdphp\kernel\App();
$app->bootstrap();