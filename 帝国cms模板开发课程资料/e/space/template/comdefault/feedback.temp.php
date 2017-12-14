<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//位置
$url="$spacename &gt; 在线反馈";
include("header.temp.php");
?>
<?=$spacegg?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
  <tr> 
    <td background="template/default/images/bg_title_sider.gif"><b>在线反馈</b></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <form name="addfeedback" method="post" action="../member/mspace/index.php">
          <input type="hidden" name="userid" value="<?=$userid?>">
          <input type="hidden" name="enews" value="AddMemberFeedback">
          <tr> 
            <td width="18%" height="25">联系人</td>
            <td width="82%"><input name="name" type="text" id="name" size="38"> 
            </td>
          </tr>
          <tr> 
            <td height="25">公司名称</td>
            <td><input name="company" type="text" id="company" size="38"> </td>
          </tr>
          <tr> 
            <td height="25">联系邮箱</td>
            <td><input name="email" type="text" id="email" size="38"> </td>
          </tr>
          <tr> 
            <td height="25">联系电话</td>
            <td><input name="phone" type="text" id="phone" size="38"></td>
          </tr>
          <tr> 
            <td height="25">传真</td>
            <td><input name="fax" type="text" id="fax" size="38"> </td>
          </tr>
          <tr> 
            <td height="25">联系地址</td>
            <td><input name="address" type="text" id="address" size="45">
              邮编: 
              <input name="zip" type="text" id="zip" size="8"> </td>
          </tr>
          <tr> 
            <td height="25">反馈标题</td>
            <td><input name="title" type="text" id="title" value="<?=RepPostStr($_GET['title'],1)?>" size="60"> 
            </td>
          </tr>
          <tr> 
            <td height="25" valign="top">反馈内容</td>
            <td><textarea name="ftext" cols="60" rows="12" id="ftext"></textarea> 
            </td>
          </tr>
          <tr>
            <td height="25">验证码</td>
            <td><table width="160" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="75"><input name="key" type="text" size="10" /></td>
                  <td width="85"><img src="<?=$public_r[newsurl]?>e/ShowKey/?v=spacefb" name="spacefbKeyImg" id="spacefbKeyImg" onclick="spacefbKeyImg.src='<?=$public_r[newsurl]?>e/ShowKey/?v=spacefb&t='+Math.random()" title="看不清楚,点击刷新" /></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="25">&nbsp;</td>
            <td><input type="submit" name="Submit" value="提交"> </td>
          </tr>
        </form>
      </table> </td>
  </tr>
</table>
<?php
include("footer.temp.php");
?>