<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='帐号状态';
$url="<a href=../../../>首页</a>&nbsp;>&nbsp;<a href=../cp/>会员中心</a>&nbsp;>&nbsp;帐号状态";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<br> 
<table width="50%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="25" colspan="2">帐号状态</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">用户ID:</td>
    <td height="25"> 
      <?=$user[userid]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">用户名:</td>
    <td height="25"> 
      <?=$user[username]?>
      &nbsp;&nbsp;(<a href="../../space/?userid=<?=$user[userid]?>" target="_blank">我的会员空间</a>) 
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="33%" height="25">注册时间:</td>
    <td width="67%" height="25"> 
      <?=$registertime?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">会员等级:</td>
    <td height="25"> 
      <?=$level_r[$r[groupid]][groupname]?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">剩余有效期:</td>
    <td height="25"> 
      <?=$userdate?>
      天 </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">剩余点数:</td>
    <td height="25"> 
      <?=$r[userfen]?>
      点</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">帐户余额:</td>
    <td height="25"> 
      <?=$r[money]?>
      元 </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">新短消息:</td>
    <td height="25">
      <?=$havemsg?>
    </td>
  </tr>
</table>
<br>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>