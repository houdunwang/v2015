<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$link=db_connect();
$empire=new mysqlquery();

//CheckFormVarNum
function Ebak_CheckFormVarNum($tbnum){
	if($tbnum<960)
	{
		return 0;
	}
	if(function_exists('ini_get'))
	{
		$val=@ini_get('max_input_vars');
	}
	else
	{
		$val=@get_cfg_var('max_input_vars');
	}
	if(!$val)
	{
		return 0;
	}
	if($val-$tbnum>40)
	{
		return 0;
	}
	return $val;
}

$mydbname=RepPostVar($_GET['mydbname']);
if(empty($mydbname))
{
	printerror("NotChangeDb","history.go(-1)");
}
//选择数据库
$udb=$empire->query("use `".$mydbname."`");
//存放目录
$mypath=$mydbname."_".date("YmdHis").make_password(6);
if($phpsafemod)
{
	$mypath="safemod";
}
//导入设置
$loadfile=RepPostVar($_GET['savefilename']);
if(strstr($loadfile,'.')||strstr($loadfile,'/')||strstr($loadfile,"\\"))
{
	$loadfile='';
}
if(empty($loadfile))
{
	$loadfile='def';
}
$loadfile='setsave/'.$loadfile;
@include($loadfile);
if($dmypath)
{
	$mypath=$dmypath;
}
//查询
$keyboard=RepPostVar($_GET['keyboard']);
if(empty($keyboard))
{
	$keyboard=$dkeyboard;
	if(empty($keyboard))
	{
		$keyboard=$baktbpre;
	}
}
$and="";
if($keyboard)
{
	$and=" LIKE '%$keyboard%'";
}
$sql=$empire->query("SHOW TABLE STATUS".$and);
require LoadAdminTemp('eChangeTable.php');
db_close();
$empire=null;
?>