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
CheckLevel($logininid,$loginin,$classid,"plf");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListAllPl.php".$ecms_hashur['whehref'].">管理评论</a>&nbsp;>&nbsp;<a href=ListPlF.php".$ecms_hashur['whehref'].">管理评论自定义字段</a>&nbsp;>&nbsp;增加字段";
//修改字段
if($enews=="EditPlF")
{
	$fid=(int)$_GET['fid'];
	$url="<a href=ListAllPl.php".$ecms_hashur['whehref'].">管理评论</a>&nbsp;>&nbsp;<a href=ListPlF.php".$ecms_hashur['whehref'].">管理评论自定义字段</a>&nbsp;>&nbsp;修改字段";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsplf where fid='$fid'");
	if(!$r[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$oftype="type".$r[ftype];
	$$oftype=" selected";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加字段</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmspl.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header">增加/修改字段 
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"> <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="oldf" type="hidden" id="oldf" value="<?=$r[f]?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="25%" height="25">字段名</td>
      <td width="75%" height="25"><input name="f" type="text" id="f" value="<?=$r[f]?>"> 
        <font color="#666666">(比如：&quot;title&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">字段标识</td>
      <td height="25"><input name="fname" type="text" id="fname" value="<?=$r[fname]?>"> 
        <font color="#666666">(比如：&quot;标题&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">字段类型</td>
      <td height="25"><select name="ftype" id="select">
          <option value="VARCHAR"<?=$typeVARCHAR?>>字符型0-255字节(VARCHAR)</option>
          <option value="TEXT"<?=$typeTEXT?>>小型字符型(TEXT)</option>
          <option value="MEDIUMTEXT"<?=$typeMEDIUMTEXT?>>中型字符型(MEDIUMTEXT)</option>
          <option value="LONGTEXT"<?=$typeLONGTEXT?>>大型字符型(LONGTEXT)</option>
          <option value="TINYINT"<?=$typeTINYINT?>>小数值型(TINYINT)</option>
          <option value="SMALLINT"<?=$typeSMALLINT?>>中数值型(SMALLINT)</option>
          <option value="INT"<?=$typeINT?>>大数值型(INT)</option>
          <option value="BIGINT"<?=$typeBIGINT?>>超大数值型(BIGINT)</option>
          <option value="FLOAT"<?=$typeFLOAT?>>数值浮点型(FLOAT)</option>
          <option value="DOUBLE"<?=$typeDOUBLE?>>数值双精度型(DOUBLE)</option>
        </select>
        字段长度 
        <input name="flen" type="text" id="flen" value="<?=$r[flen]?>" size="6"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">必填项</td>
      <td height="25"><input type="radio" name="ismust" value="1"<?=$r[ismust]==1?' checked':''?>>
        是 
        <input type="radio" name="ismust" value="0"<?=$r[ismust]==0?' checked':''?>>
        否</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">注释：</td>
      <td height="25"><textarea name="fzs" cols="65" rows="10" id="fzs"><?=stripSlashes($r[fzs])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
