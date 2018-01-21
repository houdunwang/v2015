<?php
//--------------- 收藏夹函数 ---------------

//增加收藏
function AddFava($id,$classid,$cid,$from){
	global $empire,$level_r,$class_r,$dbtbpre;
	//是否登陆
	$user_r=islogin();
	$id=(int)$id;
	$cid=(int)$cid;
	$classid=(int)$classid;
	if(empty($id)||empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)",1);
    }
	//表不存在
	if(empty($class_r[$classid][tbname]))
	{
		printerror("ErrorUrl","history.go(-1)",1);
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' and classid='$classid'");
	if(empty($num))
	{printerror("ErrorUrl","history.go(-1)",1);}
	//是否已收藏
	$newsnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsfava where id='$id' and classid='$classid' and userid='$user_r[userid]'");
	if($newsnum)
	{
		printerror("ReFava","history.go(-1)",1);
	}
	$favanum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsfava where userid='$user_r[userid]'");
	$groupid=$user_r[groupid];
	if($level_r[$groupid][favanum]<=$favanum)
	{
		printerror("MoreFava","history.go(-1)",1);
	}
	$favatime=date("Y-m-d H:i:s");
	$sql=$empire->query("insert into {$dbtbpre}enewsfava(id,favatime,userid,username,classid,cid) values('$id','$favatime','$user_r[userid]','$user_r[username]','$classid','$cid');");
	if($sql)
	{
		printerror("AddFavaSuccess",RepPostStrUrl($from),1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//批量删除收藏
function DelFava_All($favaid){
	global $empire,$dbtbpre;
	//是否登陆
	$user_r=islogin();
	$count=count($favaid);
	if(empty($count))
	{printerror("NotDelFavaid","history.go(-1)",1);}
	for($i=0;$i<$count;$i++)
	{
		$add.="favaid='".intval($favaid[$i])."' or ";
    }
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("delete from {$dbtbpre}enewsfava where (".$add.") and userid='$user_r[userid]'");
	if($sql)
	{printerror("DelFavaSuccess","../member/fava/",1);}
	else
	{printerror("DbError","history.go(-1)",1);}
}

//删除单个收藏夹
function DelFava($favaid){
	global $empire,$dbtbpre;
	//是否登陆
	$user_r=islogin();
	$favaid=(int)$favaid;
	if(empty($favaid))
	{printerror("NotDelFavaid","history.go(-1)",1);}
	$sql=$empire->query("delete from {$dbtbpre}enewsfava where favaid='$favaid' and userid='$user_r[userid]'");
	if($sql)
	{printerror("DelFavaSuccess","../member/fava/",1);}
	else
	{printerror("DbError","history.go(-1)",1);}
}


//增加收藏夹分类
function AddFavaClass($add){
	global $empire,$dbtbpre;
	if(!trim($add[cname]))
	{
		printerror('EmptyFavaClassname','history.go(-1)',1);
    }
	//是否登陆
	$user_r=islogin();
	$add[cname]=RepPostStr($add[cname]);
	$sql=$empire->query("insert into {$dbtbpre}enewsfavaclass(cname,userid) values('$add[cname]','$user_r[userid]');");
	if($sql)
	{
		printerror('AddFavaClassSuccess','../member/fava/FavaClass/',1);
	}
	else
	{
		printerror('DbError','history.go(-1)',1);
	}
}

//修改收藏夹分类
function EditFavaClass($add){
	global $empire,$dbtbpre;
	$add[cid]=(int)$add[cid];
	if(!trim($add[cname])||!$add[cid])
	{
		printerror('EmptyFavaClassname','history.go(-1)',1);
    }
	//是否登陆
	$user_r=islogin();
	$add[cname]=RepPostStr($add[cname]);
	$sql=$empire->query("update {$dbtbpre}enewsfavaclass set cname='$add[cname]' where cid='$add[cid]' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror('EditFavaClassSuccess','../member/fava/FavaClass/',1);
	}
	else
	{
		printerror('DbError','history.go(-1)',1);
	}
}

//删除收藏夹分类
function DelFavaClass($cid){
	global $empire,$dbtbpre;
	$cid=(int)$cid;
	if(!$cid)
	{
		printerror('EmptyFavaClassid','history.go(-1)',1);
    }
	//是否登陆
	$user_r=islogin();
	$sql=$empire->query("delete from {$dbtbpre}enewsfavaclass where cid='$cid' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror('DelFavaClassSuccess','../member/fava/FavaClass/',1);
	}
	else
	{
		printerror('DbError','history.go(-1)',1);
	}
}

//返回收藏夹分类
function ReturnFavaclass($userid,$cid){
	global $empire,$dbtbpre;
	$sql=$empire->query("select cid,cname from {$dbtbpre}enewsfavaclass where userid='$userid' order by cid");
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

//批量转移收藏
function MoveFava_All($favaid,$cid){
	global $empire,$dbtbpre;
	//是否登陆
	$user_r=islogin();
	$cid=(int)$cid;
	if(!$cid)
	{printerror("NotChangeMoveCid","history.go(-1)",1);}
	$count=count($favaid);
	if(empty($count))
	{printerror("NotMoveFavaid","history.go(-1)",1);}
	for($i=0;$i<$count;$i++)
	{
		$add.="favaid='".intval($favaid[$i])."' or ";
    }
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update {$dbtbpre}enewsfava set cid=$cid where (".$add.") and userid='$user_r[userid]'");
	if($sql)
	{printerror("MoveFavaSuccess","../member/fava/",1);}
	else
	{printerror("DbError","history.go(-1)",1);}
}
?>