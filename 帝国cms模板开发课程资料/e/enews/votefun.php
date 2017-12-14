<?php
//增加投票
function AddVote($voteid,$vote){
	global $empire,$dbtbpre,$public_r;
	$voteid=(int)$voteid;
	if(empty($voteid))
	{
		printerror("NotVote","history.go(-1)",1);
	}
	$lasttime=getcvar('lastvotetime');
	if($lasttime)
	{
		if(time()-$lasttime<$public_r['revotetime'])
		{
			printerror("VoteOutTime","history.go(-1)",1);
		}
	}
	$r=$empire->fetch1("select voteid,voteip,votetext,voteclass,doip,dotime from {$dbtbpre}enewsvote where voteid='$voteid'");
	if(empty($r['voteid'])||empty($r['votetext']))
	{
		printerror("NotVote","history.go(-1)",1);
	}
	$re=DoVote($r,$vote);
	$sql=$empire->query("update {$dbtbpre}enewsvote set votetext='".addslashes($re['votetext'])."',voteip='$re[voteip]',votenum=votenum+".$re['votetotal']." where voteid='$voteid'");
	if($sql)
	{
		esetcookie("lastvotetime",time(),time()+3600*24);//设置最后发表时间
		printerror("VoteSuccess","../tool/vote/?voteid=".$voteid,1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//添加信息投票
function AddInfoVote($classid,$id,$vote){
	global $empire,$dbtbpre,$class_r,$public_r;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($id)||empty($classid)||!$class_r[$classid]['tbname'])
	{
		printerror("NotVote","history.go(-1)",1);
	}
	$lasttime=getcvar('lastivotetime');
	if($lasttime)
	{
		if(time()-$lasttime<$public_r['revotetime'])
		{
			printerror("VoteOutTime","history.go(-1)",1);
		}
	}
	$pubid=ReturnInfoPubid($classid,$id);
	$r=$empire->fetch1("select id,voteip,votetext,voteclass,doip,dotime from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	if(empty($r['id'])||empty($r['votetext']))
	{
		printerror("NotVote","history.go(-1)",1);
	}
	$re=DoVote($r,$vote);
	$sql=$empire->query("update {$dbtbpre}enewsinfovote set votetext='".addslashes($re['votetext'])."',voteip='$re[voteip]',votenum=votenum+".$re['votetotal']." where pubid='$pubid' limit 1");
	if($sql)
	{
		esetcookie("lastivotetime",time(),time()+3600*24);//设置最后发表时间
		printerror("VoteSuccess","../public/vote/?classid=$classid&id=$id",1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//处理投票
function DoVote($r,$vote){
	//投票期限
	if($r['dotime']<>"0000-00-00")
	{
		$endtime=to_date($r['dotime']);
		if($endtime<time())
		{
			printerror("VoteOutDate","history.go(-1)",1);
		}
	}
	//IP限制
	if(empty($r['voteip']))
	{
		$r['voteip']='|';
	}
	$ip=egetip();
	if($r['doip'])
	{
		if(strstr($r['voteip'],'|'.$ip.'|'))
		{
			printerror("ReVote","history.go(-1)",1);
		}
		$r['voteip']=$r['voteip'].$ip."|";
	}
	$VoteField="::::::";
	$VoteRecord="\r\n";
	$vote_r=explode($VoteRecord,$r['votetext']);
	$new_vote_total=0;
	if($r['voteclass'])//多选
	{
		$vote_count=count($vote);
		if(empty($vote_count))
		{
			printerror("EmptyChangeVote","history.go(-1)",1);
		}
		for($j=0;$j<$vote_count;$j++)
		{
			$new_vote_total++;
			$v_r=explode($VoteField,$vote_r[$vote[$j]-1]);
			if(empty($v_r[0]))
			{
				continue;
			}
			$vote_num=$v_r[1]+1;
			$vote_r[$vote[$j]-1]=$v_r[0].$VoteField.$vote_num;
		}
	}
	else//单选
	{
		if(empty($vote))
		{
			printerror("NotChangeVote","history.go(-1)",1);
		}
		$v_r=explode($VoteField,$vote_r[$vote-1]);
		if(empty($v_r[0]))
		{
			printerror("NotChangeVote","history.go(-1)",1);
		}
		$vote_num=$v_r[1]+1;
		$vote_r[$vote-1]=$v_r[0].$VoteField.$vote_num;
		$new_vote_total=1;
	}
	for($n=0;$n<count($vote_r);$n++)
	{
		$new_votetext.=$vote_r[$n].$VoteRecord;
	}
	$new_votetext=substr($new_votetext,0,strlen($new_votetext)-2);//去掉最后的字符
	//返回数组
	$re['votetotal']=$new_vote_total;
	$re['votetext']=$new_votetext;
	$re['voteip']=$r['voteip'];
	return $re;
}

//评分
function AddInfoPfen($add){
	global $empire,$dbtbpre,$class_r;
	$id=(int)$add['id'];
	$classid=(int)$add['classid'];
	$fen=(int)$add['fen'];
	$doajax=(int)$add['doajax'];
	if(!$id||!$classid||!$class_r[$classid]['tbname'])
	{
		$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
	}
	//连续发表
	if(getcvar('lastforfenid')==$classid.'n'.$id)
	{
		$doajax==1?ajax_printerror('','','ReDoForPl',1):printerror('ReDoForPl','',1);
	}
	//字段
	$fnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where tbname='".$class_r[$classid]['tbname']."' and (f='infopfen' or f='infopfennum')");
	if(empty($fnum))
	{
		$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
	}
	if($fen<1)
	{
		$fen=1;
	}
	if($fen>5)
	{
		$fen=5;
	}
	$sql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid]['tbname']." set infopfen=infopfen+$fen,infopfennum=infopfennum+1 where id='$id' and classid='$classid' limit 1");
	if($sql)
	{
		esetcookie('lastforfenid',$classid.'n'.$id,time()+30*24*3600);	//最后发布
		if($doajax==1)
		{
			$nr=$empire->fetch1("select infopfen,infopfennum from {$dbtbpre}ecms_".$class_r[$classid]['tbname']." where id='$id' and classid='$classid' limit 1");
			$infopfen=$nr[infopfennum]?round($nr[infopfen]/$nr[infopfennum]):0;
			ajax_printerror($infopfen,$add['ajaxarea'],'AddInfoPfen',1);
		}
		else
		{
			printerror('AddInfoPfen',$_SERVER['HTTP_REFERER'],1);
		}
	}
	else
	{
		$doajax==1?ajax_printerror('','','DbError',1):printerror('DbError','',1);
	}
}
?>