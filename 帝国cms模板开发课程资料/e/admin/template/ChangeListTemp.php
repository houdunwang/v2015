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
$url="<a href=ChangeListTemp.php".$ecms_hashur['whehref'].">批量更换栏目列表模板</a>";
//栏目
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//列表模板
$listtemp="";
$sql=$empire->query("select mname,mid from {$dbtbpre}enewsmod order by myorder,mid");
while($r=$empire->fetch($sql))
{
	$listtemp.="<option value=0 style='background:#99C4E3'>".$r[mname]."</option>";
	$sql1=$empire->query("select tempname,tempid from ".GetTemptb("enewslisttemp")." where modid='$r[mid]'");
	while($r1=$empire->fetch($sql1))
	{
		$listtemp.="<option value='".$r1[tempid]."'>|-".$r1[tempname]."</option>";
	}
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>批量更换栏目列表模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="../ecmstemp.php" onsubmit="return confirm('确认要更换？');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">批量更换栏目列表模板 
        <input name="enews" type="hidden" id="enews" value="ChangeClassListtemp"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="15%" height="25">操作栏目：</td>
      <td width="85%" height="25"><select name="classid" size="16" id="classid" style="width:220">
          <option selected>所有栏目</option>
          <?=$class?>
        </select> <font color="#666666">（如选择父栏目，将应用于所有子栏目）</font> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">新的列表模板：</td>
      <td height="25"><select name="listtempid" id="listtempid">
          <option value=0>选择列表模板</option>
		  <?=$listtemp?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
