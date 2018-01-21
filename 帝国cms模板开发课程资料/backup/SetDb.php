<?php
define('EmpireBakSetPage',TRUE);
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
if($limittype)
{
	$checklimittype=" checked";
}
if($filechmod==1)
{
	$filechmod1=" checked";
	$filechmod0="";
}
else
{
	$filechmod1="";
	$filechmod0=" checked";
}
$haveebma=0;
if(file_exists('eapi/ebma.php'))
{
	$haveebma=1;
}
$loginauthrnd=make_password(30);
require LoadAdminTemp('eSetDb.php');
?>