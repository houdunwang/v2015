<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;

//订单号
if(!getcvar('checkpaysession'))
{
	printerror('非法操作','../../../',1,0,1);
}
else
{
	esetcookie("checkpaysession","",0);
}
//操作事件
$phome=getcvar('payphome');
if($phome=='PayToFen')//购买点数
{}
elseif($phome=='PayToMoney')//存预付款
{}
elseif($phome=='ShopPay')//商城支付
{}
elseif($phome=='BuyGroupPay')//购买充值类型
{}
else
{
	printerror('您来自的链接不存在','',1,0,1);
}

$user=array();
if($phome=='PayToFen'||$phome=='PayToMoney'||$phome=='BuyGroupPay')
{
	$user=islogin();//是否登陆
}

$paytype='alipay';
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");

$bargainor_id=$payr['payuser'];//商户号

$paykey=$payr['paykey'];//密钥

$seller_email=$payr['payemail'];//卖家支付宝帐户

//----------------------------------------------返回信息

if(!empty($_POST))
{
	foreach($_POST as $key => $data)
	{
		$_GET[$key]=$data;
	}
}

$get_seller_email=rawurldecode($_GET['seller_email']);


//支付验证
ksort($_GET);
reset($_GET);

$sign='';
foreach($_GET AS $key=>$val)
{
	if($key!='sign'&&$key!='sign_type'&&$key!='code')
	{
		$sign.="$key=$val&";
	}
}

$sign=md5(substr($sign,0,-1).$paykey);
if($sign!=$_GET['sign'])
{
	printerror('验证MD5签名失败.','../../../',1,0,1);
}

if(!($_GET['trade_status']=="TRADE_FINISHED"||$_GET['trade_status']=="WAIT_SELLER_SEND_GOODS"||$_GET['trade_status']=="TRADE_SUCCESS"))
{
	printerror('支付失败.','../../../',1,0,1);
}

//----------- 支付成功后处理 -----------

include('../payfun.php');
$pr=$empire->fetch1("select paymoneytofen,payminmoney from {$dbtbpre}enewspublic limit 1");

$orderid=$_GET['trade_no'];	//支付订单
$ddno=$_GET['out_trade_no'];	//网站的订单号
$money=$_GET['total_fee'];
$fen=floor($money)*$pr[paymoneytofen];

if($phome=='PayToFen')//购买点数
{
	$paybz='购买点数: '.$fen;
	PayApiBuyFen($fen,$money,$paybz,$orderid,$user[userid],$user[username],$paytype);
}
elseif($phome=='PayToMoney')//存预付款
{
	$paybz='存预付款';
	PayApiPayMoney($money,$paybz,$orderid,$user[userid],$user[username],$paytype);
}
elseif($phome=='ShopPay')//商城支付
{
	include('../../data/dbcache/class.php');
	$ddid=(int)getcvar('paymoneyddid');
	$paybz='商城购买 [!--ddno--] 的订单(ddid='.$ddid.')';
	PayApiShopPay($ddid,$money,$paybz,$orderid,'','',$paytype);
}
elseif($phome=='BuyGroupPay')//购买充值类型
{
	include("../../data/dbcache/MemberLevel.php");
	$bgid=(int)getcvar('paymoneybgid');
	PayApiBuyGroupPay($bgid,$money,$orderid,$user[userid],$user[username],$user[groupid],$paytype);
}

db_close();
$empire=null;
?>