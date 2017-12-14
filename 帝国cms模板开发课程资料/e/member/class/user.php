<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
define('InEmpireCMSUser',TRUE);

//--------------- 扩展函数 ---------------

//登录附加cookie
function AddLoginCookie($r){
}

//--------------- 会员表信息函数 ---------------

//返回会员表
function eReturnMemberTable(){
	global $ecms_config;
	return $ecms_config['member']['tablename'];
}

//返回默认会员组ID
function eReturnMemberDefGroupid(){
	global $ecms_config,$public_r;
	$groupid=$ecms_config['member']['defgroupid']?$ecms_config['member']['defgroupid']:$public_r['defaultgroupid'];
	return intval($groupid);
}

//返回查询会员字段列表
function eReturnSelectMemberF($f,$tb=''){
	global $ecms_config;
	if(empty($ecms_config['member']['chmember']))
	{
		if(!empty($tb))
		{
			$f=$f=='*'?$tb.$f:$tb.str_replace(',',','.$tb,$f);
		}
		return $f;
	}
	if($f=='*')
	{
		$f='userid,username,password,rnd,email,registertime,groupid,userfen,userdate,money,zgroupid,havemsg,checked,salt,userkey';
	}
	$r=explode(',',$f);
	$count=count($r);
	$selectf='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$truef=$r[$i];
		if($ecms_config['memberf'][$truef]==$truef)
		{
			$selectf.=$dh.$tb.$truef;
		}
		else
		{
			$selectf.=$dh.$tb.$ecms_config['memberf'][$truef].' as '.$truef;
		}
		$dh=',';
	}
	return $selectf;
}

//返回插入会员字段列表
function eReturnInsertMemberF($f){
	global $ecms_config;
	if(empty($ecms_config['member']['chmember']))
	{
		return $f;
	}
	$r=explode(',',$f);
	$count=count($r);
	$insertf='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$truef=$r[$i];
		$insertf.=$dh.$ecms_config['memberf'][$truef];
		$dh=',';
	}
	return $insertf;
}

//取得实际会员字段
function egetmf($f){
	global $ecms_config;
	if(empty($ecms_config['member']['chmember']))
	{
		return $f;
	}
	return $ecms_config['memberf'][$f]?$ecms_config['memberf'][$f]:$f;
}

//密码
function eDoMemberPw($password,$salt){
	global $ecms_config;
	if($ecms_config['member']['pwtype']==0)//单重md5
	{
		$pw=md5($password);
	}
	elseif($ecms_config['member']['pwtype']==1)//明码
	{
		$pw=$password;
	}
	elseif($ecms_config['member']['pwtype']==3)//16位md5
	{
		$pw=substr(md5($password),8,16);
	}
	else//双重md5
	{
		$pw=md5(md5($password).$salt);
	}
	return $pw;
}

//验证密码
function eDoCkMemberPw($oldpw,$pw,$salt){
	global $ecms_config;
	$istrue=0;
	if($ecms_config['member']['pwtype']==0)//单重md5
	{
		$oldpw=md5($oldpw);
		if($oldpw==$pw)
		{
			$istrue=1;
		}
	}
	elseif($ecms_config['member']['pwtype']==1)//明码
	{
		if($oldpw==$pw)
		{
			$istrue=1;
		}
	}
	elseif($ecms_config['member']['pwtype']==3)//16位md5
	{
		$oldpw=substr(md5($oldpw),8,16);
		if($oldpw==$pw)
		{
			$istrue=1;
		}
	}
	else//双重md5
	{
		$oldpw=md5(md5($oldpw).$salt);
		if($oldpw==$pw)
		{
			$istrue=1;
		}
	}
	return $istrue;
}

//返回注册时间
function eReturnMemberRegtime($regtime,$format){
	global $ecms_config;
	return empty($ecms_config['member']['regtimetype'])?$regtime:date($format,$regtime);
}

//返回注册时间(int)
function eReturnMemberIntRegtime($regtime){
	global $ecms_config;
	return empty($ecms_config['member']['regtimetype'])?to_time($regtime):$regtime;
}

//返回当前注册时间
function eReturnAddMemberRegtime(){
	global $ecms_config;
	return empty($ecms_config['member']['regtimetype'])?date('Y-m-d H:i:s'):time();
}

//返回SALT
function eReturnMemberSalt(){
	global $ecms_config;
	return make_password($ecms_config['member']['saltnum']);
}

//返回UserKey
function eReturnMemberUserKey(){
	global $ecms_config;
	return make_password(12);
}

