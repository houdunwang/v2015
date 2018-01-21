<?php
//--------------- 后台管理会员函数 ---------------

//后台修改资料
function admin_EditMember($add,$logininid,$loginin){
	global $empire,$dbtbpre;
	if(!trim($add[userid])||!trim($add[email])||!trim($add[username])||!$add[groupid])
	{
		printerror("EmptyEmail","history.go(-1)");
	}
    CheckLevel($logininid,$loginin,$classid,"member");//验证权限
	//变量
	$add[userid]=(int)$add[userid];
	$add[checked]=(int)$add[checked];
	$add[username]=RepPostVar($add[username]);
	$add[oldusername]=RepPostVar($add[oldusername]);
	$add[password]=RepPostVar($add[password]);
	$add[email]=RepPostStr($add[email]);
	$dousername=$add[username];
	$dooldusername=$add[oldusername];
	//修改密码
	$add1='';
	if($add[password])
	{
		$salt=eReturnMemberSalt();
		$add[password]=eDoMemberPw($add[password],$salt);
		$add1=",".egetmf('password')."='$add[password]',".egetmf('salt')."='$salt'";
    }
	//修改用户名
	if($add[oldusername]<>$add[username])
	{
		$num=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('username')."='$add[username]' and ".egetmf('userid')."<>".$add[userid]." limit 1");
		$add1.=",".egetmf('username')."='$add[username]'";
		if($num)
		{
			printerror("ReUsername","history.go(-1)");
		}
	}
	//包月
	$add[zgroupid]=(int)$add[zgroupid];
	if($add[userdate]>0)
	{
		$userdate=time()+$add[userdate]*24*3600;
	}
	else
	{
		$add[zgroupid]=0;
	}
	//变量
	$add[groupid]=(int)$add[groupid];
	$add[userfen]=(int)$add[userfen];
	$userdate=(int)$userdate;
	$add[money]=(float)$add[money];
	$add[spacestyleid]=(int)$add[spacestyleid];
	//验证附加表必填项
	$addr=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid='$add[userid]'");
	$fid=GetMemberFormId($add[groupid]);
	if(empty($addr[userid]))
	{
		$mr['add_filepass']=$add['userid'];
		$member_r=ReturnDoMemberF($fid,$_POST,$mr,0,$dousername,1);
	}
	else
	{
		$addr['add_filepass']=$add['userid'];
		$member_r=ReturnDoMemberF($fid,$_POST,$addr,1,$dousername,1);
	}

	$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('email')."='$add[email]',".egetmf('groupid')."='$add[groupid]',".egetmf('userfen')."='$add[userfen]',".egetmf('money')."='$add[money]',".egetmf('userdate')."='$userdate',".egetmf('zgroupid')."='$add[zgroupid]',".egetmf('checked')."='$add[checked]'".$add1." where ".egetmf('userid')."='$add[userid]'");

	//更改用户名
	if($add[oldusername]<>$add[username])
	{
		//短消息
		$empire->query("update {$dbtbpre}enewsqmsg set to_username='$dousername' where to_username='$dooldusername'");
		$empire->query("update {$dbtbpre}enewsqmsg set from_username='$dousername' where from_username='$dooldusername'");
		//收藏
		$empire->query("update {$dbtbpre}enewsfava set username='$dousername' where userid='$add[userid]'");
		//购买记录
		$empire->query("update {$dbtbpre}enewsbuybak set username='$dousername' where userid='$add[userid]'");
		//下载记录
		$empire->query("update {$dbtbpre}enewsdownrecord set username='$dousername' where userid='$add[userid]'");
		//信息表
		$tbsql=$empire->query("select tbname from {$dbtbpre}enewstable");
		while($tbr=$empire->fetch($tbsql))
		{
			$empire->query("update {$dbtbpre}ecms_".$tbr['tbname']." set username='$dousername' where userid='$add[userid]' and ismember=1");
			$empire->query("update {$dbtbpre}ecms_".$tbr['tbname']."_check set username='$dousername' where userid='$add[userid]' and ismember=1");
		}
	}

	//附加表
	if(empty($addr[userid]))
	{
		$sql1=$empire->query("insert into {$dbtbpre}enewsmemberadd(userid,spacestyleid".$member_r[0].") values($add[userid],$add[spacestyleid]".$member_r[1].");");
    }
	else
	{
		$sql1=$empire->query("update {$dbtbpre}enewsmemberadd set spacestyleid=$add[spacestyleid]".$member_r[0]." where userid='$add[userid]'");
    }
	//更新附件
	UpdateTheFileEditOther(6,$add['userid'],'member');
	if($sql)
	{
	   insert_dolog("userid=".$add[userid]."<br>username=".$dousername);//操作日志
	   printerror("EditMemberSuccess","ListMember.php".hReturnEcmsHashStrHref2(1));
	}
    else
	{
		printerror("DbError","history.go(-1)");
	}
}

