<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>下载压缩包</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="30"> <div align="center">下载压缩包(目录： 
        <?=$p?>
        )</div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF"> 
      <div align="center">[<a href="<?=$file?>">下载压缩包</a>]</div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF"> 
      <div align="center">[<a href="phome.php?f=<?=$f?>&phome=DelZip" onclick="return confirm('确认要删除？');">删除压缩包</a>]</div></td>
  </tr>
  <tr>
    <td height="30" bgcolor="#FFFFFF">
<div align="center">（<font color="#FF0000">说明：安全起见，下载完毕请马上删除压缩包．</font>）</div></td>
  </tr>
</table>
</body>
</html>