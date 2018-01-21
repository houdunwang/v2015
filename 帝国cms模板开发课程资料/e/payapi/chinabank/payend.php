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

$paytype='chinabank';
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");

$v_mid=$payr['payuser'];//商户号

$key=$payr['paykey'];//密钥

//----------------------------------------------返回信息
$v_oid    =trim($_POST['v_oid']);      
$v_pmode   =trim($_POST['v_pmode']);      
$v_pstatus=trim($_POST['v_pstatus']);      
$v_pstring=trim($_POST['v_pstring']);      
$v_amount=trim($_POST['v_amount']);     
$v_moneytype  =trim($_POST['v_moneytype']);     
$remark1  =trim($_POST['remark1']);     
$remark2  =trim($_POST['remark2']);     
$v_md5str =trim($_POST['v_md5str']);    

//md5
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

if($v_md5str!=$md5string)
{
	printerror('验证MD5签名失败.','../../../',1,0,1);
}

if($v_pstatus!="20")
{
	printerror('支付失败.','../../../',1,0,1);
}

//----------- 支付成功后处理 -----------

include('../payfun.php');
$pr=$empire->fetch1("select paymoneytofen,payminmoney from {$dbtbpre}enewspublic limit 1");

$orderid=$v_oid;	//支付订单
$ddno=$remark1;	//网站的订单号
$money=$v_amount;
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