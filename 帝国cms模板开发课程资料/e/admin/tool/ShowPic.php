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

$picurl=ehtmlspecialchars($_GET['picurl']);
$pic_width=ehtmlspecialchars($_GET['pic_width']);
$pic_height=ehtmlspecialchars($_GET['pic_height']);
$url=ehtmlspecialchars($_GET['url']);
?>
<title>广告预览</title>
<a href="<?=$url?>" target=_blank><img src="<?=$picurl?>" border=0 width="<?=$pic_width?>" height="<?=$pic_height?>"></a>
