<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$ztid=(int)$_GET['ztid'];
if(empty($ztid))
{
	$ztid=(int)$_POST['ztid'];
}
//验证权限
//CheckLevel($logininid,$loginin,$classid,"zt");
$returnandlevel=CheckAndUsernamesLevel('dozt',$ztid,$logininid,$loginin,$loginlevel);

//专题
if(!$ztid)
{
	printerror('ErrorUrl','');
}
$ztr=$empire->fetch1("select ztid,ztname,ztpath from {$dbtbpre}enewszt where ztid='$ztid'");
if(!$ztr['ztid'])
{
	printerror('ErrorUrl','');
}

$filepath_r=array();
$filepath_r['actionurl']='SpecialPathfile.php';
$filepathr['filepath']=$ztr['ztpath'].'/uploadfile';
$filepathr['filelevel']='dozt';
$filepathr['addpostvar']='<input type="hidden" name="ztid" value="'.$ztid.'">';
$filepathr['url']='位置：专题：<b>'.$ztr['ztname'].'</b> &gt; 管理专题附件';

include('../file/TruePathfile.php');

db_close();
$empire=null;
?>