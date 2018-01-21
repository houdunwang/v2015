<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../member/class/user.php");
require("../data/dbcache/MemberLevel.php");
eCheckCloseMods('pay');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
//是否登陆
$user=islogin();
//支付平台
$payid=intval($_POST['payid']);
if(!$payid)
{
	printerror('请选择支付平台','',1,0,1);
}
//充值类型
$id=intval($_POST['id']);
if(!$id)
{
	printerror('请选择充值类型','',1,0,1);
}
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where payid='$payid' and isclose=0 limit 1");
if(!$payr[payid])
{
	printerror('请选择支付平台','',1,0,1);
}
$buyr=$empire->fetch1("select * from {$dbtbpre}enewsbuygroup where id='$id'");
if(!$buyr['id'])
{
	printerror('请选择充值类型','',1,0,1);
}
//权限
if($buyr[buygroupid]&&$level_r[$buyr[buygroupid]][level]>$level_r[$user[groupid]][level])
{
	printerror('此充值类型需要 '.$level_r[$buyr[buygroupid]][groupname].' 会员级别以上','',1,0,1);
}
include('payfun.php');

$money=$buyr['gmoney'];
if(!$money)
{
	printerror('此充值类型金额有误','',1,0,1);
}
$ddno='';
$productname="充值类型:".$buyr['gname'].",UID:".$user['userid'].",UName:".$user['username'];
$productsay="用户ID:".$user['userid'].",用户名:".$user['username'];

esetcookie("payphome","BuyGroupPay",0);
esetcookie("paymoneybgid",$id,0);
//返回地址前缀
$PayReturnUrlQz=$public_r['newsurl'];
if(!stristr($public_r['newsurl'],'://'))
{
	$PayReturnUrlQz=eReturnDomain().$public_r['newsurl'];
}
//编码
if($ecms_config['sets']['pagechar']!='gb2312')
{
	@include_once("../class/doiconv.php");
	$iconv=new Chinese('');
	$char=$ecms_config['sets']['pagechar']=='big5'?'BIG5':'UTF8';
	$targetchar='GB2312';
	$productname=$iconv->Convert($char,$targetchar,$productname);
	$productsay=$iconv->Convert($char,$targetchar,$productsay);
	@header('Content-Type: text/html; charset=gb2312');
}
$file=$payr['paytype'].'/to_pay.php';
@include($file);
db_close();
$empire=null;
?>