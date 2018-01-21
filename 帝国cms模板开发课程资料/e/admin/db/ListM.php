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
CheckLevel($logininid,$loginin,$classid,"m");
$enews=$_GET['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
//导出模型
if($enews=="LoadOutMod")
{
	include("../../class/moddofun.php");
	LoadOutMod($_GET,$logininid,$loginin);
}
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$url="数据表:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">管理系统模型</a>";
$sql=$empire->query("select * from {$dbtbpre}enewsmod where tid='$tid' order by myorder,mid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理系统模型</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td class="emenubutton"><input type="button" name="Submit2" value="增加系统模型" onclick="self.location.href='AddM.php?enews=AddM&tid=<?=$tid?>&tbname=<?=$tbname?><?=$ecms_hashur['ehref']?>';">
      &nbsp;&nbsp;&nbsp;
      <input type="button" name="Submit22" value="导入系统模型" onclick="window.open('LoadInM.php<?=$ecms_hashur['whehref']?>','','width=520,height=300,scrollbars=yes,top=130,left=120');"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="33%" height="25"><div align="center">模型名称</div></td>
    <td width="7%"><div align="center">启用</div></td>
    <td width="55%" height="25"><div align="center">操作</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	//默认
	$defbgcolor='#ffffff';
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	if($r[isdefault])
	{
		$defbgcolor='#DBEAF5';
		$movejs='';
	}
	$do="[<a href='../../DoInfo/ChangeClass.php?mid=".$r[mid]."' target=_blank>投稿地址</a>]&nbsp;&nbsp;[<a href='AddM.php?tid=$tid&tbname=$tbname&enews=AddM&mid=".$r[mid].$ecms_hashur['ehref']."&docopy=1'>复制</a>]&nbsp;&nbsp;[<a href='ListM.php?tid=$tid&tbname=$tbname&enews=LoadOutMod&mid=".$r[mid].$ecms_hashur['href']."' onclick=\"return confirm('确认要导出?');\">导出</a>]&nbsp;&nbsp;[<a href='../ecmsmod.php?tid=$tid&tbname=$tbname&enews=DefM&mid=".$r[mid].$ecms_hashur['href']."' onclick=\"return confirm('确认要设置为默认系统模型?');\">设为默认</a>]&nbsp;&nbsp;[<a href='AddM.php?tid=$tid&tbname=$tbname&enews=EditM&mid=".$r[mid].$ecms_hashur['ehref']."'>修改</a>]&nbsp;&nbsp;[<a href='../ecmsmod.php?tid=$tid&tbname=$tbname&enews=DelM&mid=".$r[mid].$ecms_hashur['href']."' onclick=\"return confirm('确认要删除？');\">删除</a>]";
	$usemod=$r[usemod]==0?'是':'<font color="red">否</font>';
	?>
  <tr bgcolor="<?=$defbgcolor?>"<?=$movejs?>> 
    <td height="32"><div align="center"> 
        <?=$r[mid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[mname]?>
      </div></td>
    <td><div align="center"><?=$usemod?></div></td>
    <td height="25"><div align="center"> 
        <?=$do?>
      </div></td>
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
