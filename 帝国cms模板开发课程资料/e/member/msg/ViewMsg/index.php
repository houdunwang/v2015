<?php
require("../../../class/connect.php");
require("../../../class/q_functions.php");
require("../../../class/db_sql.php");
require("../../class/user.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=2;
eCheckCloseMods('member');//关闭模块
$user=islogin();
$mid=(int)$_GET['mid'];
if(empty($mid))
{
	printerror("HaveNotMsg","",1);
}
$r=$empire->fetch1("select mid,title,msgtext,from_userid,from_username,msgtime,haveread,issys from {$dbtbpre}enewsqmsg where mid=$mid and to_username='$user[username]' limit 1");
if(empty($r[mid]))
{
	printerror("HaveNotMsg","",1);
}
if($r['issys'])
{
	$r[from_username]="<b>系统信息</b>";
}
if(!$r['haveread'])
{
	$newhavemsg=0;
	if($user['havemsg']==3)
	{
		$newhavemsg=2;
	}
	$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('havemsg')."='$newhavemsg' where ".egetmf('userid')."='$user[userid]'");
	$usql=$empire->query("update {$dbtbpre}enewsqmsg set haveread=1 where mid=$mid");
}
//导入模板
require(ECMS_PATH.'e/template/member/ViewMsg.php');
db_close();
$empire=null;
?>