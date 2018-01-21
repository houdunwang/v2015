<?php
//--------------- 会员好友函数 ---------------

//增加好友
function AddFriend($add){
	global $empire,$dbtbpre;
	//是否登陆
	$user_r=islogin();
	$fname=RepPostVar(trim($add['fname']));
	$add['fcid']=(int)$add['fcid'];
	if(!$fname)
	{
		printerror("EmptyFriend","",1);
	}
	//加自己为好友
	if($fname==$user_r['username'])
	{
		printerror("NotAddFriendSelf","",1);
	}
	$num=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('username')."='$fname' limit 1");
	if(!$num)
	{
		printerror("NotFriendUsername","",1);
	}
	//重复提交
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewshy where fname='$fname' and userid='$user_r[userid]' limit 1");
	if($num)
	{
		printerror("ReAddFriend","",1);
	}
	$cid=(int)$add['cid'];
	$fsay=RepPostStr($add['fsay']);
	$sql=$empire->query("insert into {$dbtbpre}enewshy(userid,fname,cid,fsay) values('$user_r[userid]','".addslashes($fname)."',$cid,'".addslashes($fsay)."');");
	if($sql)
	{
		printerror("AddFriendSuccess","../member/friend/?cid=$add[fcid]",1);
	}
	else
	{
		printerror("DbError","",1);
	}
}

//修改好友
function EditFriend($add){
	global $empire,$dbtbpre;
	//是否登陆
	$user_r=islogin();
	$fid=(int)$add['fid'];
	$fname=RepPostVar(trim($add['fname']));
	$add['fcid']=(int)$add['fcid'];
	if(!$fname||!$fid)
	{
		printerror("EmptyFriend","",1);
	}
	//加自己为好友
	if($fname==$user_r['username'])
	{
		printerror("NotAddFriendSelf","",1);
	}
	$num=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('username')."='$fname' limit 1");
	if(!$num)
	{
		printerror("NotFriendUsername","",1);
	}
	//重复提交
	if($fname!=$add['oldfname'])
	{
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewshy where fname='$fname' and userid='$user_r[userid]' limit 1");
		if($num)
		{
			printerror("ReAddFriend","",1);
		}
	}
	$cid=(int)$add['cid'];
	$fsay=RepPostStr($add['fsay']);
	$sql=$empire->query("update {$dbtbpre}enewshy set fname='".addslashes($fname)."',cid=$cid,fsay='".addslashes($fsay)."' where fid=$fid and userid='$user_r[userid]'");
	if($sql)
	{
		printerror("EditFriendSuccess","../member/friend/?cid=$add[fcid]",1);
	}
	else
	{
		printerror("DbError","",1);
	}
}

//删除好友
function DelFriend($add){
	global $empire,$dbtbpre;
	//是否登陆
	$user_r=islogin();
	$fid=(int)$add['fid'];
	$add['fcid']=(int)$add['fcid'];
	if(!$fid)
	{
		printerror("EmptyFriendId","",1);
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewshy where fid=$fid and userid='$user_r[userid]'");
	if(!$num)
	{
		printerror("EmptyFriendId","",1);
	}
	$sql=$empire->query("delete from {$dbtbpre}enewshy where fid=$fid and userid='$user_r[userid]'");
	if($sql)
	{
		printerror("DelFriendSuccess","../member/friend/?cid=$add[fcid]",1);
	}
	else
	{
		printerror("DbError","",1);
	}
}

//增加好友分类
function AddFriendClass($add){
	global $empire,$dbtbpre;
	if(!trim($add[cname]))
	{
		printerror('EmptyFavaClassname','history.go(-1)',1);
    }
	//是否登陆
	$user_r=islogin();
	$add[cname]=RepPostStr($add[cname]);
	$sql=$empire->query("insert into {$dbtbpre}enewshyclass(cname,userid) values('$add[cname]','$user_r[userid]');");
	if($sql)
	{
		printerror('AddFavaClassSuccess','../member/friend/FriendClass/',1);
	}
	else
	{
		printerror('DbError','history.go(-1)',1);
	}
}

//修改好友分类
function EditFriendClass($add){
	global $empire,$dbtbpre;
	$add[cid]=(int)$add[cid];
	if(!trim($add[cname])||!$add[cid])
	{
		printerror('EmptyFavaClassname','history.go(-1)',1);
    }
	//是否登陆
	$user_r=islogin();
	$add[cname]=RepPostStr($add[cname]);
	$sql=$empire->query("update {$dbtbpre}enewshyclass set cname='$add[cname]' where cid='$add[cid]' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror('EditFavaClassSuccess','../member/friend/FriendClass/',1);
	}
	else
	{
		printerror('DbError','history.go(-1)',1);
	}
}

//删除好友分类
function DelFriendClass($cid){
	global $empire,$dbtbpre;
	$cid=(int)$cid;
	if(!$cid)
	{
		printerror('EmptyFavaClassid','history.go(-1)',1);
    }
	//是否登陆
	$user_r=islogin();
	$sql=$empire->query("delete from {$dbtbpre}enewshyclass where cid='$cid' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror('DelFavaClassSuccess','../member/friend/FriendClass/',1);
	}
	else
	{
		printerror('DbError','history.go(-1)',1);
	}
}

//返回好友分类
function ReturnFriendclass($userid,$cid){
	global $empire,$dbtbpre;
	$sql=$empire->query("select cid,cname from {$dbtbpre}enewshyclass where userid='$userid' order by cid");
	$select='';
	while($r=$empire->fetch($sql))
	{
		if($r[cid]==$cid)
		{$selected=' selected';}
		else
		{$selected='';}
		$select.='<option value="'.$r[cid].'"'.$selected.'>'.$r[cname].'</option>';
    }
	return $select;
}
?>