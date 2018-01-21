<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"execsql");
$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=16;//每页显示条数
$page_line=25;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select id,sqlname from {$dbtbpre}enewssql";
$totalquery="select count(*) as total from {$dbtbpre}enewssql";
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理SQL语句</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td height="25">位置：<a href="ListSql.php<?=$ecms_hashur['whehref']?>">管理SQL语句</a></td>
    <td width="50%"><div align="right" class="emenubutton">
		<input type="button" name="Submit5" value="增加SQL语句" onclick="self.location.href='AddSql.php?enews=AddSql<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
        <input type="button" name="Submit4" value="执行SQL语句" onclick="self.location.href='DoSql.php<?=$ecms_hashur['whehref']?>';">    
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="10%" height="25"> <div align="center">ID</div></td>
    <td width="62%" height="25"> <div align="center">SQL名称</div></td>
    <td width="28%" height="25"> <div align="center">操作</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r['id']?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r['sqlname']?>
      </div></td>
    <td height="25"> <div align="center">[<a href="DoSql.php?enews=ExecSql&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要执行SQL？');">执行</a>] [<a href="AddSql.php?enews=EditSql&id=<?=$r[id]?><?=$ecms_hashur['ehref']?>">修改</a>]&nbsp;[<a href="DoSql.php?enews=DelSql&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="3">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>
