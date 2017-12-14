<?php
//发表留言
function AddMemberGbook($add){
	global $empire,$dbtbpre;
	//验证码
	$keyvname='checkspacegbkey';
	ecmsCheckShowKey($keyvname,$add['key'],1);
	//用户
	$userid=intval($add['userid']);
	$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid' limit 1");
	if(empty($ur['userid']))
	{
		printerror("NotUsername","",1);
	}
	//发表者
	$uid=(int)getcvar('mluserid');
	if($uid)
	{
		$uname=RepPostVar(getcvar('mlusername'));
	}
	else
	{
		$uid=0;
		$uname=trim($add['uname']);
	}
	$uname=RepPostStr($uname);
	$gbtext=RepPostStr($add['gbtext']);
	if(empty($uname)||!trim($gbtext))
	{
		printerror("EmptyMemberGbook","history.go(-1)",1);
    }
	$isprivate=intval($add['isprivate']);
	$addtime=date("Y-m-d H:i:s");
	$ip=egetip();
	$eipport=egetipport();
	$sql=$empire->query("insert into {$dbtbpre}enewsmembergbook(userid,isprivate,uid,uname,ip,addtime,gbtext,retext,eipport) values($userid,$isprivate,$uid,'$uname','$ip','$addtime','$gbtext','','$eipport');");
	ecmsEmptyShowKey($keyvname);//清空验证码
	if($sql)
	{
		printerror("AddMemberGbookSuccess",$_SERVER['HTTP_REFERER'],1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//回复留言
function ReMemberGbook($add){
	global $empire,$dbtbpre;
	$user_r=islogin();//是否登陆
	$gid=intval($add['gid']);
	if(!$gid)
	{
		printerror("EmptyReMemberGbook","history.go(-1)",1);
	}
	$retext=RepPostStr($add['retext']);
	$sql=$empire->query("update {$dbtbpre}enewsmembergbook set retext='$retext' where gid='$gid' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror("ReMemberGbookSuccess",$_SERVER['HTTP_REFERER'],1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//删除留言
function DelMemberGbook($add){
	global $empire,$dbtbpre;
	$user_r=islogin();//是否登陆
	$gid=intval($add['gid']);
	if(!$gid)
	{
		printerror("NotDelMemberGbookid","history.go(-1)",1);
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsmembergbook where gid='$gid' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror("DelMemberGbookSuccess",$_SERVER['HTTP_REFERER'],1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//批量删除留言
function DelMemberGbook_All($add){
	global $empire,$dbtbpre;
	$user_r=islogin();//是否登陆
	$gid=$add['gid'];
	$count=count($gid);
	if(empty($count))
	{
		printerror("NotDelMemberGbookid","history.go(-1)",1);
	}
	for($i=0;$i<$count;$i++)
	{
		$addsql.="gid='".intval($gid[$i])."' or ";
    }
	$addsql=substr($addsql,0,strlen($addsql)-4);
	$sql=$empire->query("delete from {$dbtbpre}enewsmembergbook where (".$addsql.") and userid='$user_r[userid]'");
	if($sql)
	{
		printerror("DelMemberGbookSuccess",$_SERVER['HTTP_REFERER'],1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}
?>