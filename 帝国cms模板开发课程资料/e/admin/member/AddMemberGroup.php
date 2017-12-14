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
CheckLevel($logininid,$loginin,$classid,"member");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListMemberGroup.php".$ecms_hashur['whehref'].">管理会员组</a>&nbsp;>&nbsp;增加会员组";
$r[level]=1;
$r[favanum]=120;
$r[daydown]=0;
$r[msgnum]=50;
$r[msglen]=255;
if($enews=="EditMemberGroup")
{
	$groupid=(int)$_GET['groupid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmembergroup where groupid='$groupid'");
	$url="<a href=ListMemberGroup.php".$ecms_hashur['whehref'].">管理会员组</a>&nbsp;>&nbsp;修改会员组：<b>".$r[groupname]."</b>";
	if($r[checked])
	{$checked=" checked";}
}
//会员表单
$memberform='';
$fsql=$empire->query("select fid,fname from {$dbtbpre}enewsmemberform order by fid");
while($fr=$empire->fetch($fsql))
{
	if($r['formid']==$fr[fid])
	{
		$selected=' selected';
	}
	else
	{
		$selected='';
	}
	$memberform.="<option value='".$fr[fid]."'".$selected.">".$fr[fname]."</option>";
}
//空间模板
$spacestyle='';
$sssql=$empire->query("select styleid,stylename from {$dbtbpre}enewsspacestyle order by styleid");
while($ssr=$empire->fetch($sssql))
{
	if($r['spacestyleid']==$ssr[styleid])
	{
		$selected=' selected';
	}
	else
	{
		$selected='';
	}
	$spacestyle.="<option value='".$ssr[styleid]."'".$selected.">".$ssr[stylename]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>会员组</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td height="25">位置： 
      <?=$url?>
    </td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmember.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="22%" height="25">增加会员组</td>
      <td width="78%" height="25"><input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="groupid" type="hidden" id="groupid" value="<?=$groupid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">会员组名称</td>
      <td height="25"> <input name="groupname" type="text" id="groupname" value="<?=$r[groupname]?>" size="38"> 
        <font color="#666666">(比如：VIP会员,普通会员)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">会员组级别值</td>
      <td height="25"> <input name="level" type="text" id="level" value="<?=$r[level]?>" size="38"> 
        <font color="#666666">(如：1,2...等，级别值越高权限越大)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">最大收藏夹数</td>
      <td height="25"><input name="favanum" type="text" id="favanum" value="<?=$r[favanum]?>" size="38"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">每天最大下载数</td>
      <td height="25"><input name="daydown" type="text" id="daydown" value="<?=$r[daydown]?>" size="38"> 
        <font color="#666666">(0为不限制)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">每天最大投稿数</td>
      <td height="25"><input name="dayaddinfo" type="text" id="dayaddinfo" value="<?=$r[dayaddinfo]?>" size="38"> 
        <font color="#666666">(0为不限制)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">投稿信息是否审核</td>
      <td height="25"><input name="infochecked" type="checkbox" id="infochecked" value="1"<?=$r[infochecked]==1?' checked':''?>>
        直接通过,不用审核</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">评论是否审核</td>
      <td height="25"><input name="plchecked" type="checkbox" id="plchecked" value="1"<?=$r[plchecked]==1?' checked':''?>>
        直接通过,不用审核</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">最大短消息数</td>
      <td height="25"><input name="msgnum" type="text" id="msgnum" value="<?=$r[msgnum]?>" size="38"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">短消息最大字数</td>
      <td height="25"><input name="msglen" type="text" id="msglen" value="<?=$r[msglen]?>" size="38">
        个字节</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">信息使用表单</td>
      <td height="25"><select name="formid" id="formid">
          <?=$memberform?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">前台可注册</td>
      <td height="25"><input type="radio" name="canreg" value="1"<?=$r[canreg]==1?' checked':''?>>
        是 
        <input type="radio" name="canreg" value="0"<?=$r[canreg]==0?' checked':''?>>
        否</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">注册需要审核</td>
      <td height="25"><input type="radio" name="regchecked" value="1"<?=$r[regchecked]==1?' checked':''?>>
        是 
        <input type="radio" name="regchecked" value="0"<?=$r[regchecked]==0?' checked':''?>>
        否</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">会员默认空间模板</td>
      <td height="25"><select name="spacestyleid" id="spacestyleid">
          <option value=0>不设置</option>
          <?=$spacestyle?>
        </select> <font color="#666666">(不设置则使用默认空间模板) </font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
