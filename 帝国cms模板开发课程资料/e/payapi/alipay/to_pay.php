<?php
if(!defined('InEmpireCMS'))
{
	exit();
}

if($payr['paymethod']==0)//双接口
{
	$use_service='trade_create_by_buyer';
}
elseif($payr['paymethod']==2)//担保接口
{
	$use_service='create_partner_trade_by_buyer';
}
else//即时到帐接口
{
	$use_service='create_direct_pay_by_user';
}

//------------------ 参数开始 ------------------

$agent="";

$service=$use_service;

//商户号
$partner=$payr['payuser'];

//密钥
$paykey=$payr['paykey'];

//卖家支付宝帐户
$seller_email=$payr['payemail'];

//字符编码格式
$_input_charset="GBK";

//加密方式
$sign_type="MD5";

//返回地址
$notify_url=$PayReturnUrlQz."e/payapi/alipay/payend.php";
$return_url=$PayReturnUrlQz."e/payapi/alipay/payend.php";

//支付方式
$payment_type=1;

//默认支付方式
$paymethod="";

//银行类型
$defaultbank="";

//物流类型
$logistics_type="EXPRESS";

//物流费用
$logistics_fee="0";

//物流支付类型
$logistics_payment="BUYER_PAY";

//------------------ 参数结束 ------------------

if($payr['paymethod']==1)//即时到帐不需要物流
{
	$logistics_type="";
	$logistics_fee="";
	$logistics_payment="";
}

//支付金额
$price=$money;
$quantity=1;

$out_trade_no=$ddno?$ddno:time();	//订单号
esetcookie("checkpaysession",$out_trade_no,0);	//设置定单号

//产品信息
$subject=$productname;	//商品名称
$body=$productsay;	//商品描述

//md5
$parameter=array(
	'agent'             => $agent,
	'service'           => $service,
	'partner'           => $partner,
	'seller_email'      => $seller_email,
    '_input_charset'    => $_input_charset,
    'notify_url'        => $notify_url,
    'return_url'        => $return_url,
    'subject'           => $subject,
	'body'				=> $body,
    'out_trade_no'      => $out_trade_no,
    'price'             => $price,
    'quantity'          => $quantity,
    'payment_type'      => $payment_type,
	'paymethod'			=> $paymethod,
	'defaultbank'		=> $defaultbank,
	'logistics_type'    => $logistics_type,
	'logistics_fee'     => $logistics_fee,
	'logistics_payment' => $logistics_payment
 );

ksort($parameter);
reset($parameter);

$param='';
$sign='';

foreach($parameter AS $key => $val)
{
	if(strlen($val)==0)
	{
		continue;
	}
	$param.="$key=".urlencode($val)."&";
	$sign.="$key=$val&";
}

$param=substr($param,0,-1);
$sign=md5(substr($sign,0,-1).$paykey);
$gotopayurl='https://mapi.alipay.com/gateway.do?'.$param.'&sign='.$sign.'&sign_type='.$sign_type;
?>
<html>
<title>支付宝支付</title>
<meta http-equiv="Cache-Control" content="no-cache"/>
<body>
<script>
self.location.href='<?=$gotopayurl?>';
</script>
<input type="button" style="font-size: 9pt" value="支付宝支付" name="v_action" onclick="self.location.href='<?=$gotopayurl?>';">
</body>
</html>