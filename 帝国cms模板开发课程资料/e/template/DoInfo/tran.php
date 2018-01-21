<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$word?></title>
<link href="../data/images/qcss.css" rel="stylesheet" type="text/css">
<script>
function DoInsertUrl(str)
{
	if(str=="http://")
	{
		alert('请输入要插入的连接');
	    return false;
	}
pos=str.lastIndexOf(".")+1;
len=str.length;
ext=str.substring(pos,len);
if((ext == "gif")||(ext == "jpg")||(ext == "jepg")||(ext == "png")||(ext == "bmp"))
	{
	opener.InsertFile("<img src='"+str+"' border=0>");
	}
else if(ext=="swf")
	{
		opener.InsertFile("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" name=\"movie\" width=\"400\" height=\"350\" id=\"movie\"><param name=\"movie\" value=\""+str+"\"><param name=\"quality\" value=\"high\"><param name=\"menu\" value=\"false\"><embed src=\""+str+"\" width=\"400\" height=\"350\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" id=\"movie\" name=\"movie\" menu=\"false\"></embed></object>");
     }
else if((ext == "wmv")||(ext == "asf")||(ext == "wma"))
	{
	opener.InsertFile("<object align=middle classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" class=OBJECT id=MediaPlayer width=480 height=360><PARAM NAME=AUTOSTART VALUE=true><param name=ShowStatusBar value=-1><param name=Filename value=\""+str+"\"><embed type=\"application/x-oleobject codebase=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701\" flename=mp src=\""+str+"\" width=480 height=360></embed></object>");
    }
else if((ext == "rm")||(ext == "ra")||(ext == "rmvb")||(ext == "mp3")||(ext == "mp4")||(ext == "mov")||(ext == "avi")||(ext == "wav")||(ext == "ram")||(ext == "mpg")||(ext == "mpeg"))
	{
	opener.InsertFile("<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" HEIGHT=360 ID=Player WIDTH=480 VIEWASTEXT><param NAME=_ExtentX VALUE=12726><param NAME=_ExtentY VALUE=8520><param NAME=AUTOSTART VALUE=1><param NAME=SHUFFLE VALUE=0><param NAME=PREFETCH VALUE=0><param NAME=NOLABELS VALUE=0><param NAME=CONTROLS VALUE=ImageWindow><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE=\""+str+"\"><param NAME=BACKGROUNDCOLOR VALUE=\"#000000\"></object><br><object CLASSID=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA HEIGHT=32 ID=Player WIDTH=480 VIEWASTEXT><param NAME=_ExtentX VALUE=18256><param NAME=_ExtentY VALUE=794><param NAME=AUTOSTART VALUE=1><param NAME=SHUFFLE VALUE=0><param NAME=PREFETCH VALUE=0><param NAME=NOLABELS VALUE=0><param NAME=CONTROLS VALUE=controlpanel><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE=0><param NAME=BACKGROUNDCOLOR VALUE=\"#000000\"><param NAME=SRC VALUE=\""+str+"\"></object>");
    }
else
	{
	opener.InsertFile("<a href='"+str+"'>"+str+"</a>");
	}
	window.close();
}
</script>
</head>

<body>
<table width="430" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form action="ecms.php" method="post" enctype="multipart/form-data" name="form1">
    <input type=hidden name=classid value="<?=$classid?>">
	<input type=hidden name=infoid value="<?=$infoid?>">
    <input type=hidden name=enews value="<?=$enews?>">
    <input type=hidden name=type value="<?=$type?>">
	<input type=hidden name=ecms value="<?=$ecms?>">
    <input type=hidden name=filepass value="<?=$filepass?>">
	 <input type=hidden name=userid value="<?=$userid?>">
	 <input type=hidden name=username value="<?=$username?>">
	 <input type=hidden name=rnd value="<?=$rnd?>">
    <tr class="header"> 
      <td height="23"><strong><font color="#FFFFFF"><?=$word?></font></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="32">本地上传： 
        <input type="file" name="file"> <input type="submit" name="Submit" value="上传">
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>文件大小&lt; <b><?=$filesize?></b> KB，上传扩展名：<?=$filetype?></td>
    </tr>
	 </form>
  </table>
</body>
</html>
