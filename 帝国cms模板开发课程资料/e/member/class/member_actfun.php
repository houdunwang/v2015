<?php
//加密
function QMReturnCheckPass($userid,$username,$email,$ecms=1){
	global $ecms_config;
	$r['rnd']=make_password(12);
	$r['dotime']=time();
	$r['checkpass']=md5(md5($r['rnd'].'-'.$userid.'-'.$r['dotime'].'-'.$ecms).$ecms_config['cks']['ckrnd']);
	$r['ecms']=$ecms;
	return $r;
}

//验证
function QMReturnCheckThePass($ckuserid,$ckpass,$cktime,$authstr,$ecms=1){
	global $empire,$dbtbpre,$ecms_config,$public_r;
	$f=$ecms==2?'acttime':'getpasstime';
	$time=time();
	$pr=$empire->fetch1("select ".$f." from {$dbtbpre}enewspublic limit 1");
	$ar=explode('||',$authstr);
	if($cktime>$time||$time-$cktime>$pr[$f]*3600||$ar[0]!=$cktime)
	{
		printerror('GPOutTime',$public_r['newsurl'],1);
	}
	$pass=md5(md5($ar[2].'-'.$ckuserid.'-'.$ar[0].'-'.$ar[1]).$ecms_config['cks']['ckrnd']);
	if($pass!=$ckpass)
	{
		printerror('GPErrorPass',$public_r['newsurl'],1);
	}
}

//替换邮件内容变量
function QMRepEmailtext($userid,$username,$email,$pageurl,$title,$text){
	global $empire,$dbtbpre,$public_r;
	$date=date("Y-m-d");
	$r[text]=str_replace('[!--pageurl--]',$pageurl,$text);
	$r[text]=str_replace('[!--username--]',$username,$r[text]);
	$r[text]=str_replace('[!--email--]',$email,$r[text]);
	$r[text]=str_replace('[!--date--]',$date,$r[text]);
	$r[text]=str_replace('[!--sitename--]',$public_r[sitename],$r[text]);
	$r[text]=str_replace('[!--news.url--]',$public_r[newsurl],$r[text]);
	$r[title]=str_replace('[!--pageurl--]',$pageurl,$title);
	$r[title]=str_replace('[!--username--]',$username,$r[title]);
	$r[title]=str_replace('[!--email--]',$email,$r[title]);
	$r[title]=str_replace('[!--date--]',$date,$r[title]);
	$r[title]=str_replace('[!--sitename--]',$public_r[sitename],$r[title]);
	$r[title]=str_replace('[!--news.url--]',$public_r[newsurl],$r[title]);
	return $r;
}

//--------------- 取回密码 --------------

//发送取回密码邮件
function SendGetPasswordEmail($add){
	global $empire,$dbtbpre,$public_r;
	if(!$public_r['opengetpass'])
	{
		printerror('CloseGetPassword','',1);
	}
	$username=trim($add[username]);
	$email=trim($add[email]);
	if(!$username||!$email)
	{
		printerror("EmptyGetPassword","history.go(-1)",1);
	}
	//验证码
	$key=$add['key'];
	$keyvname='checkgetpasskey';
	ecmsCheckShowKey($keyvname,$key,1);
	$username=RepPostVar($username);
	$email=RepPostStr($email);
	if(!chemail($email))
	{
		printerror("EmailFail","history.go(-1)",1);
	}
	$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid,username,email')." from ".eReturnMemberTable()." where ".egetmf('username')."='$username' limit 1");
	$useremail=$ur['email'];
	if(!$ur['userid']||$useremail!=$email)
	{
		printerror("ErrorGPUsername","history.go(-1)",1);
	}
	$passr=QMReturnCheckPass($ur['userid'],$username,$email,1);
	$authstr=$passr['dotime'].'||'.$passr['ecms'].'||'.$passr['rnd'];
	$sql=DoUpdateMemberAuthstr($ur['userid'],$authstr);
	$url=eReturnDomainSiteUrl().'e/member/GetPassword/getpass.php?id='.$ur['userid'].'&cc='.$passr[checkpass].'&tt='.$passr['dotime'];
	//发送邮件
	$pr=$empire->fetch1("select getpasstext,getpasstitle from {$dbtbpre}enewspublic limit 1");
	@include(ECMS_PATH.'e/class/SendEmail.inc.php');
	$textr=QMRepEmailtext($ur['userid'],$username,$email,$url,$pr['getpasstitle'],$pr['getpasstext']);
	$sm=EcmsToSendMail($email,$textr['title'],$textr['text']);
	ecmsEmptyShowKey($keyvname);//清空验证码
	printerror("SendGetPasswordEmailSucess",$public_r['newsurl'],1);
}

//接收验证信息
function CheckGetPassword($add,$ecms=1){
	global $empire,$dbtbpre,$public_r;
	$r['id']=(int)$add['id'];
	$r['tt']=(int)$add['tt'];
	$r['cc']=RepPostVar($add['cc']);
	if(!$r[id]||!$r[tt]||!$r[cc])
	{
		printerror('GPErrorPass',$public_r['newsurl'],1);
	}
	$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid,username,checked,groupid')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$r[id]' limit 1");
	if(empty($ur['userid']))
	{
		printerror('GPErrorPass',$public_r['newsurl'],1);
	}
	$addur=$empire->fetch1("select authstr from {$dbtbpre}enewsmemberpub where userid='$r[id]' limit 1");
	if(!$addur['authstr'])
	{
		printerror('GPErrorPass',$public_r['newsurl'],1);
	}
	QMReturnCheckThePass($r['id'],$r['cc'],$r['tt'],$addur['authstr'],$ecms);
	$r['username']=$ur['username'];
	$r['checked']=$ur['checked'];
	$r['groupid']=$ur['groupid'];
	return $r;
}

