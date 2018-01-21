<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
db_close();
$empire=null;
@header('Content-Type: text/html; charset=gb2312');
@include('../class/EmpireCMS_version.php');
$pd="?product=empirecms&usechar=".$ecms_config['sets']['pagechar']."&doupdate=".EmpireCMS_UPDATE."&ver=".EmpireCMS_VERSION."&lasttime=".EmpireCMS_LASTTIME."&domain=".$_SERVER['HTTP_HOST']."&ip=".$_SERVER['REMOTE_ADDR'];
?>
<link rel="stylesheet" href="../data/images/css.css" type="text/css">
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