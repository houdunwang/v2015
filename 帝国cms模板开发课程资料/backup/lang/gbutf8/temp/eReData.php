<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>恢复数据</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="ReData.php">恢复数据</a></td>
  </tr>
</table>
<br>
  <table width="70%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="ebakredata" method="post" action="phomebak.php" onsubmit="return confirm('确认要恢复？');">
    <tr class="header"> 
      <td height="25" colspan="2">恢复数据 
        <input name="phome" type="hidden" id="phome" value="ReData"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="34%" height="25">恢复数据源目录：</td>
      <td width="66%" height="25"> 
        <?=$bakpath?>
        / 
        <input name="mypath" type="text" id="mypath" value="<?=$mypath?>"> <input type="button" name="Submit2" value="选择目录" onclick="javascript:window.open('ChangePath.php?change=1','','width=750,height=500,scrollbars=yes');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">要导入的数据库：</td>
      <td height="25"> <select name="add[mydbname]" size="23" id="add[mydbname]" style="width:300">
          <?=$db?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">恢复选项：</td>
      <td height="25">每组恢复间隔： 
        <input name="add[waitbaktime]" type="text" id="add[waitbaktime]" value="0" size="2">
        秒</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"> <div align="left"> 
          <input type="submit" name="Submit" value="开始恢复">
        </div></td>
    </tr>
	</form>
  </table>

</body>
</html>