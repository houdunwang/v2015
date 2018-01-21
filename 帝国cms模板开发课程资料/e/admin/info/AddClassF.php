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
CheckLevel($logininid,$loginin,$classid,"classf");
$enews=RepPostStr($_GET['enews'],1);
$url="<a href='../ListClass.php".$ecms_hashur['whehref']."'>管理栏目</a>&nbsp;>&nbsp;<a href='ListClassF.php".$ecms_hashur['whehref']."'>管理栏目字段</a>&nbsp;>&nbsp;增加栏目字段";
$postword='增加字段';
$r[myorder]=0;
//修改字段
if($enews=="EditClassF")
{
	$fid=(int)$_GET['fid'];
	$url="<a href='../ListClass.php".$ecms_hashur['whehref']."'>管理栏目</a>&nbsp;>&nbsp;<a href='ListClassF.php".$ecms_hashur['whehref']."'>管理栏目字段</a>&nbsp;>&nbsp;修改栏目字段";
	$postword='修改字段';
	$r=$empire->fetch1("select * from {$dbtbpre}enewsclassf where fid='$fid'");
	if(!$r[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$oftype="type".$r[ftype];
	$$oftype=" selected";
	$ofform="form".$r[fform];
	$$ofform=" selected";
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
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsclass.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header"> 
        <?=$postword?>
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"> <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="oldfform" type="hidden" id="oldfform" value="<?=$r[fform]?>"> 
        <input name="oldf" type="hidden" id="oldf" value="<?=$r[f]?>"> <input name="oldfvalue" type="hidden" id="oldfvalue" value="<?=$r[fvalue]?>">
        <input name="oldfformsize" type="hidden" id="oldfformsize" value="<?=$r[fformsize]?>"></td>
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
      <td rowspan="2">输入表单显示元素</td>
      <td height="25"><select name="fform" id="fform">
          <option value="text"<?=$formtext?>>单行文本框(text)</option>
          <option value="password"<?=$formpassword?>>密码框(password)</option>
          <option value="select"<?=$formselect?>>下拉框(select)</option>
          <option value="radio"<?=$formradio?>>单选框(radio)</option>
          <option value="textarea"<?=$formtextarea?>>多行文本框(textarea)</option>
          <option value="editor"<?=$formeditor?>>编辑器(editor)</option>
		  <option value="img"<?=$formimg?>>图片(img)</option>
          <option value="flash"<?=$formflash?>>FLASH文件(flash)</option>
          <option value="file"<?=$formfile?>>文件(file)</option>
        </select>
        元素长度 
        <input name="fformsize" type="text" id="fformsize" value="<?=$r[fformsize]?>" size="12"> 
        <font color="#666666">(空为按默认)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><font color="#666666">说明：长度如果是“多行文本框”，长度与行数用逗号格开，如“60,6”.</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">初始值<br>
        <font color="#666666"><span id="defvaldiv">(多个值用&quot;回车&quot;格开；<br>
        默认选项后面加：:default)</span></font></td>
      <td height="25"><textarea name="fvalue" cols="65" rows="8" id="fvalue" style="WIDTH: 100%"><?=str_replace("|","\r\n",$r[fvalue])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">显示顺序</td>
      <td height="25"><input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>" size="6"> 
        <font color="#666666">(数字越小越前面)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">输入表单替换html代码<br> <font color="#666666">(增加字段时请留空)</font></td>
      <td height="25"><textarea name="fhtml" cols="65" rows="10" id="fhtml" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[fhtml]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">注释</td>
      <td height="25"><textarea name="fzs" cols="65" rows="10" id="fzs" style="WIDTH: 100%"><?=stripSlashes($r[fzs])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