//启动易通行系统
function DoEpassport($ecms,$userid,$username,$password,$salt,$email,$groupid,$retime){
	global $ecms_config;
	return '';
	if(!$ecms_config['epassport']['open'])
	{
		return '';
	}
	include_once ECMS_PATH.'e/epassport/epp_config.php';
	include_once ECMS_PATH.'e/epassport/epp_function.php';
	$r=DoEpassportVar($userid,$username,$password,$salt,$email,$groupid,$retime);
	epassport_doaction($r,$ecms);
}

//易通行系统变量
function DoEpassportVar($userid,$username,$password,$salt,$email,$groupid,$retime){
	$r['userid']=$userid;
	$r['username']=$username;
	$r['password']=$password;
	$r['salt']=$salt;
	$r['email']=$email;
	$r['groupid']=$groupid;
	$r['retime']=$retime;
	return $r;
}

//--------------- 会员公共函数 ---------------

//返回设置短消息
function eReturnSetHavemsg($havemsg,$ecms=0){
	$newhavemsg=1;
	if($havemsg==3)//全部信息
	{
		$newhavemsg=3;
	}
	elseif($havemsg==2)//通知
	{
		$newhavemsg=$ecms==1?2:3;
	}
	elseif($havemsg==1)//消息
	{
		$newhavemsg=$ecms==1?3:1;
	}
	else //无状态
	{
		$newhavemsg=$ecms==1?2:1;
	}
	return $newhavemsg;
}

//取得表单id
function GetMemberFormId($groupid){
	global $empire,$dbtbpre;
	$groupid=(int)$groupid;
	$r=$empire->fetch1("select formid from {$dbtbpre}enewsmembergroup where groupid='$groupid'");
	return $r['formid'];
}

//取得邮件地址
function GetUserEmail($userid,$username){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select ".eReturnSelectMemberF('email')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid' limit 1");
	return $r['email'];
}

//返回修改资料
function ReturnUserInfo($userid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select ".eReturnSelectMemberF('username,email,groupid,userfen,money,userdate,zgroupid,checked,registertime')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid' limit 1");
	return $r;
}

//返回是否审核
function ReturnGroupChecked($groupid){
	global $level_r;
	if($level_r[$groupid]['regchecked']==1)
	{
		$checked=0;
	}
	else
	{
		$checked=1;
	}
	return $checked;
}

//返回使用空间模板
function ReturnGroupSpaceStyleid($groupid){
	global $level_r;
	$spacestyleid=$level_r[$groupid]['spacestyleid']?$level_r[$groupid]['spacestyleid']:0;
	return intval($spacestyleid);
}

//清空COOKIE
function EmptyEcmsCookie(){
	$set1=esetcookie("mlusername","",0);
	$set2=esetcookie("mluserid","",0);
	$set3=esetcookie("mlgroupid","",0);
	$set4=esetcookie("mlrnd","",0);
	$set5=esetcookie("mlauth","",0);
}

//登录验证符
function qGetLoginAuthstr($userid,$username,$rnd,$groupid,$cookietime=0){
	global $ecms_config;
	$checkpass=md5(md5($rnd.'-'.$userid.'-'.$username.'-'.$groupid).'-#empire.cms!-'.$ecms_config['cks']['ckrndtwo']);
	esetcookie('mlauth',$checkpass,$cookietime);
}

//验证登录验证符
function qCheckLoginAuthstr(){
	global $ecms_config;
	$re['userid']='';
	$re['username']='';
	$re['groupid']='';
	$re['rnd']='';
	$re['islogin']=0;
	$checkpass=getcvar('mlauth');
	if(!$checkpass)
	{
		return $re;
	}
	$re['userid']=(int)getcvar('mluserid');
	$re['username']=RepPostVar(getcvar('mlusername'));
	$re['rnd']=RepPostVar(getcvar('mlrnd'));
	$re['groupid']=(int)getcvar('mlgroupid');
	$pass=md5(md5($re['rnd'].'-'.$re['userid'].'-'.$re['username'].'-'.$re['groupid']).'-#empire.cms!-'.$ecms_config['cks']['ckrndtwo']);
	if($pass!=$checkpass)
	{
		return $re;
	}
	else
	{
		$re['islogin']=1;
		return $re;
	}
}

