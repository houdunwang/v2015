<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']=$word;
$url="<a href='../../'>首页</a>&nbsp;>&nbsp;<a href='../member/cp/'>会员中心</a>&nbsp;>&nbsp;<a href='ListInfo.php?mid=".$mid."'>管理信息</a>&nbsp;>&nbsp;".$word."&nbsp;(".$mr[qmname].")";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<script src="../data/html/setday.js"></script>
<script>
function bs(){
	var f=document.add
	if(f.title.value.length==0){alert("标题还没写");f.title.focus();return false;}
	if(f.classid.value==0){alert("请选择栏目");f.classid.focus();return false;}
}
function foreColor(){
  if(!Error())	return;
  var arr = showModalDialog("../data/html/selcolor.html", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
  if (arr != null) document.add.titlecolor.value=arr;
  else document.add.titlecolor.focus();
}
function FieldChangeColor(obj){
  if(!Error())	return;
  var arr = showModalDialog("../data/html/selcolor.html", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
  if (arr != null) obj.value=arr;
  else obj.focus();
}
</script>
<script src="../data/html/postinfo.js"></script>
<form name="add" method="POST" enctype="multipart/form-data" action="ecms.php" onsubmit="return EmpireCMSQInfoPostFun(document.add,'<?=$mid?>');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <tr class="header"> 
            <td height="25" colspan="2"> 
              <?=$word?>
              <input type=hidden value="<?=$enews?>" name=enews> <input type=hidden value="<?=$classid?>" name=classid> 
              <input name=id type=hidden id="id" value="<?=$id?>"> <input type=hidden value="<?=$filepass?>" name=filepass> 
              <input name=mid type=hidden id="mid" value="<?=$mid?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>提交者</td>
            <td><b>
              <?=$musername?>
              </b></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="16%">栏目</td>
            <td>
              <?=$postclass?>            </td>
          </tr>
        </table>
  <?php
  @include($modfile);
  ?>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  	<?=$showkey?>
    <tr class="header"> 
      <td width="16%">&nbsp;</td>
      <td><input type="submit" name="addnews" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>