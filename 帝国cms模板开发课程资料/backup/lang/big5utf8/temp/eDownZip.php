<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>下載壓縮包</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="30"> <div align="center">下載壓縮包(目錄： 
        <?=$p?>
        )</div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF"> 
      <div align="center">[<a href="<?=$file?>">下載壓縮包</a>]</div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF"> 
      <div align="center">[<a href="phome.php?f=<?=$f?>&phome=DelZip" onclick="return confirm('確認要刪除？');">刪除壓縮包</a>]</div></td>
  </tr>
  <tr>
    <td height="30" bgcolor="#FFFFFF">
<div align="center">（<font color="#FF0000">說明：安全起見，下載完畢請馬上刪除壓縮包．</font>）</div></td>
  </tr>
</table>
</body>
</html>