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
CheckLevel($logininid,$loginin,$classid,"word");

//------------------增加禁用字符
function AddWord($oldword,$newword,$userid,$username){
	global $empire,$dbtbpre;
	if(!$oldword)
	{printerror("EmptyWord","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"word");
	$sql=$empire->query("insert into {$dbtbpre}enewswords(oldword,newword) values('".eaddslashes($oldword)."','".eaddslashes($newword)."');");
	$wordid=$empire->lastid();
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("wordid=".$wordid);
		printerror("AddWordSuccess","word.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//----------------修改禁用字符
function EditWord($wordid,$oldword,$newword,$userid,$username){
	global $empire,$dbtbpre;
	if(!$oldword||!$wordid)
	{printerror("EmptyWord","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"word");
	$wordid=(int)$wordid;
	$sql=$empire->query("update {$dbtbpre}enewswords set oldword='".eaddslashes($oldword)."',newword='".eaddslashes($newword)."' where wordid='$wordid'");
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("wordid=".$wordid);
	printerror("EditWordSuccess","word.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//---------------删除禁用字符
function DelWord($wordid,$userid,$username){
	global $empire,$dbtbpre;
	$wordid=(int)$wordid;
	if(!$wordid)
	{printerror("NotDelWordid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"word");
	$sql=$empire->query("delete from {$dbtbpre}enewswords where wordid='$wordid'");
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("wordid=".$wordid);
		printerror("DelWordSuccess","word.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//增加过滤字符
if($enews=="AddWord")
{
	$oldword=$_POST['oldword'];
	$newword=$_POST['newword'];
	AddWord($oldword,$newword,$logininid,$loginin);
}
//修改过滤字符
elseif($enews=="EditWord")
{
	$wordid=$_POST['wordid'];
	$oldword=$_POST['oldword'];
	$newword=$_POST['newword'];
	EditWord($wordid,$oldword,$newword,$logininid,$loginin);
}
//删除过滤字符
elseif($enews=="DelWord")
{
	$wordid=$_GET['wordid'];
	DelWord($wordid,$logininid,$loginin);
}
else
{}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$search='';
$search.=$ecms_hashur['ehref'];
$totalquery="select count(*) as total from {$dbtbpre}enewswords";
$num=$empire->gettotal($totalquery);
$query="select wordid,oldword,newword from {$dbtbpre}enewswords order by wordid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>过滤字符</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="word.php<?=$ecms_hashur['whehref']?>">管理过滤字符</a></td>
  </tr>
</table>
<form name="form1" method="post" action="word.php">
  <input type=hidden name=enews value=AddWord>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">增加过滤字符:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 将新闻内容包含 
        <textarea name="oldword" cols="45" rows="5" id="oldword"></textarea>
        替换成 
        <textarea name="newword" cols="45" rows="5" id="newword"></textarea> 
        <input type="submit" name="Submit" value="增加">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="86%" height="25">过滤字符</td>
    <td width="14%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=word.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditWord>
    <input type=hidden name=wordid value=<?=$r[wordid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"> 将新闻内容包含 
        <textarea name="oldword" cols="43" rows="5" id="oldword"><?=ehtmlspecialchars($r[oldword])?></textarea>
        替换成 
        <textarea name="newword" cols="43" rows="5" id="newword"><?=ehtmlspecialchars($r[newword])?></textarea> 
      </td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="修改">
          &nbsp; 
          <input type="button" name="Submit4" value="删除" onclick="if(confirm('确认要删除?')){self.location.href='word.php?enews=DelWord&wordid=<?=$r[wordid]?><?=$ecms_hashur['href']?>';}">
        </div></td>
    </tr>
  </form>
  <?
  }
  db_close();
  $empire=null;
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">
	  <?=$returnpage?>
	  </td>
    </tr>
</table>
</body>
</html>
