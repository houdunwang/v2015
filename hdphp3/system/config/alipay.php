<?php
return [
	//合作身份者id，以2088开头的16位纯数字
	'partner'       => '',
	//安全检验码，以数字和字母组成的32位字符
	'key'           => '',
	//收款支付宝账号，一般情况下收款账号就是签约账号
	'seller_email'  => '',
	//支付类型
	'payment_type'  => 1,
	//服务器异步通知页面路径
	'notify_url'    => '',
	//页面跳转同步通知页面路径
	'return_url'    => '',
	//签名方式 不需修改
	'sign_type'     => 'MD5',
	//字符编码格式
	'input_charset' => 'utf-8',
	//ca证书路径地址，用于curl中ssl校验
	'cacert'        => '',
	//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
	'transport'     => 'http',
];