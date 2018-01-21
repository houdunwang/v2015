<?php
//--------------- 会员空间函数 ---------------

//选择空间模板
function ChangeSpaceStyle($add){
	global $empire,$dbtbpre;
	$user_r=islogin();//是否登陆
	$styleid=intval($add['styleid']);
	if(!$styleid)
	{
		printerror('NotChangeSpaceStyleId','',1);
	}
	$sr=$empire->fetch1("select styleid,membergroup from {$dbtbpre}enewsspacestyle where styleid='$styleid'");
	if(!$sr['styleid']||($sr['membergroup']&&!strstr($sr['membergroup'],','.$user_r[groupid].',')))
	{
		printerror('NotChangeSpaceStyleId','',1);
	}
	$sql=$empire->query("update {$dbtbpre}enewsmemberadd set spacestyleid='$styleid' where userid='$user_r[userid]' limit 1");
	if($sql)
	{
		printerror('ChangeSpaceStyleSuccess','ChangeStyle.php',1);
	}
	else
	{
		printerror('DbError','',1);
	}
}

//设置空间
function DoSetSpace($add){
	global $empire,$dbtbpre;
	$user_r=islogin();//是否登陆
	$spacename=RepPostStr($add['spacename']);
	$spacegg=RepPostStr($add['spacegg']);
	$sql=$empire->query("update {$dbtbpre}enewsmemberadd set spacename='$spacename',spacegg='$spacegg' where userid='$user_r[userid]' limit 1");
	if($sql)
	{
		printerror('SetSpaceSuccess','SetSpace.php',1);
	}
	else
	{
		printerror('DbError','',1);
	}
}
?>