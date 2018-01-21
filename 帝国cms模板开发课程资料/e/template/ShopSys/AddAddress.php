<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$postword=$enews=='EditAddress'?'修改地址':'增加地址';
$public_diyr['pagetitle']=$postword;
$url="<a href=../../../>首页</a>&nbsp;>&nbsp;<a href=../../member/cp/>会员中心</a>&nbsp;>&nbsp;<a href='ListAddress.php'>配送地址列表</a>&nbsp;>&nbsp;".$postword;
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form action="../doaction.php" method="post" name="addform" id="addform">
    <tr class="header">
      <td height="23" colspan="2"><?=$postword?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="22%" height="25">地址名称：</td>
      <td width="78%" height="25"><input name="addressname" type="text" id="title2" value="<?=$r[addressname]?>" size="42">
      *</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">姓名：</td>
      <td height="25"><input name="truename" type="text" id="addressname" value="<?=$r[truename]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">邮箱地址：</td>
      <td height="25"><input name="email" type="text" id="truename" value="<?=$r[email]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">固定电话：</td>
      <td height="25"><input name="mycall" type="text" id="email" value="<?=$r[mycall]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">手机号码：</td>
      <td height="25"><input name="phone" type="text" id="mycall" value="<?=$r[phone]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">QQ号码：</td>
      <td height="25"><input name="oicq" type="text" id="oicq" value="<?=$r[oicq]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">MSN：</td>
      <td height="25"><input name="msn" type="text" id="msn" value="<?=$r[msn]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">收货地址：</td>
      <td height="25"><input name="address" type="text" id="phone" value="<?=$r[address]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">邮编：</td>
      <td height="25"><input name="zip" type="text" id="address" value="<?=$r[zip]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">地址周边标志性建筑：</td>
      <td height="25"><input name="signbuild" type="text" id="zip" value="<?=$r[signbuild]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">最佳收货时间：</td>
      <td height="25"><input name="besttime" type="text" id="signbuild" value="<?=$r[besttime]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交">
        &nbsp;
        <input type="reset" name="Submit2" value="重置">
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>">      <input name="addressid" type="hidden" id="addressid" value="<?=$addressid?>"></td>
    </tr>
  </form>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>
