<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$hand=@opendir('setsave');
$mydbname=$_GET['mydbname'];
require LoadAdminTemp('eListSetbak.php');
?>