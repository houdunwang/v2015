<?php
if(!defined('InEmpireBak'))
{
	exit();
}
$onclickword='(点击转向备份数据)';
$change=(int)$_GET['change'];
if($change==1)
{
	$onclickword='(点击选择)';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理备份保存设置</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function ChangeSet(filename)
{
	var ok=confirm("确认要导入?");
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
    <td>位置：<a href="ListSetbak.php">管理备份设置</a>&nbsp;(存放目录：<b>setsave</b>)</td>
  </tr>
</table>
<br>
<table width="500" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="63%" height="25"> <div align="center">保存设置文件名<?=$onclickword?></div></td>
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
		//默认设置
		if($file=='def')
		{
			if(empty($change))
			{
				$showfile=$file;
			}
			$showdel="<b>默认设置</b>";
		}
		else
		{
			$showdel="<a href=\"phome.php?phome=DoDelSave&mydbname=$mydbname&change=$change&savename=$file\" onclick=\"return confirm('确认要删除？');\">删除设置</a>";
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
    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#666666">(说明：备份数据表时保存的参数设置。)</font></td>
  </tr>
</table>
</body>
</html>