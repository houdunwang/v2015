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
CheckLevel($logininid,$loginin,$classid,"user");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListUser.php".$ecms_hashur['whehref'].">管理用户</a>&nbsp;>增加用户";
if($enews=="EditUser")
{
	$userid=(int)$_GET['userid'];
	$r=$empire->fetch1("select username,adminclass,groupid,checked,styleid,filelevel,truename,email,classid from {$dbtbpre}enewsuser where userid='$userid'");
	$addur=$empire->fetch1("select equestion,openip from {$dbtbpre}enewsuseradd where userid='$userid'");
	$url="<a href=ListUser.php".$ecms_hashur['whehref'].">管理用户</a>&nbsp;>修改用户：<b>".$r[username]."</b>";
	if($r[checked])
	{$checked=" checked";}
}
//-----------用户组
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsgroup order by groupid desc");
while($gr=$empire->fetch($sql))
{
	if($r[groupid]==$gr[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$gr[groupid].$select.">".$gr[groupname]."</option>";
}
//-----------后台样式
$stylesql=$empire->query("select styleid,stylename,path from {$dbtbpre}enewsadminstyle order by styleid");
$style="";
while($styler=$empire->fetch($stylesql))
{
	if($r[styleid]==$styler[styleid])
	{$sselect=" selected";}
	else
	{$sselect="";}
	$style.="<option value=".$styler[styleid].$sselect.">".$styler[stylename]."</option>";
}
//-----------部门
$userclasssql=$empire->query("select classid,classname from {$dbtbpre}enewsuserclass order by classid");
$userclass='';
while($ucr=$empire->fetch($userclasssql))
{
	if($r[classid]==$ucr[classid])
	{$select=" selected";}
	else
	{$select="";}
	$userclass.="<option value='$ucr[classid]'".$select.">".$ucr[classname]."</option>";
}
//--------------------操作的栏目
$fcfile="../../data/fc/ListEnews.php";
$fcjsfile="../../data/fc/cmsclass.js";
if(file_exists($fcjsfile)&&file_exists($fcfile))
{
	$class=GetFcfiletext($fcjsfile);
	$acr=explode("|",$r[adminclass]);
	$count=count($acr);
	for($i=1;$i<$count-1;$i++)
	{
		$class=str_replace("<option value='$acr[$i]'","<option value='$acr[$i]' selected",$class);
	}
}
else
{
	$class=ShowClass_AddClass($r[adminclass],"n",0,"|-",0,3);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加用户　</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function selectalls(doselect,formvar)
{  
	 var bool=doselect==1?true:false;
	 var selectform=document.getElementById(formvar);
	 for(var i=0;i<selectform.length;i++)
	 { 
		  selectform.all[i].selected=bool;
	 } 
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListUser.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">增加用户 
        <input name="userid" type="hidden" id="userid" value="<?=$userid?>"> <input name="oldusername" type="hidden" id="oldusername" value="<?=$r[username]?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="oldadminclass" type="hidden" id="oldadminclass" value="<?=$r[adminclass]?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="22%" height="25">用户名：</td>
      <td width="78%" height="25"><input name="username" type="text" id="username" value="<?=$r[username]?>" size="32">
        *</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">是否禁止：</td>
      <td height="25"><input name="checked" type="checkbox" id="checked" value="1"<?=$checked?>>
        是</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">密码：</td>
      <td height="25"><input name="password" type="password" id="password" size="32">
        * <font color="#666666">(不想修改请留空)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">重复密码：</td>
      <td height="25"><input name="repassword" type="password" id="repassword" size="32">
        * <font color="#666666">(不想修改请留空)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">安全提问：</td>
      <td height="25"> <select name="equestion" id="equestion">
          <option value="0"<?=$addur[equestion]==0?' selected':''?>>无安全提问</option>
          <option value="1"<?=$addur[equestion]==1?' selected':''?>>母亲的名字</option>
          <option value="2"<?=$addur[equestion]==2?' selected':''?>>爷爷的名字</option>
          <option value="3"<?=$addur[equestion]==3?' selected':''?>>父亲出生的城市</option>
          <option value="4"<?=$addur[equestion]==4?' selected':''?>>您其中一位老师的名字</option>
          <option value="5"<?=$addur[equestion]==5?' selected':''?>>您个人计算机的型号</option>
          <option value="6"<?=$addur[equestion]==6?' selected':''?>>您最喜欢的餐馆名称</option>
          <option value="7"<?=$addur[equestion]==7?' selected':''?>>驾驶执照的最后四位数字</option>
        </select> <font color="#666666"> 
        <input name="oldequestion" type="hidden" id="oldequestion" value="<?=$addur[equestion]?>">
        (如果启用安全提问，登录时需填入相应的项目才能登录)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">安全回答：</td>
      <td height="25"><input name="eanswer" type="text" id="eanswer" size="32"> 
        <font color="#666666">(如果修改答案，请在此输入新答案)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">姓名：</td>
      <td height="25"><input name="truename" type="text" id="truename" value="<?=$r[truename]?>" size="32"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">邮箱：</td>
      <td height="25"><input name="email" type="text" id="email" value="<?=$r[email]?>" size="32"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">用户组(*)：</td>
      <td height="25"><select name="groupid" id="groupid">
          <?=$group?>
        </select> <input type="button" name="Submit62223222" value="管理用户组" onclick="window.open('ListGroup.php<?=$ecms_hashur['whehref']?>');">
        *</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属部门：</td>
      <td height="25"><select name="classid" id="classid">
          <option value="0">未分配</option>
          <?=$userclass?>
        </select> <input type="button" name="Submit622232222" value="管理部门" onclick="window.open('UserClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">后台样式(*)：</td>
      <td height="25"><select name="styleid" id="styleid">
          <?=$style?>
        </select> <input type="button" name="Submit6222322" value="管理后台样式" onclick="window.open('../template/AdminStyle.php<?=$ecms_hashur['whehref']?>');">
        *</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="2" valign="top"> <p><strong>管理的栏目信息：</strong><br>
          <br>
          <input name="filelevel" type="checkbox" id="filelevel" value="1"<?=$r[filelevel]==1?' checked':''?>>
          应用于附件权限<br>
          <br>
          (多个，请用ctrl。)</p></td>
      <td height="25" valign="top"> <select name="adminclass[]" size="12" multiple id="adminclassselect" style="width:270;">
          <?=$class?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'adminclassselect')">全部取消</a>] 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"> 注意事项：<font color="#FF0000">选择父栏目会应用于子栏目，并且如果选择父栏目，请勿选择其子栏目</font>)</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><strong>允许登录后台的 IP 列表:</strong><br>
        只有当管理员处于本列表中的 IP 地址时才可以登录后台，列表以外的地址访问将视为 IP 被禁止.每个 IP 一行，既可输入完整地址，也可只输入 
        IP 开头，例如 &quot;192.168.&quot;(不含引号) 可匹配 192.168.0.0～192.168.255.255 范围内的所有地址，留空为不限</td>
      <td height="25"><textarea name="openip" cols="50" rows="8" id="openip"><?=$addur[openip]?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><font color="#666666">说明：密码设置6位以上，且密码不能包含：$ 
        &amp; * # &lt; &gt; ' &quot; / \ % ; 空格</font></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>
