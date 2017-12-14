<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$link=db_connect();
$empire=new mysqlquery();
//Ъ§ОнПт
$mydbname=RepPostVar($_GET['mydbname']);
$mytbname=RepPostVar($_GET['mytbname']);
if(empty($mydbname)||empty($mytbname))
{
	printerror("ErrorUrl","history.go(-1)");
}
$form=$_GET['form'];
if(empty($form))
{
	$form='ebakchangetb';
}
$usql=$empire->query("use `$mydbname`");
$sql=$empire->query("SHOW FIELDS FROM `".$mytbname."`");
require LoadAdminTemp('eListField.php');
db_close();
$empire=null;
?>