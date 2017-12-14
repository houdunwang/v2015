<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
//第一次使用
if(empty($phome_db_ver))
{
	printerror("FirstUseMsg","SetDb.php");
}
include('class/eginfofun.php');
require LoadAdminTemp('emain.php');
?>