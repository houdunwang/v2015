<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='设置空间';
$url="<a href='../../../'>首页</a>&nbsp;>&nbsp;<a href='../cp/'>会员中心</a>&nbsp;>&nbsp;设置空间";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
		<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
        <form name="setspace" method="post" action="index.php">
          <tr class="header"> 
            <td height="25" colspan="2">设置空间</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="17%" height="25">空间名称</td>
            <td width="83%"> 
              <input name="spacename" type="text" id="spacename" value="<?=$addr[spacename]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>空间公告</td>
            <td> 
              <textarea name="spacegg" cols="60" rows="6" id="spacegg"><?=$addr[spacegg]?></textarea></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">&nbsp;</td>
            <td> 
              <input type="submit" name="Submit" value="提交">
              <input type="reset" name="Submit2" value="重置">
              <input name="enews" type="hidden" id="enews" value="DoSetSpace"></td>
          </tr>
		  </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>