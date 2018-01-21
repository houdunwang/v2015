<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../class/user.php");
require("../../data/dbcache/MemberLevel.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
//是否登陆
$user=islogin();
$r=ReturnUserInfo($user[userid]);
$addr=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid='".$user[userid]."' limit 1");
//头像
$userpic=$addr['userpic']?$addr['userpic']:$public_r[newsurl].'e/data/images/nouserpic.gif';
//有效期
$userdate=0;
if($r[userdate])
{
	$userdate=$r[userdate]-time();
	if($userdate<=0)
	{
		$userdate=0;
	}
	else
	{
		$userdate=round($userdate/(24*3600));
	}
}
//是否有短消息
$havemsg="无";
if($user[havemsg])
{
	$havemsg="<a href='".$public_r['newsurl']."e/member/msg' target=_blank><font color=red>您有新消息</font></a>";
}
//注册时间
$registertime=eReturnMemberRegtime($r['registertime'],"Y-m-d H:i:s");
//导入模板
require(ECMS_PATH.'e/template/member/cp.php');
db_close();
$empire=null;
?>