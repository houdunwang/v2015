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
//验证权限
CheckLevel($logininid,$loginin,$classid,"wap");

//设置
function SetWap($add,$userid,$username){
	global $empire,$dbtbpre;
	$wapopen=(int)$add['wapopen'];
	$wapdefstyle=(int)$add['wapdefstyle'];
	$wapshowmid=RepPostVar($add['wapshowmid']);
	$waplistnum=(int)$add['waplistnum'];
	$wapsubtitle=(int)$add['wapsubtitle'];
	$wapchar=(int)$add['wapchar'];
	$sql=$empire->query("update {$dbtbpre}enewspublic set wapopen=$wapopen,wapdefstyle=$wapdefstyle,wapshowmid='$wapshowmid',waplistnum=$waplistnum,wapsubtitle=$wapsubtitle,wapshowdate='$add[wapshowdate]',wapchar=$wapchar limit 1");
	//操作日志
	insert_dolog("");
	printerror("SetWapSuccess","SetWap.php".hReturnEcmsHashStrHref2(1));
}

$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='SetWap')
{
	SetWap($_POST,$logininid,$loginin);
}

$r=$empire->fetch1("select wapopen,wapdefstyle,wapshowmid,waplistnum,wapsubtitle,wapshowdate,wapchar from {$dbtbpre}enewspublic limit 1");
//wap模板
$wapdefstyles='';
$stylesql=$empire->query("select styleid,stylename from {$dbtbpre}enewswapstyle order by styleid");
while($styler=$empire->fetch($stylesql))
{
	$select='';
	if($styler['styleid']==$r['wapdefstyle'])
	{
		$select=' selected';
	}
	$wapdefstyles.="<option value='".$styler[styleid]."'".$select.">".$styler[stylename]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WAP设置</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置：<a href="SetWap.php<?=$ecms_hashur['whehref']?>">WAP设置</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit522" value="管理WAP模板" onclick="self.location.href='WapStyle.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="setwapform" method="post" action="SetWap.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">WAP设置 
        <input name=enews type=hidden value=SetWap></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">开启WAP</td>
      <td height="25"><input type="radio" name="wapopen" value="1"<?=$r[wapopen]==1?' checked':''?>>
        是 
        <input type="radio" name="wapopen" value="0"<?=$r[wapopen]==0?' checked':''?>>
        否 </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">WAP字符集</td>
      <td height="25"><input type="radio" name="wapchar" value="1"<?=$r[wapchar]==1?' checked':''?>>
        UTF-8 
        <input type="radio" name="wapchar" value="0"<?=$r[wapchar]==0?' checked':''?>>
        UNICODE <font color="#666666">(默认为 UNICODE 编码)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">只显示系统模型列表</td>
      <td height="25"><input name="wapshowmid" type="text" id="wapshowmid" value="<?=$r[wapshowmid]?>"> 
        <font color="#666666">(多个模型ID用&quot;,&quot;隔开,空为显示所有)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">默认使用WAP模板</td>
      <td width="80%" height="25"><select name="wapdefstyle" id="wapdefstyle">
          <?=$wapdefstyles?>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">列表每页显示</td>
      <td height="25"> <input name="waplistnum" type="text" id="waplistnum" value="<?=$r[waplistnum]?>">
        条信息</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">标题截取</td>
      <td height="25"> <input name="wapsubtitle" type="text" id="wapsubtitle" value="<?=$r[wapsubtitle]?>">
        个字节 <font color="#666666">(0为不截取)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">时间显示格式</td>
      <td height="25"><input name="wapshowdate" type="text" id="wapshowdate" value="<?=$r[wapshowdate]?>"> 
        <font color="#666666">(格式：Y表示年,m表示月,d表示天)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25">WAP地址：<a href="<?=$public_r[newsurl]?>e/wap/" target="_blank"><?=$public_r[newsurl]?>e/wap/</a></td>
    </tr>
  </table>
</form>
</body>
</html>
