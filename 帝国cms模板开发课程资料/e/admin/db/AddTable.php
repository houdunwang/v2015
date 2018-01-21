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
CheckLevel($logininid,$loginin,$classid,"table");
$enews=RepPostStr($_GET['enews'],1);
$url="<a href=ListTable.php".$ecms_hashur['whehref'].">管理数据表</a>&nbsp;>&nbsp;新建数据表";
//修改
if($enews=="EditTable")
{
	$tid=(int)$_GET['tid'];
	$url="<a href=ListTable.php".$ecms_hashur['whehref'].">管理数据表</a>&nbsp;>&nbsp;修改数据表";
	$r=$empire->fetch1("select tid,tbname,tname,tsay,yhid,intb from {$dbtbpre}enewstable where tid='$tid'");
}
//优化方案
$yh_options='';
$yhsql=$empire->query("select id,yhname from {$dbtbpre}enewsyh order by id");
while($yhr=$empire->fetch($yhsql))
{
	$select='';
	if($r[yhid]==$yhr[id])
	{
		$select=' selected';
	}
	$yh_options.="<option value='".$yhr[id]."'".$select.">".$yhr[yhname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新建数据表</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置： 
      <?=$url?>
    </td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmod.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header">建立/修改数据表</td>
    </tr>
    <tr> 
      <td width="23%" height="25" bgcolor="#F8F8F8">数据表名:</td>
      <td width="77%" height="25" bgcolor="#FFFFFF"><strong> 
        <?=$dbtbpre?>
        ecms_</strong> <input name="tbname" type="text" id="tbname" value="<?=$r[tbname]?>">
        *<font color="#666666">(如:news,只能由字母、数字组成)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#F8F8F8">数据表标识:</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="tname" type="text" id="tname" value="<?=$r[tname]?>" size="38">
        *<font color="#666666">(如:新闻数据表)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#F8F8F8">使用优化方案:</td>
      <td height="25" bgcolor="#FFFFFF"><select name="yhid" id="yhid">
          <option name="0">不使用</option>
          <?=$yh_options?>
        </select> <input type="button" name="Submit63" value="管理优化方案" onclick="window.open('../db/ListYh.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#F8F8F8">是否内部表:</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="intb" value="0"<?=$r['intb']==0?' checked':''?>>
        正常表 
        <input type="radio" name="intb" value="1"<?=$r['intb']==1?' checked':''?>>
        内部表 <font color="#666666">(内部表前台不显示和生成，只有后台才能查看)</font></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#F8F8F8">备注:</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="tsay" cols="70" rows="8" id="tsay"><?=stripSlashes($r[tsay])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#F8F8F8">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="提交"> 
        <input type="reset" name="Submit2" value="重置"> <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="oldtbname" type="hidden" id="oldtbname" value="<?=$r[tbname]?>"></td>
    </tr>
  </table>
</form>
</body>
</html>
