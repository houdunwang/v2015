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
CheckLevel($logininid,$loginin,$classid,"totaldata");
$tbname=RepPostVar($_GET['tbname']);
if(empty($tbname))
{
	$tbname=$public_r['tbname'];
}
//数据表
$b=0;
$htb=0;
$tbsql=$empire->query("select tbname,tname from {$dbtbpre}enewstable order by tid");
while($tbr=$empire->fetch($tbsql))
{
	$b=1;
	$select="";
	if($tbr[tbname]==$tbname)
	{
		$htb=1;
		$select=" selected";
	}
	$tbstr.="<option value='".$tbr[tbname]."'".$select.">".$tbr[tname]."</option>";
}
if($b==0)
{
	printerror('ErrorUrl','');
}
if($htb==0)
{
	printerror('ErrorUrl','');
}
//用户
$sql=$empire->query("select userid,username from {$dbtbpre}enewsuser order by userid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>用户发布统计</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td height="25">位置：<a href="UserTotal.php<?=$ecms_hashur['whehref']?>">用户发布统计</a></td>
  </tr>
  <tr>
    <td height="30"> 选择统计数据表： 
      <select name="tbname" id="tbname" onchange="window.location='UserTotal.php?<?=$ecms_hashur['ehref']?>&tbname='+this.options[this.selectedIndex].value">
	  <?=$tbstr?>
      </select>
    </td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="25%" height="25"> 
      <div align="center">用户</div></td>
    <td width="13%" height="25"> <div align="center">今天发布数</div></td>
    <td width="13%" height="25"> <p align="center">昨天发布数</p></td>
    <td width="13%" height="25"> <div align="center">本月发布数</div></td>
    <td width="13%"> <div align="center">总发布数</div></td>
    <td width="13%"> 
      <div align="center">未审核数</div></td>
    <td width="10%"><div align="center"></div></td>
  </tr>
  <?php
  $totime=time();
  $today=date("Y-m-d");
  $yesterday=date("Y-m-d",$totime-24*3600);
  $month=date("Y-m");
  //本月最大天数
  $maxday=date("t",mktime(0,0,0,date("m"),date("d"),date("Y")));
  while($r=$empire->fetch($sql))
  {
  	$tquery="select count(*) as total from {$dbtbpre}ecms_".$tbname." where userid='$r[userid]' and ismember=0";
	$checktquery="select count(*) as total from {$dbtbpre}ecms_".$tbname."_check where userid='$r[userid]' and ismember=0";
  	//今天发布数
  	$todaynum=$empire->gettotal($tquery." and truetime>=".to_time($today." 00:00:00")." and truetime<=".to_time($today." 23:59:59"));
	$todaychecknum=$empire->gettotal($checktquery." and truetime>=".to_time($today." 00:00:00")." and truetime<=".to_time($today." 23:59:59"));
	//昨天发布数
	$yesterdaynum=$empire->gettotal($tquery." and truetime>=".to_time($yesterday." 00:00:00")." and truetime<=".to_time($yesterday." 23:59:59"));
	$yesterdaychecknum=$empire->gettotal($checktquery." and truetime>=".to_time($yesterday." 00:00:00")." and truetime<=".to_time($yesterday." 23:59:59"));
	//本月发布数
	$monthnum=$empire->gettotal($tquery." and truetime>=".to_time($month."-01 00:00:00")." and truetime<=".to_time($month."-".$maxday." 23:59:59"));
	$monthchecknum=$empire->gettotal($checktquery." and truetime>=".to_time($month."-01 00:00:00")." and truetime<=".to_time($month."-".$maxday." 23:59:59"));
	//所有
	$totalnum=$empire->gettotal($tquery);
	$checktotalnum=$empire->gettotal($checktquery);
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"><a href="AddUser.php?enews=EditUser&userid=<?=$r[userid]?><?=$ecms_hashur['ehref']?>" target="_blank">
        <u><?=$r[username]?></u>
        </a></div></td>
    <td height="25"><div align="center"> 
        <?=$todaynum+$todaychecknum?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$yesterdaynum+$yesterdaychecknum?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$monthnum+$monthchecknum?>
      </div></td>
    <td><div align="center"><a href="../ListAllInfo.php?keyboard=<?=$r[username]?>&show=2&tbname=<?=$tbname?>&sear=1<?=$ecms_hashur['ehref']?>" target="_blank">
        <u><?=$totalnum+$checktotalnum?></u>
        </a> </div></td>
    <td><div align="center"><a href="../ListAllInfo.php?showspecial=4&keyboard=<?=$r[username]?>&show=2&tbname=<?=$tbname?>&sear=1&ecmscheck=1&infocheck=2<?=$ecms_hashur['ehref']?>" target="_blank">
        <u><?=$checktotalnum?></u>
        </a></div></td>
    <td><div align="center"><a href="#ecms" onclick="window.open('MoreUserTotal.php?tbname=<?=$tbname?>&userid=<?=$r[userid]?>&username=<?=$r[username]?><?=$ecms_hashur['ehref']?>','ViewUserTotal','width=420,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">[详细]</a></div></td>
  </tr>
  <?php
  }
  ?>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>