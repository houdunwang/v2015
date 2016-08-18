<?php

return [
	'partner'       => '',
	//合作身份者id，以2088开头的16位纯数字
	'key'           => '',
	//安全检验码，以数字和字母组成的32位字符
	'seller_email'  => '',
	//收款支付宝账号，一般情况下收款账号就是签约账号
	'payment_type'  => 1,
	//支付类型
	'notify_url'    => '',
	//服务器异步通知页面路径
	'return_url'    => '',
	//页面跳转同步通知页面路径
	'sign_type'     => strtoupper( 'MD5' ),
	//签名方式 不需修改
	'input_charset' => strtolower( 'utf-8' ),
	//字符编码格式
	'cacert'        => getcwd() . '\\cacert.pem',
	//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
	'transport'     => 'http',
	//ca证书路径地址，用于curl中ssl校验
];