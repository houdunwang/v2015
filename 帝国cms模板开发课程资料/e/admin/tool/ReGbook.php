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
CheckLevel($logininid,$loginin,$classid,"gbook");
$lyid=(int)$_GET['lyid'];
$bid=(int)$_GET['bid'];
$r=$empire->fetch1("select * from {$dbtbpre}enewsgbook where lyid='$lyid' limit 1");
$username="游客";
if($r['userid'])
{
	$username="<a href='../member/AddMember.php?enews=EditMember&userid=".$r['userid'].$ecms_hashur['ehref']."' target=_blank>".$r['username']."</a>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>回复留言</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" method="post" action="gbook.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
  <?=$ecms_hashur['form']?>
    <tr class=header> 
      <td height="25" colspan="2">回复/修改留言
        <input name="enews" type="hidden" id="enews" value="ReGbook">
        <input name="lyid" type="hidden" id="lyid" value="<?=$lyid?>">
        <input name="bid" type="hidden" id="bid" value="<?=$bid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">留言发表者:</td>
      <td width="80%" height="25"> 
        <?=$r[name]?>&nbsp;(<?=$username?>)
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">留言内容:</td>
      <td height="25"> 
        <?=nl2br($r[lytext])?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">发布时间:</td>
      <td height="25">
        <?=$r[lytime]?>&nbsp;
        (IP:
        <?=$r[ip]?>)
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>回复内容:</strong></td>
      <td height="25"><textarea name="retext" cols="60" rows="9" id="retext"><?=$r[retext]?></textarea> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center">[ <a href="javascript:window.close();">关 
          闭</a> ]</div></td>
    </tr>
  </table>
</form>
</body>
</html>
