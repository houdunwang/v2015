<?php
require("../../class/connect.php");
require("../../class/q_functions.php");
require("../../class/db_sql.php");
require("../class/user.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
$user=islogin();
$fid=(int)$_GET['fid'];
$r=$empire->fetch1("select fid,name,company,phone,fax,email,address,zip,title,ftext,userid,ip,uid,uname,addtime,eipport from {$dbtbpre}enewsmemberfeedback where fid='$fid' and userid='$user[userid]'");
if(!$r['fid'])
{
	printerror('ErrorUrl','',1);
}
if($r['uid'])
{
	$r['uname']="<a href='../../space/?userid=$r[uid]' target='_blank'>$r[uname]</a>&nbsp;&nbsp;(<a href='../msg/AddMsg/?username=$r[uname]' target='_blank'>消息回复</a>)";
}
else
{
	$r['uname']='游客';
}
//导入模板
require(ECMS_PATH.'e/template/member/mspace/ShowFeedback.php');
db_close();
$empire=null;
?>