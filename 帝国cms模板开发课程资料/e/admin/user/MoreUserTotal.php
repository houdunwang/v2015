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
$userid=(int)$_GET['userid'];
$username=RepPostVar($_GET['username']);
$tbname=RepPostVar($_GET['tbname']);
if(empty($tbname))
{
	$tbname=$public_r['tbname'];
}
if(!$userid||!$username||!$tbname)
{
	printerror('ErrorUrl','');
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
//日期
$year=date("Y");
$yyear=$year-1;
$date=RepPostVar($_GET['date']);
if(empty($date))
{
	$date=date("Y-m");
}
$selectdate='';
$yselectdate='';
for($i=1;$i<=12;$i++)
{
	$m=$i;
	if($i<10)
	{
		$m='0'.$i;
	}
	//今年
	$sdate=$year.'-'.$m;
	$select='';
	if($sdate==$date)
	{
		$select=' selected';
	}
	$selectdate.="<option value='".$sdate."'".$select.">".$sdate."</option>";
	//去年
	$ysdate=$yyear.'-'.$m;
	$yselect='';
	if($ysdate==$date)
	{
		$yselect=' selected';
	}
	$yselectdate.="<option value='".$ysdate."'".$yselect.">".$ysdate."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$username?> 的发布统计</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="ChangeDate" method="get" action="MoreUserTotal.php">
<?=$ecms_hashur['eform']?>
<input type="hidden" name="userid" value="<?=$userid?>">
<input type="hidden" name="username" value="<?=$username?>">
  <tr> 
    <td height="25">位置：<a href="MoreUserTotal.php?tbname=<?=$tbname?>&userid=<?=$userid?>&username=<?=$username?><?=$ecms_hashur['ehref']?>"><?=$username?> 的发布统计</a></td>
  </tr>
  <tr>
    <td height="30"> <div align="center">
        <select name="date" id="date">
		<?=$yselectdate.$selectdate?>
        </select>
        <select name="tbname" id="tbname">
          <?=$tbstr?>
        </select>
        <input type="submit" name="Submit" value="显示">
      </div></td>
  </tr>
</form>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="40%" height="25"> 
      <div align="center">日期</div></td>
    <td width="30%" height="25"> 
      <div align="center">发布数</div></td>
    <td width="30%">
<div align="center">未审核数</div></td>
  </tr>
  <?php
  $dr=explode('-',$date);
  $dr[0]=(int)$dr[0];
  $dr[1]=(int)$dr[1];
  for($j=1;$j<=31;$j++)
  {
  	//检测日期合法性
	if(!checkdate($dr[1],$j,$dr[0]))
	{
		continue;
	}
 	$d=$j;
	if($j<10)
	{
		$d='0'.$j;
	}
  	$thisday=$date.'-'.$d;
	//发布数
	$totalnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$tbname." where userid='$userid' and ismember=0 and truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59"));
	//未审核数
	$totalchecknum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$tbname."_check where userid='$userid' and ismember=0 and truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59"));
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25"><div align="center">
        <?=$thisday?>
      </div></td>
    <td height="25"><div align="center">
        <?=($totalnum+$totalchecknum)?>
      </div></td>
    <td><div align="center"><?=$totalchecknum?></div></td>
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