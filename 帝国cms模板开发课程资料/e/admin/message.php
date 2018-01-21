<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//特殊提示
if($GLOBALS['ecmsadderrorurl'])//增加信息
{
	$error='<br>'.$error.'<br><br><a href="'.$GLOBALS['ecmsadderrorurl'].'">返回信息列表</a>';
}

//风格
$loginadminstyleid=EcmsReturnAdminStyle();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>信息提示</title>
<link href="<?=$a?>adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<?php
if(!$noautourl)
{
?>
<SCRIPT language=javascript>
var secs=2;//3秒
for(i=1;i<=secs;i++) 
{ window.setTimeout("update(" + i + ")", i * 1000);} 
function update(num) 
{ 
if(num == secs) 
{ <?=$gotourl_js?>; } 
else 
{ } 
}
</SCRIPT>
<?
}
?>
</head>

<body>
<br>
<br>
<br>
<br>
<br>
<br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="25"><div align="center">信息提示</div></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="80"> 
      <div align="center">
	  <br>
        <b><?=$error?></b>
        <br>
        <br><a href="<?=$gotourl?>">如果您的浏览器没有自动跳转，请点击这里</a>
<br><br>
	  </div></td>
  </tr>
</table>
</body>
</html>