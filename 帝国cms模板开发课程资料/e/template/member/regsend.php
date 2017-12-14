<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='发送帐号激活邮件';
$url="<a href=../../../>首页</a>&nbsp;>&nbsp;<a href=../cp/>会员中心</a>&nbsp;>&nbsp;重发帐号激活邮件";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<br>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="RegSendForm" method="POST" action="../doaction.php">
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">重发帐号激活邮件</div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25">用户名(*)</td>
      <td width="77%"><input name="username" type="text" id="username" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">密码(*)</td>
      <td><input name="password" type="password" id="password" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">邮箱(*)</td>
      <td><input name="email" type="text" id="email" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">新接收邮箱</td>
      <td><input name="newemail" type="text" id="newemail" size="38">
        <font color="#666666">(要改变接收邮箱可填写)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">验证码</td>
      <td><input name="key" type="text" id="key" size="6"> <img src="../../ShowKey/?v=regsend" name="regsendKeyImg" id="regsendKeyImg" onclick="regsendKeyImg.src='../../ShowKey/?v=regsend&t='+Math.random()" title="看不清楚,点击刷新"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp; </td>
      <td> <input type="submit" name="button" value="提交"> 
        <input name="enews" type="hidden" id="enews" value="RegSend"></td>
    </tr>
  </form>
</table>
<br>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>