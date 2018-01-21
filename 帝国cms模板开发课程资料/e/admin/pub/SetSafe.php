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
CheckLevel($logininid,$loginin,$classid,"setsafe");
if($ecms_config['esafe']['openonlinesetting']==0||$ecms_config['esafe']['openonlinesetting']==1)
{
	echo"没有开启后台在线配置参数，如果要使用在线配置先修改/e/config/config.php文件的\$ecms_config['esafe']['openonlinesetting']变量设置开启";
	exit();
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include('setfun.php');
}
if($enews=='SetSafe')
{
	SetSafe($_POST,$logininid,$loginin);
}

db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>安全参数配置</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="SetSafe.php<?=$ecms_hashur['whehref']?>">安全参数配置</a> 
      <div align="right"> </div></td>
  </tr>
</table>
<form name="setform" method="post" action="SetSafe.php" onsubmit="return confirm('确认设置?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">安全参数配置 
        <input name="enews" type="hidden" id="enews" value="SetSafe"> </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">后台安全相关配置</td>
    </tr>
    <tr> 
      <td width="17%" height="25" bgcolor="#FFFFFF"> <div align="left">后台登陆认证码</div></td>
      <td width="83%" height="25" bgcolor="#FFFFFF"> <input name="loginauth" type="password" id="loginauth" value="<?=$ecms_config['esafe']['loginauth']?>" size="35"> 
        <font color="#666666">(如果设置登录需要输入此认证码才能通过)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="left">后台登录COOKIE认证码</div></td>
      <td height="25" bgcolor="#FFFFFF"> <input name="ecookiernd" type="text" id="ecookiernd" value="<?=$ecms_config['esafe']['ecookiernd']?>" size="35"> 
        <input type="button" name="Submit3" value="随机" onclick="document.setform.ecookiernd.value='<?=make_password(36)?>';"> 
        <font color="#666666">(填写10~50个任意字符，最好多种字符组合)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">后台开启验证登录IP</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="ckhloginip" value="1"<?=$ecms_config['esafe']['ckhloginip']==1?' checked':''?>>
        开启 
        <input type="radio" name="ckhloginip" value="0"<?=$ecms_config['esafe']['ckhloginip']==0?' checked':''?>>
        关闭 <font color="#666666">(如果上网的IP是变动的，不要开启)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">后台启用SESSION验证</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ckhsession" value="1"<?=$ecms_config['esafe']['ckhsession']==1?' checked':''?>>
        开启 
        <input type="radio" name="ckhsession" value="0"<?=$ecms_config['esafe']['ckhsession']==0?' checked':''?>>
        关闭 <font color="#666666">(更安全，需空间支持SESSION)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">记录登陆日志</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="theloginlog" value="0"<?=$ecms_config['esafe']['theloginlog']==0?' checked':''?>>
        开启 
        <input type="radio" name="theloginlog" value="1"<?=$ecms_config['esafe']['theloginlog']==1?' checked':''?>>
        关闭</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">记录操作日志</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="thedolog" value="0"<?=$ecms_config['esafe']['thedolog']==0?' checked':''?>>
        开启 
        <input type="radio" name="thedolog" value="1"<?=$ecms_config['esafe']['thedolog']==1?' checked':''?>>
        关闭</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">开启访问来源验证</td>
      <td height="25" bgcolor="#FFFFFF"><select name="ckfromurl" id="ckfromurl">
          <option value="0"<?=$ecms_config['esafe']['ckfromurl']==0?' selected':''?>>不开启验证</option>
          <option value="1"<?=$ecms_config['esafe']['ckfromurl']==1?' selected':''?>>开启前后台验证</option>
          <option value="2"<?=$ecms_config['esafe']['ckfromurl']==2?' selected':''?>>仅开启后台验证</option>
          <option value="3"<?=$ecms_config['esafe']['ckfromurl']==3?' selected':''?>>仅开启前台验证</option>
        </select>
        <font color="#666666">(设置禁止非本站访问地址来源)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">开启后台来源认证码</td>
      <td height="25" bgcolor="#FFFFFF"><select name="ckhash" id="ckhash">
        <option value="0"<?=$ecms_config['esafe']['ckhash']==0?' selected':''?>>金刚模式</option>
        <option value="1"<?=$ecms_config['esafe']['ckhash']==1?' selected':''?>>刺猬模式</option>
        <option value="2"<?=$ecms_config['esafe']['ckhash']==2?' selected':''?>>关闭验证</option>
      </select>
        <font color="#666666">(推荐启用“金刚模式”，对外部访问与提交进行防御)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">COOKIE配置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE作用域</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="cookiedomain" type="text" id="fw_pass3" value="<?=$ecms_config['cks']['ckdomain']?>" size="35">      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE作用路径</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookiepath" type="text" id="cookiedomain" value="<?=$ecms_config['cks']['ckpath']?>" size="35"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">前台COOKIE变量前缀</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookievarpre" type="text" id="cookievarpre" value="<?=$ecms_config['cks']['ckvarpre']?>" size="35"> 
        <font color="#666666">(由英文字母组成,5~12个字符组成)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">后台COOKIE变量前缀</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookieadminvarpre" type="text" id="cookieadminvarpre" value="<?=$ecms_config['cks']['ckadminvarpre']?>" size="35"> 
        <font color="#666666">(由英文字母组成,5~12个字符组成)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE验证随机码</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="cookieckrnd" type="text" id="cookieckrnd" value="<?=$ecms_config['cks']['ckrnd']?>" size="35"> 
        <input type="button" name="Submit32" value="随机" onclick="document.setform.cookieckrnd.value='<?=make_password(36)?>';"> 
        <font color="#666666">(填写10~50个任意字符，最好多种字符组合)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">COOKIE验证随机码2</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookieckrndtwo" type="text" id="cookieckrndtwo" value="<?=$ecms_config['cks']['ckrndtwo']?>" size="35">
        <input type="button" name="Submit322" value="随机" onclick="document.setform.cookieckrndtwo.value='<?=make_password(36)?>';">
        <font color="#666666">(填写10~50个任意字符，最好多种字符组合)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"></td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value=" 设 置 "> 
        &nbsp;&nbsp;&nbsp; <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
