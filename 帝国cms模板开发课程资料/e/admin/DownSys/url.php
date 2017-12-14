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
CheckLevel($logininid,$loginin,$classid,"downurl");

//增加url地址
function AddDownurl($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[urlname]))
	{printerror("EmptyDownurl","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"downurl");
	$downtype=(int)$add['downtype'];
	$sql=$empire->query("insert into {$dbtbpre}enewsdownurlqz(urlname,url,downtype) values('$add[urlname]','$add[url]',$downtype);");
	$urlid=$empire->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("urlid=".$urlid);
		printerror("AddDownurlSuccess","url.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改url地址
function EditDownurl($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[urlid]=(int)$add[urlid];
	if(empty($add[urlname])||empty($add[urlid]))
	{printerror("EmptyDownurl","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"downurl");
	$downtype=(int)$add['downtype'];
	$sql=$empire->query("update {$dbtbpre}enewsdownurlqz set urlname='$add[urlname]',url='$add[url]',downtype=$downtype where urlid='$add[urlid]'");
	if($sql)
	{
		//操作日志
		insert_dolog("urlid=".$add[urlid]);
		printerror("EditDownurlSuccess","url.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除url地址
function DelDownurl($urlid,$userid,$username){
	global $empire,$dbtbpre;
	$urlid=(int)$urlid;
	if(empty($urlid))
	{printerror("NotChangeDownurlid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"downurl");
	$sql=$empire->query("delete from {$dbtbpre}enewsdownurlqz where urlid='$urlid'");
	if($sql)
	{
		//操作日志
		insert_dolog("urlid=".$urlid);
		printerror("DelDownurlSuccess","url.php".hReturnEcmsHashStrHref2(1));
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
//增加前缀
if($enews=="AddDownurl")
{
	AddDownurl($_POST,$logininid,$loginin);
}
//修改前缀
elseif($enews=="EditDownurl")
{
	EditDownurl($_POST,$logininid,$loginin);
}
//删除前缀
elseif($enews=="DelDownurl")
{
	$urlid=$_GET['urlid'];
	DelDownurl($urlid,$logininid,$loginin);
}
else
{}
$sql=$empire->query("select urlid,urlname,url,downtype from {$dbtbpre}enewsdownurlqz order by urlid desc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理下载地址前缀</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="url.php<?=$ecms_hashur['whehref']?>">管理下载地址前缀</a></td>
  </tr>
</table>
<form name="form1" method="post" action="url.php">
  <input type=hidden name=enews value=AddDownurl>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" class="header">增加下载地址前缀:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 名称: 
        <input name="urlname" type="text" id="urlname">
        地址: 
        <input name="url" type="text" id="url" value="http://" size="38">
        下载方式: <select name="downtype" id="downtype">
          <option value="0">HEADER</option>
          <option value="1">META</option>
          <option value="2">READ</option>
        </select> <input type="submit" name="Submit" value="增加"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="74%" height="25">下载地址前缀管理:</td>
    <td width="26%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=url.php>
	  <?=$ecms_hashur['form']?>
  <input type=hidden name=enews value=EditDownurl>
  <input type=hidden name=urlid value=<?=$r[urlid]?>>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25">名称: 
        <input name="urlname" type="text" id="urlname" value="<?=$r[urlname]?>">
        地址: 
        <input name="url" type="text" id="url" value="<?=$r[url]?>" size="30">
        <select name="downtype" id="downtype">
          <option value="0"<?=$r['downtype']==0?' selected':''?>>HEADER</option>
          <option value="1"<?=$r['downtype']==1?' selected':''?>>META</option>
          <option value="2"<?=$r['downtype']==2?' selected':''?>>READ</option>
        </select> </td>
    <td height="25"><div align="center">
          <input type="submit" name="Submit3" value="修改">&nbsp;
          <input type="button" name="Submit4" value="删除" onclick="if(confirm('确认要删除?')){self.location.href='url.php?enews=DelDownurl&urlid=<?=$r[urlid]?><?=$ecms_hashur['href']?>';}">
        </div></td>
  </tr>
  </form>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class=tableborder>
  <tr> 
    <td height="26" bgcolor="#FFFFFF"><strong>下载方式说明：</strong></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#FFFFFF"><strong>HEADER：</strong>使用header转向，通常设为这个。<br>
      <strong>META：</strong>直接转自，如果是FTP地址推荐选择这个。<br>
      <strong>READ：</strong>使用PHP程序读取，防盗链较强，但较占资源，服务器本地小文件可选择。</td>
  </tr>
</table>
</body>
</html>
