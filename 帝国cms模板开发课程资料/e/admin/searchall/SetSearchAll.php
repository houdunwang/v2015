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
CheckLevel($logininid,$loginin,$classid,"searchall");
$r=$empire->fetch1("select openschall,schallfield,schallminlen,schallmaxlen,schallnotcid,schallnum,schallpagenum,schalltime from {$dbtbpre}enewspublic limit 1");
$schallnotcid=substr($r[schallnotcid],1,strlen($r[schallnotcid])-2);
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>全站搜索设置</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="ListSearchLoadTb.php<?=$ecms_hashur['whehref']?>">管理全站搜索数据源</a>&nbsp;->&nbsp;全站搜索设置
    </td>
  </tr>
</table>
<form name="searchset" method="post" action="ListSearchLoadTb.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">全站搜索设置 
        <input name=enews type=hidden value=SetSearchAll></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">开启搜索</td>
      <td height="25"><input type="radio" name="openschall" value="1"<?=$r[openschall]==1?' checked':''?>>
        是 
        <input type="radio" name="openschall" value="0"<?=$r[openschall]==0?' checked':''?>>
        否 </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">搜索范围：</td>
      <td width="81%" height="25"><select name="schallfield" id="schallfield">
          <option value="1"<?=$r[schallfield]==1?' selected':''?>>搜索标题和全文</option>
          <option value="2"<?=$r[schallfield]==2?' selected':''?>>搜索标题</option>
          <option value="3"<?=$r[schallfield]==3?' selected':''?>>搜索全文</option>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">搜索关键字长度：</td>
      <td height="25">在 
        <input name="schallminlen" type="text" id="schallminlen" value="<?=$r[schallminlen]?>" size="6">
        个字符与 
        <input name="schallmaxlen" type="text" id="schallmaxlen" value="<?=$r[schallmaxlen]?>" size="6">
        个字符之间 </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">搜索时间间隔：</td>
      <td height="25">在 
        <input name="schalltime" type="text" id="schalltime" value="<?=$r[schalltime]?>" size="6">
        秒</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">页面显示：</td>
      <td height="25">每页 
        <input name="schallnum" type="text" id="schallnum" value="<?=$r[schallnum]?>" size="6">
        显示条记录， 
        <input name="schallpagenum" type="text" id="schallpagenum" value="<?=$r[schallpagenum]?>" size="6">
        个分页链接<font color="#666666">&nbsp;</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">不导入搜索表的终极栏目：</td>
      <td height="25"><input name="schallnotcid" type="text" id="schallnotcid" value="<?=$schallnotcid?>"> 
        <font color="#666666">(格式：栏目ID1,栏目ID2...多个用&quot;,&quot;格开)</font> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25">全站搜索测试地址：<a href="<?=$public_r[newsurl].'e/sch/sch.html'?>" target="_blank">
        <?=$public_r[newsurl].'e/sch/sch.html'?>
        </a></td>
    </tr>
  </table>
</form>
</body>
</html>
