<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$p=$_GET['p'];
$f=$_GET['f'];
$file=$bakzippath."/".$f;
require LoadAdminTemp('eDownZip.php');
?>