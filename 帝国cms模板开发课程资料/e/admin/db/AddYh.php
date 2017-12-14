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
CheckLevel($logininid,$loginin,$classid,"yh");
$enews=RepPostStr($_GET['enews'],1);
$url="<a href=ListYh.php".$ecms_hashur['whehref'].">管理优化方案</a> &gt; 增加优化方案";
$r[hlist]=30;
$r[qlist]=30;
$r[bqnew]=30;
$r[bqhot]=30;
$r[bqpl]=30;
$r[bqgood]=30;
$r[bqfirst]=30;
$r[bqdown]=30;
$r[otherlink]=30;
$r[qmlist]=0;
$r[dobq]=1;
$r[dojs]=1;
$r[dosbq]=0;
$r[rehtml]=0;
//复制
if($enews=="AddYh"&&$_GET['docopy'])
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsyh where id='$id'");
	$url="<a href=ListYh.php".$ecms_hashur['whehref'].">管理优化方案</a> &gt; 复制优化方案：<b>".$r[yhname]."</b>";
}
//修改
if($enews=="EditYh")
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsyh where id='$id'");
	$url="<a href=ListYh.php".$ecms_hashur['whehref'].">管理优化方案</a> -&gt; 修改优化方案：<b>".$r[yhname]."</b>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>优化方案</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListYh.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">增加优化方案 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="id" type="hidden" id="id" value="<?=$id?>"> 
      </td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">方案名称:</td>
      <td width="80%" height="25" bgcolor="#FFFFFF"> <input name="yhname" type="text" id="yhname" value="<?=$r[yhname]?>" size="42"> 
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">方案说明：</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="yhtext" cols="45" rows="4" id="yhtext"><?=ehtmlspecialchars($r[yhtext])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">信息列表</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">后台管理列表：</td>
      <td height="25" bgcolor="#FFFFFF"> 显示 
        <input name="hlist" type="text" id="hlist" value="<?=$r[hlist]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">前台管理列表：</td>
      <td height="25" bgcolor="#FFFFFF">显示 
        <input name="qmlist" type="text" id="qmlist" value="<?=$r[qmlist]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">前台信息列表：</td>
      <td height="25" bgcolor="#FFFFFF">显示 
        <input name="qlist" type="text" id="qlist" value="<?=$r[qlist]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">标签调用 </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">优化范围：</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dobq" type="checkbox" id="dobq" value="1"<?=$r[dobq]==1?' checked':''?>>
        标签调用 
        <input name="dojs" type="checkbox" id="dojs" value="1"<?=$r[dojs]==1?' checked':''?>>
        JS调用 
        <input name="dosbq" type="checkbox" id="dosbq" value="1"<?=$r[dosbq]==1?' checked':''?>>
        会员空间标签调用</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">最新信息：</td>
      <td height="25" bgcolor="#FFFFFF">调用 
        <input name="bqnew" type="text" id="hlist3" value="<?=$r[bqnew]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">点击排行：</td>
      <td height="25" bgcolor="#FFFFFF">调用 
        <input name="bqhot" type="text" id="bqnew" value="<?=$r[bqhot]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">推荐信息：</td>
      <td height="25" bgcolor="#FFFFFF">调用 
        <input name="bqgood" type="text" id="bqnew2" value="<?=$r[bqgood]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">评论排行：</td>
      <td height="25" bgcolor="#FFFFFF">调用 
        <input name="bqpl" type="text" id="bqnew3" value="<?=$r[bqpl]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">头条信息：</td>
      <td height="25" bgcolor="#FFFFFF">调用 
        <input name="bqfirst" type="text" id="bqnew4" value="<?=$r[bqfirst]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">下载排行：</td>
      <td height="25" bgcolor="#FFFFFF">调用 
        <input name="bqdown" type="text" id="bqnew5" value="<?=$r[bqdown]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">其它相关</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">内容页生成范围：</td>
      <td height="25" bgcolor="#FFFFFF">生成 
        <input name="rehtml" type="text" id="rehtml" value="<?=$r[rehtml]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">相关链接检索范围：</td>
      <td height="25" bgcolor="#FFFFFF"> 查询 
        <input name="otherlink" type="text" id="otherlink" value="<?=$r[otherlink]?>" size="8">
        天内的信息 <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="提交"> 
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
