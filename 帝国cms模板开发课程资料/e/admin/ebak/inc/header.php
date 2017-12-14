<?php
define('EmpireCMSAdmin','1');
@require("../../../../class/connect.php");
if(!defined('InEmpireCMS'))
{
	exit();
}
require("config.php");
require("../../../../class/db_sql.php");
require("../../../../class/functions.php");
require("../../class/functions.php");
require "../../../".LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$logininid=getcvar('loginuserid',1);
$loginin=getcvar('loginusername',1);
$loginrnd=getcvar('loginrnd',1);
$loginlevel=getcvar('loginlevel',1);
$editor=3;
is_login_ebak($logininid,$loginin,$loginrnd);
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//验证权限
//CheckLevel($logininid,$loginin,$classid,"dbdata");
hCheckEcmsRHash();
$mydbname=RepPostVar($_GET['mydbname']);
$mypath=RepPostStr($_GET['mypath'],1);
if(empty($mydbname)||empty($mypath))
{
	printerror("ErrorUrl","history.go(-1)");
}
//编码
DoSetDbChar($b_dbchar);
$usql=$empire->usequery("use `$mydbname`");
?>