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
CheckLevel($logininid,$loginin,$classid,"card");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListCard.php".$ecms_hashur['whehref'].">管理点卡</a> &gt; <a href=AddMoreCard.php".$ecms_hashur['whehref'].">批量增加点卡</a>";
//----------会员组
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($sql))
{
	$group.="<option value=".$level_r[groupid].">".$level_r[groupname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>批量增加点卡</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListCard.php">
  <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">批量增加点卡 
          <input name="enews" type="hidden" id="enews" value="AddMoreCard">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="36%" height="25">批量生成点卡数量：</td>
      <td width="64%" height="25"><input name="donum" type="text" id="donum" value="10" size="6">
        个</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">点卡帐号位数：</td>
      <td height="25"><input name="cardnum" type="text" id="cardnum" value="8" size="6">
        位 </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">点卡密码位数：</td>
      <td height="25"><input name="passnum" type="text" id="passnum" value="6" size="6">
        位 </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">点卡金额：</td>
      <td height="25"><input name="money" type="text" id="money" value="10" size="6">
        元</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">点数：</td>
      <td height="25"><input name="cardfen" type="text" id="cardfen" value="0" size="6">
        点</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="3">充值有效期:</td>
      <td height="25"><input name="carddate" type="text" id="carddate" value="0" size="6">
        天</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">充值设置转向会员组: 
        <select name="cdgroupid" id="select2">
          <option value=0>不设置</option>
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">到期后转向的会员组: 
        <select name="cdzgroupid" id="cdzgroupid">
          <option value=0>不设置</option>
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">到期时间：</td>
      <td height="25"><input name="endtime" type="text" id="endtime" value="0000-00-00" size="20" onclick="setday(this)">
        (0000-00-00为不限制)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <input type="submit" name="Submit" value="提交">
          &nbsp; 
          <input type="reset" name="Submit2" value="重置">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>