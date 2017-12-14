<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$hand=@opendir($bakpath);
$form='ebakredata';
if($_GET['toform'])
{
	$form=$_GET['toform'];
}
require LoadAdminTemp('eChangePath.php');
?>