<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//参数
$returnform=ehtmlspecialchars($_GET['returnform']);
//基目录
$openpath="../../DownSys/play";
$hand=@opendir($openpath);
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择文件</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="56%">位置：<a href="ChangePlayerFile.php<?=$ecms_hashur['whehref']?>">选择文件</a></td>
    <td width="44%"><div align="right"> </div></td>
  </tr>
</table>
<form name="chfile" method="post" action="../enews.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <?=$ecms_hashur['eform']?>
    <tr class="header"> 
      <td height="25">文件名 (当前目录：<strong>/e/DownSys/play/</strong>)</td>
    </tr>
    <?php
	while($file=@readdir($hand))
	{
		$truefile=$file;
		if($file=="."||$file=="..")
		{
			continue;
		}
		//目录
		if(is_dir($openpath."/".$file))
		{
			continue;
		}
		//文件
		else
		{
			$img="txt_icon.gif";
			$target="";
		}
	 ?>
    <tr> 
      <td width="88%" height="25"><img src="../../data/images/dir/<?=$img?>" width="23" height="22"><a href="#ecms" onclick="<?=$returnform?>='<?=$truefile?>';window.close();" title="选择"> 
        <?=$truefile?>
        </a></td>
    </tr>
    <?
	}
	@closedir($hand);
	?>
  </table>
</form>
</body>
</html>