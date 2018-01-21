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
		$dbservername.=' ('.$dbserverr['dbname'].')';
	}
}
$pmaurl='eapi/'.$ebak_ebma_path.'/';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>使用EBMA系統</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="goebma.php">EBMA系統：更安全的MYSQL管理和備份系統。</a></td>
    <td width="50%"><div align="right">EBMA系統官方網站：<a href="http://ebak.phome.net" target="_blank">http://ebak.phome.net</a>&nbsp;&nbsp;</div></td>
  </tr>
</table>
<br>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><div align="center"><strong> 
        </strong>
        <h3><strong>歡迎使用更安全的EBMA系統 (<font color="#FF0000">E</font>mpire<font color="#FF0000">B</font>ak+php<font color="#FF0000">M</font>y<font color="#FF0000">A</font>dmin+高安全)</strong></h3>
        <strong></strong></div></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="650" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header">
      <td height="25" colspan="2"><div align="center">進入phpMyAdmin管理MYSQL</div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="28%" height="32">當前服務器<strong><?=$dbserverno?></strong>：</td>
      <td width="72%" height="25"><?=$dbservername?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="32">進入phpMyAdmin：</td>
      <td height="25">
	  <?php
	  if($ebak_ebma_open)
	  {
	  ?>
	  <strong><a href="<?=$pmaurl?>" target="_blank">點擊進入phpMyAdmin</a></strong>
	  <?php
	  }
	  else
	  {
	  ?>
	  當前phpMyAdmin已關閉，要使用請到<a href="SetDb.php"><strong>全局參數設置</strong></a>中開啟。
	  <?php
	  }
	  ?>	  </td>
    </tr>
    <?php
	if($ebak_ebma_cklogin)
	{
	?>
    <tr bgcolor="#FFFFFF">
      <td height="32" colspan="2"><div align="center"><font color="#009900"><strong>當前phpMyAdmin正受帝國備份王安全認證保護。</strong></font></div></td>
    </tr>
	<?php
	}
	else
	{
	?>
    <tr bgcolor="#FFFFFF">
      <td height="32" colspan="2"><div align="center"><font color="#009900"><strong>當前phpMyAdmin正受帝國備份王安全認證+phpMyAdmin本身雙重安全認證保護。</strong></font></div></td>
    </tr>
	<?php
	}
	?>
    <tr bgcolor="#FFFFFF">
      <td height="25" colspan="2">(注意事項：使用過程中請不要切換服務器.)</td>
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