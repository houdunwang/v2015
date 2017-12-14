<?php
if(!defined('InEmpireBak'))
{
	exit();
}
$onclickword='(点击转向恢复数据)';
$change=(int)$_GET['change'];
if($change==1)
{
	$onclickword='(点击选择)';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理备份目录</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function ChangePath(pathname)
{
	opener.document.<?=$form?>.mypath.value=pathname;
	window.close();
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="ChangePath.php">管理备份目录</a>&nbsp;(存放目录：<b><?=$bakpath?></b>)</td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="42%" height="25"> <div align="center">备份目录名
        <?=$onclickword?>
    </div></td>
    <td width="16%" height="25"> <div align="center">查看说明文件</div></td>
    <td width="42%"><div align="center">操作</div></td>
  </tr>
  <?php
  while($file=@readdir($hand))
  {
	if($file!="."&&$file!=".."&&is_dir($bakpath."/".$file))
	{
		if($change==1)
		{
			$showfile="<a href='#ebak' onclick=\"javascript:ChangePath('$file');\" title='$file'>$file</a>";
		}
		else
		{
			$showfile="<a href='phome.php?phome=PathGotoRedata&mypath=$file' title='$file'>$file</a>";
		}
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25"> <div align="left"><img src="images/dir.gif" width="19" height="15">&nbsp; 
        <?=$showfile?> </div></td>
    <td height="25"> <div align="center"> [<a href="<? echo $bakpath."/".$file."/readme.txt"?>" target=_blank>查看备份说明</a>]</div></td>
    <td><div align="center">[<a href="#ebak" onclick="window.open('phome.php?phome=DoZip&p=<?=$file?>&change=<?=$change?>','','width=350,height=160');">打包并下载</a>]&nbsp;&nbsp;[<a href="RepFiletext.php?mypath=<?=$file?>">替换文件内容</a>]&nbsp;&nbsp;[<a href="phome.php?phome=DelBakpath&path=<?=$file?>&change=<?=$change?>" onclick="return confirm('确认要删除？');">删除目录</a>]</div></td>
  </tr>
  <?
     }
  }
  ?>
  <tr> 
    <td height="25" colspan="3" bgcolor="#FFFFFF"><font color="#666666">(说明：如果备份目录文件较多建议直接从FTP下载备份目录。)</font></td>
  </tr>
</table>
</body>
</html>