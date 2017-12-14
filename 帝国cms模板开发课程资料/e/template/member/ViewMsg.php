<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='查看消息';
$url="<a href=../../../../>首页</a>&nbsp;>&nbsp;<a href=../../cp/>会员中心</a>&nbsp;>&nbsp;<a href=../../msg/>消息列表</a>&nbsp;>&nbsp;查看消息";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <form name="form1" method="post" action="../../doaction.php">
            <tr class="header"> 
              <td height="23" colspan="2">
                <?=stripSlashes($r[title])?>              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td width="19%" height="25">发送者：</td>
              <td width="81%" height="25"><a href="../../ShowInfo/?userid=<?=$r[from_userid]?>"> 
                <?=$r[from_username]?>
                </a></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">发送时间：</td>
              <td height="25">
                <?=$r[msgtime]?>              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25" valign="top">内容：</td>
              <td height="25"> 
                <?=nl2br(stripSlashes($r[msgtext]))?>              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25" valign="top">&nbsp;</td>
              <td height="25">[<a href="#ecms" onclick="javascript:history.go(-1);"><strong>返回</strong></a>] 
                [<a href="../AddMsg/?enews=AddMsg&re=1&mid=<?=$mid?>"><strong>回复</strong></a>] 
                [<a href="../AddMsg/?enews=AddMsg&mid=<?=$mid?>"><strong>转发</strong></a>] 
                [<a href="../../doaction.php?enews=DelMsg&mid=<?=$mid?>" onclick="return confirm('确认要删除?');"><strong>删除</strong></a>]</td>
            </tr>
          </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>