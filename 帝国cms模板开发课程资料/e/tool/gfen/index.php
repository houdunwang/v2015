<?php
//------------------参数配置
$open=1;	//1为关闭，0为开启
$type=0;	//0为按ip(同一ip不重复增加点数)，1为按cookie(同一机器不重复增加点数)
$retime=3600;	//重复增加点数时间间隔，单位为秒
$fen=1;		//单一点击点数
$gotourl="../../../";	//转向地址


//------------------
if($open)
{
	exit();
}

require("../../class/connect.php");
$id=(int)$_GET['id'];
$n=RepPostVar($_GET['n']);
if(!($id||$n))
{
	Header("Location:$gotourl");
	exit();
}
require("../../class/db_sql.php");
require("../../member/class/user.php");
$link=db_connect();
$empire=new mysqlquery();
if($id)
{
	$where=egetmf('userid')."='".$id."'";
}
else
{
	$where=egetmf('username')."='".$n."'";
}
$r=$empire->fetch1("select ".eReturnSelectMemberF('userid,username')." from ".eReturnMemberTable()." where ".$where." limit 1");
if(empty($r[userid]))
{
	Header("Location:$gotourl");
	exit();
}
//cookie
if($type==1)
{
	$gfencookie=getcvar('ecmsgfen');
	if($gfencookie)
	{
		Header("Location:$gotourl");
		exit();
	}
	$set=esetcookie("ecmsgfen","ecms",time()+$retime);
}
//ip
else
{
	$ip=egetip();
	$time=time();
	//删除过期记录
	$del=$empire->query("delete from {$dbtbpre}enewsgfenip where ".$time."-addtime>".$retime);
	$ipr=$empire->fetch1("select ip,addtime from {$dbtbpre}enewsgfenip where ip='$ip' limit 1");
	if($ipr['ip'])
	{
		Header("Location:$gotourl");
		exit();
	}
	else
	{
		$usql=$empire->query("insert into {$dbtbpre}enewsgfenip(ip,addtime) values('$ip',$time);");
	}
}
$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userfen')."=".egetmf('userfen')."+".$fen." where ".$where);
$set=esetcookie("gfenuserid",$r[userid],0);
$set=esetcookie("gfenusername",$r[username],0);
db_close();
$empire=null;
header("Refresh:0; URL=$gotourl");
?>