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
CheckLevel($logininid,$loginin,$classid,"user");

//增加部门
function AddUserClass($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[classname])
	{
		printerror("EmptyUserClass","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"user");
	$add[classname]=hRepPostStr($add[classname],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsuserclass(classname) values('".$add[classname]."');");
	$lastid=$empire->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$lastid."<br>classname=".$add[classname]);
		printerror("AddUserClassSuccess","UserClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改部门
function EditUserClass($add,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$add[classid];
	if(!$add[classname]||!$classid)
	{
		printerror("EmptyUserClass","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"user");
	$add[classname]=hRepPostStr($add[classname],1);
	$sql=$empire->query("update {$dbtbpre}enewsuserclass set classname='".$add[classname]."' where classid='$classid'");
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$classid."<br>classname=".$add[classname]);
		printerror("EditUserClassSuccess","UserClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除部门
function DelUserClass($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror("NotDelUserClassid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"user");
	$r=$empire->fetch1("select classname from {$dbtbpre}enewsuserclass where classid='$classid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsuserclass where classid='$classid'");
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("DelUserClassSuccess","UserClass.php".hReturnEcmsHashStrHref2(1));
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
if($enews=="AddUserClass")//增加部门
{
	AddUserClass($_POST,$logininid,$loginin);
}
elseif($enews=="EditUserClass")//修改部门
{
	EditUserClass($_POST,$logininid,$loginin);
}
elseif($enews=="DelUserClass")//删除部门
{
	$classid=$_GET['classid'];
	DelUserClass($classid,$logininid,$loginin);
}
else
{}

$sql=$empire->query("select classid,classname from {$dbtbpre}enewsuserclass order by classid desc");
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
    <td><p>位置：<a href="ListUser.php<?=$ecms_hashur['whehref']?>">管理用户</a> &gt; <a href="UserClass.php<?=$ecms_hashur['whehref']?>">管理部门</a></p>
      </td>
  </tr>
</table>
<form name="form1" method="post" action="UserClass.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">增加部门: 
        <input name=enews type=hidden id="enews" value=AddUserClass>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 部门名称: 
        <input name="classname" type="text" id="classname">
        <input type="submit" name="Submit" value="增加">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="10%"><div align="center">ID</div></td>
    <td width="59%" height="25"><div align="center">部门名称</div></td>
    <td width="31%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=UserClass.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditUserClass>
    <input type=hidden name=classid value=<?=$r[classid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center"><?=$r[classid]?></div></td>
      <td height="25"> <div align="center">
          <input name="classname" type="text" id="classname" value="<?=$r[classname]?>">
        </div></td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="修改">
          &nbsp; 
          <input type="button" name="Submit4" value="删除" onclick="if(confirm('确认要删除?')){self.location.href='UserClass.php?enews=DelUserClass&classid=<?=$r[classid]?><?=$ecms_hashur['href']?>';}">
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
