<?php
//错误登陆记录
function InsertErrorLoginNum($username,$password,$loginauth,$ip,$time){
	global $empire,$public_r,$dbtbpre;
	//COOKIE
	$loginnum=intval(getcvar('loginnum'));
	$logintime=$time;
	$lastlogintime=intval(getcvar('lastlogintime'));
	if($lastlogintime&&($logintime-$lastlogintime>$public_r['logintime']*60))
	{
		$loginnum=0;
	}
	$loginnum++;
	esetcookie("loginnum",$loginnum,$logintime+3600*24);
	esetcookie("lastlogintime",$logintime,$logintime+3600*24);
	//数据库
	$chtime=$time-$public_r['logintime']*60;
	$empire->query("delete from {$dbtbpre}enewsloginfail where lasttime<$chtime");
	$r=$empire->fetch1("select ip from {$dbtbpre}enewsloginfail where ip='$ip' limit 1");
	if($r['ip'])
	{
		$empire->query("update {$dbtbpre}enewsloginfail set num=num+1,lasttime='$time' where ip='$ip' limit 1");
	}
	else
	{
		$empire->query("insert into {$dbtbpre}enewsloginfail(ip,num,lasttime) values('$ip',1,'$time');");
	}
	//日志
	insert_log($username,$password,0,$ip,$loginauth);
}

//验证登录次数
function CheckLoginNum($ip,$time){
	global $empire,$public_r,$dbtbpre;
	//COOKIE验证
	$loginnum=intval(getcvar('loginnum'));
	$lastlogintime=intval(getcvar('lastlogintime'));
	if($lastlogintime)
	{
		if($time-$lastlogintime<$public_r['logintime']*60)
		{
			if($loginnum>=$public_r['loginnum'])
			{
				printerror("LoginOutNum","index.php");
			}
		}
	}
	//数据库验证
	$chtime=$time-$public_r['logintime']*60;
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsloginfail where ip='$ip' and num>=$public_r[loginnum] and lasttime>$chtime limit 1");
	if($num)
	{
		printerror("LoginOutNum","index.php");
	}
}

//登陆
function login($username,$password,$key,$post){
	global $empire,$public_r,$dbtbpre,$ecms_config;
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	if(!$username||!$password)
	{
		printerror("EmptyKey","index.php");
	}
	//验证码
	$keyvname='checkkey';
	if(!$public_r['adminloginkey'])
	{
		ecmsCheckShowKey($keyvname,$key,0,0);
	}
	if(strlen($username)>30||strlen($password)>30)
	{
		printerror("EmptyKey","index.php");
	}
	$loginip=egetip();
	$logintime=time();
	CheckLoginNum($loginip,$logintime);
	//认证码
	if($ecms_config['esafe']['loginauth']&&$ecms_config['esafe']['loginauth']!=$post['loginauth'])
	{
		InsertErrorLoginNum($username,$password,1,$loginip,$logintime);
		printerror("ErrorLoginAuth","index.php");
	}
	$user_r=$empire->fetch1("select userid,password,salt,salt2,lasttime,lastip,addtime,addip,userprikey,lastipport,addipport from {$dbtbpre}enewsuser where username='".$username."' and checked=0 limit 1");
	if(!$user_r['userid'])
	{
		InsertErrorLoginNum($username,$password,0,$loginip,$logintime);
		printerror("LoginFail","index.php");
	}
	$ch_password=DoEmpireCMSAdminPassword($password,$user_r['salt'],$user_r['salt2']);
	if($user_r['password']!=$ch_password)
	{
		InsertErrorLoginNum($username,$password,0,$loginip,$logintime);
		printerror("LoginFail","index.php");
	}
	//安全问答
	$user_addr=$empire->fetch1("select userid,equestion,eanswer,openip,certkey from {$dbtbpre}enewsuseradd where userid='$user_r[userid]'");
	if(!$user_addr['userid'])
	{
		InsertErrorLoginNum($username,$password,0,$loginip,$logintime);
		printerror("LoginFail","index.php");
	}
	if($user_addr['equestion'])
	{
		$equestion=(int)$post['equestion'];
		$eanswer=$post['eanswer'];
		if($user_addr['equestion']!=$equestion)
		{
			InsertErrorLoginNum($username,$password,0,$loginip,$logintime);
			printerror("LoginFail","index.php");
		}
		$ckeanswer=ReturnHLoginQuestionStr($user_r['userid'],$username,$user_addr['equestion'],$eanswer);
		if($ckeanswer!=$user_addr['eanswer'])
		{
			InsertErrorLoginNum($username,$password,0,$loginip,$logintime);
			printerror("LoginFail","index.php");
		}
	}
	//IP限制
	if($user_addr['openip'])
	{
		eCheckAccessAdminLoginIp($user_addr['openip']);
	}
	//取得随机密码
	$rnd=make_password(20);
	$loginipport=egetipport();
	$sql=$empire->query("update {$dbtbpre}enewsuser set rnd='$rnd',loginnum=loginnum+1,lastip='$loginip',lasttime='$logintime',pretime='$user_r[lasttime]',preip='".RepPostVar($user_r[lastip])."',lastipport='$loginipport',preipport='".RepPostVar($user_r[lastipport])."' where username='$username' limit 1");
	$r=$empire->fetch1("select groupid,userid,styleid,userprikey from {$dbtbpre}enewsuser where username='$username' limit 1");
	//样式
	if(empty($r[styleid]))
	{
		$stylepath=$public_r['defadminstyle']?$public_r['defadminstyle']:1;
	}
	else
	{
		$styler=$empire->fetch1("select path,styleid from {$dbtbpre}enewsadminstyle where styleid='$r[styleid]'");
		if(empty($styler[styleid]))
		{
			$stylepath=$public_r['defadminstyle']?$public_r['defadminstyle']:1;
		}
		else
		{
			$stylepath=$styler['path'];
		}
	}
	//设置备份
	$cdbdata=0;
	$bnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsgroup where groupid='$r[groupid]' and dodbdata=1");
	if($bnum)
	{
		$cdbdata=1;
		$set5=esetcookie("ecmsdodbdata","empirecms",0,1);
    }
	else
	{
		$set5=esetcookie("ecmsdodbdata","",0,1);
	}
	
	ecmsEmptyShowKey($keyvname,0);//清空验证码
	$set4=esetcookie("loginuserid",$r[userid],0,1);
	$set1=esetcookie("loginusername",$username,0,1);
	$set2=esetcookie("loginrnd",$rnd,0,1);
	$set3=esetcookie("loginlevel",$r[groupid],0,1);
	$set5=esetcookie("eloginlic","empirecmslic",0,1);
	$set6=esetcookie("loginadminstyleid",$stylepath,0,1);
	//COOKIE加密验证
	DoEDelFileRnd($r[userid]);
	DoECookieRnd($r[userid],$username,$rnd,$r['userprikey'],$cdbdata,$r[groupid],intval($stylepath),$logintime);
	//最后登陆时间
	$set4=esetcookie("logintime",$logintime,0,1);
	$set5=esetcookie("truelogintime",$logintime,0,1);
	esetcookie('ecertkeyrnds','',0);
	//写入日志
	insert_log($username,'',1,$loginip,0);
	//FireWall
	FWSetPassword();
	if($set1&&$set2&&$set3)
	{
		$cache_enews='doclass,doinfo,douserinfo';
		$cache_ecmstourl='admin.php'.urlencode(hReturnEcmsHashStrDef(1,'ehref'));
		$cache_mess='LoginSuccess';
		$cache_url="CreateCache.php?enews=$cache_enews&ecmstourl=$cache_ecmstourl&mess=$cache_mess".hReturnEcmsHashStrDef(0,'ehref');
		//操作日志
	    insert_dolog("");
		if($post['adminwindow'])
		{
		?>
			<script>
			AdminWin=window.open("<?=$cache_url?>","EmpireCMS","scrollbars");
			AdminWin.moveTo(0,0);
			AdminWin.resizeTo(screen.width,screen.height-30);
			self.location.href="blank.php";
			</script>
		<?
		exit();
		}
		else
		{
			//printerror("LoginSuccess",$cache_url);
			echo'<meta http-equiv="refresh" content="0;url='.$cache_url.'">';
			db_close();
			$empire=null;
			exit();
		}
	}
	else
	{
		printerror("NotCookie","index.php");
	}
}

