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
CheckLevel($logininid,$loginin,$classid,"wap");

//增加wap模板
function AddWapStyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(empty($path)||empty($add['stylename']))
	{
		printerror("EmptyWapStyle","history.go(-1)");
	}
	//目录是否存在
	if(!file_exists("../../wap/template/".$path))
	{
		printerror("EmptyWapStylePath","history.go(-1)");
	}
	$sql=$empire->query("insert into {$dbtbpre}enewswapstyle(stylename,path) values('$add[stylename]',$path);");
	if($sql)
	{
		$styleid=$empire->lastid();
		//操作日志
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("AddWapStyleSuccess","WapStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改wap模板
function EditWapStyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$add['styleid'];
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(!$styleid||empty($path)||empty($add['stylename']))
	{
		printerror("EmptyWapStyle","history.go(-1)");
	}
	//目录是否存在
	if(!file_exists("../../wap/template/".$path))
	{
		printerror("EmptyWapStylePath","history.go(-1)");
	}
	$sql=$empire->query("update {$dbtbpre}enewswapstyle set stylename='$add[stylename]',path=$path where styleid=$styleid");
	if($sql)
	{
		//操作日志
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("EditWapStyleSuccess","WapStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除wap模板
function DelWapStyle($styleid,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$styleid=(int)$styleid;
	if(!$styleid)
	{
		printerror("EmptyWapStyleid","history.go(-1)");
	}
	$r=$empire->fetch1("select stylename,path from {$dbtbpre}enewswapstyle where styleid=$styleid");
	if($styleid==$public_r['wapdefstyle'])
	{
		printerror("NotDelDefWapStyle","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewswapstyle where styleid=$styleid");
	if($sql)
	{
		//操作日志
		insert_dolog("styleid=$styleid&stylename=$r[stylename]");
		printerror("DelWapStyleSuccess","WapStyle.php".hReturnEcmsHashStrHref2(1));
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
//增加wap模板
if($enews=="AddWapStyle")
{
	AddWapStyle($_POST,$logininid,$loginin);
}
//修改wap模板
elseif($enews=="EditWapStyle")
{
	EditWapStyle($_POST,$logininid,$loginin);
}
//删除wap模板
elseif($enews=="DelWapStyle")
{
	DelWapStyle($_GET['styleid'],$logininid,$loginin);
}
else
{}
$pr=$empire->fetch1("select wapdefstyle from {$dbtbpre}enewspublic limit 1");
$sql=$empire->query("select styleid,stylename,path from {$dbtbpre}enewswapstyle order by styleid");
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
    <td><p>位置：<a href="WapStyle.php<?=$ecms_hashur['whehref']?>">管理WAP模板</a></p></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit522" value="WAP设置" onclick="self.location.href='SetWap.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="form1" method="post" action="WapStyle.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">增加WAP模板: 
        <input name=enews type=hidden id="enews" value=AddWapStyle>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 模板名称: 
        <input name="stylename" type="text" id="stylename">
        模板目录:e/wap/template/ 
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
    <td width="29%" height="25"><div align="center">模板名称</div></td>
    <td width="30%"><div align="center">模板目录</div></td>
    <td width="34%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$bgcolor="#FFFFFF";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
  	if($r[styleid]==$pr['wapdefstyle'])
	{
		$bgcolor="#DBEAF5";
		$movejs='';
	}
  ?>
  <form name=form2 method=post action=WapStyle.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditWapStyle>
    <input type=hidden name=styleid value=<?=$r[styleid]?>>
    <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
      <td><div align="center">
          <?=$r[styleid]?>
        </div></td>
      <td height="25"> <div align="center"> 
          <input name="stylename" type="text" id="stylename" value="<?=$r[stylename]?>">
        </div></td>
      <td><div align="center">e/wap/template/
<input name="path" type="text" id="path" value="<?=$r[path]?>" size="6">
        </div></td>
      <td height="25"><div align="center">
          <input type="submit" name="Submit3" value="修改">
          &nbsp; 
          <input type="button" name="Submit4" value="删除" onclick="if(confirm('确认要删除?')){self.location.href='WapStyle.php?enews=DelWapStyle&styleid=<?=$r[styleid]?><?=$ecms_hashur['href']?>';}">
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
