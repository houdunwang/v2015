<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<?php
if($phome=='TestCj')
{
	if($testcjst)
	{
		echo"<br>測試結果：<b>支持採集</b>";
	}
	else
	{
		echo"<br>測試結果：<b>不支持採集</b>";
	}
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>帝國PHP探針</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function DoHiddenShowInfo(){
	var str='[已隱藏]';
	document.getElementById('showabspath').innerHTML=str;
	document.getElementById('showuserip').innerHTML=str;
	document.getElementById('showdomain').innerHTML=str;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="8">
  <tr>
    <td height="25">位置：<a href="eginfo.php">帝國PHP探針</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="8" cellpadding="3">
  <tr>
    <td width="50%" height="25" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
      <tr class="header">
        <td height="27" colspan="2"><div align="center">服務器信息</div></td>
        </tr>
      <tr bgcolor="#FFFFFF">
        <td width="35%">操作系統:</td>
        <td width="65%" height="27"><?=EGInfo_GetUseSys()?></td>
        </tr>
      <tr bgcolor="#FFFFFF">
        <td>服務器軟件:</td>
        <td height="27"><?=EGInfo_GetUseWebServer()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>PHP版本:</td>
        <td height="27"><?=EGInfo_GetPHPVersion()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>MYSQL版本:</td>
        <td height="27">
		<?php
		$mysqlver=EGInfo_GetMysqlVersion();
		echo $mysqlver?$mysqlver:'未知';
		?>		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>當前目錄:</td>
        <td height="27" id="showabspath"><?=EGInfo_GetAbsPath()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>登錄者IP:</td>
        <td height="27" id="showuserip"><?=EGInfo_GetUserIP()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>使用域名:</td>
        <td height="27" id="showdomain"><?=EGInfo_GetDomain()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>服務器時間:</td>
        <td height="27"><?=EGInfo_GetDatetime()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>PHP運行模式:</td>
        <td height="27"><?=EGInfo_GetPhpMod()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否支持ZEND:</td>
        <td height="27">
		<?php
		$getzend=EGInfo_GetZend();
		if($getzend==1)
		{
			echo'支持';
		}
		elseif($getzend==-1)
		{
			echo'未知';
		}
		else
		{
			echo'不支持';
		}
		?>
		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;</td>
        <td height="27">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;</td>
        <td height="27">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;</td>
        <td height="27">&nbsp;</td>
      </tr>
    </table></td>
    <td width="50%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
      <tr class="header">
        <td height="27" colspan="2"><div align="center">PHP配置信息</div></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td width="35%">PHP安全模式:</td>
        <td width="65%" height="27"><?=EGInfo_GetPHPSafemod()?'PHP運行於安全模式':'正常模式'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>全局變量:</td>
        <td height="27"><?=EGInfo_GetPHPRGlobals()?'打開':'關閉'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>魔術引用:</td>
        <td height="27"><?=EGInfo_GetPHPMagicQuotes()?'開啟':'關閉'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>PHP短標籤:</td>
        <td height="27"><?=EGInfo_GetPHPShortTag()?'支持':'不支持'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否支持採集:</td>
        <td height="27">
		<?=EGInfo_GetCj()?'支持':'不支持'?>
		 &nbsp;&nbsp;&nbsp;&nbsp;(<a href="#eginfo" onclick="window.open('eginfo.php?phome=TestCj','','width=200,height=80');"><u>點擊測試採集</u></a>)</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>MYSQL接口支持類型:</td>
        <td height="27">
		<?php
		$mysqlconnecttype=EGInfo_GetMysqlConnectType();
		echo $mysqlconnecttype;
		?>		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否支持GD庫:</td>
        <td height="27"><?=EGInfo_GetPHPGd()?'支持':'不支持'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否支持ICONV組件:</td>
        <td height="27"><?=EGInfo_GetIconv()?'支持':'不支持'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>表單提交最大數據:</td>
        <td height="27"><?=EGInfo_GetPHPMaxPostSize()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>表單變量數限制:</td>
        <td height="27">
		<?php
		$maxinputvars=EGInfo_GetPHPMaxInputVars();
		echo $maxinputvars?$maxinputvars:'不限';
		?>		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否允許上傳文件:</td>
        <td height="27"><?=EGInfo_GetPHPFileUploads()?'可以':'不可以'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>最大上傳文件大小:</td>
        <td height="27"><?=EGInfo_GetPHPMaxUploadSize()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>表單file數量限制:</td>
        <td height="27">
		<?php
		$maxuploadfilenum=EGInfo_GetPHPMaxUploadFileNum();
		echo $maxuploadfilenum?$maxuploadfilenum:'不限';
		?>		</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="8" cellpadding="3">
  <tr>
    <td><div align="center">[<a href="eginfo.php?phome=ShowPHPInfo" target="_blank">點擊這裡查看PHPINFO信息</a>] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<a href="#empirebak" onclick="DoHiddenShowInfo();">點擊這裡隱藏敏感信息顯示</a>]</div></td>
  </tr>
</table>
</body>
</html>