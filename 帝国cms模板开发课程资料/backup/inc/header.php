<?php
require(substr(dirname(__FILE__),0,-3).'class/connect.php');
if(!defined('InEmpireBak'))
{
	exit();
}
@require('config.php');
require(EBAK_PATH.'class/functions.php');
require EBAK_PATH.LoadLang('f.php');
$editor=2;
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$link=db_connect();
$empire=new mysqlquery();
$mydbname=RepPostVar($_GET['mydbname']);
$mypath=$_GET['mypath'];
if(empty($mydbname)||empty($mypath))
{
	printerror("ErrorUrl","history.go(-1)");
}
//БрТы
DoSetDbChar($b_dbchar);
$usql=$empire->query("use `$mydbname`");
?>