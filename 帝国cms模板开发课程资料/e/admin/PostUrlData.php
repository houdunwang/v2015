<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"postdata");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>远程发布</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="PostUrlData.php<?=$ecms_hashur['whehref']?>">远程发布</a></td>
  </tr>
</table>
<form name="form1" method="post" action="enews.php" onsubmit="return confirm('确认要发布？');">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="2">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="6%" height="25"> <div align="center"></div></td>
      <td width="49%" height="25">任务</td>
      <td width="45%" height="25">说明</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"></div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>附件包 (/d)</strong></td>
      <td height="25" bgcolor="#DBEAF5">存放附件目录</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="d/file!!!0">
        </div></td>
      <td height="25">上传附件包 (/d/file)</td>
      <td height="25">系统上传的附件存放目录</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="d/js!!!0">
        </div></td>
      <td height="25">公共JS包 (/d/js)</td>
      <td height="25">共公JS包括广告JS,投票JS,图片信息JS,总排行/最新JS等</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="s!!!0">
        </div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>专题包 (/s)</strong></td>
      <td height="25" bgcolor="#DBEAF5">专题存放目录</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"></div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>系统动态包[与数据库相关] (/e)</strong></td>
      <td height="25" bgcolor="#DBEAF5">与数据库打交道的包</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]3" value="search!!!0">
        </div></td>
      <td height="25">信息搜索表单包 (/search)</td>
      <td height="25">信息搜索表单</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]5" value="e/pl!!!0">
        </div></td>
      <td height="25">信息评论包 (/e/pl)</td>
      <td height="25">信息评论页面</td>
    </tr>
    <tr> 
      <td height="25"><div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="e/DoPrint!!!0">
        </div></td>
      <td height="25">信息打印包(/e/DoPrint)</td>
      <td height="25">信息打印页面</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]6" value="e/data/template!!!0">
        </div></td>
      <td height="25">会员控制面板模板包 (/e/data/template)</td>
      <td height="25">会员控制面板模板</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]7" value="e/config/config.php,e/data/dbcache/class.php,e/data/dbcache/class1.php,e/data/dbcache/ztclass.php,e/data/dbcache/MemberLevel.php!!!1">
        </div></td>
      <td height="25">缓存包 (/e/config/config.php,e/data/dbcache/class.php)</td>
      <td height="25">系统设置的一些参数缓存</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"></div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>站点目录包 (/)</strong></td>
      <td height="25" bgcolor="#DBEAF5">信息栏目存放目录</td>
    </tr>
    <?
	$sql=$empire->query("select classid,classurl,classname,classpath from {$dbtbpre}enewsclass where bclassid=0 order by classid desc");
	while($r=$empire->fetch($sql))
	{
	if($r[classurl])
	{
	$classurl=$r[classurl];
	}
	else
	{
	$classurl="../../".$r[classpath];
	}
	?>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]10" value="<?=$r[classpath]?>!!!0">
        </div></td>
      <td height="25"><a href='<?=$classurl?>' target=_blank> 
        <?=$r[classname]?>
        </a>&nbsp;(/ 
        <?=$r[classpath]?>
        )</td>
      <td height="25"> 
        <?=$r[classurl]?>
      </td>
    </tr>
    <?
	}
	?>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="index<?=$public_r[indextype]?>!!!1">
        </div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>首页 (/index 
        <?=$public_r[indextype]?>
        )</strong></td>
      <td height="25" bgcolor="#DBEAF5">网站首页</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        </div></td>
      <td height="25"> <input type="submit" name="Submit" value="开始发布"> &nbsp;&nbsp; 
        <input type="button" name="Submit2" value="设置FTP参数" onclick="javascript:window.open('SetEnews.php<?=$ecms_hashur['whehref']?>');"> 
        <input name="enews" type="hidden" id="enews" value="AddPostUrlData"></td>
      <td height="25">每 <input name="line" type="text" id="line" value="10" size="6">
        个项目为一组</td>
    </tr>
    <tr> 
      <td height="25" colspan="3"><div align="left">(备注：远程发布所发费的时间较长，请耐心等待.最好将程序运行时间设为最长)</div></td>
    </tr>
  </table>
  <br>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
