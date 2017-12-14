<?php
require("../../class/connect.php");
require("../../class/q_functions.php");
require("../../class/db_sql.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$picid=(int)$_GET['picid'];
if(empty($picid))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
$r=$empire->fetch1("select picid,title,pictext,pic_url from {$dbtbpre}enewspic where picid='$picid'");
if(empty($r[picid]))
{
	printerror("ErrorUrl","history.go(-1)",1);
}
db_close();
$empire=null;
?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$r[title]?></title>
<style>
td {
	font-size: 12px;
}
body {
	font-size: 12px;
	text-align: center;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
}
hr {  height: 1px; color: #000000 }
textarea {
	font-size: 12px;FONT-FAMILY: "Tahoma", "MS Shell Dlg";
}
A:link, A:active
{
	color: #333366;
	text-decoration: none;
}
A:visited
{  
	color: #333366;
	text-decoration: none;
}
A:hover
{
	color: #FF0000;
	text-decoration: underline;
}
SELECT {
	FONT-SIZE: 12px; FONT-FAMILY: "MS Shell Dlg"
}
FORM {
	MARGIN-TOP: 3px; FONT-SIZE: 12px; MARGIN-BOTTOM: 0px; FONT-FAMILY: "Tahoma", "MS Shell Dlg"
}
INPUT {
	FONT-SIZE: 12px; FONT-FAMILY: "Tahoma", "MS Shell Dlg"
}
</style>
<script>
function bbimg(o){
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;if (zoom>0) o.style.zoom=zoom+'%';
	return false;
}
</script>
</head><body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td><div align="center"></div></td>
  </tr>
  <tr> 
    <td align="center"><img src="<?=$r[pic_url]?>" border=0 onmousewheel="return bbimg(this)" onload="if(this.width>screen.width-500)this.style.width=screen.width-500;"></td>
  </tr>
  <tr> 
    <td><div align="center">图片名称： 
        <?=$r[title]?>
      </div></td>
  </tr>
  <tr> 
    <td valign="top"> <div align="center"> 
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr> 
            <td>简介：<br> 
              <?=nl2br($r[pictext])?>
            </td>
          </tr>
        </table>
        <br>
      </div></td>
  </tr>
  <tr>
    <td><div align="center">注:支持鼠标滚轮放大&amp;缩小图片.</div></td>
  </tr>
  <tr> 
    <td><div align="center"> 
        <input type="button" name="Submit" value="关闭" onclick="window.close();">
      </div></td>
  </tr>
</table>
</body>
</html>