//修改密码
function DoGetPassword($add){
	global $empire,$dbtbpre,$public_r;
	if(!$public_r['opengetpass'])
	{
		printerror('CloseGetPassword','',1);
	}
	$r=CheckGetPassword($add,1);
	$password=RepPostVar($add['newpassword']);
	$add['renewpassword']=RepPostVar($add['renewpassword']);
	if($password!=$add['renewpassword'])
	{
		printerror('NotRepassword','',1);
	}
	//密码
	$salt=eReturnMemberSalt();
	$password=eDoMemberPw($password,$salt);
	$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('password')."='$password',".egetmf('salt')."='$salt' where ".egetmf('userid')."='$r[id]'");
	$usql=$empire->query("update {$dbtbpre}enewsmemberpub set authstr='' where userid='$r[id]'");
	printerror('GetPasswordSuccess',$public_r['newsurl'],1);
}


//--------------- 帐号激活 --------------

//发送激活帐号邮件
function SendActUserEmail($userid,$username,$email){
	global $empire,$dbtbpre,$public_r;
	$passr=QMReturnCheckPass($userid,$username,$email,2);
	$authstr=$passr['dotime'].'||'.$passr['ecms'].'||'.$passr['rnd'];
	$sql=DoUpdateMemberAuthstr($userid,$authstr);
	$url=eReturnDomainSiteUrl().'e/member/doaction.php?enews=DoActUser&id='.$userid.'&cc='.$passr[checkpass].'&tt='.$passr['dotime'];
	//发送邮件
	$pr=$empire->fetch1("select acttext,acttitle from {$dbtbpre}enewspublic limit 1");
	@include(ECMS_PATH.'e/class/SendEmail.inc.php');
	$textr=QMRepEmailtext($userid,$username,$email,$url,$pr['acttitle'],$pr['acttext']);
	$sm=EcmsToSendMail($email,$textr['title'],$textr['text']);
	printerror("SendActUserEmailSucess",$public_r['newsurl'],1);
}

//激活帐号
function DoActUser($add){
	global $empire,$dbtbpre,$public_r;
	$r=CheckGetPassword($add,2);
	if(!$r['checked'])
	{
		$checked=ReturnGroupChecked($r[groupid]);
		if($checked)
		{
			$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('checked')."=1 where ".egetmf('userid')."='$r[id]'");
		}
	}
	$usql=$empire->query("update {$dbtbpre}enewsmemberpub set authstr='' where userid='$r[id]'");
	printerror('ActUserSuccess',$public_r['newsurl'],1);
}

//重新发送帐号激活邮件
function DoRegSend($add){
	global $empire,$dbtbpre,$public_r;
	if($public_r['regacttype']!=1)
	{
		printerror('CloseRegAct','',1);
	}
	$username=trim($add[username]);
	$password=trim($add[password]);
	$email=trim($add[email]);
	$newemail=trim($add[newemail]);
	if(!$username||!$password||!$email)
	{
		printerror("EmptyRegAct","history.go(-1)",1);
	}
	//验证码
	$key=$add['key'];
	$keyvname='checkregsendkey';
	ecmsCheckShowKey($keyvname,$key,1);
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	$username=RepPostStr($username);
	$email=RepPostStr($email);
	$newemail=RepPostStr($newemail);
	if(!chemail($email))
	{
		printerror("EmailFail","history.go(-1)",1);
	}
	if($newemail)
	{
		if(!chemail($newemail))
		{
			printerror("EmailFail","history.go(-1)",1);
		}
		$sendemail=$newemail;
	}
	else
	{
		$sendemail=$email;
	}
	//密码
	$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid,salt,password')." from ".eReturnMemberTable()." where ".egetmf('username')."='$username' limit 1");
	if(!$ur['userid'])
	{
		printerror("ErrorRegActUser","history.go(-1)",1);
	}
	if(!eDoCkMemberPw($password,$ur['password'],$ur['salt']))
	{
		printerror("ErrorRegActUser","history.go(-1)",1);
	}
	$r=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('username')."='$username' limit 1");
	$useremail=$r['email'];
	if(!$r['userid']||$useremail!=$email)
	{
		printerror("ErrorRegActUser","history.go(-1)",1);
	}
	if($r['checked'])
	{
		printerror("HaveRegActUser",'',1);
	}
	$addr=$empire->fetch1("select userid,authstr from {$dbtbpre}enewsmemberpub where userid='".$r['userid']."' limit 1");
	$ar=explode('||',$addr['authstr']);
	if(!$addr['userid']||!$addr['authstr']||$ar[1]!=2)
	{
		printerror("HaveRegActUser",'',1);
	}
	ecmsEmptyShowKey($keyvname);//清空验证码
	SendActUserEmail($r['userid'],$username,$sendemail);
}
?>