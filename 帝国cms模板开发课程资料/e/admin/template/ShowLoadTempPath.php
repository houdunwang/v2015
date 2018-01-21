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
CheckLevel($logininid,$loginin,$classid,"template");
$bakpath="../../data/LoadTemp";
$hand=@opendir($bakpath);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>查看导入模板目录</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：查看导入模板目录</td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr bgcolor="#0472BC"> 
    <td width="45%" height="25" bgcolor="#698CC3"> 
      <div align="left"><strong><font color="#FFFFFF">导入模板目录(e/data/LoadTemp)</font></strong></div></td>
  </tr>
  <?
  while($file=@readdir($hand))
  {
  if ($file!="."&&$file!=".."&&is_file($bakpath."/".$file))
	{
  ?>
  <tr bgcolor="#DBEAF5"> 
    <td height="25" bgcolor="#FFFFFF"> 
      <div align="left">&nbsp;<img src="../../data/images/dir/htm_icon.gif" width="19" height="15"> 
        <?=$file?>
      </div></td>
  </tr>
  <?
     }
  }
  @closedir($hand);
  ?>
  <tr> 
    <td height="25">&nbsp;</td>
  </tr>
</table>
</body>
</html>
