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

$showmod=(int)$_GET['showmod'];
$type=(int)$_GET['type'];
$classid=(int)$_GET['classid'];
$filepass=(int)$_GET['filepass'];
$infoid=(int)$_GET['infoid'];
$modtype=(int)$_GET['modtype'];
$sinfo=(int)$_GET['sinfo'];
$InstanceName=ehtmlspecialchars($_GET['InstanceName']);
$editor=3;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>上传视频</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="noindex, nofollow" name="robots">
		<script src="../editor/dialog/common/fck_dialog_common.js" type="text/javascript"></script>
		<script src="../editor/dialog/tranmedia/media.js" type="text/javascript"></script>
		<script type="text/javascript">

document.write( FCKTools.GetStyleHtml( GetCommonDialogCss() ) ) ;

		</script>
		<script type="text/javascript">
		function DoCheckTranFile(obj){
			var ctypes,actypes,cfiletype,ctypest,sfile,sfocus;
			ctypes="<?=$ecms_config['sets']['mediaplayertype']?>";
			ctypest="<?=$ecms_config['sets']['realplayertype']?>";
			actypes="<?=$public_r['filetype']?>";
			if(obj.tranurl.value==''&&obj.file.value=='')
			{
				alert('请选择要上传的视频');
				obj.file.focus();
				return false;
			}
			if(obj.file.value!='')
			{
				sfile=obj.file.value;
				sfocus=0;
			}
			else
			{
				sfile=obj.tranurl.value;
				sfocus=1;
			}
			cfiletype=','+ToGetFiletype(sfile)+',';
			if(ctypes.indexOf(cfiletype)==-1&&ctypest.indexOf(cfiletype)==-1&&cfiletype!=',.flv,')
			{
				alert('文件扩展名错误');
				if(sfocus==1)
				{
					obj.tranurl.focus();
				}
				else
				{
					obj.file.focus();
				}
				return false;
			}
			cfiletype='|'+ToGetFiletype(sfile)+'|';
			if(actypes.indexOf(cfiletype)==-1)
			{
				alert('文件扩展名不在允许的范围内');
				if(sfocus==1)
				{
					obj.tranurl.focus();
				}
				else
				{
					obj.file.focus();
				}
				return false;
			}
			ReturnFileNo(obj);
			// Show animation
			window.parent.Throbber.Show( 100 ) ;
			GetE( 'divUpload' ).style.display  = 'none' ;
			return true;
		}
		function ToGetFiletype(sfile){
			var filetype,s;
			s=sfile.lastIndexOf(".");
			filetype=sfile.substring(s+1).toLowerCase();
			return '.'+filetype;
		}
		//返回编号
		function ExpStr(str,exp){
			var pos,len,ext;
			pos=str.lastIndexOf(exp)+1;
			len=str.length;
			ext=str.substring(pos,len);
			return ext;
		}
		function GetFname(str){
			var filename,exp;
			if(str.indexOf("\\")>=0)
			{
				exp="\\";
			}
			else
			{
				exp="/";
			}
			filename=ExpStr(str,exp);
			return filename;
		}
		function ReturnFileNo(obj){
			var filename,str,exp;
			if(obj.no.value!='')
			{
				return '';
			}
			if(obj.file.value!='')
			{
				str=obj.file.value;
			}
			else
			{
				str=obj.tranurl.value;
			}
			filename=GetFname(str);
			obj.no.value=filename;
		}
