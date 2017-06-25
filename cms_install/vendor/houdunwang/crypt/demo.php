<?php
require 'vendor/autoload.php';
$config=[
	'key'=>"sdkdsklldsksdksdksdkldsklsdkllksd"
];
\houdunwang\config\Config::set('crypt',$config);

//设置密钥
//$a1 = new \houdunwang\crypt\Crypt();
//$a2 = new \houdunwang\crypt\Crypt();
//$a1::encrypt('3');
//$a2::encrypt('3');
//exit;
\houdunwang\crypt\Crypt::key( $key );
echo $d = \houdunwang\crypt\Crypt::encrypt( '后盾网人人做后盾' );
echo "<hr/>";
echo \houdunwang\crypt\Crypt::decrypt( $d );