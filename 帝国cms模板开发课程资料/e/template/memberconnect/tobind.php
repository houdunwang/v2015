<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$qappname=$appr['qappname'];

$public_diyr['pagetitle']='绑定登录';
$url="位置:<a href='../../'>首页</a>&nbsp;>&nbsp;绑定登录";
$regurl=$public_r['newsurl'].'e/member/register/?tobind=1';
$loginurl=$public_r['newsurl'].'e/member/login/?tobind=1';
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="30" colspan="2"><font color="#FF0000"><strong>您好！已通过<?=$qappname?>成功登录！</strong></font></td>
  </tr>
  <tr>
    <td width="50%" valign="top"><form name="bindform" method="post" action="doaction.php">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td height="25"><div align="center"><strong>1、如果您已有账号，可以点击下面登录绑定</strong></div></td>
        </tr>
        <tr>
          <td height="50"><div align="center">
            <input type="button" name="Submit" value="马上登录绑定" onclick="window.open('<?=$loginurl?>');">
            <input name="enews" type="hidden" id="enews" value="BindUser">
          </div></td>
          </tr>
        <tr>
          <td height="25"><div align="center">提示：捆绑成功后，下次
            <?=$qappname?>
            方式登录即可直接登录到捆绑后的账号。</div></td>
          </tr>
      </table>
        </form>
    </td>
    <td width="50%" valign="top"><form name="bindregform" method="post" action="doaction.php">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td height="25"><div align="center"><strong>2、如果还没有账号，您可以快速注册</strong></div></td>
          </tr>
        <tr>
          <td height="50"><div align="center">
            <input type="button" name="Submit2" value="马上注册绑定" onclick="window.open('<?=$regurl?>');">
            <input name="enews" type="hidden" id="enews" value="BindReg">
          </div></td>
          </tr>
        <tr>
          <td height="25"><div align="center">提示：捆绑成功后，下次
            <?=$qappname?>
            方式登录即可直接登录到捆绑后的账号。</div></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>