//后台删除会员
function admin_DelMember($userid,$loginuserid,$loginusername){
	global $empire,$dbtbpre;
	$userid=(int)$userid;
	if(empty($userid))
	{
		printerror("NotDelMemberid","history.go(-1)");
	}
    CheckLevel($loginuserid,$loginusername,$classid,"member");//验证权限
	$r=$empire->fetch1("select ".eReturnSelectMemberF('username,groupid')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid'");
	if(empty($r['username']))
	{
		printerror("NotDelMemberid","history.go(-1)");
	}
    $sql=$empire->query("delete from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid'");
	$dousername=$r['username'];
	//删除附加表
	$fid=GetMemberFormId($r['groupid']);
	DoDelMemberF($fid,$userid,$dousername);
	//删除收藏
	$del=$empire->query("delete from {$dbtbpre}enewsfava where userid='$userid'");
	$del=$empire->query("delete from {$dbtbpre}enewsfavaclass where userid='$userid'");
	//删除短消息
	$del=$empire->query("delete from {$dbtbpre}enewsqmsg where to_username='".$dousername."'");
	//删除购买记录
	$del=$empire->query("delete from {$dbtbpre}enewsbuybak where userid='$userid'");
	//删除下载记录
	$del=$empire->query("delete from {$dbtbpre}enewsdownrecord where userid='$userid'");
	//删除好友记录
	$del=$empire->query("delete from {$dbtbpre}enewshy where userid='$userid'");
	$del=$empire->query("delete from {$dbtbpre}enewshyclass where userid='$userid'");
	//删除留言
	$del=$empire->query("delete from {$dbtbpre}enewsmembergbook where userid='$userid'");
	//删除反馈
	$del=$empire->query("delete from {$dbtbpre}enewsmemberfeedback where userid='$userid'");
	//删除绑定
	$del=$empire->query("delete from {$dbtbpre}enewsmember_connect where userid='$userid';");
    if($sql)
	{
	    insert_dolog("userid=".$userid."<br>username=".$dousername);//操作日志
		printerror("DelMemberSuccess","ListMember.php".hReturnEcmsHashStrHref2(1));
	}
    else
	{
		printerror("DbError","history.go(-1)");
	}
}

//后台批量删除会员
function admin_DelMember_all($userid,$logininid,$loginin){
	global $empire,$dbtbpre;
    CheckLevel($logininid,$loginin,$classid,"member");//验证权限
    $count=count($userid);
    if(!$count)
	{
		 printerror("NotDelMemberid","history.go(-1)");
	}
	$dh="";
	for($i=0;$i<$count;$i++)
	{
		$euid=(int)$userid[$i];
		//删除短消息
		$ur=$empire->fetch1("select ".eReturnSelectMemberF('username,groupid')." from ".eReturnMemberTable()." where ".egetmf('userid')."='".$euid."'");
		if(empty($ur['username']))
		{
			continue;
		}
		$dousername=$ur['username'];
		//删除附加表
		$fid=GetMemberFormId($ur['groupid']);
		DoDelMemberF($fid,$euid,$dousername);
		$del=$empire->query("delete from {$dbtbpre}enewsqmsg where to_username='".$dousername."'");
		//集合
		$inid.=$dh.$euid;
		$dh=",";
    }
	if(empty($inid))
	{
		printerror("NotDelMemberid","history.go(-1)");
	}
	$add=egetmf('userid')." in (".$inid.")";
	$adda="userid in (".$inid.")";
	$sql=$empire->query("delete from ".eReturnMemberTable()." where ".$add);
	//删除收藏
	$del=$empire->query("delete from {$dbtbpre}enewsfava where ".$adda);
	$del=$empire->query("delete from {$dbtbpre}enewsfavaclass where ".$adda);
	//删除购买记录
	$del=$empire->query("delete from {$dbtbpre}enewsbuybak where ".$adda);
	//删除下载记录
	$del=$empire->query("delete from {$dbtbpre}enewsdownrecord where ".$adda);
	//删除好友记录
	$del=$empire->query("delete from {$dbtbpre}enewshy where ".$adda);
	$del=$empire->query("delete from {$dbtbpre}enewshyclass where ".$adda);
	//删除留言
	$del=$empire->query("delete from {$dbtbpre}enewsmembergbook where ".$adda);
	//删除反馈
	$del=$empire->query("delete from {$dbtbpre}enewsmemberfeedback where ".$adda);
	//删除绑定
	$del=$empire->query("delete from {$dbtbpre}enewsmember_connect where ".$adda);
	if($sql)
	{
	    insert_dolog("");//操作日志
		printerror("DelMemberSuccess","ListMember.php".hReturnEcmsHashStrHref2(1));
    }
	else
	{
		printerror("DbError","history.go(-1)");
    }
}

//审核会员
function admin_DoCheckMember_all($userid,$logininid,$loginin){
	global $empire,$dbtbpre;
    CheckLevel($logininid,$loginin,$classid,"member");//验证权限
    $count=count($userid);
    if(!$count)
	{
		 printerror("NotChangeDoCheckMember","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$dh=",";
		if($i==0)
		{
			$dh="";
		}
		//集合
		$inid.=$dh.intval($userid[$i]);
	}
	$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('checked')."=1 where ".egetmf('userid')." in (".$inid.")");
	if($sql)
	{
		insert_dolog("");//操作日志
		printerror("DoCheckMemberSuccess","ListMember.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//后台清理会员
function admin_ClearMember($add,$logininid,$loginin){
	global $empire,$dbtbpre,$level_r;
    CheckLevel($logininid,$loginin,$classid,"member");//验证权限
	//变量处理
	$username=RepPostVar($add['username']);
	$email=RepPostStr($add['email']);
	$startuserid=(int)$add['startuserid'];
	$enduserid=(int)$add['enduserid'];
	$groupid=(int)$add['groupid'];
	$startregtime=RepPostVar($add['startregtime']);
	$endregtime=RepPostVar($add['endregtime']);
	$startuserfen=(int)$add['startuserfen'];
	$enduserfen=(int)$add['enduserfen'];
	$startmoney=(int)$add['startmoney'];
	$endmoney=(int)$add['endmoney'];
	$checked=(int)$add['checked'];
	$where='';
	if($username)
	{
		$where.=" and ".egetmf('username')." like '%$username%'";
	}
	if($email)
	{
		$where.=" and ".egetmf('email')." like '%$email%'";
	}
	if($enduserid)
	{
		$where.=' and '.egetmf('userid').' BETWEEN '.$startuserid.' and '.$enduserid;
	}
	if($groupid)
	{
		$where.=" and ".egetmf('groupid')."='$groupid'";
	}
	if($startregtime&&$endregtime)
	{
		$startregtime=to_time($startregtime);
		$endregtime=to_time($endregtime);
		$where.=" and ".egetmf('registertime').">='$startregtime' and ".egetmf('registertime')."<='$endregtime'";
	}
	if($enduserfen)
	{
		$where.=' and '.egetmf('userfen').' BETWEEN '.$startuserfen.' and '.$enduserfen;
	}
	if($endmoney)
	{
		$where.=' and '.egetmf('money').' BETWEEN '.$startmoney.' and '.$endmoney;
	}
	if($checked)
	{
		$checkval=$checked==1?1:0;
		$where.=" and ".egetmf('checked')."='$checkval'";
	}
    if(!$where)
	{
		 printerror("EmptyClearMember","history.go(-1)");
	}
	$where=substr($where,5);
	$sql=$empire->query("select ".eReturnSelectMemberF('userid,username,groupid')." from ".eReturnMemberTable()." where ".$where);
	$dh='';
	$inid='';
	while($r=$empire->fetch($sql))
	{
		$euid=$r['userid'];
		//删除短消息
		$dousername=$r['username'];
		//删除附加表
		$fid=GetMemberFormId($r['groupid']);
		DoDelMemberF($fid,$euid,$dousername);
		$empire->query("delete from {$dbtbpre}enewsqmsg where to_username='".$dousername."'");
		//集合
		$inid.=$dh.$euid;
		$dh=',';
    }
	if($inid)
	{
		$addw=egetmf('userid')." in (".$inid.")";
		$addaw="userid in (".$inid.")";
		$sql=$empire->query("delete from ".eReturnMemberTable()." where ".$addw);
		//删除收藏
		$del=$empire->query("delete from {$dbtbpre}enewsfava where ".$addaw);
		$del=$empire->query("delete from {$dbtbpre}enewsfavaclass where ".$addaw);
		//删除购买记录
		$del=$empire->query("delete from {$dbtbpre}enewsbuybak where ".$addaw);
		//删除下载记录
		$del=$empire->query("delete from {$dbtbpre}enewsdownrecord where ".$addaw);
		//删除好友记录
		$del=$empire->query("delete from {$dbtbpre}enewshy where ".$addaw);
		$del=$empire->query("delete from {$dbtbpre}enewshyclass where ".$addaw);
		//删除留言
		$del=$empire->query("delete from {$dbtbpre}enewsmembergbook where ".$addaw);
		//删除反馈
		$del=$empire->query("delete from {$dbtbpre}enewsmemberfeedback where ".$addaw);
		//删除绑定
		$del=$empire->query("delete from {$dbtbpre}enewsmember_connect where ".$addaw);
	}
	insert_dolog("");//操作日志
	printerror("DelMemberSuccess","ClearMember.php".hReturnEcmsHashStrHref2(1));
}

//批量赠送点数
function GetFen_all($cardfen,$userid,$username){
	global $empire,$dbtbpre;
	$cardfen=(int)$cardfen;
	if(!$cardfen)
	{printerror("EmptyGetFen","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"card");
	$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userfen')."=".egetmf('userfen')."+$cardfen");
	if($sql)
	{
		//操作日志
		insert_dolog("cardfen=$cardfen");
		printerror("GetFenSuccess","GetFen.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}
?>