//返回播放器代码
function echoViewFileCode(toplay,width,height,autostart,furl){
	var fname=document.TranFlashFormT.no.value;
	if(toplay==1)//media
	{
		imgstr="<object align=middle classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" class=\"OBJECT\" id=\"MediaPlayer\" width=\""+width+"\" height=\""+height+"\"><PARAM NAME=\"AUTOSTART\" VALUE=\""+autostart+"\"><param name=\"ShowStatusBar\" value=\"-1\"><param name=\"Filename\" value=\""+furl+"\"><embed type=\"application/x-oleobject codebase=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701\" flename=\"mp\" src=\""+furl+"\" width=\""+width+"\" height=\""+height+"\"></embed></object>";
	}
	else if(toplay==3)//flv
	{
		imgstr="<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\""+width+"\" height=\""+height+"\"><param name=\"movie\" value=\"<?=$public_r[newsurl]?>e/data/images/flvplayer.swf?vcastr_file="+furl+"&vcastr_title="+fname+"&BarColor=0xFF6600&BarPosition=1&IsAutoPlay="+autostart+"\"><param name=\"quality\" value=\"high\"><param name=\"allowFullScreen\" value=\"true\" /><embed src=\"<?=$public_r[newsurl]?>e/data/images/flvplayer.swf?vcastr_file="+furl+"&vcastr_title="+fname+"&BarColor=0xFF6600&BarPosition=1&IsAutoPlay="+autostart+"\" allowFullScreen=\"true\"  quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\""+width+"\" height=\""+height+"\"></embed></object>";
	}
	else//reaplayer
	{
		imgstr="<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" HEIGHT=\""+height+"\" ID=\"Player\" WIDTH=\""+width+"\" VIEWASTEXT><param NAME=\"_ExtentX\" VALUE=\"12726\"><param NAME=\"_ExtentY\" VALUE=\"8520\"><param NAME=\"AUTOSTART\" VALUE=\""+autostart+"\"><param NAME=\"SHUFFLE\" VALUE=\"0\"><param NAME=\"PREFETCH\" VALUE=\"0\"><param NAME=\"NOLABELS\" VALUE=0><param NAME=CONTROLS VALUE=ImageWindow><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE=\""+furl+"\"><param NAME=BACKGROUNDCOLOR VALUE=\"#000000\"></object><br><object CLASSID=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" HEIGHT=32 ID=\"Player\" WIDTH=\""+width+"\" VIEWASTEXT><param NAME=_ExtentX VALUE=18256><param NAME=_ExtentY VALUE=794><param NAME=AUTOSTART VALUE=\""+autostart+"\"><param NAME=SHUFFLE VALUE=0><param NAME=PREFETCH VALUE=0><param NAME=NOLABELS VALUE=0><param NAME=CONTROLS VALUE=controlpanel><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE=0><param NAME=BACKGROUNDCOLOR VALUE=\"#000000\"><param NAME=SRC VALUE=\""+furl+"\"></object>";
	}
	return imgstr;
}
//返回
function echoViewFile(obj,ecms){
	var height=obj.height.value;
	var width=obj.width.value;
	var toplay=obj.toplay.value;
	var playmod=obj.playmod.value;
	var picsay=obj.picsay.value;
	var imgstr="";
	var autostart;
	var mediatypes="<?=$ecms_config['sets']['mediaplayertype']?>";
	var realtypes="<?=$ecms_config['sets']['realplayertype']?>";
	var furl,filetype;
	if(obj.inserturl.value=='')
	{
		return '';
	}
	if(height==""||height==0||width==""||width==0)
	{
		alert("请输入高度与宽度");
		return false;
	}
	furl=obj.inserturl.value;
	autostart="true";
	if(playmod==1)
	{
		autostart="false";
	}
	if(toplay==0)
	{
		filetype=ToGetFiletype(furl);
		if(filetype=='.flv')
		{
			toplay=3;
		}
		else if(mediatypes.indexOf(','+filetype+',')==-1)
		{
			toplay=2;
		}
		else
		{
			toplay=1;
		}
	}
	imgstr=echoViewFileCode(toplay,width,height,autostart,furl);
	if(picsay!="")
	{
		imgstr+="<br><span style='line-height=18pt'>"+picsay+"</span>";
	}
	imgstr='<center>'+imgstr+'</center>';
	if(ecms==0)
	{
		ePreview.innerHTML=imgstr;
		return '';
	}
	oEditor.FCK.InsertHtml(imgstr);
	window.parent.Cancel();
}
		</script>
	</head>
	<body scroll="no" style="OVERFLOW: hidden">
		<div id="divInfo">
			
  <table cellSpacing="1" cellPadding="1" width="100%" border="0">
    <form action="" method="post" name="etranflashform" onsubmit="return false;">
	<input type="hidden" name="picsay" value="">
      <tr> 
        <td> <table cellSpacing="0" cellPadding="0" width="100%" border="0">
            <tr> 
              <td width="100%"><span fckLang="DlgImgURL">URL</span> </td>
              <td id="tdBrowse" style="DISPLAY: none" noWrap rowSpan="2">&nbsp; 
                <input id="btnBrowse" onclick="window.open('<?="../../FileMain.php?filepass=$filepass&classid=$classid&infoid=$infoid&type=3&modtype=$modtype&sinfo=$sinfo&InstanceName=$InstanceName&tranfrom=1&field=opener.document.etranflashform.inserturl".$ecms_hashur['ehref'];?>','','width=700,height=550,scrollbars=yes');" type="button" value="Browse Server" fckLang="DlgBtnBrowseServer"> 
              </td>
            </tr>
            <tr> 
              <td vAlign="top"><input id="txtUrl" name="inserturl" onblur="echoViewFile(document.etranflashform,0);" style="WIDTH: 100%" type="text"> 
              </td>
            </tr>
          </table></td>
      </tr>
      <TR> 
        <TD> <table cellSpacing="1" cellPadding="3" border="0">
            <TR> 
              <TD nowrap> <span fckLang="DlgImgWidth">Width</span><br> <input type="text" id="txtWidth" name="width" value="480" size="3" onblur="echoViewFile(document.etranflashform,0);"> 
              </TD>
              <TD>&nbsp;</TD>
              <TD> <span fckLang="DlgImgHeight">Height</span><br> <input type="text" id="txtHeight" name="height" value="360" size="3" onblur="echoViewFile(document.etranflashform,0);"> 
              </TD>
              <TD>&nbsp;&nbsp;&nbsp;</TD>
              <TD>播放器<br> <select name="toplay" id="toplay" onchange="echoViewFile(document.etranflashform,0);">
                  <option value="0">自动识别</option>
                  <option value="1">Media Player</option>
                  <option value="2">Real Player</option>
				  <option value="3">Flv Player</option>
                </select> </TD>
              <TD>播放模式<br>
                <select name="playmod" id="playmod" onchange="echoViewFile(document.etranflashform,0);">
                  <option value="0">自动播放</option>
                  <option value="1">手动播放</option>
                </select></TD>
            </TR>
          </table></TD>
      </TR>
      <tr> 
        <td vAlign="top"> <table cellSpacing="0" cellPadding="0" width="100%" border="0">
            <tr> 
              <td valign="top" width="100%"> <table cellSpacing="0" cellPadding="0" width="100%">
                  <tr> 
                    <td><span fckLang="DlgImgPreview">Preview</span></td>
                  </tr>
                  <tr> 
                    <td id="ePreviewCell" valign="top" class="FlashPreviewArea"><iframe src="../editor/dialog/fck_flash/fck_flash_preview.html" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </form>
  </table>
		</div>
		
