<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//验证权限
CheckLevel($logininid,$loginin,$classid,"searchall");
$lid=$_GET['lid'];
$count=count($lid);
if(!$count)
{
	echo"<script>alert('请至少选择一个数据源');window.close();</script>";
	exit();
}
$url="LoadSearchAll.php?".$ecms_hashur['href']."&enews=LoadSearchAll&lid=";
echo"<link href='../adminstyle/".$loginadminstyleid."/adminstyle.css' rel='stylesheet' type='text/css'><center>导入全站搜索表的数据源总个数为:<font color=red>$count</font>个</center><br>";
for($i=0;$i<$count;$i++)
{
	$id=intval($lid[$i]);
	$lr=$empire->fetch1("select tbname from {$dbtbpre}enewssearchall_load where lid='$id'");
	if(empty($lr[tbname]))
	{
		continue;
	}
	$trueurl=$url.$id;
	echo"<table width='100%' border=0 align=center cellpadding=3 cellspacing=1 class=tableborder><tr class=header><td>导入数据表：".$lr[tbname]."</td></tr><tr><td bgcolor='#ffffff'><iframe frameborder=0 height=35 id='lid".$id."' scrolling=no src=\"".$trueurl."\" width=\"100%\"></iframe></td></tr></table>";
}
db_close();
$empire=null;
?>