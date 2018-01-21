<?php
require('../../../../class/connect.php');
$showmod=(int)$_GET['showmod'];
$type=(int)$_GET['type'];
$classid=(int)$_GET['classid'];
$filepass=(int)$_GET['filepass'];
$InstanceName=ehtmlspecialchars($_GET['InstanceName']);
$editor=3;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Flash Properties</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="noindex, nofollow" name="robots">
		<script src="../editor/dialog/common/fck_dialog_common.js" type="text/javascript"></script>
		<script src="../editor/dialog/fck_flash/fck_flash.js" type="text/javascript"></script>
		<script type="text/javascript">

document.write( FCKTools.GetStyleHtml( GetCommonDialogCss() ) ) ;

		</script>
		<script type="text/javascript">
		function DoCheckTranFile(obj){
			var ctypes,actypes,cfiletype,sfile,sfocus;
			ctypes="<?=$ecms_config['sets']['tranflashtype']?>";
			if(obj.file.value=='')
			{
				alert('请选择要上传的FLASH');
				obj.file.focus();
				return false;
			}
			sfile=obj.file.value;
			sfocus=0;
			cfiletype=','+ToGetFiletype(sfile)+',';
			if(ctypes.indexOf(cfiletype)==-1)
			{
				alert('文件扩展名错误');
				obj.file.focus();
				return false;
			}
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
		function ReturnFileNo(obj){
			var filename,str,exp;
			if(obj.no.value!='')
			{
				return '';
			}
			str=obj.file.value;
			if(str.indexOf("\\")>=0)
			{
				exp="\\";
			}
			else
			{
				exp="/";
			}
			filename=ExpStr(str,exp);
			obj.no.value=filename;
		}
		</script>
	</head>
	<body scroll="no" style="OVERFLOW: hidden">
		<div id="divInfo">
			<table cellSpacing="1" cellPadding="1" width="100%" border="0">
			<form action="" method="post" name="etranflashform" onsubmit="return false;">
				<tr>
					<td>
						<table cellSpacing="0" cellPadding="0" width="100%" border="0">
							<tr>
								<td width="100%"><span fckLang="DlgImgURL">URL</span>
								</td>
								
              <td id="tdBrowse" style="DISPLAY: none" noWrap rowSpan="2">&nbsp; 
              </td>
							</tr>
							<tr>
								<td vAlign="top"><input id="txtUrl" name="inserturl" onblur="UpdatePreview();" style="WIDTH: 100%" type="text">
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<TR>
					<TD>
						<table cellSpacing="0" cellPadding="0" border="0">
							<TR>
								<TD nowrap>
									<span fckLang="DlgImgWidth">Width</span><br>
									<input id="txtWidth" onkeypress="return IsDigit(event);" type="text" size="3">
								</TD>
								<TD>&nbsp;</TD>
								<TD>
									<span fckLang="DlgImgHeight">Height</span><br>
									<input id="txtHeight" onkeypress="return IsDigit(event);" type="text" size="3">
								</TD>
							</TR>
						</table>
					</TD>
				</TR>
				<tr>
					<td vAlign="top">
						<table cellSpacing="0" cellPadding="0" width="100%" border="0">
							<tr>
								<td valign="top" width="100%">
									<table cellSpacing="0" cellPadding="0" width="100%">
										<tr>
											<td><span fckLang="DlgImgPreview">Preview</span></td>
										</tr>
										<tr>
											<td id="ePreviewCell" valign="top" class="FlashPreviewArea"><iframe src="../editor/dialog/fck_flash/fck_flash_preview.html" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</form>
			</table>
		</div>
		
<div id="divUpload" style="DISPLAY: none"> 
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" id="tranpictb">
    <form id="frmUpload" name="TranFlashFormT" method="post" target="UploadWindow" enctype="multipart/form-data" action="../../../../DoInfo/ecms.php" onsubmit="return DoCheckTranFile(TranFlashFormT);">
      <input type=hidden name=classid value="<?=$classid?>">
      <input type=hidden name=filepass value="<?=$filepass?>">
      <input type=hidden name=enews value="MEditorTranFile">
      <input type=hidden name=type value="2">
      <input type=hidden name=doing value="0">
      <input type=hidden name=tranfrom value="1">
      <input type=hidden name=InstanceName value="<?=$InstanceName?>">
      <tr> 
        <td>本地上传<br> <input type="file" name="file" id="file" style="width: 100%"> 
        </td>
      </tr>
      <tr> 
        <td height="30"> <input type="submit" name="Submit2" value="上 传"> 
        </td>
      </tr>
    </form>
  </table>
  <script type="text/javascript">
					document.write( '<iframe name="UploadWindow" style="DISPLAY: none" src="' + FCKTools.GetVoidUrl() + '"><\/iframe>' ) ;
  </script>
		</div>
		<div id="divAdvanced" style="DISPLAY: none">
			<TABLE cellSpacing="0" cellPadding="0" border="0">
				<TR>
					<TD nowrap>
						<span fckLang="DlgFlashScale">Scale</span><BR>
						<select id="cmbScale">
							<option value="" selected></option>
							<option value="showall" fckLang="DlgFlashScaleAll">Show all</option>
							<option value="noborder" fckLang="DlgFlashScaleNoBorder">No Border</option>
							<option value="exactfit" fckLang="DlgFlashScaleFit">Exact Fit</option>
						</select></TD>
					<TD>&nbsp;&nbsp;&nbsp; &nbsp;
					</TD>
					<td valign="bottom">
						<table>
							<tr>
								<td><input id="chkAutoPlay" type="checkbox" checked></td>
								<td><label for="chkAutoPlay" nowrap fckLang="DlgFlashChkPlay">Auto Play</label>&nbsp;&nbsp;</td>
								<td><input id="chkLoop" type="checkbox" checked></td>
								<td><label for="chkLoop" nowrap fckLang="DlgFlashChkLoop">Loop</label>&nbsp;&nbsp;</td>
								<td><input id="chkMenu" type="checkbox" checked></td>
								<td><label for="chkMenu" nowrap fckLang="DlgFlashChkMenu">Enable Flash Menu</label></td>
							</tr>
						</table>
					</td>
				</TR>
			</TABLE>
			<br>
			&nbsp;
			<table cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
				<tr>
					<td vAlign="top" width="50%"><span fckLang="DlgGenId">Id</span><br>
						<input id="txtAttId" style="WIDTH: 100%" type="text">
					</td>
					<td>&nbsp;&nbsp;</td>
					<td vAlign="top" nowrap><span fckLang="DlgGenClass">Stylesheet Classes</span><br>
						<input id="txtAttClasses" style="WIDTH: 100%" type="text">
					</td>
					<td>&nbsp;&nbsp;</td>
					<td vAlign="top" nowrap width="50%">&nbsp;<span fckLang="DlgGenTitle">Advisory Title</span><br>
						<input id="txtAttTitle" style="WIDTH: 100%" type="text">
					</td>
				</tr>
			</table>
			<span fckLang="DlgGenStyle">Style</span><br>
			<input id="txtAttStyle" style="WIDTH: 100%" type="text">
		</div>
	</body>
</html>
