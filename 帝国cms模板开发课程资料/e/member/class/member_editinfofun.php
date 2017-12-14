<?php
//--------------- 修改信息函数 ---------------

//修改安全信息
function EditSafeInfo($add){
	global $empire,$dbtbpre,$public_r;
	$user_r=islogin();//是否登陆
	$userid=$user_r[userid];
	$username=$user_r[username];
	$rnd=$user_r[rnd];
	//邮箱
	$email=trim($add['email']);
	if(!$email||!chemail($email))
	{
		printerror("EmailFail","history.go(-1)",1);
	}
	$email=RepPostStr($email);
	//验证原密码
	$oldpassword=RepPostVar($add[oldpassword]);
	if(!$oldpassword)
	{
		printerror('FailOldPassword','',1);
	}
	$add[password]=RepPostVar($add[password]);
	$num=0;
	$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid,password,salt')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid'");
	if(empty($ur['userid']))
	{
		printerror('FailOldPassword','',1);
	}
	if(!eDoCkMemberPw($oldpassword,$ur['password'],$ur['salt']))
	{
		printerror('FailOldPassword','',1);
	}
	//邮箱
	$pr=$empire->fetch1("select regemailonly from {$dbtbpre}enewspublic limit 1");
	if($pr['regemailonly'])
	{
		$num=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('email')."='$email' and ".egetmf('userid')."<>'$userid' limit 1");
		if($num)
		{
			printerror("ReEmailFail","history.go(-1)",1);
		}
	}
	//密码
	$a='';
	$salt='';
	$truepassword='';
	if($add[password])
	{
		if($add[password]!==$add[repassword])
		{
			printerror('NotRepassword','history.go(-1)',1);
		}
		$salt=eReturnMemberSalt();
		$password=eDoMemberPw($add[password],$salt);
		$a=",".egetmf('password')."='$password',".egetmf('salt')."='$salt'";
		$truepassword=$add[password];
	}
	$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('email')."='$email'".$a." where ".egetmf('userid')."='$userid'");
	if($sql)
    {
		//易通行系统
		DoEpassport('editpassword',$userid,$username,$truepassword,$salt,$email,$user_r['groupid'],'');
		printerror("EditInfoSuccess","../member/EditInfo/EditSafeInfo.php",1);
	}
    else
    {
		printerror("DbError","history.go(-1)",1);
	}
}

//信息修改
function EditInfo($post){
	global $empire,$dbtbpre,$public_r;
	$user_r=islogin();//是否登陆
	$userid=$user_r[userid];
	$username=$user_r[username];
	$dousername=$username;
	$rnd=$user_r[rnd];
	$groupid=$user_r[groupid];
	if(!$userid||!$username)
	{
		printerror("NotEmpty","history.go(-1)",1);
	}
	//验证附加表必填项
	$addr=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid='$userid'");
	$user_r=$empire->fetch1("select ".eReturnSelectMemberF('groupid')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid'");
	$fid=GetMemberFormId($user_r['groupid']);
	if(empty($addr[userid]))
	{
		$mr['add_filepass']=$userid;
		$member_r=ReturnDoMemberF($fid,$post,$mr,0,$dousername);
	}
	else
	{
		$addr['add_filepass']=$userid;
		$member_r=ReturnDoMemberF($fid,$post,$addr,1,$dousername);
	}
	//附加表
	if(empty($addr[userid]))
	{
		//IP
		$regip=egetip();
		$regipport=egetipport();
		$lasttime=time();
		$sql=$empire->query("insert into {$dbtbpre}enewsmemberadd(userid,regip,lasttime,lastip,loginnum,regipport,lastipport".$member_r[0].") values('$userid','$regip','$lasttime','$regip',1,'$regipport','$regipport'".$member_r[1].");");
    }
	else
	{
		$sql=$empire->query("update {$dbtbpre}enewsmemberadd set userid='$userid'".$member_r[0]." where userid='$userid'");
    }
	//更新附件
	UpdateTheFileEditOther(6,$userid,'member');
    if($sql)
    {
		printerror("EditInfoSuccess","../member/EditInfo/",1);
	}
    else
    {
		printerror("DbError","history.go(-1)",1);
	}
}
?>