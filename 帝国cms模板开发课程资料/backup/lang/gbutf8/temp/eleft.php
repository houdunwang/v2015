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
	$dbservername='<strong>默认服务器</strong>';
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
<title>菜单</title>
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
      当前服务器<?=$dbserverno?></div></td>
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
    <td height="27"><div align="center">后台首页</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="main.php" target="ebakmain">后台首页</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="admin.php" target="_parent">刷新后台主界面</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="doc.html" target="ebakmain">说明文档</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="http://bbs.phome.net" target="_blank">技术支持</a></div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="27"><div align="center">备份与恢复数据库</div></td>
  </tr>
  
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="SetDb.php" target="ebakmain">全局参数设置</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="ChangeDb.php" target="ebakmain">备份数据</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="ListSetbak.php" target="ebakmain">管理备份设置</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="ReData.php" target="ebakmain">恢复数据</a></div></td>
  </tr>
  <tr> 
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="ChangePath.php" target="ebakmain">管理备份目录</a></div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="27"><div align="center">附加组件</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="RepFiletext.php" target="ebakmain">替换目录文件</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="DoSql.php" target="ebakmain">执行SQL语句</a></div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="eginfo.php" target="ebakmain">帝国PHP探针</a></div></td>
  </tr>
</table>
<?php
if($ebak_ebma_path&&file_exists('eapi/'.$ebak_ebma_path))
{
?>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="27" title="EmpireBak+phpMyAdmin+高安全"><div align="center">EBMA系统</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="goebma.php" title="用EBMA管理和备份MYSQL更安全。" target="ebakmain">使用phpMyAdmin</a></div></td>
  </tr>
</table>
<?php
}
?>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="27"><div align="center">退出系统</div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="phome.php?phome=exit" onclick="return confirm('确认要退出系统？');" target="_parent">退出系统</a></div></td>
  </tr>
</table>
</body>
</html>