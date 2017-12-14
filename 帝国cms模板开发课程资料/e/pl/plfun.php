<?php
//发表评论
function AddPl($username,$password,$nomember,$key,$saytext,$id,$classid,$repid,$add){
	global $empire,$dbtbpre,$public_r,$class_r,$level_r;
	//验证本时间允许操作
	eCheckTimeCloseDo('pl');
	//验证IP
	eCheckAccessDoIp('pl');
	$id=(int)$id;
	$repid=(int)$repid;
	$classid=(int)$classid;
	//验证码
	$keyvname='checkplkey';
	if($public_r['plkey_ok'])
	{
		ecmsCheckShowKey($keyvname,$key,1);
	}
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	$muserid=(int)getcvar('mluserid');
	$musername=RepPostVar(getcvar('mlusername'));
	$mgroupid=(int)getcvar('mlgroupid');
	if($muserid)//已登陆
	{
		$cklgr=qCheckLoginAuthstr();
		if($cklgr['islogin'])
		{
			$username=$musername;
		}
		else
		{
			$muserid=0;
		}
	}
	else
	{
		if(empty($nomember))//非匿名
		{
			if(!$username||!$password)
			{
				printerror("FailPassword","history.go(-1)",1);
			}
			$ur=$empire->fetch1("select ".eReturnSelectMemberF('userid,salt,password,checked,groupid')." from ".eReturnMemberTable()." where ".egetmf('username')."='$username' limit 1");
			if(empty($ur['userid']))
			{
				printerror("FailPassword","history.go(-1)",1);
			}
			if(!eDoCkMemberPw($password,$ur['password'],$ur['salt']))
			{
				printerror("FailPassword","history.go(-1)",1);
			}
			if($ur['checked']==0)
			{
				printerror("NotCheckedUser",'',1);
			}
			$muserid=$ur['userid'];
			$mgroupid=$ur['groupid'];
		}
		else
		{
			$muserid=0;
		}
	}
	if($public_r['plgroupid'])
	{
		if(!$muserid)
		{
			printerror("GuestNotToPl","history.go(-1)",1);
		}
		if($level_r[$mgroupid][level]<$level_r[$public_r['plgroupid']][level])
		{
			printerror("NotLevelToPl","history.go(-1)",1);
		}
	}
	//专题
	$doaction=$add['doaction'];
	if($doaction=='dozt')
	{
		if(!trim($saytext)||!$classid)
		{
			printerror("EmptyPl","history.go(-1)",1);
		}
		//是否关闭评论
		$r=$empire->fetch1("select ztid,closepl,checkpl,restb from {$dbtbpre}enewszt where ztid='$classid'");
		if(!$r['ztid'])
		{
			printerror("ErrorUrl","history.go(-1)",1);
		}
		if($r['closepl'])
		{
			printerror("CloseClassPl","history.go(-1)",1);
		}
		//审核
		if($r['checkpl'])
		{$checked=1;}
		else
		{$checked=0;}
		$restb=$r['restb'];
		$pubid='-'.$classid;
		$id=0;
		$pagefunr=eReturnRewritePlUrl($classid,$id,'dozt',0,0,1);
		$returl=$pagefunr['pageurl'];
	}
	else//信息
	{
		if(!trim($saytext)||!$id||!$classid)
		{
			printerror("EmptyPl","history.go(-1)",1);
		}
		//表存在
		if(empty($class_r[$classid][tbname]))
		{
			printerror("ErrorUrl","history.go(-1)",1);
		}
		//是否关闭评论
		$r=$empire->fetch1("select classid,stb,restb from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
		if(!$r['classid']||$r['classid']!=$classid)
		{
			printerror("ErrorUrl","history.go(-1)",1);
		}
		if($class_r[$r[classid]][openpl])
		{
			printerror("CloseClassPl","history.go(-1)",1);
		}
		//单信息关闭评论
		$pubid=ReturnInfoPubid($classid,$id);
		$finfor=$empire->fetch1("select closepl from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_data_".$r['stb']." where id='$id' limit 1");
		if($finfor['closepl'])
		{
			printerror("CloseInfoPl","history.go(-1)",1);
		}
		//审核
		if($class_r[$classid][checkpl])
		{$checked=1;}
		else
		{$checked=0;}
		$restb=$r['restb'];
		$pagefunr=eReturnRewritePlUrl($classid,$id,'doinfo',0,0,1);
		$returl=$pagefunr['pageurl'];
	}
	//设置参数
	$plsetr=$empire->fetch1("select pltime,plsize,plincludesize,plclosewords,plmustf,plf,plmaxfloor,plquotetemp from {$dbtbpre}enewspl_set limit 1");
	if(strlen($saytext)>$plsetr['plsize'])
	{
		$GLOBALS['setplsize']=$plsetr['plsize'];
		printerror("PlSizeTobig","history.go(-1)",1);
	}
	$time=time();
	$saytime=$time;
	$pltime=getcvar('lastpltime');
	if($pltime)
	{
		if($time-$pltime<$plsetr['pltime'])
		{
			$GLOBALS['setpltime']=$plsetr['pltime'];
			printerror("PlOutTime","history.go(-1)",1);
		}
	}
	$sayip=egetip();
	$eipport=egetipport();
	$username=str_replace("\r\n","",$username);
	$username=RepPostStr($username);
	$saytext=nl2br(RepFieldtextNbsp(RepPostStr($saytext)));
	if($repid)
	{
		$saytext=RepPlTextQuote($repid,$saytext,$plsetr,$restb);
		CkPlQuoteFloor($plsetr['plmaxfloor'],$saytext);//验证楼层
	}
	//过滤字符
	$saytext=ReplacePlWord($plsetr['plclosewords'],$saytext);
	if($level_r[$mgroupid]['plchecked'])
	{
		$checked=0;
	}
	$ret_r=ReturnPlAddF($add,$plsetr,0);
	//主表
	$sql=$empire->query("insert into {$dbtbpre}enewspl_".$restb."(pubid,username,sayip,saytime,id,classid,checked,zcnum,fdnum,userid,isgood,saytext,eipport".$ret_r['fields'].") values('$pubid','".$username."','$sayip','$saytime','$id','$classid','$checked',0,0,'$muserid',0,'".addslashes($saytext)."','$eipport'".$ret_r['values'].");");
	$plid=$empire->lastid();
	if($doaction!='dozt')
	{
		//信息表加1
		$usql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]." set plnum=plnum+1 where id='$id' limit 1");
	}
	//更新新评论数
	DoUpdateAddDataNum('pl',$restb,1);
	//设置最后发表时间
	$set1=esetcookie("lastpltime",time(),time()+3600*24);
	ecmsEmptyShowKey($keyvname);//清空验证码
	if($sql)
	{
		$reurl=DoingReturnUrl($returl,$_POST['ecmsfrom']);
		printerror("AddPlSuccess",$reurl,1);
	}
	else
	{printerror("DbError","history.go(-1)",1);}
}

