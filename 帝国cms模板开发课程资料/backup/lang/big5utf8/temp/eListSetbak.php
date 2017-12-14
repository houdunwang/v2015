<?php
if(!defined('InEmpireBak'))
{
	exit();
}
$onclickword='(點擊轉向備份數據)';
$change=(int)$_GET['change'];
if($change==1)
{
	$onclickword='(點擊選擇)';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理備份保存設置</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function ChangeSet(filename)
{
	var ok=confirm("確認要導入?");
	if(ok)
	{
		opener.parent.ebakmain.location.href='ChangeTable.php?mydbname=<?=$mydbname?>&savefilename='+filename;
		window.close();
	}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="ListSetbak.php">管理備份設置</a>&nbsp;(存放目錄：<b>setsave</b>)</td>
  </tr>
</table>
<br>
<table width="500" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="63%" height="25"> <div align="center">保存設置文件名<?=$onclickword?></div></td>
    <td width="37%"><div align="center">操作</div></td>
  </tr>
  <?php
  while($file=@readdir($hand))
  {
  	if($file!="."&&$file!=".."&&$file!="index.html"&&is_file("setsave/".$file))
	{
		if($change==1)
		{
			$showfile="<a href='#ebak' onclick=\"javascript:ChangeSet('$file');\" title='$file'>$file</a>";
		}
		else
		{
			$showfile="<a href='phome.php?phome=SetGotoBak&savename=$file' title='$file'>$file</a>";
		}
		//默認設置
		if($file=='def')
		{
			if(empty($change))
			{
				$showfile=$file;
			}
			$showdel="<b>默認設置</b>";
		}
		else
		{
			$showdel="<a href=\"phome.php?phome=DoDelSave&mydbname=$mydbname&change=$change&savename=$file\" onclick=\"return confirm('確認要刪除？');\">刪除設置</a>";
		}
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25"> <div align="left"><img src="images/txt.gif" width="19" height="16">&nbsp; 
        <?=$showfile?> </div></td>
    <td><div align="center">&nbsp;[<?=$showdel?>]</div></td>
  </tr>
  <?
     }
  }
  ?>
  <tr> 
    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#666666">(說明：備份數據表時保存的參數設置。)</font></td>
  </tr>
</table>
</body>
</html>