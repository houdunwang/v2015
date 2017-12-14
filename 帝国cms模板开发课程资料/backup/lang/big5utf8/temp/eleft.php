<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<?php
$dbserverr=Ebak_SetUseMoreDbServer();
if(empty($dbserverr['serverid']))
{
	$dbserverno=' ('.$dbserverr['serverid'].')';
	$dbservername='<strong>默認服務器</strong>';
}
else
{
	$dbserverno=' ('.$dbserverr['serverid'].')';
	$dbservername='<strong>'.$dbserverr['dbhost'].'</strong>';
	if($dbserverr['dbname'])
	{
		$dbservername.='<br>('.$dbserverr['dbname'].')';
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>菜單</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="0">
<div align="center"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="65"> 
        <div align="center"><a href="http://www.phome.net" target="_blank"><img src="images/logo.gif" alt="Empire Soft" width="151" height="58" border="0"></a></div></td>
    </tr>
  </table>
  <br>
</div>
<?php
if($ebak_set_moredbserver)
{
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <tr class="header">
    <td height="27"><div align="center">
      當前服務器<?=$dbserverno?></div></td>
  </tr>
  <tr>
    <td height="27"><div align="center"><?=$dbservername?></div></td>
  </tr>
</table>
<br>
<?php
}
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="27"><div align="center">後台首頁</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="main.php" target="ebakmain">後台首頁</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="admin.php" target="_parent">刷新後台主界面</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="doc.html" target="ebakmain">說明文檔</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="http://bbs.phome.net" target="_blank">技術支持</a></div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="27"><div align="center">備份與恢復數據庫</div></td>
  </tr>
  
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="SetDb.php" target="ebakmain">全局參數設置</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="ChangeDb.php" target="ebakmain">備份數據</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="ListSetbak.php" target="ebakmain">管理備份設置</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="ReData.php" target="ebakmain">恢復數據</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="ChangePath.php" target="ebakmain">管理備份目錄</a></div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="27"><div align="center">附加組件</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="RepFiletext.php" target="ebakmain">替換目錄文件</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="DoSql.php" target="ebakmain">執行SQL語句</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="eginfo.php" target="ebakmain">帝國PHP探針</a></div></td>
  </tr>
</table>
<?php
if($ebak_ebma_path&&file_exists('eapi/'.$ebak_ebma_path))
{
?>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="27" title="EmpireBak+phpMyAdmin+高安全"><div align="center">EBMA系統</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="goebma.php" title="用EBMA管理和備份MYSQL更安全。" target="ebakmain">使用phpMyAdmin</a></div></td>
  </tr>
</table>
<?php
}
?>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="27"><div align="center">退出系統</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="phome.php?phome=exit" onclick="return confirm('確認要退出系統？');" target="_parent">退出系統</a></div></td>
  </tr>
</table>
</body>
</html>