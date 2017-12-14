<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='增加信息';
$url="<a href='../../'>首页</a>&nbsp;>&nbsp;<a href='../member/cp/'>会员中心</a>&nbsp;>&nbsp;<a href='ListInfo.php?mid=".$mid."'>管理信息</a>&nbsp;>&nbsp;增加信息&nbsp;(".$mr[qmname].")";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<script>
function CheckChangeClass()
{
	if(document.changeclass.classid.value==0||document.changeclass.classid.value=='')
	{
		alert("请选择栏目");
		return false;
	}
	return true;
}
</script>
      <table width="500" border="0" align="center">
        <tr> 
          <td>你好，<b><?=$musername?></b></td>
        </tr>
      </table>
      <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form action="AddInfo.php" method="get" name="changeclass" id="changeclass" onsubmit="return CheckChangeClass();">
          <tr class="header"> 
            <td height="23"><strong>请选择要增加信息的栏目 
                <input name="mid" type="hidden" id="mid" value="<?=$mid?>">
              <input name="enews" type="hidden" id="enews" value="MAddInfo">
              </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32"> <select name=classid size="22" style="width:300px">
                <script src="<?=$classjs?>"></script>
              </select> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><input type="submit" name="Submit" value="添加信息"> <font color="#666666">(请选择终极栏目[蓝色条])</font></td>
          </tr>
        </form>
      </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>