<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../data/dbcache/class.php");
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

$classid=(int)$_GET['classid'];
$id=(int)$_GET['id'];
$enews=ehtmlspecialchars($_GET['enews']);
//验证权限
CheckLevel($logininid,$loginin,$classid,"cj");
if($_GET['from'])
{
	$listclasslink="ListPageInfoClass.php";
}
else
{
	$listclasslink="ListInfoClass.php";
}
//节点名称
$cr=$empire->fetch1("select classname,newsclassid,classid,tbname from {$dbtbpre}enewsinfoclass where classid='$classid'");
if(!$cr[classid])
{
	printerror("ErrorUrl","history.go(-1)");
}
$r=$empire->fetch1("select * from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where id='$id'");
if(empty($r[id]))
{
	printerror("ErrorUrl","history.go(-1)");
}
//模型
$modid=(int)$class_r[$cr[newsclassid]][modid];
$enter=$emod_r[$modid]['enter'];
//会员组
$sql1=$empire->query("select * from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	$ygroup.="<option value=".$l_r[groupid].">".$l_r[groupname]."</option>";
}
//----------------特殊模型----------------
//下载地址前缀
if(strstr($enter,',downpath,')||strstr($enter,',onlinepath,'))
{
	$downurlqz="";
	$newdownqz="";
	$downsql=$empire->query("select urlname,url,urlid from {$dbtbpre}enewsdownurlqz order by urlid");
	while($downr=$empire->fetch($downsql))
	{
		$downurlqz.="<option value='".$downr[url]."'>".$downr[urlname]."</option>";
		$newdownqz.="<option value='".$downr[urlid]."'>".$downr[urlname]."</option>";
	}
}
//html编辑器
if($emod_r[$modid]['editorf']&&$emod_r[$modid]['editorf']!=',')
{
	include('ecmseditor/infoeditor/fckeditor.php');
}
//栏目名称
$newsclassid=$cr[newsclassid];
$newsclassname=$class_r[$newsclassid][classname];
$newsbclassname=$class_r[$class_r[$newsclassid][bclassid]][classname];
$newsclass="<font color=red>".$newsbclassname."&nbsp;>&nbsp;".$newsclassname."</font>";
//表单文件
$cjfile="../data/html/editcj".$modid.".php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>修改采集信息</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<?=$htmlareacode?>
<script>
function doSpChangeFile(name,url,filesize,filetype,idvar){
	document.getElementById(idvar).value=url;
	if(document.add.filetype!=null)
	{
		if(document.add.filetype.value=='')
		{
			document.add.filetype.value=filetype;
		}
	}
	if(document.add.filesize!=null)
	{
		if(document.add.filesize.value=='')
		{
			document.add.filesize.value=filesize;
		}
	}
}

function SpOpenChFile(type,field){
	window.open('ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&classid=<?=$classid?>&filepass=<?=$filepass?>&type='+type+'&sinfo=1&tranfrom=2&field='+field,'','width=700,height=550,scrollbars=yes');
}

function bs(){
	var f=document.add;
	if(f.title.value.length==0){alert("标题还没写");f.title.focus();return false;}
}
function foreColor(){
  if(!Error())	return;
  var arr = showModalDialog("../data/html/selcolor.html", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
  if (arr != null) document.add.titlecolor.value=arr;
  else document.add.titlecolor.focus();
}
function FieldChangeColor(obj){
  if(!Error())	return;
  var arr = showModalDialog("../data/html/selcolor.html", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
  if (arr != null) obj.value=arr;
  else obj.focus();
}
</script>
<script src="ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td>位置：采集 &gt; <a href="<?=$listclasslink?><?=$ecms_hashur['whehref']?>">管理节点</a> &gt; <a href="CheckCj.php?classid=<?=$classid?>&from=<?=ehtmlspecialchars($_GET['from'])?><?=$ecms_hashur['ehref']?>">审核采集</a> 
      &gt; 节点名称： 
      <?=$cr[classname]?>
      &gt; 修改采集信息</td>
  </tr>
  <tr>
    <td>入库栏目： 
      <?=$newsclass?>
    </td>
  </tr>
</table>
<form name="add" method="post" enctype="multipart/form-data" action=ecmscj.php>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="17%" height="25">修改采集信息</td>
      <td width="83%" height="25"><input type=hidden name=from value="<?=ehtmlspecialchars($_GET['from'])?>">
	  <input name="id" type="hidden" value="<?=$id?>"> 
        <input name="classid" type="hidden" value="<?=$classid?>">
		<input name="editnum" type="hidden" value="<?=$editnum?>">
        <input name="enews" type="hidden" value="<?=$enews?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">采集地址：</td>
      <td height="25"><a href="<?=$r[oldurl]?>" target="_blank">
        <?=$r[oldurl]?>
        </a></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">采集时间：</td>
      <td height="25">
        <?=$r[tmptime]?>
      </td>
    </tr>
    <?php
	@include($cjfile);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="修改"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>