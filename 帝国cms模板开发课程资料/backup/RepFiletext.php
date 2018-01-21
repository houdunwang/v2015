<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$mypath=$_GET['mypath'];
require LoadAdminTemp('eRepFiletext.php');
?>