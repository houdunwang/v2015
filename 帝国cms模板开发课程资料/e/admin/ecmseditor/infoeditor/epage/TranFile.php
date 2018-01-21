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
		<title>插入附件</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="noindex, nofollow" name="robots">
		<script src="../editor/dialog/common/fck_dialog_common.js" type="text/javascript"></script>
		<script src="../editor/dialog/tranfile/file.js" type="text/javascript"></script>
		<script type="text/javascript">

document.write( FCKTools.GetStyleHtml( GetCommonDialogCss() ) ) ;

		</script>
		<script type="text/javascript">
		function DoCheckTranFile(obj){
			var ctypes,actypes,cfiletype,sfile,sfocus;
			ctypes="<?=$ecms_config['sets']['tranflashtype']?>";
			actypes="<?=$public_r['filetype']?>";
			if(obj.tranurl.value==''&&obj.file.value=='')
			{
				alert('请选择要上传的文件');
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
		//预览
		function echoViewFile(obj,doshow){
			var imgstr,filetype,fn,filename,furl,sizestr;
			if(obj.inserturl.value=='')
			{
				return '';
			}
			furl=obj.inserturl.value;
			filetype=ToGetFiletype(furl);
			filename=GetFname(furl);
			if(obj.fname.value=='')
			{
				fn=filename;
			}
			else
			{
				fn=obj.fname.value;
			}
			sizestr='';
			if(obj.filesize.value!='')
			{
				sizestr="&nbsp;("+obj.filesize.value+")";
			}
			imgstr="<div style='padding:6px'><fieldset><legend>"+fn+"</legend><table cellpadding=0 cellspacing=0 border=0><tr><td><img src='<?=$public_r[newsurl]?>e/data/images/downfile.jpg' alt='文件类型: "+filetype+"' border=0 style='vertical-align:baseline'></td><td> <a href='"+furl+"' title='"+fn+"' target='_blank'>"+filename+"</a>"+sizestr+"</td></tr></table></fieldset></div>";
			if(doshow==0)
			{
				document.getElementById("ViewFile").innerHTML=imgstr;
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
    <form action="" method="post" name="etranfileform" onsubmit="return false;">
      <tr> 
        <td> <table cellSpacing="1" cellPadding="1" width="100%" border="0">
            <tr> 
              <td width="100%"><span fckLang="DlgImgURL">URL</span> </td>
              <td id="tdBrowse" style="DISPLAY: none" noWrap rowSpan="2">&nbsp; 
                <input id="btnBrowse" onclick="window.open('<?="../../FileMain.php?filepass=$filepass&classid=$classid&infoid=$infoid&type=0&modtype=$modtype&sinfo=$sinfo&InstanceName=$InstanceName&tranfrom=1&field=opener.document.etranfileform.inserturl".$ecms_hashur['ehref'];?>','','width=700,height=550,scrollbars=yes');" type="button" value="Browse Server" fckLang="DlgBtnBrowseServer"> 
              </td>
            </tr>
            <tr> 
              <td vAlign="top"><input id="txtUrl" name="inserturl" onblur="echoViewFile(document.etranfileform,0);" style="WIDTH: 100%" type="text"> 
              </td>
            </tr>
            <tr> 
              <td colspan="2" vAlign="top">附件名称<br> 
                <input name="fname" type="text" id="fname" value="<?=ehtmlspecialchars($_GET['fname'])?>" style="width: 100%" onblur="echoViewFile(document.etranfileform,0);"> 
              </td>
            </tr>
			<tr> 
              <td colspan="2" vAlign="top">文件大小<br> 
                <input name="filesize" type="text" id="filesize" value="<?=ehtmlspecialchars($_GET['filesize'])?>" style="width: 100%" onblur="echoViewFile(document.etranfileform,0);"> 
              </td>
            </tr>
          </table></td>
      </tr>
    </form>
  </table><br>
		
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
      <td>附件预览</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" id="ViewFile">&nbsp;</td>
    </tr>
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
      <input type=hidden name=type value="0">
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
