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
$url="<a href=ListMemberGroup.php".$ecms_hashur['whehref'].">管理会员组</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理会员组</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加会员组" onclick="self.location.href='AddMemberGroup.php?enews=AddMemberGroup<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="35%" height="25"> <div align="center">会员组名称</div></td>
    <td width="11%"><div align="center">级别值</div></td>
    <td width="16%"><div align="center">发送短消息</div></td>
    <td width="14%"><div align="center">注册地址</div></td>
    <td width="18%" height="25"> <div align="center">操作</div></td>
  </tr>
  <?
  $sql=$empire->query("select * from {$dbtbpre}enewsmembergroup order by groupid");
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[groupid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[groupname]?>
      </div></td>
    <td><div align="center"> 
        <?=$r[level]?>
      </div></td>
    <td><div align="center"><a href="SendMsg.php?groupid=<?=$r[groupid]?><?=$ecms_hashur['ehref']?>" target=_blank>发送信息</a></div></td>
    <td><div align="center"><a href="../../member/register/?groupid=<?=$r[groupid]?>" target="_blank">注册地址</a></div></td>
    <td height="25"> <div align="center">[<a href="AddMemberGroup.php?enews=EditMemberGroup&groupid=<?=$r[groupid]?><?=$ecms_hashur['ehref']?>">修改</a>] 
        [<a href="../ecmsmember.php?enews=DelMemberGroup&groupid=<?=$r[groupid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除此会员组？');">删除</a>]</div></td>
  </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6"><font color="#666666">说明：级别值越高，查看信息的权限越大</font></td>
  </tr>
</table>
</body>
</html>
