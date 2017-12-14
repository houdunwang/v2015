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
CheckLevel($logininid,$loginin,$classid,"writer");

//------------------增加作者
function AddWriter($writer,$email,$userid,$username){
	global $empire,$dbtbpre;
	if(!$writer)
	{printerror("EmptyWriter","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"writer");
	$sql=$empire->query("insert into {$dbtbpre}enewswriter(writer,email) values('$writer','$email');");
	$lastid=$empire->lastid();
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("wid=".$lastid."<br>writer=".$writer);
		printerror("AddWriterSuccess","writer.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//----------------修改作者
function EditWriter($wid,$writer,$email,$userid,$username){
	global $empire,$dbtbpre;
	if(!$writer||!$wid)
	{printerror("EmptyWriter","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"writer");
	$wid=(int)$wid;
	$sql=$empire->query("update {$dbtbpre}enewswriter set writer='$writer',email='$email' where wid='$wid'");
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("wid=".$wid."<br>writer=".$writer);
		printerror("EditWriterSuccess","writer.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//---------------删除作者
function DelWriter($wid,$userid,$username){
	global $empire,$dbtbpre;
	$wid=(int)$wid;
	if(!$wid)
	{printerror("NotDelWid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"writer");
	$r=$empire->fetch1("select writer from {$dbtbpre}enewswriter where wid='$wid'");
	$sql=$empire->query("delete from {$dbtbpre}enewswriter where wid='$wid'");
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("wid=".$wid."<br>writer=".$r[writer]);
		printerror("DelWriterSuccess","writer.php".hReturnEcmsHashStrHref2(1));
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
if($enews=="AddWriter")
{
	$writer=$_POST['writer'];
	$email=$_POST['email'];
	AddWriter($writer,$email,$logininid,$loginin);
}
elseif($enews=="EditWriter")
{
	$wid=$_POST['wid'];
	$writer=$_POST['writer'];
	$email=$_POST['email'];
	EditWriter($wid,$writer,$email,$logininid,$loginin);
}
elseif($enews=="DelWriter")
{
	$wid=$_GET['wid'];
	DelWriter($wid,$logininid,$loginin);
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
$totalquery="select count(*) as total from {$dbtbpre}enewswriter";
$num=$empire->gettotal($totalquery);
$query="select wid,writer,email from {$dbtbpre}enewswriter order by wid desc limit $offset,$line";
$sql=$empire->query($query);
$addwritername=RepPostStr($_GET['addwritername'],1);
$search.="&addwritername=$addwritername";
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理作者</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="writer.php<?=$ecms_hashur['whehref']?>">管理作者</a></td>
  </tr>
</table>
<form name="form1" method="post" action="writer.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">增加作者: 
        <input name=enews type=hidden id="enews" value=AddWriter>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 作者名称: 
        <input name="writer" type="text" id="writer" value="<?=$addwritername?>">
        联系邮箱: 
        <input name="email" type="text" id="email" value="mailto:" size="36"> 
        <input type="submit" name="Submit" value="增加">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="70%" height="25">作者</td>
    <td width="30%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=writer.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditWriter>
    <input type=hidden name=wid value=<?=$r[wid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25">作者名称: 
        <input name="writer" type="text" id="writer" value="<?=$r[writer]?>">
        联系邮箱: 
        <input name="email" type="text" id="email" value="<?=$r[email]?>" size="30"> 
      </td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="修改">
          &nbsp; 
          <input type="button" name="Submit4" value="删除" onclick="if(confirm('确认要删除?')){self.location.href='writer.php?enews=DelWriter&wid=<?=$r[wid]?><?=$ecms_hashur['href']?>';}">
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
