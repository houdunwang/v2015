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
CheckLevel($logininid,$loginin,$classid,"public");

//设置伪静态参数
function SetRewrite($add,$userid,$username){
	global $empire,$dbtbpre;
	CheckLevel($userid,$username,$classid,"public");//验证权限
	$sql=$empire->query("update {$dbtbpre}enewspublic set rewriteinfo='".eaddslashes($add[rewriteinfo])."',rewriteclass='".eaddslashes($add[rewriteclass])."',rewriteinfotype='".eaddslashes($add[rewriteinfotype])."',rewritetags='".eaddslashes($add[rewritetags])."',rewritepl='".eaddslashes($add[rewritepl])."' limit 1");
	if($sql)
	{
		GetConfig();
		//操作日志
		insert_dolog("");
		printerror("SetRewriteSuccess","SetRewrite.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="SetRewrite")//设置伪静态参数
{
	SetRewrite($_POST,$logininid,$loginin);
}

$r=$empire->fetch1("select rewriteinfo,rewriteclass,rewriteinfotype,rewritetags,rewritepl from {$dbtbpre}enewspublic limit 1");
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>设置伪静态</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><p>位置：<a href="SetRewrite.php<?=$ecms_hashur['whehref']?>">伪静态设置</a></p>
    </td>
  </tr>
</table>
<form name="setpublic" method="post" action="SetRewrite.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="4">伪静态参数设置 
        <input name="enews" type="hidden" value="SetRewrite"></td>
    </tr>
    <tr>
      <td width="135" height="25">页面</td>
      <td width="302" height="25">标记</td>
      <td width="554">格式</td>
      <td width="323">对应页面</td>
    </tr>
	<tr bgcolor="#FFFFFF">
      <td height="25">信息内容页</td>
      <td height="25">[!--classid--],[!--id--],[!--page--]</td>
      <td>/
        <input name="rewriteinfo" type="text" id="rewriteinfo" value="<?=$r[rewriteinfo]?>" size="55">
[<a href="#empirecms" onclick="document.setpublic.rewriteinfo.value='showinfo-[!--classid--]-[!--id--]-[!--page--].html';">默认</a>]</td>
      <td>/e/action/ShowInfo.php?classid=栏目ID&amp;id=信息ID&amp;page=分页号</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">信息列表页</td>
      <td height="25">[!--classid--],[!--page--]</td>
      <td>/
        <input name="rewriteclass" type="text" id="rewriteclass" value="<?=$r[rewriteclass]?>" size="55">
      [<a href="#empirecms" onclick="document.setpublic.rewriteclass.value='listinfo-[!--classid--]-[!--page--].html';">默认</a>]</td>
      <td>/e/action/ListInfo/index.php?classid=栏目ID&amp;page=分页号</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">标题分类列表页</td>
      <td height="25">[!--ttid--],[!--page--]</td>
      <td>/
        <input name="rewriteinfotype" type="text" id="rewriteinfotype" value="<?=$r[rewriteinfotype]?>" size="55">
[<a href="#empirecms" onclick="document.setpublic.rewriteinfotype.value='infotype-[!--ttid--]-[!--page--].html';">默认</a>]</td>
      <td>/e/action/InfoType/index.php?ttid=标题分类ID&amp;page=分页号</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">TAGS信息列表页</td>
      <td height="25">[!--tagname--],[!--page--]</td>
      <td>/
        <input name="rewritetags" type="text" id="rewritetags" value="<?=$r[rewritetags]?>" size="55">
[<a href="#empirecms" onclick="document.setpublic.rewritetags.value='tags-[!--tagname--]-[!--page--].html';">默认</a>]</td>
      <td>/e/tags/index.php?tagname=TAGS名称&amp;page=分页号</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">评论列表页</td>
      <td height="25">[!--doaction--],[!--classid--],[!--id--],<br>
      [!--page--],[!--myorder--],[!--tempid--]</td>
      <td>/
        <input name="rewritepl" type="text" id="rewritepl" value="<?=$r[rewritepl]?>" size="55">
[<a href="#empirecms" onclick="document.setpublic.rewritepl.value='comment-[!--doaction--]-[!--classid--]-[!--id--]-[!--page--]-[!--myorder--]-[!--tempid--].html';">默认</a>]</td>
      <td>/e/pl/index.php?doaction=事件&amp;classid=栏目ID&amp;id=信息ID&amp;page=分页号&amp;myorder=排序&amp;tempid=评论模板ID</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25" colspan="3"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
	<tr bgcolor="#FFFFFF">
      <td height="25" colspan="4">说明：采用静态页面时不需要设置，只有当采用动态页面时可通过设置伪静态来提高SEO优化，如果不启用请留空。注意：伪静态会增加服务器负担，修改伪静态格式后你需要修改服务器的 Rewrite 规则设置。</td>
    </tr>
  </table>
</form>
</body>
</html>