//写入登录日志
function insert_log($username,$password,$status,$loginip,$loginauth){
	global $empire,$ecms_config,$dbtbpre;
	if($ecms_config['esafe']['theloginlog'])
	{
		return "";
	}
	$password=RepPostVar($password);
	$loginauth=RepPostVar($loginauth);
	$password='';
	if($password)
	{
		$password=preg_replace("/^(.{".round(strlen($password) / 4)."})(.+?)(.{".round(strlen($password) / 6)."})$/s", "\\1***\\3", $password);
	}
	$password=RepPostVar($password);
	$username=RepPostVar($username);
	$loginip=RepPostVar($loginip);
	$ipport=egetipport();
	$status=RepPostVar($status);
	$logintime=date("Y-m-d H:i:s");
	$sql=$empire->query("insert into {$dbtbpre}enewslog(username,loginip,logintime,status,password,loginauth,ipport) values('$username','$loginip','$logintime','$status','$password','$loginauth','$ipport');");
}

//退出登陆
function loginout($userid,$username,$rnd){
	global $empire,$dbtbpre,$ecms_config;
	$userid=(int)$userid;
	if(!$userid||!$username)
	{
		printerror("NotLogin","history.go(-1)");
	}
	$set1=esetcookie("loginuserid","",0,1);
	$set2=esetcookie("loginusername","",0,1);
	$set3=esetcookie("loginrnd","",0,1);
	$set4=esetcookie("loginlevel","",0,1);
	//COOKIERND
	DelECookieRnd();
	DelESessionRnd();
	DelECookieAdminLoginFileInfo();
	//FireWall
	FWEmptyPassword();
	//取得随机密码
	$rnd=make_password(20);
	$sql=$empire->query("update {$dbtbpre}enewsuser set rnd='$rnd' where userid='$userid'");
	DoEDelFileRnd($userid);
	DoEDelAndAuthRnd($userid);
	//操作日志
	insert_dolog("");
	printerror("ExitSuccess","index.php");
}

//验证登录IP
function eCheckAccessAdminLoginIp($openips){
	if(empty($openips))
	{
		return '';
	}
	$userip=egetip();
	//允许IP
	if($openips)
	{
		$close=1;
		foreach(explode("\n",$openips) as $ctrlip)
		{
			if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
			{
				$close=0;
				break;
			}
		}
		if($close==1)
		{
			echo"Ip<font color='#cccccc'>(".$userip.")</font> be prohibited.";
			exit();
		}
	}
}
?>