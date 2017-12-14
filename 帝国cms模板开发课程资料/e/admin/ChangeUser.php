<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$field=RepPostVar($_GET['field']);
$form=RepPostVar($_GET['form']);
$line=20;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$search="&field=$field&form=$form".$ecms_hashur['ehref'];
$query="select * from {$dbtbpre}enewsuser";
$num=$empire->num($query);//取得总条数
$query=$query." order by userid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择用户</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ChangeUser(user){
	var v;
	var str;
	var r;
	str=','+opener.document.<?=$form?>.<?=$field?>.value+',';
	//重复
	r=str.split(','+user+',');
	if(r.length!=1)
	{
		return false;
	}
	if(str==",,")
	{v="";}
	else
	{v=",";}
	opener.document.<?=$form?>.<?=$field?>.value+=v+user;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="15%" height="25"><div align="center">ID</div></td>
    <td width="52%" height="25"><div align="center">用户名(点击选择)</div></td>
    <td width="33%"><div align="center">等级</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
 $gr=$empire->fetch1("select groupname from {$dbtbpre}enewsgroup where groupid='$r[groupid]'");
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25"><div align="center"> 
        <?=$r[userid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <a href="#empirecms" onclick="javascript:ChangeUser('<?=$r[username]?>');" title="选择"><?=$r[username]?></a>
      </div></td>
    <td><div align="center"> 
        <?=$gr[groupname]?>
      </div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25" colspan="3"> 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
