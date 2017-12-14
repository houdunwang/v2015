<?php
define('EmpireCMSAdmin','1');
require('../../../../class/connect.php');
require("../../../../class/db_sql.php");
require("../../../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=3;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$filename=ehtmlspecialchars($_GET['filename']);
$ecms=ehtmlspecialchars($_GET['ecms']);
if($ecms=="pic")
{
	$title="插入图片";
}
elseif($ecms=="flash")
{
	$title="插入FLASH";
}
elseif($ecms=="rm")
{
	$title="插入视频文件";
}
else
{
	$title="插入附件";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$title?></title>
<link href="../../../../data/images/css.css" rel="stylesheet" type="text/css">
<head>
</head>
<body>
<?
if($ecms=="pic")
{
?>
<script src="../../../../data/js/pagejs.js"></script>
<script>
function SetPicOk(ecms){
	var height=document.insertpic.height.value;
	var width=document.insertpic.width.value;
	var border=document.insertpic.border.value;
	var picsay=document.insertpic.picsay.value;
	var addjs=0,imgstr="";
	imgstr="<img src='<?=$filename?>'";
	if(document.insertpic.addjs.checked)
	{
		addjs=1;
		imgstr+=" onload=\"autosimg(this);\" onmousewheel=\"return zoomimg(this);\"";
	}
	if(!(height==""||height==0))
	{
		imgstr+=" height="+height;
	}
	if(!(width==""||width==0))
	{
		imgstr+=" width="+width;
	}
	imgstr+=" border="+border;
	imgstr="<a href=\"<?=$filename?>\" target=_blank title=\"点击查看原图\">"+imgstr+"></a>";
	if(picsay!="")
	{
		imgstr+="<br><span style='line-height=18pt'>"+picsay+"</span>";
	}
	imgstr='<center>'+imgstr+'</center>';
	if(ecms==0)
	{
		window.viewpic.innerHTML=imgstr;
	}
	else
	{
		window.returnValue=imgstr;
		window.close();
	}
}
</script>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="insertpic" method="post" action="">
    <tr class="header"> 
      <td height="23">插入图片设置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">宽度 
        <input name="width" type=text id="width" value="0" size="4">
        × 高度 
        <input name="height" type=text id="height" value="0" size="4">
        边框 
        <input name="border" type="text" id="border" value="0" size="4"> <input name="addjs" type="checkbox" id="addjs3" value="1">
        自动缩放 </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">图片下面显示文字
        <input name="picsay" type="text" id="picsay" size="30"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <input type="button" name="Submit" value="插入图片" onclick="SetPicOk(1);"> 
        <input type="button" name="Submit3" value="预览图片" onclick="SetPicOk(0);"> 
        <input type="button" name="Submit2" value="取消" onclick="window.close();"></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">
	  <table border="0" cellpadding="0" cellspacing="0">
	  <tr><td id="viewpic"></td></tr>
	  </table>
	  </td>
    </tr>
  </form>
</table>
<?
}
elseif($ecms=="flash")
{
?>
<script>
function SetPicOk(ecms){
	var height=document.insertpic.height.value;
	var width=document.insertpic.width.value;
	var picsay=document.insertpic.picsay.value;
	var imgstr="";
	if(height==""||height=="0"||width==""||width=="0")
	{
		alert("请输入高度与宽度");
		return false;
	}
	imgstr="<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\""+width+"\" height=\""+height+"\"><param name=\"movie\" value=\"<?=$filename?>\"><param name=\"quality\" value=\"high\"><embed src=\"<?=$filename?>\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\""+width+"\" height=\""+height+"\"></embed></object>";
	if(picsay!="")
	{
		imgstr+="<br><span style='line-height=18pt'>"+picsay+"</span>";
	}
	imgstr='<center>'+imgstr+'</center>';
	if(ecms==0)
	{
		window.viewpic.innerHTML=imgstr;
	}
	else
	{
		window.returnValue=imgstr;
		window.close();
	}
}
</script>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="insertpic" method="post" action="">
    <tr class="header"> 
      <td height="23">插入FLASH设置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">宽度 
        <input name="width" type=text id="width" value="480" size="6">
        × 高度 
        <input name="height" type=text id="height" value="360" size="6">
      </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">FLASH下面显示文字 
        <input name="picsay" type="text" id="picsay" size="30"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <input type="button" name="Submit" value="插入FLASH" onclick="SetPicOk(1);"> 
        <input type="button" name="Submit3" value="预览效果" onclick="SetPicOk(0);"> 
        <input type="button" name="Submit2" value="取消" onclick="window.close();"></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">
	  <table border="0" cellpadding="0" cellspacing="0">
	  <tr><td id="viewpic"></td></tr>
	  </table>
	  </td>
    </tr>
  </form>
</table>
<?
}
elseif($ecms=="rm")
{
?>
<script>
function SetPicOk(ecms){
	var height=document.insertpic.height.value;
	var width=document.insertpic.width.value;
	var toplay=document.insertpic.toplay.value;
	var playmod=document.insertpic.playmod.value;
	var picsay=document.insertpic.picsay.value;
	var imgstr="";
	var autostart;
	if(height==""||height==0||width==""||width==0)
	{
		alert("请输入高度与宽度");
		return false;
	}
	autostart="true";
	if(playmod==1)
	{
		autostart="false";
	}
	if(toplay==0)
	{
		imgstr="<object align=middle classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" class=\"OBJECT\" id=\"MediaPlayer\" width=\""+width+"\" height=\""+height+"\"><PARAM NAME=\"AUTOSTART\" VALUE=\""+autostart+"\"><param name=\"ShowStatusBar\" value=\"-1\"><param name=\"Filename\" value=\"<?=$filename?>\"><embed type=\"application/x-oleobject codebase=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701\" flename=\"mp\" src=\"<?=$filename?>\" width=\""+width+"\" height=\""+height+"\"></embed></object>";
	}
	else
	{
		imgstr="<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" HEIGHT=\""+height+"\" ID=\"Player\" WIDTH=\""+width+"\" VIEWASTEXT><param NAME=\"_ExtentX\" VALUE=\"12726\"><param NAME=\"_ExtentY\" VALUE=\"8520\"><param NAME=\"AUTOSTART\" VALUE=\""+autostart+"\"><param NAME=\"SHUFFLE\" VALUE=\"0\"><param NAME=\"PREFETCH\" VALUE=\"0\"><param NAME=\"NOLABELS\" VALUE=0><param NAME=CONTROLS VALUE=ImageWindow><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE=\"<?=$filename?>\"><param NAME=BACKGROUNDCOLOR VALUE=\"#000000\"></object><br><object CLASSID=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" HEIGHT=32 ID=\"Player\" WIDTH=\""+width+"\" VIEWASTEXT><param NAME=_ExtentX VALUE=18256><param NAME=_ExtentY VALUE=794><param NAME=AUTOSTART VALUE=\""+autostart+"\"><param NAME=SHUFFLE VALUE=0><param NAME=PREFETCH VALUE=0><param NAME=NOLABELS VALUE=0><param NAME=CONTROLS VALUE=controlpanel><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE=0><param NAME=BACKGROUNDCOLOR VALUE=\"#000000\"><param NAME=SRC VALUE=\"<?=$filename?>\"></object>";
	}
	if(picsay!="")
	{
		imgstr+="<br><span style='line-height=18pt'>"+picsay+"</span>";
	}
	imgstr='<center>'+imgstr+'</center>';
	if(ecms==0)
	{
		window.viewpic.innerHTML=imgstr;
	}
	else
	{
		window.returnValue=imgstr;
		window.close();
	}
}
</script>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="insertpic" method="post" action="">
    <tr class="header"> 
      <td height="23">插入多媒体文件设置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">使用播放器
        <select name="toplay" id="toplay">
          <option value="0">Media Player</option>
          <option value="1">Real Player</option>
        </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">宽度 
        <input name="width" type=text id="width" value="480" size="6">
        × 高度 
        <input name="height" type=text id="height" value="360" size="6"> </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">播放模式
        <select name="playmod" id="playmod">
          <option value="0">自动播放</option>
          <option value="1">手动播放</option>
        </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">播放器下面显示文字 
        <input name="picsay" type="text" id="picsay" size="30"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <input type="button" name="Submit" value="插入多媒体文件" onclick="SetPicOk(1);"> 
        <input type="button" name="Submit3" value="预览效果" onclick="SetPicOk(0);"> 
        <input type="button" name="Submit2" value="取消" onclick="window.close();"></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"> <table border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td id="viewpic"></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<?
}
else
{
	$fileid=(int)$_GET['fileid'];
	$fname=ehtmlspecialchars($_GET['fname']);
	$filesize=ehtmlspecialchars($_GET['filesize']);
	$filetype=ehtmlspecialchars($_GET['filetype']);
?>
<script>
function SetPicOk(ecms){
	var picsay=document.insertpic.picsay.value;
	var imgstr="";
	if(picsay=="")
	{
		picsay="<?=$fname?>";
	}
	imgstr="<div style='padding:6px'><fieldset><legend>"+picsay+"</legend><table cellpadding=0 cellspacing=0 border=0><tr><td><img src='<?=$public_r[newsurl]?>e/data/images/downfile.jpg' alt='文件类型: <?=$filetype?>' border=0 style='vertical-align:baseline'></td><td><a href='<?=$filename?>' title='"+picsay+"' target='_blank'><?=$fname?></a>&nbsp;(<?=$filesize?>)</td></tr></table></fieldset></div>";
	if(ecms==0)
	{
		window.viewpic.innerHTML=imgstr;
	}
	else
	{
		window.returnValue=imgstr;
		window.close();
	}
}
</script>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="insertpic" method="post" action="">
    <tr class="header"> 
      <td height="23">插入附件设置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">附件名称 
        <input name="picsay" type="text" id="picsay" size="30"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <input type="button" name="Submit" value="插入附件" onclick="SetPicOk(1);"> 
        <input type="button" name="Submit3" value="预览效果" onclick="SetPicOk(0);"> 
        <input type="button" name="Submit2" value="取消" onclick="window.close();"></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"> <table border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td id="viewpic"></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<?
}
?>
</body>
</html>