//替换回复
function RepPlTextQuote($repid,$saytext,$pr,$restb){
	global $public_r,$empire,$dbtbpre,$fun_r;
	$quotetemp=stripSlashes($pr['plquotetemp']);
	$r=$empire->fetch1("select userid,username,saytime,saytext from {$dbtbpre}enewspl_".$restb." where plid='$repid'");
	if(empty($r['username']))
	{
		$r['username']=$fun_r['nomember'];
	}
	if($r['userid'])
	{
		$r['username']="<a href=\"$public_r[newsurl]e/space/?userid=$r[userid]\" target=\"_blank\">$r[username]</a>";
	}
	$quotetemp=str_replace('[!--plid--]',$repid,$quotetemp);
	$quotetemp=str_replace('[!--pltime--]',date('Y-m-d H:i:s',$r['saytime']),$quotetemp);
	$quotetemp=str_replace('[!--username--]',$r['username'],$quotetemp);
	$quotetemp=str_replace('[!--pltext--]',$r['saytext'],$quotetemp);
	$restr=$quotetemp.$saytext;
	return $restr;
}

//去掉原引用
function RepYPlQuote($text){
	$preg_str="/<div (.+?)<\/div>/is";
	$text=preg_replace($preg_str,"",$text);
	return $text;
}

