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
CheckLevel($logininid,$loginin,$classid,"moreport");
$enews=ehtmlspecialchars($_GET['enews']);
$r['ppath']=ReturnAbsEcmsPath();
$url="<a href=ListMoreport.php".$ecms_hashur['whehref'].">管理网站访问端</a> &gt; 增加网站访问端";
$postword='增加网站访问端';
if($enews=="EditMoreport")
{
	$pid=(int)$_GET['pid'];
	if($pid==1)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmoreport where pid='$pid' limit 1");
	$url="<a href=ListMoreport.php".$ecms_hashur['whehref'].">管理网站访问端</a> &gt; 修改网站访问端：<b>".$r[pname]."</b>";
	$postword='修改网站访问端';
}
$tgtemps='';
$tgsql=$empire->query("select gid,gname,isdefault from {$dbtbpre}enewstempgroup order by gid");
while($tgr=$empire->fetch($tgsql))
{
	$selected='';
	if($tgr['gid']==$r['tempgid'])
	{
		$selected=' selected';
	}
	$tgtemps.="<option value='".$tgr['gid']."'".$selected.">".$tgr['gname']."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>网站访问端</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="moreportform" method="post" action="ListMoreport.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><?=$postword?> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
        <input name="pid" type="hidden" id="pid" value="<?=$pid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="25%" height="25">访问端名称：</td>
      <td width="75%" height="25"><input name="pname" type="text" id="pname" value="<?=$r[pname]?>" size="50">
      *
        <font color="#666666">(比如：手机访问端)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">访问端地址：</td>
      <td height="25"><input name="purl" type="text" id="purl" value="<?=$r[purl]?>" size="50">
        *        <font color="#666666">(结尾需加“/”，比如：http://3g.phome.net/)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">访问端目录：</td>
      <td height="25"><input name="ppath" type="text" id="ppath" value="<?=$r[ppath]?>" size="50">
        *<font color="#666666">(需填绝对目录地址，结尾需加“/”，比如：d:/abc/3g/)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">通讯密钥：</td>
      <td height="25"><input name="postpass" type="text" id="postpass" value="<?=$r[postpass]?>" size="50">
        *
        <input type="button" name="Submit32" value="随机" onclick="document.moreportform.postpass.value='<?=make_password(60)?>';">
      <font color="#666666">(填写10~100个任意字符，最好多种字符组合)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">使用模板组：</td>
      <td height="25"><select name="tempgid" id="tempgid">
        <?=$tgtemps?>
      </select>
        *        <font color="#666666">(选择本访问端使用的模板组)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">页面模式：</td>
      <td height="25"><input type="radio" name="mustdt" value="1"<?=$r[mustdt]==1?' checked':''?>>
        <a href="#empirecms" title="强制动态页面模式时，访问端首页、栏目、内容页等均采用动态页面方式显示，好处是：不用再生成静态页面">强制动态页面模式</a>
        <input type="radio" name="mustdt" value="0"<?=$r[mustdt]==0?' checked':''?>>
        <a href="#empirecms" title="与主端相同：如果主端是采用静态页面模式，需要在本访问端后台生成页面，才会同步显示。">与主端相同</a></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">关闭访问端：</td>
      <td height="25"><input name="isclose" type="checkbox" id="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
      关闭</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">关闭投稿：</td>
      <td height="25"><input name="closeadd" type="checkbox" id="closeadd" value="1"<?=$r[closeadd]==1?' checked':''?>>
        关闭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交">&nbsp;<input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>