<div id="divUpload" style="DISPLAY: none"> 
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" id="tranpictb">
    <form id="frmUpload" name="TranFlashFormT" method="post" target="UploadWindow" enctype="multipart/form-data" action="../../ecmseditor.php" onsubmit="return DoCheckTranFile(TranFlashFormT);">
	<?=$ecms_hashur['form']?>
      <input type=hidden name=classid value="<?=$classid?>">
      <input type=hidden name=filepass value="<?=$filepass?>">
	  <input type=hidden name=infoid value="<?=$infoid?>">
      <input type=hidden name=modtype value="<?=$modtype?>">
      <input type=hidden name=sinfo value="<?=$sinfo?>">
      <input type=hidden name=enews value="TranFile">
      <input type=hidden name=type value="3">
      <input type=hidden name=doing value="0">
      <input type=hidden name=tranfrom value="1">
      <input type=hidden name=InstanceName value="<?=$InstanceName?>">
      <tr> 
        <td>远程保存<br> <input name="tranurl" type="text" id="tranurl" size="32" style="width: 100%"></td>
      </tr>
      <tr> 
        <td>本地上传<br> <input type="file" name="file" id="file" style="width: 100%"> 
        </td>
      </tr>
      <tr> 
        <td>文件别名<br> <input name="no" type="text" id="no" value="<?=ehtmlspecialchars($_GET['fileno'])?>" style="width: 100%"> 
        </td>
      </tr>
      <tr> 
        <td height="30"> <input type="submit" name="Submit2" value="发送到服务器上"> 
        </td>
      </tr>
    </form>
  </table>
  <script type="text/javascript">
					document.write( '<iframe name="UploadWindow" style="DISPLAY: none" src="' + FCKTools.GetVoidUrl() + '"><\/iframe>' ) ;
  </script>
		</div>
	</body>
</html>
