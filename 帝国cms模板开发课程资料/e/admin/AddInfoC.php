<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"cj");
//--------------------操作的栏目
$fcfile="../data/fc/ListEnews.php";
$do_class="<script src=../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$do_class=ShowClass_AddClass("","n",0,"|-",0,0);}
db_close();
$empire=null;
if($_GET['from'])
{
	$listclasslink="ListPageInfoClass.php";
}
else
{
	$listclasslink="ListInfoClass.php";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加采集节点</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function changecj(obj)
{
	if(obj.newsclassid.value=="nono")
	{
		alert("请选择栏目");
	}
	else
	{
		self.location.href='AddInfoClass.php?<?=$ecms_hashur['ehref']?>&enews=AddInfoClass&from=<?=RepPostStr($_GET['from'],1)?>&newsclassid='+obj.newsclassid.value;
	}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：采集&nbsp;&gt;&nbsp;<a href='<?=$listclasslink?><?=$ecms_hashur['whehref']?>'>管理节点</a>&nbsp;&gt;&nbsp;增加节点</td>
  </tr>
</table>

<form name="form1" method="post" action="enews.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['eform']?>
    <tr class="header"> 
      <td height="25"><div align="center">请选择要增加采集的栏目</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center"> 
          <select name="newsclassid" id="newsclassid" onchange='javascript:changecj(document.form1);'>
            <option value=''>选择栏目</option>
            <option value='0'>非采集节点(父节点)</option>
            <?=$do_class?>
          </select>
        </div></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><div align="center"><font color="#666666">(采集节点要选择终极栏目)</font></div></td>
    </tr>
  </table>
</form>
</body>
</html>
