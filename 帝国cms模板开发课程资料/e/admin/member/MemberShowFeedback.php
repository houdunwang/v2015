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
CheckLevel($logininid,$loginin,$classid,"spacedata");
$fid=(int)$_GET['fid'];
$r=$empire->fetch1("select fid,name,company,phone,fax,email,address,zip,title,ftext,userid,ip,uid,uname,addtime,userid,eipport from {$dbtbpre}enewsmemberfeedback where fid='$fid'");
if(!$r['fid'])
{
	printerror('ErrorUrl','',1);
}
if($r['uid'])
{
	$r['uname']="<a href='../../space/?userid=$r[uid]' target='_blank'>$r[uname]</a>";
}
else
{
	$r['uname']='游客';
}
$ur=$empire->fetch1("select ".egetmf('username')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$r[userid]'");
$username=$ur['username'];
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>查看反馈信息</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder style='word-break:break-all'>
  <tr class=header> 
    <td height="25" colspan="2">标题：
      <?=$r[title]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">空间主人：</td>
    <td height="25"><a href="../../space/?userid=<?=$r[userid]?>" target="_blank"><?=$username?></a></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="19%" height="25">提交者:</td>
    <td width="81%" height="25"> 
      <?=$r[uname]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">发布时间:</td>
    <td height="25"> 
      <?=$r[addtime]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">IP地址:</td>
    <td height="25"> 
      <?=$r[ip]?>:<?=$r[eipport]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">姓名:</td>
    <td height="25">
      <?=$r[name]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">公司名称:</td>
    <td height="25">
      <?=$r[company]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">联系邮箱:</td>
    <td height="25">
      <?=$r[email]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">联系电话:</td>
    <td height="25">
      <?=$r[phone]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">传真:</td>
    <td height="25">
      <?=$r[fax]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">联系地址:</td>
    <td height="25">
      <?=$r[address]?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮编：
      <?=$r[zip]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">信息标题:</td>
    <td height="25">
      <?=$r[title]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" valign="top">信息内容:</td>
    <td height="25">
      <?=nl2br($r[ftext])?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="2"><div align="center">[ <a href="javascript:window.close();">关 
        闭</a> ]</div></td>
  </tr>
</table>
</body>
</html>
