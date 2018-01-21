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
CheckLevel($logininid,$loginin,$classid,"tags");
$defdate=date('Y-m-d H:i:s',time()-180*24*3600);
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>TAGS</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="ListTags.php<?=$ecms_hashur['whehref']?>">管理TAGS</a> &gt; 删除过期的TAGS信息</td>
  </tr>
</table>
<form name="form1" method="post" action="ListTags.php" onsubmit="return confirm('确认要操作?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">删除过期的TAGS信息 
          <input name="enews" type="hidden" id="enews" value="DelOldTagsInfo">
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">删除截止于 
          <input name="newstime" type="text" id="newstime" value="<?=$defdate?>">
          之前的TAGS信息 
          <input type="submit" name="Submit" value="提交">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>