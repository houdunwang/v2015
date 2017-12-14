<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../../data/dbcache/class.php");
require "../".LoadLang("pub/fun.php");
require("../class/ShopSysFun.php");
eCheckCloseMods('shop');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//是否登陆
$user=islogin();
//更新库存
$shoppr=ShopSys_ReturnSet();
ShopSys_TimeCutMaxnum($user['userid'],$shoppr);

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=16;//每页显示条数
$page_line=10;//每页显示链接数
$offset=$page*$line;//总偏移量
$add="";
$search='';
$totalquery="select count(*) as total from {$dbtbpre}enewsshopdd where userid='$user[userid]'";
$query="select ddid,ddno,ddtime,userid,username,outproduct,haveprice,checked,truename,psid,psname,pstotal,alltotal,payfsid,payfsname,payby,alltotalfen,fp,fptotal,pretotal from {$dbtbpre}enewsshopdd where userid='$user[userid]'";
//搜索
$sear=(int)$_GET['sear'];
$keyboard='';
$starttime='';
$endtime='';
if($sear)
{
	$keyboard=RepPostVar($_GET['keyboard']);
	$add=" and ddno like '%$keyboard%'";
	//时间
	$starttime=RepPostVar($_GET['starttime']);
	$endtime=RepPostVar($_GET['endtime']);
	if($endtime!="")
	{
		$ostarttime=$starttime." 00:00:00";
		$oendtime=$endtime." 23:59:59";
		$add.=" and ddtime>='$ostarttime' and ddtime<='$oendtime'";
	}
	$search="&sear=1&keyboard=$keyboard&starttime=$starttime&endtime=$endtime";
}
$totalquery.=$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query.=$add;
$query=$query." order by ddid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page1($num,$line,$page_line,$start,$page,$search);
//导入模板
require(ECMS_PATH.'e/template/ShopSys/ListDd.php');
db_close();
$empire=null;
?>
