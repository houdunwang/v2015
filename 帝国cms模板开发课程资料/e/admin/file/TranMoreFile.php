<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//验证权限
CheckLevel($logininid,$loginin,$classid,"file");
$url="<a href=TranMoreFile.php".$ecms_hashur['whehref'].">批量上传附件</a>";
$filenum=(int)$_GET['filenum'];
if(empty($filenum))
{$filenum=10;}
$o="n".$filenum;
$$o=" selected";
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>上传附件</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="31%" height="25">位置： 
      <?=$url?>
    </td>
    <td width="69%"><div align="right" class="emenubutton">
      </div></td>
  </tr>
</table>

<form action="../ecmsfile.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25">批量上传附件</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">请选择要上传的附件个数： <select name="filenum" id="filenum" onchange=window.location='TranMoreFile.php?<?=$ecms_hashur['ehref']?>&filenum='+this.options[this.selectedIndex].value>
          <option value="1"<?=$n1?>>1</option>
          <option value="2"<?=$n2?>>2</option>
          <option value="3"<?=$n3?>>3</option>
          <option value="4"<?=$n4?>>4</option>
          <option value="5"<?=$n5?>>5</option>
          <option value="6"<?=$n6?>>6</option>
          <option value="7"<?=$n7?>>7</option>
          <option value="8"<?=$n8?>>8</option>
          <option value="9"<?=$n9?>>9</option>
          <option value="10"<?=$n10?>>10</option>
          <option value="11"<?=$n11?>>11</option>
          <option value="12"<?=$n12?>>12</option>
          <option value="13"<?=$n13?>>13</option>
          <option value="14"<?=$n14?>>14</option>
          <option value="15"<?=$n15?>>15</option>
          <option value="16"<?=$n16?>>16</option>
          <option value="17"<?=$n17?>>17</option>
          <option value="18"<?=$n18?>>18</option>
          <option value="19"<?=$n19?>>19</option>
          <option value="20"<?=$n20?>>20</option>
        </select>
        ，上传附件类别： 
        <select name="type">
        <option value="1">图片</option>
        <option value="2">Flash文件</option>
<option value="3">多媒体文件</option>
        <option value="0">其他附件</option>
      </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr bgcolor="#DBEAF5"> 
            <td width="35%">文件</td>
            <td width="65%">编号（便于管理附件）</td>
          </tr>
          <?
		  for($i=0;$i<$filenum;$i++)
		  {
		  ?>
          <tr> 
            <td height="25"> <input name="file[]" type="file" id="file[]"> </td>
            <td><input name="no[]" type="text" id="no[]"></td>
          </tr>
          <?
		  }
		  ?>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="开始上传"> 
        <input name="enews" type="hidden" id="enews" value="TranMoreFile"></td>
    </tr>
  </table>
</form>
</body>
</html>
