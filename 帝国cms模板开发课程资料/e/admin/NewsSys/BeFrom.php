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
CheckLevel($logininid,$loginin,$classid,"befrom");

//增加来源
function AddBefrom($sitename,$siteurl,$userid,$username){
	global $empire,$dbtbpre;
	if(!$sitename||!$siteurl)
	{
		printerror("EmptyBefrom","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"befrom");
	$sitename=hRepPostStr($sitename,1);
	$siteurl=hRepPostStr($siteurl,1);
	$sql=$empire->query("insert into {$dbtbpre}enewsbefrom(sitename,siteurl) values('".$sitename."','".$siteurl."');");
	$lastid=$empire->lastid();
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("befromid=".$lastid."<br>sitename=".$sitename);
		printerror("AddBefromSuccess","BeFrom.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改来源
function EditBefrom($befromid,$sitename,$siteurl,$userid,$username){
	global $empire,$dbtbpre;
	if(!$sitename||!$siteurl||!$befromid)
	{
		printerror("EmptyBefrom","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"befrom");
	$befromid=(int)$befromid;
	$sitename=hRepPostStr($sitename,1);
	$siteurl=hRepPostStr($siteurl,1);
	$sql=$empire->query("update {$dbtbpre}enewsbefrom set sitename='".$sitename."',siteurl='".$siteurl."' where befromid='$befromid'");
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("befromid=".$befromid."<br>sitename=".$sitename);
		printerror("EditBefromSuccess","BeFrom.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除来源
function DelBefrom($befromid,$userid,$username){
	global $empire,$dbtbpre;
	$befromid=(int)$befromid;
	if(!$befromid)
	{
		printerror("NotDelBefromid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"befrom");
	$r=$empire->fetch1("select sitename from {$dbtbpre}enewsbefrom where befromid='$befromid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsbefrom where befromid='$befromid'");
	GetConfig();//更新缓存
	if($sql)
	{
		//操作日志
		insert_dolog("befromid=".$befromid."<br>sitename=".$r[sitename]);
		printerror("DelBefromSuccess","BeFrom.php".hReturnEcmsHashStrHref2(1));
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
//增加信息来源
if($enews=="AddBefrom")
{
	$sitename=$_POST['sitename'];
	$siteurl=$_POST['siteurl'];
	AddBefrom($sitename,$siteurl,$logininid,$loginin);
}
//修改信息来源
elseif($enews=="EditBefrom")
{
	$sitename=$_POST['sitename'];
	$siteurl=$_POST['siteurl'];
	$befromid=$_POST['befromid'];
	EditBefrom($befromid,$sitename,$siteurl,$logininid,$loginin);
}
//删除信息来源
elseif($enews=="DelBefrom")
{
	$befromid=$_GET['befromid'];
	DelBefrom($befromid,$logininid,$loginin);
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
$totalquery="select count(*) as total from {$dbtbpre}enewsbefrom";
$num=$empire->gettotal($totalquery);
$query="select sitename,siteurl,befromid from {$dbtbpre}enewsbefrom order by befromid desc limit $offset,$line";
$sql=$empire->query($query);
$addsitename=ehtmlspecialchars($_GET['addsitename']);
$search.="&addsitename=$addsitename";
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>信息来源</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="BeFrom.php<?=$ecms_hashur['whehref']?>">管理信息来源</a></td>
  </tr>
</table>
<form name="form1" method="post" action="BeFrom.php">
  <input type=hidden name=enews value=AddBefrom>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr>
      <td height="25" class="header">增加信息来源:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 站点名称: 
        <input name="sitename" type="text" id="sitename" value="<?=$addsitename?>">
        链接地址:
        <input name="siteurl" type="text" id="siteurl" value="http://" size="50"> 
        <input type="submit" name="Submit" value="增加">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="70%" height="25">信息来源</td>
    <td width="30%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=BeFrom.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditBefrom>
    <input type=hidden name=befromid value=<?=$r[befromid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25">站点名称: 
        <input name="sitename" type="text" id="sitename" value="<?=$r[sitename]?>">
        链接地址: 
        <input name="siteurl" type="text" id="siteurl" value="<?=$r[siteurl]?>" size="30"> 
      </td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="修改">
          &nbsp; 
          <input type="button" name="Submit4" value="删除" onclick="if(confirm('确认要删除?')){self.location.href='BeFrom.php?enews=DelBefrom&befromid=<?=$r[befromid]?><?=$ecms_hashur['href']?>';}">
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
