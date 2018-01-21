<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$showmod=(int)$_GET['showmod'];
$type=(int)$_GET['type'];
$classid=(int)$_GET['classid'];
$infoid=(int)$_GET['infoid'];
$filepass=(int)$_GET['filepass'];
$modtype=(int)$_GET['modtype'];
$sinfo=(int)$_GET['sinfo'];
$doing=ehtmlspecialchars($_GET['doing']);
$field=ehtmlspecialchars($_GET['field']);
$tranfrom=ehtmlspecialchars($_GET['tranfrom']);
$fileno=ehtmlspecialchars($_GET['fileno']);
if(empty($field))
{
	$field="ecms";
}
$search="&classid=$classid&infoid=$infoid&filepass=$filepass&type=$type&modtype=$modtype&sinfo=$sinfo&doing=$doing&tranfrom=$tranfrom&field=$field&fileno=$fileno".$ecms_hashur['ehref'];
$search1="&classid=$classid&infoid=$infoid&filepass=$filepass&modtype=$modtype&sinfo=$sinfo&doing=$doing&tranfrom=$tranfrom&field=$field&fileno=$fileno".$ecms_hashur['ehref'];
if($showmod==1)
{
	$filename="filep.php";
}
else
{
	$filename="file.php";
}
$editor=1;
//风格
$loginadminstyleid=(int)getcvar('loginadminstyleid',1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>选择文件</title>
<script>
function ChangeShowMod(obj){
	var furl,searchstr,dotype;
	searchstr="<?=$search1?>";
	dotype=obj.type.value;
	if(obj.showmod.value==1)
	{
		furl="filep.php?"+searchstr+"&type="+dotype;
	}
	else
	{
		furl="file.php?"+searchstr+"&type="+dotype;
	}
	elfile.location=furl;
}
</script>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" class="tableborder">
  <tr class="header">
    <td height="27"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <form name="FileMainNav" method="get" action="">
          <tr> 
            <td height="25">显示模式： 
              <select name="showmod" id="showmod" onchange="ChangeShowMod(document.FileMainNav);">
                <option value="0"<?=$showmod==0?' selected':''?>>数据库模式</option>
                <option value="1"<?=$showmod==1?' selected':''?>>目录模式</option>
              </select>
              文件类型： 
              <select name="type" id="type" onchange="ChangeShowMod(document.FileMainNav);">
                <option value="1"<?=$type==1?' selected':''?>>图片</option>
                <option value="2"<?=$type==2?' selected':''?>>Flash文件</option>
                <option value="3"<?=$type==3?' selected':''?>>多媒体文件</option>
                <option value="0"<?=$type==0?' selected':''?>>其他附件</option>
              </select>
            </td>
          </tr>
        </form>
      </table>
	</td>
  </tr>
  <tr>
    <td height="100%"> 
      <IFRAME frameBorder="0" id="elfile" name="elfile" scrolling="yes" src="<?=$filename.'?'.$search?>" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1"></IFRAME>
    </td>
  </tr>
</table>
</body>
</html>
