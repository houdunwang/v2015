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
CheckLevel($logininid,$loginin,$classid,"dttemp");
//关闭
if(!$ecms_config['esafe']['openeditdttemp'])
{
	echo"没有开启在线修改动态页面模板";
	exit();
}

//取得动态模板内容
function GetDtTempFiletext($tempid){
	global $empire,$dbtbpre;
	$tempid=(int)$tempid;
	if(!$tempid)
	{
		printerror('ErrorUrl','');
	}
	$tempr=$empire->fetch1("select * from {$dbtbpre}enewstempdt where tempid='$tempid'");
	if(!$tempr['tempid'])
	{
		printerror('ErrorUrl','');
	}
	$file=ECMS_PATH.$tempr['tempfile'];
	if(!file_exists($file))
	{
		printerror('FileNotExist','');
	}
	$tempr['temptext']=ReadFiletext($file);
	return $tempr;
}

//修改动态模板内容
function EditDtTempFiletext($add,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,'dttemp');
	$tempid=(int)$add['tempid'];
	if(!$tempid)
	{
		printerror('ErrorUrl','');
	}
	$tempr=$empire->fetch1("select tempid,tempname,tempvar,tempfile from {$dbtbpre}enewstempdt where tempid='$tempid'");
	if(!$tempr['tempid'])
	{
		printerror('ErrorUrl','');
	}
	$file=ECMS_PATH.$tempr['tempfile'];
	if(!file_exists($file))
	{
		printerror('FileNotExist','');
	}
	$temptext=ClearAddsData($add['temptext']);
	WriteFiletext_n($file,$temptext);
	//操作日志
	insert_dolog("tempid=".$tempid."<br>tempname=".$tempr['tempname']);
	printerror("EditDttempSuccess","EditDttemp.php?tempid=$tempid".hReturnEcmsHashStrHref2(0));
}

//操作
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include("../../class/tempfun.php");
}
//增加模板
if($enews=="EditDtTempFiletext")
{
	EditDtTempFiletext($_POST,$logininid,$loginin);
}
else
{}

//修改
$tempid=(int)$_GET['tempid'];
$r=GetDtTempFiletext($tempid);
$url="修改动态页面模板: ".$r['tempname'];
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>修改动态页面模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ReturnHtml(html)
{
document.form1.temptext.value=html;
}
</script>
<SCRIPT lanuage="JScript">
<!--
function tempturnit(ss)
{
 if (ss.style.display=="") 
  ss.style.display="none";
 else
  ss.style.display=""; 
}
-->
</SCRIPT>
<script>
function ReTempBak(){
	self.location.reload();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="EditDttemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 
        修改动态页面模板
        <input name="enews" type="hidden" id="enews" value="EditDtTempFiletext"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">模板名称(*)</td>
      <td width="81%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>" size="30">      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">模板文件地址</td>
      <td height="25">/<?=$r[tempfile]?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>模板内容</strong>(*)</td>
      <td height="25">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="temptext" cols="90" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars($r[temptext])?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="保存模板"> &nbsp;<input type="reset" name="Submit2" value="重置"></td>
    </tr>
	</form>
  </table>
</body>
</html>
