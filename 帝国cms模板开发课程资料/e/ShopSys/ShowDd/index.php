<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../class/ShopSysFun.php");
eCheckCloseMods('shop');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//是否登陆
$user=islogin();
$ddid=(int)$_GET['ddid'];
$r=$empire->fetch1("select * from {$dbtbpre}enewsshopdd where ddid='$ddid' and userid='$user[userid]' limit 1");
if(empty($r['ddid']))
{
	printerror('此订单不存在','',1,0,1);
}
$addr=$empire->fetch1("select * from {$dbtbpre}enewsshopdd_add where ddid='$ddid' limit 1");
//需要发票
$fp="否";
if($r[fp])
{
	$fp="是";
}
//金额
$total=0;
if($r[payby]==1)
{
	$pstotal=$r[pstotal]." 点";
	$alltotal=$r[alltotalfen]." 点";
	$total=$r[pstotal]+$r[alltotalfen];
	$mytotal=$total." 点";
}
else
{
	$pstotal=$r[pstotal]." 元";
	$alltotal=$r[alltotal]." 元";
	$total=$r[pstotal]+$r[alltotal]+$r[fptotal]-$r[pretotal];
	$mytotal=$total." 元";
}
//支付方式
if($r[payby]==1)
{
	$payfsname=$r[payfsname]."(点数购买)";
}
elseif($r[payby]==2)
{
	$payfsname=$r[payfsname]."(余额购买)";
}
else
{
	$payfsname=$r[payfsname];
}
//状态
if($r['checked']==1)
{
	$ch="已确认";
}
elseif($r['checked']==2)
{
	$ch="取消";
}
elseif($r['checked']==3)
{
	$ch="退货";
}
else
{
	$ch="<font color=red>未确认</font>";
}
//发货
if($r['outproduct']==1)
{
	$ou="已发货";
}
elseif($r['outproduct']==2)
{
	$ou="备货中";
}
else
{
	$ou="<font color=red>未发货</font>";
}
$topay='';
if($r['haveprice']==1)
{
	$ha="已付款";
}
else
{
	//是否网银支付
	$payfs_r=$empire->fetch1("select payurl from {$dbtbpre}enewsshoppayfs where payid='$r[payfsid]'");
	if($payfs_r['payurl'])
	{
		$topay="&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' name='button' value='点击支付' onclick=\"window.open('../doaction.php?ddid=$ddid&enews=ShopDdToPay','','width=760,height=600,scrollbars=yes,resizable=yes');\">";
	}
	$ha="<font color=red>未付款</font>";
}
//导入模板
require(ECMS_PATH.'e/template/ShopSys/ShowDd.php');
db_close();
$empire=null;
?>