//是否登录
function islogin($uid=0,$uname='',$urnd=''){
	global $empire,$dbtbpre,$public_r,$ecmsreurl,$ecms_config;
	if($uid)
	{$userid=(int)$uid;}
	else
	{$userid=(int)getcvar('mluserid');}
	if($uname)
	{$username=$uname;}
	else
	{$username=getcvar('mlusername');}
	$username=RepPostVar($username);
	if($urnd)
	{$rnd=$urnd;}
	else
	{$rnd=getcvar('mlrnd');}
	if($ecms_config['member']['loginurl'])
	{$gotourl=$ecms_config['member']['loginurl'];}
	else
	{$gotourl=$public_r['newsurl']."e/member/login/";}
	$petype=1;
	$rnd=RepPostVar($rnd);
	if(!$userid||!$username||!$rnd)
	{
		if(!getcvar('returnurl'))
		{
			esetcookie("returnurl",RepPostStrUrl($_SERVER['HTTP_REFERER']),0);
		}
		if($ecmsreurl==1)
		{
			$gotourl="history.go(-1)";
			$petype=9;
		}
		elseif($ecmsreurl==2)
		{
			$phpmyself=urlencode(eReturnSelfPage(1));
			$gotourl=$public_r['newsurl']."e/member/login/login.php?prt=1&from=".$phpmyself;
			$petype=9;
		}
		printerror("NotLogin",$gotourl,$petype);
	}
	$cr=$empire->fetch1("select ".eReturnSelectMemberF('userid,username,email,groupid,userfen,money,userdate,zgroupid,havemsg,checked,registertime')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid' and ".egetmf('username')."='$username' and ".egetmf('rnd')."='$rnd' limit 1");
	if(!$cr['userid'])
	{
		EmptyEcmsCookie();
		if(!getcvar('returnurl'))
		{
			esetcookie("returnurl",RepPostStrUrl($_SERVER['HTTP_REFERER']),0);
		}
		if($ecmsreurl==1)
		{
			$gotourl="history.go(-1)";
			$petype=9;
		}
		elseif($ecmsreurl==2)
		{
			$phpmyself=urlencode(eReturnSelfPage(1));
			$gotourl=$public_r['newsurl']."e/member/login/login.php?prt=1&from=".$phpmyself;
			$petype=9;
		}
		printerror("NotSingleLogin",$gotourl,$petype);
	}
	if($cr['checked']==0)
	{
		EmptyEcmsCookie();
		if($ecmsreurl==1)
		{
			$gotourl="history.go(-1)";
			$petype=9;
		}
		elseif($ecmsreurl==2)
		{
			$phpmyself=urlencode(eReturnSelfPage(1));
			$gotourl=$public_r['newsurl']."e/member/login/login.php?prt=1&from=".$phpmyself;
			$petype=9;
		}
		printerror("NotCheckedUser",'',$petype);
	}
	//默认会员组
	if(empty($cr['groupid']))
	{
		$user_groupid=eReturnMemberDefGroupid();
		$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('groupid')."='$user_groupid' where ".egetmf('userid')."='".$cr[userid]."'");
		$cr['groupid']=$user_groupid;
	}
	//是否过期
	if($cr['userdate'])
	{
		if($cr['userdate']-time()<=0)
		{
			OutTimeZGroup($cr['userid'],$cr['zgroupid']);
			$cr['userdate']=0;
			if($cr['zgroupid'])
			{
				$cr['groupid']=$cr['zgroupid'];
				$cr['zgroupid']=0;
			}
		}
	}
	$re[userid]=$cr['userid'];
	$re[rnd]=$rnd;
	$re[username]=$cr['username'];
	$re[email]=$cr['email'];
	$re[userfen]=$cr['userfen'];
	$re[money]=$cr['money'];
	$re[groupid]=$cr['groupid'];
	$re[userdate]=$cr['userdate'];
	$re[zgroupid]=$cr['zgroupid'];
	$re[havemsg]=$cr['havemsg'];
	$re[registertime]=$cr['registertime'];
	return $re;
}

//会员登录
function DoEcmsMemberLogin($r,$lifetime=0){
	global $empire,$dbtbpre,$ecms_config;
	$rnd=make_password(20);//取得随机密码
	//默认会员组
	if(empty($r['groupid']))
	{
		$r['groupid']=eReturnMemberDefGroupid();
	}
	$r['groupid']=(int)$r['groupid'];
	$empire->query("update ".eReturnMemberTable()." set ".egetmf('rnd')."='$rnd',".egetmf('groupid')."='$r[groupid]' where ".egetmf('userid')."='$r[userid]'");
	//设置cookie
	$lifetime=(int)$lifetime;
	$logincookie=0;
	if($lifetime)
	{
		$logincookie=time()+$lifetime;
	}
	esetcookie("mlusername",$r['username'],$logincookie);
	esetcookie("mluserid",$r['userid'],$logincookie);
	esetcookie("mlgroupid",$r['groupid'],$logincookie);
	esetcookie("mlrnd",$rnd,$logincookie);
	//验证符
	qGetLoginAuthstr($r['userid'],$r['username'],$rnd,$r['groupid'],$logincookie);
	//登录附加cookie
	AddLoginCookie($r);
}

