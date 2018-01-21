<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];

@header('Content-Type: text/html; charset=gb2312');
@include('EmpireBak_version.php');
$pd="?product=empirebak&doupdate=".EmpireBak_UPDATE."&ver=".EmpireBak_VERSION."&lasttime=".EmpireBak_LASTTIME."&domain=".$_SERVER['HTTP_HOST']."&ip=".$_SERVER['REMOTE_ADDR'];
?>
<link rel="stylesheet" href="images/css.css" type="text/css">
<body leftmargin="0" topmargin="0">
<script>
function EchoUpdateInfo(showdiv,messagereturn){
	document.getElementById(showdiv).innerHTML=messagereturn;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="empirecmsdt"></div></td>
  </tr>
</table>
<script type="text/javascript" src="http://www.phome.net/empireupdate/<?php echo $pd;?>"></script>