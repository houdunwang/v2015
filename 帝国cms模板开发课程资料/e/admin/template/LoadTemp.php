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
$url="<a href=LoadTemp.php".$ecms_hashur['whehref'].">批量导入栏目模板</a>";
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>批量导入栏目模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="../ecmstemp.php" onsubmit="return confirm('确认要导入？');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">批量导入栏目模板 
          <input name="enews" type="hidden" id="enews" value="LoadTempInClass">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center"><br>
          <input type="submit" name="Submit" value="开始导入模板">
          <br>
          <br>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="center">(说明：非终极栏目有效，请将要导入的模板上传至：<a href="ShowLoadTempPath.php<?=$ecms_hashur['whehref']?>" target="_blank"><strong>/e/data/LoadTemp</strong></a>,然后点击导入模板．<br>
          模板文件命名形式：<strong><font color="#FF0000">栏目ID.htm</font></strong> ,系统会搜索相应的&quot;ID文件&quot;进行导入．)</div></td>
    </tr>
  </table>
</form>
</body>
</html>
