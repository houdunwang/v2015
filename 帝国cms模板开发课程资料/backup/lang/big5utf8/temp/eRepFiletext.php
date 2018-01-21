<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>替換目錄文件內容</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr bgcolor="#FFFFFF"> 
    <td>位置：<a href="RepFiletext.php">替換目錄文件內容</a></td>
  </tr>
</table>
<br>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="ebakrepfiletext" method="post" action="phome.php" onsubmit="return confirm('確認要替換？');">
    <tr class="header"> 
      <td height="25" colspan="2">替換目錄文件內容 
        <input name="phome" type="hidden" id="phome" value="RepPathFiletext"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="34%" height="25">替換目錄：</td>
      <td width="66%" height="25"> 
        <?=$bakpath?>
        / 
        <input name="mypath" type="text" id="mypath" value="<?=$mypath?>" size="38"> 
        <input type="button" name="Submit2" value="選擇目錄" onclick="javascript:window.open('ChangePath.php?change=1&toform=ebakrepfiletext','','width=750,height=500,scrollbars=yes');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">將字符：<br> <br> <font color="#666666">(若是正則替換，可用「*」表示任意字符) 
        </font></td>
      <td height="25"><textarea name="oldword" cols="70" rows="8" id="oldword"></textarea>      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">替換為：</td>
      <td height="25"><textarea name="newword" cols="70" rows="8" id="newword"></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">選項：</td>
      <td height="25"><input name="dozz" type="checkbox" id="dozz" value="1">
        正則替換</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="left"> </div>      </td>
      <td height="25"><input type="submit" name="Submit" value="開始替換">&nbsp;&nbsp;
        <input type="reset" name="Submit3" value="重置"> </td>
    </tr>
	</form>
  </table>
</body>
</html>