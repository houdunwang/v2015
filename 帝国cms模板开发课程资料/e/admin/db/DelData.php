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
CheckLevel($logininid,$loginin,$classid,"delinfodata");
//栏目
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//刷新表
$retable="";
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
while($tr=$empire->fetch($tsql))
{
	$retable.="<option value='".$tr[tbname]."'>".$tr[tname]."(".$tr[tbname].")</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>按条件删除信息</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<a href="DelData.php<?=$ecms_hashur['whehref']?>">按条件删除信息</a></td>
  </tr>
</table>
<form action="../ecmsinfo.php" method="get" name="form1" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> <div align="center">按条件删除信息</div></td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">选择数据表</td>
      <td width="80%" bgcolor="#FFFFFF"><select name="tbname" id="tbname">
          <option value=''>------ 选择数据表 ------</option>
          <?=$retable?>
        </select>
        *</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">选择栏目</td>
      <td bgcolor="#FFFFFF"><select name="classid" id="select">
          <option value="0">所有栏目</option>
          <?=$class?>
        </select> <font color="#666666">(如选择父栏目，将删除所有子栏目)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <input name="retype" type="radio" value="0" checked>
        按时间删除</td>
      <td bgcolor="#FFFFFF">从 
        <input name="startday" type="text" size="12" onclick="setday(this)">
        到 
        <input name="endday" type="text" size="12" onclick="setday(this)">
        之间的数据 <font color="#666666">(不填为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><input name="retype" type="radio" value="1">
        按ID删除</td>
      <td bgcolor="#FFFFFF">从 
        <input name="startid" type="text" id="startid2" value="0" size="6">
        到 
        <input name="endid" type="text" id="endid2" value="0" size="6">
        之间的数据 <font color="#666666">(两个值0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">是否审核</td>
      <td bgcolor="#FFFFFF"><input name="infost" type="radio" value="0" checked>
        不限 
        <input name="infost" type="radio" value="1">
        已审核 
        <input name="infost" type="radio" value="2">
        未审核</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">是否用户发布</td>
      <td bgcolor="#FFFFFF"><input name="ismember" type="radio" value="0" checked>
        不限 <input type="radio" name="ismember" value="1">
        游客发布 
        <input type="radio" name="ismember" value="2">
        会员+用户发布 
        <input type="radio" name="ismember" value="3">
        会员发布 
        <input type="radio" name="ismember" value="4">
        用户发布</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">是否外部链接</td>
      <td bgcolor="#FFFFFF"><input name="isurl" type="radio" value="0" checked>
        不限 <input type="radio" name="isurl" value="1">
        外部链接信息 
        <input type="radio" name="isurl" value="2">
        内部信息</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">评论数少于</td>
      <td bgcolor="#FFFFFF"><input name="plnum" type="text" id="plnum" size="38"> <font color="#666666">(不设置为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">点击数少于</td>
      <td bgcolor="#FFFFFF"><input name="onclick" type="text" id="onclick" size="38"> <font color="#666666">(不设置为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">下载数少于</td>
      <td bgcolor="#FFFFFF"><input name="totaldown" type="text" id="totaldown" size="38"> 
        <font color="#666666">(不设置为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">标题包含字符</td>
      <td bgcolor="#FFFFFF"><input name="title" type="text" id="title" size="38"> <font color="#666666">(多个字符用“|”隔开)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">发布者帐号ID</td>
      <td bgcolor="#FFFFFF"><select name="usertype" id="usertype">
          <option value="0">会员ID</option>
          <option value="1">用户ID</option>
        </select>
        <input name="userids" type="text" id="userids" size="28">
        <font color="#666666">(多个用“,”逗号隔开)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">删除HTML文件</td>
      <td bgcolor="#FFFFFF"><input name="delhtml" type="radio" value="0" checked>
        删除 
        <input type="radio" name="delhtml" value="1">
        不删除 </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="Submit6" value="批量删除"> 
        <input name="enews" type="hidden" id="enews2" value="DelInfoData"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25">说明: 会员为前台注册会员，用户为后台管理员。删除后的数据不能恢复,请谨慎使用。</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>
