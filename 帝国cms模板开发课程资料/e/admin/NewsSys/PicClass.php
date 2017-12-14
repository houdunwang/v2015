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
CheckLevel($logininid,$loginin,$classid,"picnews");

//增加图片信息分类
function AddPicClass($classname,$userid,$username){
	global $empire,$dbtbpre;
	if(!$classname)
	{printerror("EmptyPicNewsClass","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"picnews");
	$sql=$empire->query("insert into {$dbtbpre}enewspicclass(classname) values('$classname');");
	$classid=$empire->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$classid."<br>classname=".$classname);
		printerror("AddPicNewsClassSuccess","PicClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改图片信息分类
function EditPicClass($classid,$classname,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classname||!$classid)
	{printerror("EmptyPicNewsClass","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"picnews");
	$sql=$empire->query("update {$dbtbpre}enewspicclass set classname='$classname' where classid='$classid'");
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$classid."<br>classname=".$classname);
		printerror("EditPicNewsClassSuccess","PicClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除图片信息分类
function DelPicClass($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classid)
	{printerror("NotPicNewsClassid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"picnews");
	$r=$empire->fetch1("select classname from {$dbtbpre}enewspicclass where classid='$classid'");
	$sql=$empire->query("delete from {$dbtbpre}enewspicclass where classid='$classid'");
	$sql1=$empire->query("delete from {$dbtbpre}enewspic where classid='$classid'");
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("DelPicNewsClassSuccess","PicClass.php".hReturnEcmsHashStrHref2(1));
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
//增加图片新闻分类
if($enews=="AddPicClass")
{
	$classname=$_POST['classname'];
	AddPicClass($classname,$logininid,$loginin);
}
//修改图片新闻分类
elseif($enews=="EditPicClass")
{
	$classname=$_POST['classname'];
	$classid=$_POST['classid'];
	EditPicClass($classid,$classname,$logininid,$loginin);
}
//删除图片新闻分类
elseif($enews=="DelPicClass")
{
	$classid=$_GET['classid'];
	DelPicClass($classid,$logininid,$loginin);
}

$sql=$empire->query("select classid,classname from {$dbtbpre}enewspicclass order by classid desc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href=ListPicNews.php<?=$ecms_hashur['whehref']?>>管理图片信息</a>&nbsp;&gt;&nbsp;<a href="PicClass.php<?=$ecms_hashur['whehref']?>">管理图片信息分类</a></td>
  </tr>
</table>
<form name="form1" method="post" action="PicClass.php">
  <input type=hidden name=enews value=AddPicClass>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">增加图片信息类别:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 类别名称: 
        <input name="classname" type="text" id="classname">
        <input type="submit" name="Submit" value="增加">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="10%"><div align="center">ID</div></td>
    <td width="59%" height="25"><div align="center">类别名称</div></td>
    <td width="31%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=PicClass.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditPicClass>
    <input type=hidden name=classid value=<?=$r[classid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center"><?=$r[classid]?></div></td>
      <td height="25"> <div align="center">
          <input name="classname" type="text" id="classname" value="<?=$r[classname]?>">
        </div></td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="修改">
          &nbsp; 
          <input type="button" name="Submit4" value="删除" onclick="if(confirm('确认要删除?')){self.location.href='PicClass.php?enews=DelPicClass&classid=<?=$r[classid]?><?=$ecms_hashur['href']?>';}">
        </div></td>
    </tr>
  </form>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
</body>
</html>