//验证会员帐号和密码
function DoEcmsMemberCheckUserPass($add){
	global $empire,$dbtbpre,$ecms_config;
	$dopr=1;
	if($_POST['prtype'])
	{
		$dopr=9;
	}
	$username=trim($add['username']);
	$password=trim($add['password']);
	if(!$username||!$password)
	{
		printerror("EmptyLogin","history.go(-1)",$dopr);
	}
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	$num=0;
	$r=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('username')."='$username' limit 1");
	if(!$r['userid'])
	{
		printerror("FailPassword","history.go(-1)",$dopr);
	}
	if(!eDoCkMemberPw($password,$r['password'],$r['salt']))
	{
		printerror("FailPassword","history.go(-1)",$dopr);
	}
	if($r['checked']==0)
	{
		printerror('NotCheckedUser','',$dopr);
	}
	return $r;
}

//--------------- 其他函数 ---------------

//增加点数
function AddInfoFen($cardfen,$userid,$checkfen=1){
	global $empire,$dbtbpre;
	$cardfen=(int)$cardfen;
	if(!$cardfen)
	{
		return '';
	}
	//checkfen
	if($checkfen==1)
	{
		if($cardfen<0)
		{
			$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid,userdate,userfen')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid' limit 1");
			if(!$ur['userid'])
			{
				return '';
			}
			if($ur['userdate']-time()>0)
			{
				return '';
			}
			if($cardfen+$ur['userfen']<0)
			{
				$cardfen=$ur['userfen']*-1;
			}
		}
	}
	$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userfen')."=".egetmf('userfen')."+".$cardfen." where ".egetmf('userid')."='$userid'");
}

//转向会员组
function OutTimeZGroup($userid,$zgroupid){
	global $empire,$dbtbpre;
	if($zgroupid)
	{
		$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('groupid')."='".$zgroupid."',".egetmf('userdate')."=0 where ".egetmf('userid')."='$userid'");
	}
	else
	{
		$sql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userdate')."=0 where ".egetmf('userid')."='$userid'");
	}
}

//充值
function eAddFenToUser($fen,$date,$groupid,$zgroupid,$user){
	global $empire,$dbtbpre,$public_r;
	if(!($fen||$date))
	{
		return '';
	}
	$update='';
	//积分
	if($fen)
	{
		$update.=egetmf('userfen')."=".egetmf('userfen')."+$fen";
	}
	//有效期
	if($date)
	{
		$dh='';
		if($update)
		{
			$dh=',';
		}
		if($user[userdate]<time())
		{
			$userdate=time()+$date*24*3600;
		}
		else
		{
			$userdate=$user[userdate]+$date*24*3600;
		}
		$update.=$dh.egetmf('userdate')."='$userdate'";
		//转向会员组
		if($groupid)
		{
			$update.=",".egetmf('groupid')."='$groupid'";
		}
		if($zgroupid)
		{
			$update.=",".egetmf('zgroupid')."='$zgroupid'";
		}
	}
	$sql=$empire->query("update ".eReturnMemberTable()." set ".$update." where ".egetmf('userid')."='".$user[userid]."'");
	if(!$sql)
	{
		printerror('DbError',$public_r[newsurl],1);
	}
}

//检查下载数
function DoCheckMDownNum($userid,$groupid,$ecms=0){
	global $empire,$dbtbpre,$level_r;
	$ur=$empire->fetch1("select userid,todaydate,todaydown from {$dbtbpre}enewsmemberpub where userid='$userid' limit 1");
	$thetoday=date("Y-m-d");
	if($ur['userid'])
	{
		if($thetoday!=$ur['todaydate'])
		{
			$query="update {$dbtbpre}enewsmemberpub set todaydate='$thetoday',todaydown=1 where userid='$userid'";
		}
		else
		{
			if($ur['todaydown']>=$level_r[$groupid]['daydown'])
			{
				if($ecms==1)
				{
					exit();
				}
				elseif($ecms==2)
				{
					return 'error';
				}
				else
				{
					printerror("CrossDaydown","history.go(-1)",1);
				}
			}
			$query="update {$dbtbpre}enewsmemberpub set todaydown=todaydown+1 where userid='$userid'";
		}
	}
	else
	{
		$query="replace into {$dbtbpre}enewsmemberpub(userid,todaydate,todaydown) values('$userid','$thetoday',1);";
	}
	return $query;
}

//更新激活认证码
function DoUpdateMemberAuthstr($userid,$authstr){
	global $empire,$dbtbpre;
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmemberpub where userid='$userid' limit 1");
	if($num)
	{
		$sql=$empire->query("update {$dbtbpre}enewsmemberpub set authstr='$authstr' where userid='$userid'");
	}
	else
	{
		$sql=$empire->query("replace into {$dbtbpre}enewsmemberpub(userid,authstr) values('$userid','$authstr');");
	}
	return $sql;
}
?>