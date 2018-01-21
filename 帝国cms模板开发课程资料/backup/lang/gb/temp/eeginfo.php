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
		echo"<br>测试结果：<b>支持采集</b>";
	}
	else
	{
		echo"<br>测试结果：<b>不支持采集</b>";
	}
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>帝国PHP探针</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function DoHiddenShowInfo(){
	var str='[已隐藏]';
	document.getElementById('showabspath').innerHTML=str;
	document.getElementById('showuserip').innerHTML=str;
	document.getElementById('showdomain').innerHTML=str;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="8">
  <tr>
    <td height="25">位置：<a href="eginfo.php">帝国PHP探针</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="8" cellpadding="3">
  <tr>
    <td width="50%" height="25" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
      <tr class="header">
        <td height="27" colspan="2"><div align="center">服务器信息</div></td>
        </tr>
      <tr bgcolor="#FFFFFF">
        <td width="35%">操作系统:</td>
        <td width="65%" height="27"><?=EGInfo_GetUseSys()?></td>
        </tr>
      <tr bgcolor="#FFFFFF">
        <td>服务器软件:</td>
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
        <td>当前目录:</td>
        <td height="27" id="showabspath"><?=EGInfo_GetAbsPath()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>登录者IP:</td>
        <td height="27" id="showuserip"><?=EGInfo_GetUserIP()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>使用域名:</td>
        <td height="27" id="showdomain"><?=EGInfo_GetDomain()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>服务器时间:</td>
        <td height="27"><?=EGInfo_GetDatetime()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>PHP运行模式:</td>
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
        <td width="65%" height="27"><?=EGInfo_GetPHPSafemod()?'PHP运行于安全模式':'正常模式'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>全局变量:</td>
        <td height="27"><?=EGInfo_GetPHPRGlobals()?'打开':'关闭'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>魔术引用:</td>
        <td height="27"><?=EGInfo_GetPHPMagicQuotes()?'开启':'关闭'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>PHP短标签:</td>
        <td height="27"><?=EGInfo_GetPHPShortTag()?'支持':'不支持'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否支持采集:</td>
        <td height="27">
		<?=EGInfo_GetCj()?'支持':'不支持'?>
		 &nbsp;&nbsp;&nbsp;&nbsp;(<a href="#eginfo" onclick="window.open('eginfo.php?phome=TestCj','','width=200,height=80');"><u>点击测试采集</u></a>)</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>MYSQL接口支持类型:</td>
        <td height="27">
		<?php
		$mysqlconnecttype=EGInfo_GetMysqlConnectType();
		echo $mysqlconnecttype;
		?>		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否支持GD库:</td>
        <td height="27"><?=EGInfo_GetPHPGd()?'支持':'不支持'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否支持ICONV组件:</td>
        <td height="27"><?=EGInfo_GetIconv()?'支持':'不支持'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>表单提交最大数据:</td>
        <td height="27"><?=EGInfo_GetPHPMaxPostSize()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>表单变量数限制:</td>
        <td height="27">
		<?php
		$maxinputvars=EGInfo_GetPHPMaxInputVars();
		echo $maxinputvars?$maxinputvars:'不限';
		?>		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>是否允许上传文件:</td>
        <td height="27"><?=EGInfo_GetPHPFileUploads()?'可以':'不可以'?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>最大上传文件大小:</td>
        <td height="27"><?=EGInfo_GetPHPMaxUploadSize()?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>表单file数量限制:</td>
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
    <td><div align="center">[<a href="eginfo.php?phome=ShowPHPInfo" target="_blank">点击这里查看PHPINFO信息</a>] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<a href="#empirebak" onclick="DoHiddenShowInfo();">点击这里隐藏敏感信息显示</a>]</div></td>
  </tr>
</table>
</body>
</html>