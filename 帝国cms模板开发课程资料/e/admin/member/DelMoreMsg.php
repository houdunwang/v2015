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
CheckLevel($logininid,$loginin,$classid,"msg");
$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="DelMoreMsg")
{
	include("../../class/com_functions.php");
	DelMoreMsg($_POST,$logininid,$loginin);
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>批量删除站内短消息</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置: <a href="DelMoreMsg.php<?=$ecms_hashur['whehref']?>">批量删除站内短消息</a></td>
  </tr>
</table>
<form name="form1" method="post" action="DelMoreMsg.php" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">删除站内短消息 
          <input name="enews" type="hidden" id="enews" value="DelMoreMsg">
        </div></td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">消息类型</td>
      <td width="80%" bgcolor="#FFFFFF"><select name="msgtype" id="msgtype">
          <option value="0">前台全部消息</option>
		  <option value="2">只删除前台系统消息</option>
		  <option value="1">后台全部消息</option>
		  <option value="3">只删除后台系统消息</option>
        </select></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">发件人</td>
      <td bgcolor="#FFFFFF"><input name="from_username" type="text" id="from_username">
        <input name="fromlike" type="checkbox" id="fromlike" value="1" checked>
        模糊匹配 (不填为不限)</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">收件人</td>
      <td bgcolor="#FFFFFF"><input name="to_username" type="text" id="to_username">
        <input name="tolike" type="checkbox" id="tolike" value="1" checked>
        模糊匹配(不填为不限)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">包含关键字</td>
      <td bgcolor="#FFFFFF"><input name="keyboard" type="text" id="keyboard"> 
        <select name="keyfield" id="keyfield">
          <option value="0">检索标题和内容</option>
          <option value="1">检索信息标题</option>
          <option value="2">检索信息内容</option>
        </select>
        (多个请用&quot;,&quot;格开)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">时间</td>
      <td bgcolor="#FFFFFF">删除从 
        <input name="starttime" type="text" id="starttime" onclick="setday(this)" size="12">
        到 
        <input name="endtime" type="text" id="endtime" onclick="setday(this)" size="12">
        之间的短消息</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="批量删除"></td>
    </tr>
  </table>
</form>
</body>
</html>
