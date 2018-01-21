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
CheckLevel($logininid,$loginin,$classid,"tags");
$enews=ehtmlspecialchars($_GET['enews']);
$postword='增加TAGS';
$url="<a href=ListTags.php".$ecms_hashur['whehref'].">管理TAGS</a> &gt; 增加TAGS";
$fcid=(int)$_GET['fcid'];
//修改
if($enews=="EditTags")
{
	$postword='修改TAGS';
	$tagid=(int)$_GET['tagid'];
	$r=$empire->fetch1("select tagid,tagname,cid from {$dbtbpre}enewstags where tagid='$tagid'");
	$url="<a href=ListTags.php".$ecms_hashur['whehref'].">管理TAGS</a> -&gt; 修改TAGS：<b>".$r[tagname]."</b>";
}
//分类
$csql=$empire->query("select classid,classname from {$dbtbpre}enewstagsclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($r[cid]==$cr[classid])
	{
		$select=" selected";
	}
	$cs.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>TAGS</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListTags.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><?=$postword?> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="tagid" type="hidden" id="tagid" value="<?=$tagid?>">
        <input name="fcid" type="hidden" id="fcid" value="<?=$fcid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="18%" height="25">TAG名称:</td>
      <td width="82%" height="25"> <input name="tagname" type="text" id="tagname" value="<?=$r[tagname]?>" size="42"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属分类:</td>
      <td height="25"><select name="cid" id="cid">
          <option value="0">不分类</option>
		  <?=$cs?>
        </select> 
        <input type="button" name="Submit62223" value="管理分类" onclick="window.open('TagsClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
