<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='会员中心';
$url="<a href=../../../>首页</a>&nbsp;>&nbsp;<a href=../cp/>会员中心</a>";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <tr class="header"> 
    <td height="25">会员中心</td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="220" valign="top"> 
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="6">
              <tr> 
                <td height="25"><div align="center"><img src="<?=$userpic?>" width="158" height="158" style="border:1px solid #cccccc;" /></div></td>
              </tr>
              <tr> 
                <td height="25"><div align="center"><a href="../../space/?userid=<?=$user[userid]?>" target="_blank"> 
                    <?=$user[username]?>
                    </a></div></td>
              </tr>
            </table>
          </td>
          <td> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
              <tr bgcolor="#FFFFFF"> 
                <td width="15%" height="25">用户ID:</td>
                <td width="85%" height="25"> 
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
                <td height="25">新消息:</td>
                <td height="25"> 
                  <?=$havemsg?>
                </td>
              </tr>
            </table>
            <div align="center"> </div></td>
        </tr>
      </table> 
    </td>
  </tr>
  <tr>
    <td height="20">快速入口</td>
  </tr>
  <tr>
    <td height="36" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="16%" height="25"> 
            <div align="center"><a href="../EditInfo/"><img src="../../data/images/membercp/userinfo.gif" width="16" height="16" border="0" align="absmiddle"> 
              修改资料</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../msg/"><img src="../../data/images/membercp/msg.gif" width="16" height="16" border="0" align="absmiddle"> 
              站内消息</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../mspace/SetSpace.php"><img src="../../data/images/membercp/space.gif" width="16" height="16" border="0" align="absmiddle"> 
              空间设置</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../../DoInfo/"><img src="../../data/images/membercp/info.gif" width="16" height="16" border="0" align="absmiddle"> 
              管理信息</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../fava/"><img src="../../data/images/membercp/favitorie.gif" width="16" height="16" border="0" align="absmiddle"> 
              管理收藏夹</a></div></td>
          <td width="16%">
<div align="center"><a href="../friend/"><img src="../../data/images/membercp/friend.gif" width="16" height="16" border="0" align="absmiddle"> 
              我的好友</a></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>