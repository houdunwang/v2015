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

//清理多余数据
function ClearSearchAll($start,$line,$userid,$username){
	global $empire,$dbtbpre,$class_r,$fun_r;
	$line=(int)$line;
	if(empty($line))
	{
		$line=500;
	}
	$start=(int)$start;
	$b=0;
	$sql=$empire->query("select id,classid,sid from {$dbtbpre}enewssearchall where sid>$start order by sid limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r['sid'];
		if(empty($class_r[$r[classid]]['tbname']))
		{
			$empire->query("delete from {$dbtbpre}enewssearchall where sid='".$r['sid']."'");
			continue;
		}
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[classid]]['tbname']."_index where id='$r[id]' and classid='$r[classid]' limit 1");
		if(!$num)
		{
			$empire->query("delete from {$dbtbpre}enewssearchall where sid='".$r['sid']."'");
		}
	}
	if(empty($b))
	{
		//操作日志
		insert_dolog("");
		printerror('ClearSearchAllSuccess','ClearSearchAll.php'.hReturnEcmsHashStrHref2(1));
	}
	echo"<meta http-equiv=\"refresh\" content=\"0;url=ClearSearchAll.php?enews=ClearSearchAll&line=$line&start=$newstart".hReturnEcmsHashStrHref(0)."\">".$fun_r[OneClearSearchAllSuccess]."(ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

$enews=$_GET['enews'];
if($enews)
{
	hCheckEcmsRHash();
	include("../../data/dbcache/class.php");
	include "../".LoadLang("pub/fun.php");
	ClearSearchAll($_GET[start],$_GET[line],$logininid,$loginin);
}

$total=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssearchall");
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>清理搜索多余数据</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="ListSearchLoadTb.php<?=$ecms_hashur['whehref']?>">管理全站搜索数据源</a>&nbsp;->&nbsp;清理搜索多余数据</td>
  </tr>
</table>
<form name="searchclear" method="get" action="ClearSearchAll.php" onsubmit="return confirm('确认要操作?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">清理搜索多余数据 <input name=enews type=hidden value=ClearSearchAll></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">搜索表总信息数：</td>
      <td width="81%" height="25"><?=$total?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">每组整理数：</td>
      <td height="25"><input name="line" type="text" id="line" value="500">
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="开始清理"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>