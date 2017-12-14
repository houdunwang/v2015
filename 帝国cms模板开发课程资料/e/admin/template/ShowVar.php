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

$modid=(int)$_GET['modid'];
$mr=$empire->fetch1("select mid,mname,tempvar from {$dbtbpre}enewsmod where mid='$modid'");
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>模型变量列表</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：模型变量列表</td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id=m<?=$mr[mid]?>>
  <tr class="header">
    <td><div align="center">
        <?=$mr[mname]?>
        </div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
	<?
	$record="<!--record-->";
    $field="<!--field--->";
	$r=explode($record,$mr[tempvar]);
	$count=count($r)-1;
	for($i=0;$i<$count;$i++)
	{
	$r1=explode($field,$r[$i]);
	?>
        <tr>
          <td width="35%"><b><?=$r1[0]?></b></td>
          <td width="65%"><input name="textfield" type="text" value="[!--<?=$r1[1]?>--]"></td>
        </tr>
		<?
		}
		?>
      </table></td>
  </tr>
</table>
</body>
</html>