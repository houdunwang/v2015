<?php
//--------------- 注册函数 ---------------

//验证会员组是否可注册
function CheckMemberGroupCanReg($groupid){
	global $empire,$dbtbpre;
	$groupid=(int)$groupid;
	$r=$empire->fetch1("select groupid from {$dbtbpre}enewsmembergroup where groupid='$groupid' and canreg=1");
	if(empty($r['groupid']))
	{
		printerror('ErrorUrl','',1);
	}
}

//验证注册时间
function eCheckIpRegTime($ip,$time){
	global $empire,$dbtbpre;
	if(empty($time))
	{
		return '';
	}
	$uaddr=$empire->fetch1("select userid from {$dbtbpre}enewsmemberadd where regip='$ip' order by userid desc limit 1");
	if(empty($uaddr['userid']))
	{
		return '';
	}
	$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid,registertime')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$uaddr[userid]' limit 1");
	if(empty($ur['userid']))
	{
		return '';
	}
	$registertime=eReturnMemberIntRegtime($ur['registertime']);
	if(time()-$registertime<=$time*3600)
	{
		printerror('RegisterReIpError','',1);
	}
}

//用户注册
function register($add){
	global $empire,$dbtbpre,$public_r,$ecms_config;
	//关闭注册
	if($public_r['register_ok'])
	{
		printerror('CloseRegister','',1);
	}
	//验证时间段允许操作
	eCheckTimeCloseDo('reg');
	//验证IP
	eCheckAccessDoIp('register');
	if(!empty($ecms_config['member']['registerurl']))
	{
		Header("Location:".$ecms_config['member']['registerurl']);
		exit();
    }
	//已经登陆不能注册
	if(getcvar('mluserid'))
	{
		printerror('LoginToRegister','',1);
	}
	CheckCanPostUrl();//验证来源
	$username=trim($add['username']);
	$password=trim($add['password']);
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	$email=RepPostStr($add['email']);
	if(!$username||!$password||!$email)
	{
		printerror("EmptyMember","history.go(-1)",1);
	}
	$tobind=(int)$add['tobind'];
	//验证码
	$keyvname='checkregkey';
	if($public_r['regkey_ok'])
	{
		ecmsCheckShowKey($keyvname,$add['key'],1);
	}
	$user_groupid=eReturnMemberDefGroupid();
	$groupid=(int)$add['groupid'];
	$groupid=empty($groupid)?$user_groupid:$groupid;
	CheckMemberGroupCanReg($groupid);
	//IP
	$regip=egetip();
	$regipport=egetipport();
	//用户字数
	$pr=$empire->fetch1("select min_userlen,max_userlen,min_passlen,max_passlen,regretime,regclosewords,regemailonly from {$dbtbpre}enewspublic limit 1");
	$userlen=strlen($username);
	if($userlen<$pr[min_userlen]||$userlen>$pr[max_userlen])
	{
		printerror('FaiUserlen','',1);
	}
	//密码字数
	$passlen=strlen($password);
	if($passlen<$pr[min_passlen]||$passlen>$pr[max_passlen])
	{
		printerror('FailPasslen','',1);
	}
	if($add['repassword']!==$password)
	{
		printerror('NotRepassword','',1);
	}
	if(!chemail($email))
	{
		printerror('EmailFail','',1);
	}
	if(strstr($username,'|')||strstr($username,'*'))
	{
		printerror('NotSpeWord','',1);
	}
	//同一IP注册
	eCheckIpRegTime($regip,$pr['regretime']);
	//保留用户
	toCheckCloseWord($username,$pr['regclosewords'],'RegHaveCloseword');
	$username=RepPostStr($username);
	//重复用户
	$num=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('username')."='$username' limit 1");
	if($num)
	{
		printerror('ReUsername','',1);
	}
	//重复邮箱
	if($pr['regemailonly'])
	{
		$num=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('email')."='$email' limit 1");
		if($num)
		{
			printerror('ReEmailFail','',1);
		}
	}
	//注册时间
	$lasttime=time();
	$registertime=eReturnAddMemberRegtime();
	$rnd=make_password(20);//产生随机密码
	$userkey=eReturnMemberUserKey();
	//密码
	$truepassword=$password;
	$salt=eReturnMemberSalt();
	$password=eDoMemberPw($password,$salt);
	//审核
	$checked=ReturnGroupChecked($groupid);
	if($checked&&$public_r['regacttype']==1)
	{
		$checked=0;
	}
	//验证附加表必填项
	$mr['add_filepass']=ReturnTranFilepass();
	$fid=GetMemberFormId($groupid);
	$member_r=ReturnDoMemberF($fid,$add,$mr,0,$username);

	$sql=$empire->query("insert into ".eReturnMemberTable()."(".eReturnInsertMemberF('username,password,rnd,email,registertime,groupid,userfen,userdate,money,zgroupid,havemsg,checked,salt,userkey').") values('$username','$password','$rnd','$email','$registertime','$groupid','$public_r[reggetfen]','0','0','0','0','$checked','$salt','$userkey');");
	//取得userid
	$userid=$empire->lastid();
	//附加表
	$addr=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid='$userid'");
	if(!$addr[userid])
	{
		$spacestyleid=ReturnGroupSpaceStyleid($groupid);
		$sql1=$empire->query("insert into {$dbtbpre}enewsmemberadd(userid,spacestyleid,regip,lasttime,lastip,loginnum,regipport,lastipport".$member_r[0].") values('$userid','$spacestyleid','$regip','$lasttime','$regip','1','$regipport','$regipport'".$member_r[1].");");
	}
	//更新附件
	UpdateTheFileOther(6,$userid,$mr['add_filepass'],'member');
	ecmsEmptyShowKey($keyvname);//清空验证码
	//绑定帐号
	if($tobind)
	{
		MemberConnect_BindUser($userid);
	}
	if($sql)
	{
		//邮箱激活
		if($checked==0&&$public_r['regacttype']==1)
		{
			include('class/member_actfun.php');
			SendActUserEmail($userid,$username,$email);
		}
		//审核
		if($checked==0)
		{
			$location=DoingReturnUrl("../../",$_POST['ecmsfrom']);
			printerror("RegisterSuccessCheck",$location,1);
		}
		$logincookie=0;
		if($ecms_config['member']['regcookietime'])
		{
			$logincookie=time()+$ecms_config['member']['regcookietime'];
		}
		$r=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid' limit 1");
		$set1=esetcookie("mlusername",$username,$logincookie);
		$set2=esetcookie("mluserid",$userid,$logincookie);
		$set3=esetcookie("mlgroupid",$groupid,$logincookie);
		$set4=esetcookie("mlrnd",$rnd,$logincookie);
		//验证符
		qGetLoginAuthstr($userid,$username,$rnd,$groupid,$logincookie);
		//登录附加cookie
		AddLoginCookie($r);
		$location="../member/cp/";
		$returnurl=getcvar('returnurl');
		if($returnurl&&!strstr($returnurl,"e/member/iframe")&&!strstr($returnurl,"e/member/register")&&!strstr($returnurl,"enews=exit"))
		{
			$location=$returnurl;
		}
		$set5=esetcookie("returnurl","");
		//易通行系统
		DoEpassport('reg',$userid,$username,$truepassword,$salt,$email,$groupid,$registertime);
		$location=DoingReturnUrl($location,$_POST['ecmsfrom']);
		printerror("RegisterSuccess",$location,1);
	}
	else
	{printerror("DbError","history.go(-1)",1);}
}
?>