//验证引用楼数
function CkPlQuoteFloor($plmaxfloor,$saytext){
	if(!$plmaxfloor)
	{
		return '';
	}
	$fr=explode('<div',$saytext);
	$fcount=count($fr)-1;
	if($fcount>$plmaxfloor)
	{
		printerror('PlOutMaxFloor','history.go(-1)',1);
	}
}

//禁用字符
function ReplacePlWord($plclosewords,$text){
	global $empire,$dbtbpre;
	if(empty($text))
	{
		return $text;
	}
	toCheckCloseWord($text,$plclosewords,'HavePlCloseWords');
	return $text;
}

//返回字段
function ReturnPlAddF($add,$pr,$ecms=0){
	global $empire,$dbtbpre;
	$fr=explode(',',$pr['plf']);
	$count=count($fr)-1;
	$ret_r['fields']='';
	$ret_r['values']='';
	for($i=1;$i<$count;$i++)
	{
		$f=$fr[$i];
		$fval=RepPostStr($add[$f]);
		//必填
		if(strstr($pr[plmustf],','.$f.','))
		{
			if(!trim($fval))
			{
				$chfr=$empire->fetch1("select fname from {$dbtbpre}enewsplf where f='$f' limit 1");
				$GLOBALS['msgmustf']=$chfr['fname'];
				printerror('EmptyPlMustF','',1);
			}
		}
		$fval=nl2br(RepFieldtextNbsp($fval));
		$ret_r['fields'].=",".$f;
		$ret_r['values'].=",'".addslashes($fval)."'";
	}
	return $ret_r;
}

//支持/反对评论
function DoForPl($add){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$add['classid'];
	$id=(int)$add['id'];
	$plid=(int)$add['plid'];
	$dopl=(int)$add['dopl'];
	$doajax=(int)$add['doajax'];
	//专题
	$doaction=$add['doaction'];
	if($doaction=='dozt')
	{
		if(!$classid||!$plid)
		{
			$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
		}
		$infor=$empire->fetch1("select ztid,restb from {$dbtbpre}enewszt where ztid='$classid'");
		if(!$infor['ztid'])
		{
			$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
		}
		$pubid='-'.$classid;
	}
	else//信息
	{
		if(!$classid||!$id||!$plid||!$class_r[$classid][tbname])
		{
			$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
		}
		$infor=$empire->fetch1("select classid,restb from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
		if(!$infor['classid'])
		{
			$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
		}
		$pubid=ReturnInfoPubid($classid,$id);
	}
	//连续发表
	if(getcvar('lastforplid'.$plid))
	{
		$doajax==1?ajax_printerror('','','ReDoForPl',1):printerror('ReDoForPl','',1);
	}
	if($dopl==1)
	{
		$f='zcnum';
		$msg='DoForPlGSuccess';
	}
	else
	{
		$f='fdnum';
		$msg='DoForPlBSuccess';
	}
	$sql=$empire->query("update {$dbtbpre}enewspl_".$infor['restb']." set ".$f."=".$f."+1 where plid='$plid' and pubid='$pubid'");
	if($sql)
	{
		esetcookie('lastforplid'.$plid,$plid,time()+30*24*3600);	//最后发布
		if($doajax==1)
		{
			$nr=$empire->fetch1("select ".$f." from {$dbtbpre}enewspl_".$infor['restb']." where plid='$plid' and pubid='$pubid'");
			ajax_printerror($nr[$f],$add['ajaxarea'],$msg,1);
		}
		else
		{
			printerror($msg,$_SERVER['HTTP_REFERER'],1);
		}
	}
	else
	{
		$doajax==1?ajax_printerror('','','DbError',1):printerror('DbError','',1);
	}
}
?>