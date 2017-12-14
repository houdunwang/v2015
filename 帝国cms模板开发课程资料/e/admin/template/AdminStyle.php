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
CheckLevel($logininid,$loginin,$classid,"adminstyle");

//更新样式缓存
function UpAdminstyle(){
	global $empire,$dbtbpre;
	$adminstyle=',';
	$sql=$empire->query("select path from {$dbtbpre}enewsadminstyle");
	while($r=$empire->fetch($sql))
	{
		$adminstyle.=$r['path'].',';
	}
	$empire->query("update {$dbtbpre}enewspublic set adminstyle='$adminstyle'");
	GetConfig();
}

//增加后台样式
function AddAdminstyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(empty($path)||empty($add['stylename']))
	{
		printerror("EmptyAdminStyle","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"adminstyle");
	//目录是否存在
	if(!file_exists("../adminstyle/".$path))
	{
		printerror("EmptyAdminStylePath","history.go(-1)");
	}
	$sql=$empire->query("insert into {$dbtbpre}enewsadminstyle(stylename,path,isdefault) values('$add[stylename]',$path,0);");
	if($sql)
	{
		UpAdminstyle();
		$styleid=$empire->lastid();
		//操作日志
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("AddAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改后台样式
function EditAdminStyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$add['styleid'];
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(!$styleid||empty($path)||empty($add['stylename']))
	{
		printerror("EmptyAdminStyle","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"adminstyle");
	//目录是否存在
	if(!file_exists("../adminstyle/".$path))
	{
		printerror("EmptyAdminStylePath","history.go(-1)");
	}
	$sql=$empire->query("update {$dbtbpre}enewsadminstyle set stylename='$add[stylename]',path=$path where styleid=$styleid");
	if($sql)
	{
		UpAdminstyle();
		//操作日志
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("EditAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//默认后台样式
function DefAdminStyle($styleid,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$styleid;
	if(!$styleid)
	{
		printerror("EmptyAdminStyleid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"adminstyle");
	$r=$empire->fetch1("select stylename,path from {$dbtbpre}enewsadminstyle where styleid=$styleid");
	$usql=$empire->query("update {$dbtbpre}enewsadminstyle set isdefault=0");
	$sql=$empire->query("update {$dbtbpre}enewsadminstyle set isdefault=1 where styleid=$styleid");
	$upsql=$empire->query("update {$dbtbpre}enewspublic set defadminstyle='$r[path]' limit 1");
	if($sql)
	{
		GetConfig();
		//操作日志
		insert_dolog("styleid=$styleid&stylename=$r[stylename]");
		printerror("DefAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除后台样式
function DelAdminStyle($styleid,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$styleid;
	if(!$styleid)
	{
		printerror("EmptyAdminStyleid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"adminstyle");
	$r=$empire->fetch1("select stylename,path,isdefault from {$dbtbpre}enewsadminstyle where styleid=$styleid");
	if($r['isdefault'])
	{
		printerror("NotDelDefAdminStyle","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsadminstyle where styleid=$styleid");
	if($sql)
	{
		UpAdminstyle();
		//操作日志
		insert_dolog("styleid=$styleid&stylename=$r[stylename]");
		printerror("DelAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//增加后台样式
if($enews=="AddAdminStyle")
{
	AddAdminstyle($_POST,$logininid,$loginin);
}
//修改后台样式
elseif($enews=="EditAdminStyle")
{
	EditAdminStyle($_POST,$logininid,$loginin);
}
//默认后台样式
elseif($enews=="DefAdminStyle")
{
	DefAdminStyle($_GET['styleid'],$logininid,$loginin);
}
//删除后台样式
elseif($enews=="DelAdminStyle")
{
	DelAdminStyle($_GET['styleid'],$logininid,$loginin);
}
$sql=$empire->query("select styleid,stylename,path,isdefault from {$dbtbpre}enewsadminstyle order by styleid");
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
    <td><p>位置：<a href="AdminStyle.php<?=$ecms_hashur['whehref']?>">管理后台样式</a></p>
      </td>
  </tr>
</table>
<form name="form1" method="post" action="AdminStyle.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">增加后台样式: 
        <input name=enews type=hidden id="enews" value=AddAdminStyle>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 样式名称: 
        <input name="stylename" type="text" id="stylename">
        样式目录:adminstyle/ 
        <input name="path" type="text" id="path" size="6">
        (请填写数字) 
        <input type="submit" name="Submit" value="增加">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="7%"><div align="center">ID</div></td>
    <td width="29%" height="25"><div align="center">样式名称</div></td>
    <td width="30%"><div align="center">样式目录</div></td>
    <td width="34%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$bgcolor="#FFFFFF";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
  	if($r[isdefault])
	{
		$bgcolor="#DBEAF5";
		$movejs='';
	}
  ?>
  <form name=form2 method=post action=AdminStyle.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditAdminStyle>
    <input type=hidden name=styleid value=<?=$r[styleid]?>>
    <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
      <td><div align="center">
          <?=$r[styleid]?>
        </div></td>
      <td height="25"> <div align="center"> 
          <input name="stylename" type="text" id="stylename" value="<?=$r[stylename]?>">
        </div></td>
      <td><div align="center">adminstyle/ 
          <input name="path" type="text" id="path" value="<?=$r[path]?>" size="6">
        </div></td>
      <td height="25"><div align="center">
          <input type="button" name="Submit4" value="设为默认" onclick="self.location.href='AdminStyle.php?enews=DefAdminStyle&styleid=<?=$r[styleid]?><?=$ecms_hashur['href']?>';"> 
		  &nbsp;
          <input type="submit" name="Submit3" value="修改">
          &nbsp; 
          <input type="button" name="Submit4" value="删除" onclick="self.location.href='AdminStyle.php?enews=DelAdminStyle&styleid=<?=$r[styleid]?><?=$ecms_hashur['href']?>';">
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
