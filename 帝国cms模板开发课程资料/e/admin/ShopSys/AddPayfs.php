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
CheckLevel($logininid,$loginin,$classid,"shoppayfs");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListPayfs.php".$ecms_hashur['whehref'].">管理支付方式</a>&nbsp;>&nbsp;增加支付方式";
if($enews=="EditPayfs")
{
	$payid=(int)$_GET['payid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsshoppayfs where payid='$payid'");
	$url="<a href=ListPayfs.php".$ecms_hashur['whehref'].">管理支付方式</a>&nbsp;>&nbsp;修改支付方式：<b>".$r[payname]."</b>";
	if($r[userpay])
	{$userpay=" checked";}
	if($r[userfen])
	{$userfen=" checked";}
}
//--------------------html编辑器
include('../ecmseditor/infoeditor/fckeditor.php');
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>支付方式</title>
<script>
function on()
{
var f=document.add
f.HTML.value=f.paysay.value;
}
function bs(){
var f=document.add
f.paysay.value=f.HTML.value;
}
function br(){
if(!confirm("是否复位？")){return false;}
document.add.title.select()
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="add" method="post" action="ListPayfs.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="21%" height="25">增加支付方式</td>
      <td width="79%" height="25"><input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="payid" type="hidden" id="payid" value="<?=$payid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">方式名称:</td>
      <td height="25"><input name="payname" type="text" id="payname" value="<?=$r[payname]?>">
        (如:邮局汇款) </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input name="userpay" type="checkbox" id="userpay" value="1"<?=$userpay?>>
        <strong>直接划帐</strong>(非划帐请勿选择)</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25"><input name="userfen" type="checkbox" id="userfen" value="1"<?=$userfen?>>
        <strong>点数购买</strong>(非点数购买请勿选择)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">在线支付地址:</td>
      <td height="25"><input name="payurl" type="text" id="payurl" value="<?=$r[payurl]?>" size="52">
        (在线支付/手机支付请填写)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">详细说明:</td>
      <td height="25">
	  <?=ECMS_ShowEditorVar('paysay',$r[paysay],'Default','../ecmseditor/infoeditor/')?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">是否启用</td>
      <td height="25"><input type="radio" name="isclose" value="0"<?=$r[isclose]==0?' checked':''?>>
      开启
        <input type="radio" name="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
      关闭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
