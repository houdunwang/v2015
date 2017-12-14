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
CheckLevel($logininid,$loginin,$classid,"pubvar");
$enews=ehtmlspecialchars($_GET['enews']);
$cid=(int)$_GET['cid'];
$r[myorder]=0;
$url="<a href=ListPubVar.php".$ecms_hashur['whehref'].">管理扩展变量</a>&nbsp;>&nbsp;增加扩展变量";
//修改
if($enews=="EditPubVar")
{
	$varid=(int)$_GET['varid'];
	$r=$empire->fetch1("select myvar,varname,varvalue,varsay,classid,tocache,myorder from {$dbtbpre}enewspubvar where varid='$varid'");
	$r[varvalue]=ehtmlspecialchars($r[varvalue]);
	$url="<a href=ListPubVar.php".$ecms_hashur['whehref'].">管理扩展变量</a>&nbsp;>&nbsp;修改扩展变量：".$r[myvar];
}
//分类
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewspubvarclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加扩展变量</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="ListPubVar.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">增加扩展变量 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="varid" type="hidden" value="<?=$varid?>"> 
        <input name="cid" type="hidden" value="<?=$cid?>">
        <input name="oldmyvar" type="hidden" id="oldmyvar" value="<?=$r[myvar]?>">
        <input name="oldtocache" type="hidden" id="oldtocache" value="<?=$r[tocache]?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">变量名(*)</td>
      <td width="81%" height="25"> <input name="myvar" type="text" value="<?=$r[myvar]?>">
        <font color="#666666">(由英文与数字组成，且不能以数字开头。如：&quot;title&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属分类</td>
      <td height="25"><select name="classid">
          <option value="0">不隶属于任何分类</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="管理分类" onclick="window.open('PubVarClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">变量标识(*)</td>
      <td height="25"><input name="varname" type="text" value="<?=$r[varname]?>"> 
        <font color="#666666">(如：标题)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">变量说明</td>
      <td height="25"><input name="varsay" type="text" id="varsay" value="<?=$r[varsay]?>" size="60"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">是否写入缓存</td>
      <td height="25"><input type="radio" name="tocache" value="1"<?=$r[tocache]==1?' checked':''?>>
        写入缓存 
        <input type="radio" name="tocache" value="0"<?=$r[tocache]==0?' checked':''?>>
        不写入缓存<font color="#666666">（大内容不建议写入缓存，缓存调用变量：$public_r['add_变量名']）</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">变量排序</td>
      <td height="25"><input name="myorder" type="text" value="<?=$r[myorder]?>">
        <font color="#666666">(值越小显示越前面)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>变量值</strong></td>
      <td height="25">请将变量内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.varvalue.value);document.form1.varvalue.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('../template/editor.php?<?=$ecms_hashur['ehref']?>&getvar=opener.document.form1.varvalue.value&returnvar=opener.document.form1.varvalue.value&fun=ReturnHtml&notfullpage=1','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="varvalue" cols="90" rows="16" wrap="OFF" style="WIDTH: 100%"><?=$r[varvalue]?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> &nbsp; <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
