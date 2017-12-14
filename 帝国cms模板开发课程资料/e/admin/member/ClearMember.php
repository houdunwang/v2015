<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
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
CheckLevel($logininid,$loginin,$classid,"member");

$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='ClearMember')
{
	@set_time_limit(0);
	include('../../member/class/member_adminfun.php');
	include('../../member/class/member_modfun.php');
	admin_ClearMember($_POST,$logininid,$loginin);
}

//会员组
$group='';
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($sql))
{
	$group.="<option value=".$level_r[groupid].">".$level_r[groupname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>清理会员</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="ListMember.php<?=$ecms_hashur['whehref']?>">管理会员</a>&nbsp;>&nbsp;清理会员</td>
  </tr>
</table>
<form name="form1" method="post" action="ClearMember.php" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">清理会员
        <input name="enews" type="hidden" id="enews" value="ClearMember"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">用户名包含字符：</td>
      <td width="80%" height="25"><input name=username type=text id="username"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">邮箱地址包含字符：</td>
      <td height="25"><input name=email type=text id="email"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">用户ID 介于：</td>
      <td height="25"><input name="startuserid" type="text" id="startuserid">
        -- 
        <input name="enduserid" type="text" id="enduserid"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">所属会员组：</td>
      <td height="25"><select name="groupid" id="groupid">
          <option value="0">不限</option>
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">注册时间 介于：</td>
      <td height="25"><input name="startregtime" type="text" id="startregtime" onclick="setday(this)">
        -- 
        <input name="endregtime" type="text" id="endregtime" onclick="setday(this)">
        <font color="#666666">(格式：2011-01-27)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">点数 介于：</td>
      <td height="25"><input name="startuserfen" type="text" id="startuserfen">
        -- 
        <input name="enduserfen" type="text" id="enduserfen"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">帐户余额 介于：</td>
      <td height="25"><input name="startmoney" type="text" id="startmoney">
        -- 
        <input name="endmoney" type="text" id="endmoney"></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">是否审核：</td>
      <td height="25"><input name="checked" type="radio" value="0" checked>
        不限 
        <input name="checked" type="radio" value="1">
        已审核会员 
        <input name="checked" type="radio" value="2">
        未审核会员</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="删除会员">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
