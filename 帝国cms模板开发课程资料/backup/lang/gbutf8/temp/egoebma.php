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
		$dbservername.=' ('.$dbserverr['dbname'].')';
	}
}
$pmaurl='eapi/'.$ebak_ebma_path.'/';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>使用EBMA系统</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="goebma.php">EBMA系统：更安全的MYSQL管理和备份系统。</a></td>
    <td width="50%"><div align="right">EBMA系统官方网站：<a href="http://ebak.phome.net" target="_blank">http://ebak.phome.net</a>&nbsp;&nbsp;</div></td>
  </tr>
</table>
<br>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><div align="center"><strong> 
        </strong>
        <h3><strong>欢迎使用更安全的EBMA系统 (<font color="#FF0000">E</font>mpire<font color="#FF0000">B</font>ak+php<font color="#FF0000">M</font>y<font color="#FF0000">A</font>dmin+高安全)</strong></h3>
        <strong></strong></div></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="650" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header">
      <td height="25" colspan="2"><div align="center">进入phpMyAdmin管理MYSQL</div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="28%" height="32">当前服务器<strong><?=$dbserverno?></strong>：</td>
      <td width="72%" height="25"><?=$dbservername?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="32">进入phpMyAdmin：</td>
      <td height="25">
	  <?php
	  if($ebak_ebma_open)
	  {
	  ?>
	  <strong><a href="<?=$pmaurl?>" target="_blank">点击进入phpMyAdmin</a></strong>
	  <?php
	  }
	  else
	  {
	  ?>
	  当前phpMyAdmin已关闭，要使用请到<a href="SetDb.php"><strong>全局参数设置</strong></a>中开启。
	  <?php
	  }
	  ?>	  </td>
    </tr>
    <?php
	if($ebak_ebma_cklogin)
	{
	?>
    <tr bgcolor="#FFFFFF">
      <td height="32" colspan="2"><div align="center"><font color="#009900"><strong>当前phpMyAdmin正受帝国备份王安全认证保护。</strong></font></div></td>
    </tr>
	<?php
	}
	else
	{
	?>
    <tr bgcolor="#FFFFFF">
      <td height="32" colspan="2"><div align="center"><font color="#009900"><strong>当前phpMyAdmin正受帝国备份王安全认证+phpMyAdmin本身双重安全认证保护。</strong></font></div></td>
    </tr>
	<?php
	}
	?>
    <tr bgcolor="#FFFFFF">
      <td height="25" colspan="2">(注意事项：使用过程中请不要切换服务器.)</td>
    </tr>
</table>
<br>
<br>
<br>
<table width="420" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="38"><div align="center">Powered by <a href="http://ebak.phome.net" target="_blank"><strong>EBMA</strong></a></div></td>
  </tr>
</table>
</body>
</html>