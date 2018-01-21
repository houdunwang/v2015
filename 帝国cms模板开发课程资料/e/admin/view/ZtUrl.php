<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
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

$ztid=(int)$_GET['ztid'];
if(empty($class_zr[$ztid][zturl]))
{$url=$public_r[newsurl].$class_zr[$ztid][ztpath]."/";}
else
{$url=$class_zr[$ztid][zturl];}
$jspath=$public_r['newsurl'].'d/js/class/zt'.$ztid.'_';
?>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">

<title>调用地址</title>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class=header> 
    <td height="25">&nbsp;</td>
    <td height="25">调用地址</td>
    <td height="25"> <div align="center">预览</div></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="22%" height="25">专题地址:</td>
    <td width="71%" height="25"> <input name="textfield" type="text" value="<?=$url?>" size="35"></td>
    <td width="7%" height="25"> <div align="center"><a href="<?=$url?>" target="_blank">预览</a></div></td>
  </tr>
</table>
