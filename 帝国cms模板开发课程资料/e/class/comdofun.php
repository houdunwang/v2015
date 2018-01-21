<?php
//批量更新相关链接
function ChangeInfoOtherLink($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"changedata");
	$start=(int)$start;
	$tbname=RepPostVar($tbname);
	if(empty($tbname)||!eCheckTbname($tbname))
	{
		printerror("ErrorUrl","history.go(-1)");
    }
	//按栏目刷新
	$classid=(int)$classid;
	if($classid)
	{
		if(empty($class_r[$classid][islast]))//父栏目
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//终极栏目
		{
			$where="classid='$classid'";
		}
		$add1=" and (".$where.")";
    }
	//按ID刷新
	if($retype)
	{
		$startid=(int)$startid;
		$endid=(int)$endid;
		if($endid)
		{
			$add1.=" and id>=$startid and id<=$endid";
	    }
    }
	else
	{
		$startday=RepPostVar($startday);
		$endday=RepPostVar($endday);
		if($startday&&$endday)
		{
			$add1.=" and truetime>=".to_time($startday." 00:00:00")." and truetime<=".to_time($endday." 23:59:59");
	    }
    }
	$b=0;
	$sql=$empire->query("select id,classid,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[infolinknum]);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r[id];
		//手动相关链接
		$pubid=ReturnInfoPubid($r['classid'],$r['id']);
		$infopr=$empire->fetch1("select diyotherlink from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
		if($infopr['diyotherlink'])
		{
			continue;
		}
		//返回表
		$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
		$infor=$empire->fetch1("select stb,keyboard from ".$infotb." where id='$r[id]' limit 1");
		//返回表信息
		$infodatatb=ReturnInfoDataTbname($tbname,$r['checked'],$infor['stb']);
		$newkeyid=GetKeyid($infor[keyboard],$r[classid],$r[id],$class_r[$r[classid]][link_num]);
		$usql=$empire->query("update ".$infodatatb." set keyid='$newkeyid' where id='$r[id]' limit 1");
	}
	if(empty($b))
	{
	    insert_dolog("");//操作日志
		printerror("ChangeInfoLinkSuccess",$from);
	}
	echo $fun_r[OneChangeInfoLinkSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmscom.php?enews=ChangeInfoOtherLink&tbname=$tbname&classid=$classid&start=$new_start&from=".urlencode($from)."&retype=$retype&startday=$startday&endday=$endday&startid=$startid&endid=$endid".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//检测目录已存在
function CheckPath($classpath){
	global $fun_r;
	if(empty($classpath)){
		echo $fun_r['EmptyPath'];
	}
	else{
		if(file_exists("../../".$classpath)){
			echo $fun_r['RePath'];
		}
		else{
			echo $fun_r['PathNot'];
		}
	}
	exit();
}

//增加自定义页面
function AddUserpage($add,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"userpage");
	$classid=(int)$add[classid];
	$title=$add['title'];
	$path=$add['path'];
	$pagetext=$add['pagetext'];
	if(empty($title)||empty($path))
	{
		printerror("EmptyUserpagePath","history.go(-1)");
    }
	$pagetext=RepPhpAspJspcode($pagetext);
	$pagetitle=RepPhpAspJspcode($add[pagetitle]);
	$pagekeywords=RepPhpAspJspcode($add[pagekeywords]);
	$pagedescription=RepPhpAspJspcode($add[pagedescription]);
	$tempid=(int)$add['tempid'];
	$gid=(int)$add['gid'];
	$sql=$empire->query("insert into {$dbtbpre}enewspage(title,path,pagetext,classid,pagetitle,pagekeywords,pagedescription,tempid) values('$title','$path','".eaddslashes2($pagetext)."','$classid','".eaddslashes($pagetitle)."','".eaddslashes($pagekeywords)."','".eaddslashes($pagedescription)."','$tempid');");
	$id=$empire->lastid();
	ReUserpage($id,$pagetext,$path,$title,$pagetitle,$pagekeywords,$pagedescription,$tempid);
	if($sql)
	{
		//操作日志
	    insert_dolog("id=$id&title=$title");
		printerror("AddUserpageSuccess","template/AddPage.php?enews=AddUserpage&gid=$gid&ChangePagemod=$add[pagemod]".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改自定义页面
function EditUserpage($add,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"userpage");
	$id=(int)$add['id'];
	$classid=(int)$add[classid];
	$title=$add['title'];
	$path=$add['path'];
	$pagetext=$add['pagetext'];
	if(!$id||empty($title)||empty($path))
	{
		printerror("EmptyUserpagePath","history.go(-1)");
    }
	//改变地址
	if($add['oldpath']<>$path)
	{
		DelFiletext($add['oldpath']);
	}
	$pagetext=RepPhpAspJspcode($pagetext);
	$pagetitle=RepPhpAspJspcode($add[pagetitle]);
	$pagekeywords=RepPhpAspJspcode($add[pagekeywords]);
	$pagedescription=RepPhpAspJspcode($add[pagedescription]);
	$tempid=(int)$add['tempid'];
	$gid=(int)$add['gid'];
	$sql=$empire->query("update {$dbtbpre}enewspage set title='$title',path='$path',pagetext='".eaddslashes2($pagetext)."',classid='$classid',pagetitle='".eaddslashes($pagetitle)."',pagekeywords='".eaddslashes($pagekeywords)."',pagedescription='".eaddslashes($pagedescription)."',tempid='$tempid' where id='$id'");
	ReUserpage($id,$pagetext,$path,$title,$pagetitle,$pagekeywords,$pagedescription,$tempid);
	if($sql)
	{
		//操作日志
	    insert_dolog("id=$id&title=$title");
		printerror("EditUserpageSuccess","template/ListPage.php?classid=$add[cid]&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除自定义页面
function DelUserpage($id,$cid,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"userpage");
	$id=(int)$id;
	if(empty($id))
	{
		printerror("EmptyDelUserpageid","history.go(-1)");
    }
	$gid=(int)$_GET['gid'];
	$r=$empire->fetch1("select title,id,path from {$dbtbpre}enewspage where id='$id'");
	if(empty($r['id']))
	{
		printerror("NotDelUserpageid","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewspage where id='$id'");
	DelFiletext($r['path']);
	if($sql)
	{
		//操作日志
	    insert_dolog("id=$id&title=$r[title]");
		printerror("DelUserpageSuccess","template/ListPage.php?classid=$cid&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//刷新自定义页面
function DoReUserpage($add,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"userpage");
	$id=$add['id'];
	$count=count($id);
	if(!$count)
	{
		printerror("EmptyReUserpageid","history.go(-1)");
    }
	for($i=0;$i<$count;$i++)
	{
		$id[$i]=(int)$id[$i];
		if(empty($id[$i]))
		{
			continue;
		}
		$ur=$empire->fetch1("select id,path,pagetext,title,pagetitle,pagekeywords,pagedescription,tempid from {$dbtbpre}enewspage where id='".$id[$i]."'");
		ReUserpage($ur[id],$ur[pagetext],$ur[path],$ur[title],$ur[pagetitle],$ur[pagekeywords],$ur[pagedescription],$ur[tempid]);
	}
	//操作日志
	insert_dolog("");
	printerror("DoReUserpageSuccess",$_SERVER['HTTP_REFERER']);
}

//批量替换字段值
function DoRepNewstext($start,$oldword,$newword,$field,$classid,$tid,$tbname,$over,$dozz,$dotxt,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre,$emod_r;
	$tbname=RepPostVar($tbname);
	$field=RepPostVar($field);
	$tid=(int)$tid;
	$dotype=(int)$_POST['dotype'];
	$classid=(int)$classid;
	if(!$field||empty($tbname)||!$tid)
	{
		printerror("FailCX","history.go(-1)");
	}
	if($dotype==0&&strlen($oldword)==0)
	{
		printerror("FailCX","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"repnewstext");//验证权限
	//变量替换
	$postoldword=ClearAddsData($oldword);
	$postnewword=ClearAddsData($newword);
	//替换条件
	if($classid)//按栏目替换
	{
		if(empty($class_r[$classid][islast]))//中级栏目
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//终极栏目
		{
			$where="classid='$classid'";
		}
		$add1=" and (".$where.")";
		$add2=" where (".$where.")";
    }
	$fr=$empire->fetch1("select tid,savetxt,tbdataf from {$dbtbpre}enewsf where tbname='$tbname' and f='$field' limit 1");
	//系统字段
	$specialdatafield=',keyid,dokey,newstempid,closepl,haveaddfen,infotags,';
	if(!$fr['tid']&&stristr($specialdatafield,','.$field.','))
	{
		$fr['tbdataf']=1;
	}
	//覆盖方式
	if($dotype==1)
	{
		$repoldword=addslashes($oldword);
		$repnewword=addslashes($newword);
		if($over==1)//完全替换
		{
			if(empty($add2))
			{
				$and=" where ";
			}
			else
			{
				$and=" and ";
			}
			$add2.=$and.$field."='".$repoldword."'";
		}
		if($fr['tbdataf'])//副表
		{
			//已审核
			$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
			if($tbr['datatbs'])
			{
				$dtbr=explode(',',$tbr['datatbs']);
				$count=count($dtbr);
				for($i=1;$i<$count-1;$i++)
				{
					$empire->query("update {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." set ".$field."='$repnewword'".$add2);
				}
			}
			//未审核
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check_data set ".$field."='$repnewword'".$add2);
		}
		else//主表
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname." set ".$field."='$repnewword'".$add2);
			//未审核
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check set ".$field."='$repnewword'".$add2);
		}
		//替换完毕
		insert_dolog("tbname=".$tbname."&field=".$field."&dotype=1<br>oldword=".$oldword."<br>newword=".$newword);//操作日志
		printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
	}
	//存文本替换
	elseif($fr['savetxt'])
	{
		$repoldword=addslashes($postoldword);
		$repnewword=addslashes($postnewword);
		//字段
		$selectf=$fr['tbdataf']?',stb':','.$field;
		$fieldform="<input type='hidden' name='field' value='".$field."'>";
		if(empty($public_r[dorepnum]))
		{
			$public_r[dorepnum]=600;
		}
		$start=(int)$start;
		$b=0;
		$sql=$empire->query("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[dorepnum]);
		while($r=$empire->fetch($sql))
		{
			$b=1;
			$newstart=$r[id];
			//返回表
			$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
			//主表
			$infor=$empire->fetch1("select isurl".$selectf." from ".$infotb." where id='$r[id]' limit 1");
			if($infor['isurl'])
			{
				continue;
			}
			//副表
			if($fr['tbdataf'])
			{
				//返回表信息
				$infodatatb=ReturnInfoDataTbname($tbname,$r['checked'],$infor['stb']);
				$finfor=$empire->fetch1("select ".$field." from ".$infodatatb." where id='$r[id]' limit 1");
				$infor[$field]=$finfor[$field];
			}
			$value=GetTxtFieldText($infor[$field]);
			if(empty($value))
			{
				continue;
			}
			if($dozz==1)//正则
			{
				$newvalue=DoRepNewstextZz($repoldword,$repnewword,$value);//正则替换
			}
			else//普通
			{
				if(!stristr($value,$repoldword))
				{
					continue;
				}
				$newvalue=str_replace($repoldword,$repnewword,$value);
			}
			EditTxtFieldText($infor[$field],$newvalue);
		}
		//替换完毕
		if(empty($b))
		{
			insert_dolog("tbname=".$tbname."&field=".$field."<br>oldword=".$oldword."<br>newword=".$newword);//操作日志
			printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
		}
		EchoRepFieldForm($tid,$tbname,$over,$dozz,$dotxt,$newstart,$fieldform,$classid,$postoldword,$postnewword);
	}
	//正则替换
	elseif($dozz==1)
	{
		//字段
		$selectf=$fr['tbdataf']?',stb':','.$field;
		$fieldform="<input type='hidden' name='field' value='".$field."'>";
		if(empty($public_r[dorepnum]))
		{
			$public_r[dorepnum]=600;
		}
		$start=(int)$start;
		$b=0;
		$sql=$empire->query("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[dorepnum]);
		while($r=$empire->fetch($sql))
		{
			$b=1;
			$newstart=$r[id];
			//返回表
			$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
			//主表
			$infor=$empire->fetch1("select isurl".$selectf." from ".$infotb." where id='$r[id]' limit 1");
			if($infor['isurl'])
			{
				continue;
			}
			if($fr['tbdataf'])//副表
			{
				//返回表信息
				$infodatatb=ReturnInfoDataTbname($tbname,$r['checked'],$infor['stb']);
				$finfor=$empire->fetch1("select ".$field." from ".$infodatatb." where id='$r[id]' limit 1");
				$newvalue=DoRepNewstextZz($oldword,$newword,stripSlashes($finfor[$field]));//正则替换
				$empire->query("update ".$infodatatb." set ".$field."='".addslashes($newvalue)."' where id='$r[id]'");
			}
			else//主表
			{
				$newvalue=DoRepNewstextZz($oldword,$newword,stripSlashes($infor[$field]));//正则替换
				$empire->query("update ".$infotb." set ".$field."='".addslashes($newvalue)."' where id='$r[id]'");
			}
		}
		//替换完毕
		if(empty($b))
		{
			insert_dolog("tbname=".$tbname."&field=".$field."<br>oldword=".$oldword."<br>newword=".$newword);//操作日志
			printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
		}
		EchoRepFieldForm($tid,$tbname,$over,$dozz,$dotxt,$newstart,$fieldform,$classid,$postoldword,$postnewword);
	}
	//普通替换
	else
	{
		$repoldword=eaddslashes2($oldword);
		$repnewword=eaddslashes2($newword);
		if($over==1)//完全替换
		{
			if(empty($add2))
			{
				$and=" where ";
			}
			else
			{
				$and=" and ";
			}
			$add2.=$and.$field."='".$repoldword."'";
		}
		if($fr['tbdataf'])//副表
		{
			//已审核
			$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
			if($tbr['datatbs'])
			{
				$dtbr=explode(',',$tbr['datatbs']);
				$count=count($dtbr);
				for($i=1;$i<$count-1;$i++)
				{
					$empire->query("update {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
				}
			}
			//未审核
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check_data set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
		}
		else//主表
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname." set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
			//未审核
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
		}
		//替换完毕
		insert_dolog("tbname=".$tbname."&field=".$field."<br>oldword=".$oldword."<br>newword=".$newword);//操作日志
		printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
	}
}

//正则替换信息
function DoRepNewstextZz($oldword,$newword,$text){
	$zztext=RepInfoZZ($oldword,"empire-cms-wm.chief-phome",0);
	$text=preg_replace($zztext,$newword,$text);
	return $text;
}

//输出批量替换字段表单
function EchoRepFieldForm($tid,$tbname,$over,$dozz,$dotxt,$newstart,$fieldform,$classid,$oldword,$newword){
	global $fun_r;
	$dotype=(int)$_POST['dotype'];
	?>
	<?=$fun_r['RepOneNewstextSuccess']?>(ID:<font color=red><b><?=$newstart?></b></font>)
	<form name="RepFieldForm" method="post" action="ecmscom.php">
		<?=hReturnEcmsHashStrForm(0)?>
		<input type=hidden name="enews" value="DoRepNewstext">
		<input type=hidden name="tid" value="<?=$tid?>">
		<input type=hidden name="tbname" value="<?=$tbname?>">
		<input type=hidden name="over" value="<?=$over?>">
		<input type=hidden name="dozz" value="<?=$dozz?>">
		<input type=hidden name="dotxt" value="<?=$dotxt?>">
		<input type=hidden name="dotype" value="<?=$dotype?>">
		<input type=hidden name="start" value="<?=$newstart?>">
		<?=$fieldform?>
		<input type=hidden name="classid" value="<?=$classid?>">
		<input type=hidden name="oldword" value="<?=ehtmlspecialchars($oldword)?>">
		<input type=hidden name="newword" value="<?=ehtmlspecialchars($newword)?>">
	</form>
	<script>
	document.RepFieldForm.submit();
	</script>
	<?
	exit();
}

//返回类别管理操作信息
function ReturnDoclassVar($ecms){
	global $dbtbpre;
	//标签模板分类
	if($ecms=="bqtemp")
	{
		$r['tbname']=$dbtbpre."enewsbqtempclass";
		$r['mess']="Bqtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/BqtempClass.php";
	}
	//用户自定义页面分类
	elseif($ecms=="page")
	{
		$r['tbname']=$dbtbpre."enewspageclass";
		$r['mess']="Page";
		$r['thelevel']="userpage";
		$r['returnpage']="template/PageClass.php";
	}
	//公共模板变量分类
	elseif($ecms=="tempvar")
	{
		$r['tbname']=$dbtbpre."enewstempvarclass";
		$r['mess']="Tempvar";
		$r['thelevel']="tempvar";
		$r['returnpage']="template/TempvarClass.php";
	}
	//列表模板分类
	elseif($ecms=="listtemp")
	{
		$r['tbname']=$dbtbpre."enewslisttempclass";
		$r['mess']="Listtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/ListtempClass.php";
	}
	//内容模板分类
	elseif($ecms=="newstemp")
	{
		$r['tbname']=$dbtbpre."enewsnewstempclass";
		$r['mess']="Newstemp";
		$r['thelevel']="template";
		$r['returnpage']="template/NewstempClass.php";
	}
	//搜索模板分类
	elseif($ecms=="searchtemp")
	{
		$r['tbname']=$dbtbpre."enewssearchtempclass";
		$r['mess']="Searchtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/SearchtempClass.php";
	}
	//标签分类
	elseif($ecms=="bq")
	{
		$r['tbname']=$dbtbpre."enewsbqclass";
		$r['mess']="Bq";
		$r['thelevel']="bq";
		$r['returnpage']="template/BqClass.php";
	}
	//JS模板
	elseif($ecms=="jstemp")
	{
		$r['tbname']=$dbtbpre."enewsjstempclass";
		$r['mess']="Jstemp";
		$r['thelevel']="template";
		$r['returnpage']="template/JsTempClass.php";
	}
	//专题
	elseif($ecms=="zt")
	{
		$r['tbname']=$dbtbpre."enewsztclass";
		$r['mess']="Ztclass";
		$r['thelevel']="zt";
		$r['returnpage']="special/ListZtClass.php";
	}
	//友情链接
	elseif($ecms=="link")
	{
		$r['tbname']=$dbtbpre."enewslinkclass";
		$r['mess']="Linkclass";
		$r['thelevel']="link";
		$r['returnpage']="tool/LinkClass.php";
	}
	//单页模板
	elseif($ecms=="classtemp")
	{
		$r['tbname']=$dbtbpre."enewsclasstempclass";
		$r['mess']="Classtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/ClassTempClass.php";
	}
	//错误报告
	elseif($ecms=="error")
	{
		$r['tbname']=$dbtbpre."enewserrorclass";
		$r['mess']="Error";
		$r['thelevel']="downerror";
		$r['returnpage']="DownSys/ErrorClass.php";
	}
	//TAGS
	elseif($ecms=="tags")
	{
		$r['tbname']=$dbtbpre."enewstagsclass";
		$r['mess']="Tags";
		$r['thelevel']="tags";
		$r['returnpage']="tags/TagsClass.php";
	}
	//用户自定义列表
	elseif($ecms=="userlist")
	{
		$r['tbname']=$dbtbpre."enewsuserlistclass";
		$r['mess']="Userlist";
		$r['thelevel']="userlist";
		$r['returnpage']="other/UserlistClass.php";
	}
	//用户自定义JS
	elseif($ecms=="userjs")
	{
		$r['tbname']=$dbtbpre."enewsuserjsclass";
		$r['mess']="Userjs";
		$r['thelevel']="userjs";
		$r['returnpage']="other/UserjsClass.php";
	}
	else
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$r['returnpage'].=hReturnEcmsHashStrHref2(1);
	return $r;
}

//增加分类
function AddThisClass($add,$userid,$username){
	global $empire,$dbtbpre;
	//取得返回信息
	$thisr=ReturnDoclassVar($add['doing']);
	if(!$add['classname'])
	{
		printerror("Empty".$thisr['mess']."Classname","history.go(-1)");
    }
	//验证权限
    CheckLevel($userid,$username,$classid,$thisr['thelevel']);
	$sql=$empire->query("insert into ".$thisr['tbname']."(classname) values('$add[classname]');");
	if($sql)
	{
		$lastid=$empire->lastid();
		//操作日志
	    insert_dolog("classid=".$lastid."<br>classname=".$add[classname]);
		printerror("Add".$thisr['mess']."ClassSuccess",$thisr['returnpage']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改分类
function EditThisClass($add,$userid,$username){
	global $empire,$dbtbpre;
	//取得返回信息
	$thisr=ReturnDoclassVar($add['doing']);
	$classid=(int)$add['classid'];
	if(!$add['classname']||!$classid)
	{
		printerror("Empty".$thisr['mess']."Classname","history.go(-1)");
    }
	//验证权限
    CheckLevel($userid,$username,$classid,$thisr['thelevel']);
	$sql=$empire->query("update ".$thisr['tbname']." set classname='$add[classname]' where classid='$classid'");
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$classid."<br>classname=".$add[classname]);
		printerror("Edit".$thisr['mess']."ClassSuccess",$thisr['returnpage']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除分类
function DelThisClass($classid,$doing,$userid,$username){
	global $empire,$dbtbpre;
	//取得返回信息
	$thisr=ReturnDoclassVar($doing);
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror("NotChange".$thisr['mess']."Classid","history.go(-1)");
    }
	//验证权限
    CheckLevel($userid,$username,$classid,$thisr['thelevel']);
	$r=$empire->fetch1("select classname from ".$thisr['tbname']." where classid=$classid");
	$sql=$empire->query("delete from ".$thisr['tbname']." where classid=$classid");
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("Del".$thisr['mess']."ClassSuccess",$thisr['returnpage']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//批量替换地址权限
function RepDownLevel($add,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"repdownpath");
	$tbname=RepPostVar($add['tbname']);
	if(!$tbname||!($add[downpath]||$add[onlinepath])||!($add[dogroup]||$add[dofen]||$add[doqz]||$add[dopath]||$add[doname]))
	{printerror("EmptyRepDownLevel","history.go(-1)");}
	$start=(int)$add['start'];
	//转换变量
	if(empty($add[oldgroupid]))
	{
		$add[oldgroupid]=0;
	}
	if(empty($add[newgroupid]))
	{
		$add[newgroupid]=0;
	}
	if(empty($add[oldfen]))
	{
		$add[oldfen]=0;
	}
	if(empty($add[newfen]))
	{
		$add[newfen]=0;
	}
	if(empty($add[oldqz]))
	{
		$add[oldqz]=0;
	}
	if(empty($add[newqz]))
	{
		$add[newqz]=0;
	}
	//字段
	$field='';
	$sfield='';
	if($add['downpath'])
	{
		$field.=",downpath";
		$dh=",";
		$checkf='downpath';
	}
	if($add['onlinepath'])
	{
		$field.=",onlinepath";
		$checkf='onlinepath';
	}
	$fr=$empire->fetch1("select tid,savetxt,tbdataf from {$dbtbpre}enewsf where tbname='$tbname' and f='$checkf' limit 1");
	if($fr['tbdataf'])//副表
	{
		$sfield=$field;
		$field='';
	}
	$wheresql="";
	//栏目
	$classid=(int)$add['classid'];
	if($classid)
	{
		if(empty($class_r[$classid][islast]))//中级栏目
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//终极栏目
		{
			$where="classid='$classid'";
		}
		$wheresql.=" and (".$where.")";
	}
	//附加sql语句
	$query=$add['query'];
	if($query)
	{
		//取除adds
		$query=ClearAddsData($query);
		$wheresql.=" and (".$query.")";
	}
	$update="";
	$b=0;
	$sql=$empire->query("select id,stb".$field." from {$dbtbpre}ecms_".$tbname." where id>$start".$wheresql." order by id limit ".$public_r['dorepdlevelnum']);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[id];
		//副表
		if($fr['tbdataf'])
		{
			$finfor=$empire->fetch1("select id".$sfield." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]'");
			$r['downpath']=$finfor['downpath'];
			$r['onlinepath']=$finfor['onlinepath'];
		}
		$update='';
		//下载地址
		$newdownpath="";
		if($add[downpath])
		{
			$newdownpath=RepDownLevelStrip($r[downpath],$add);
			$update="downpath='".addslashes($newdownpath)."'";
		}
		//在线地址
		$newonlinepath="";
		if($add[onlinepath])
		{
			$newonlinepath=RepDownLevelStrip($r[onlinepath],$add);
			$update.=$dh."onlinepath='".addslashes($newonlinepath)."'";
		}
		//副表
		if($fr['tbdataf'])
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." set ".$update." where id='$r[id]'");
		}
		else
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname." set ".$update." where id='$r[id]'");
		}
	}
	//替换完毕
	if(empty($b))
	{
		//未审核
		$sql=$empire->query("select id,stb".$field." from {$dbtbpre}ecms_".$tbname."_check".($wheresql?' where '.substr($wheresql,5):''));
		while($r=$empire->fetch($sql))
		{
			//副表
			if($fr['tbdataf'])
			{
				$finfor=$empire->fetch1("select id".$sfield." from {$dbtbpre}ecms_".$tbname."_check_data where id='$r[id]' limit 1");
				$r['downpath']=$finfor['downpath'];
				$r['onlinepath']=$finfor['onlinepath'];
			}
			$update='';
			//下载地址
			$newdownpath="";
			if($add[downpath])
			{
				$newdownpath=RepDownLevelStrip($r[downpath],$add);
				$update="downpath='".addslashes($newdownpath)."'";
			}
			//在线地址
			$newonlinepath="";
			if($add[onlinepath])
			{
				$newonlinepath=RepDownLevelStrip($r[onlinepath],$add);
				$update.=$dh."onlinepath='".addslashes($newonlinepath)."'";
			}
			//副表
			if($fr['tbdataf'])
			{
				$empire->query("update {$dbtbpre}ecms_".$tbname."_check_data set ".$update." where id='$r[id]'");
			}
			else
			{
				$empire->query("update {$dbtbpre}ecms_".$tbname."_check set ".$update." where id='$r[id]'");
			}
		}
		//操作日志
	    insert_dolog("tbname=$tbname<br>downpath=$add[downpath]<br>onlinepath=$add[onlinepath]");
		printerror("RepDownLevelSuccess","DownSys/RepDownLevel.php".hReturnEcmsHashStrHref2(1));
	}
	EchoRepDownLevelForm($add,$newstart);
}

//替换权限处理函数
function RepDownLevelStrip($downpath,$add){
	if(empty($downpath))
	{
		return "";
	}
	$add[oldpath]=ClearAddsData($add[oldpath]);
	$add[newpath]=ClearAddsData($add[newpath]);
	$add[oldname]=ClearAddsData($add[oldname]);
	$add[newname]=ClearAddsData($add[newname]);
	$f_exp="::::::";
	$r_exp="\r\n";
	$newdownpath="";
	$downpath=stripSlashes($downpath);
	$down_rr=explode($r_exp,$downpath);
	$count=count($down_rr);
	for($i=0;$i<$count;$i++)
	{
		$down_fr=explode($f_exp,$down_rr[$i]);
		//权限替换
		$d_groupid=(int)$down_fr[2];
		if($add[dogroup])
		{
			if($add[oldgroupid]=="no")//不设置
			{
				$d_groupid=$add[newgroupid];
			}
			else//设置
			{
				if($d_groupid==$add[oldgroupid])
				{
					$d_groupid=$add[newgroupid];
				}
			}
		}
		//点数转换
		$d_fen=(int)$down_fr[3];
		if($add[dofen])
		{
			if($add[oldfen]=="no")//不设置
			{
				$d_fen=$add[newfen];
			}
			else//设置
			{
				if($d_fen==$add[oldfen])
				{
					$d_fen=$add[newfen];
				}
			}
		}
		//前缀转换
		$d_qz=(int)$down_fr[4];
		if($add[doqz])
		{
			if($add[oldqz]=="no")//不设置
			{
				$d_qz=$add['newqz'];
			}
			else//设置
			{
				if($d_qz==$add[oldqz])
				{
					$d_qz=$add[newqz];
				}
			}
		}
		//地址替换
		$d_path=$down_fr[1];
		if($add[dopath]&&$add[oldpath])
		{
			$d_path=str_replace($add[oldpath],$add[newpath],$down_fr[1]);
		}
		//名称替换
		$d_name=$down_fr[0];
		if($add[doname]&&$add[oldname])
		{
			$d_name=str_replace($add[oldname],$add[newname],$down_fr[0]);
		}
		//组合
		$newdownpath.=$d_name.$f_exp.$d_path.$f_exp.$d_groupid.$f_exp.$d_fen.$f_exp.$d_qz.$r_exp;
	}
	//去掉最后的字符
	$newdownpath=substr($newdownpath,0,strlen($newdownpath)-2);
	return $newdownpath;
}

//输出批量替换下载权限表单
function EchoRepDownLevelForm($add,$newstart){
	global $fun_r;
	?>
	<?=$fun_r['RepOneDLeveSuccess']?>(ID:<font color=red><b><?=$newstart?></b></font>)
	<form name="RepDownLevelForm" method="post" action="ecmscom.php">
		<?=hReturnEcmsHashStrForm(0)?>
		<input type=hidden name="enews" value="RepDownLevel">
		<input type=hidden name="start" value="<?=$newstart?>">
		<input type=hidden name="tbname" value="<?=$add['tbname']?>">
		<input type=hidden name="classid" value="<?=$add['classid']?>">
		<input type=hidden name="downpath" value="<?=$add['downpath']?>">
		<input type=hidden name="onlinepath" value="<?=$add['onlinepath']?>">
		<input type=hidden name="dogroup" value="<?=$add['dogroup']?>">
		<input type=hidden name="oldgroupid" value="<?=$add['oldgroupid']?>">
		<input type=hidden name="newgroupid" value="<?=$add['newgroupid']?>">
		<input type=hidden name="dofen" value="<?=$add['dofen']?>">
		<input type=hidden name="oldfen" value="<?=$add['oldfen']?>">
		<input type=hidden name="newfen" value="<?=$add['newfen']?>">
		<input type=hidden name="doqz" value="<?=$add['doqz']?>">
		<input type=hidden name="oldqz" value="<?=$add['oldqz']?>">
		<input type=hidden name="newqz" value="<?=$add['newqz']?>">
		<input type=hidden name="dopath" value="<?=$add['dopath']?>">
		<input type=hidden name="oldpath" value="<?=ehtmlspecialchars(ClearAddsData($add['oldpath']))?>">
		<input type=hidden name="newpath" value="<?=ehtmlspecialchars(ClearAddsData($add['newpath']))?>">
		<input type=hidden name="doname" value="<?=$add['doname']?>">
		<input type=hidden name="oldname" value="<?=ehtmlspecialchars(ClearAddsData($add['oldname']))?>">
		<input type=hidden name="newname" value="<?=ehtmlspecialchars(ClearAddsData($add['newname']))?>">
		<input type=hidden name="query" value="<?=ehtmlspecialchars(ClearAddsData($add['query']))?>">
	</form>
	<script>
	document.RepDownLevelForm.submit();
	</script>
	<?
	exit();
}

//清空临时数据与文件
function ClearTmpFileData($add,$userid,$username){
	global $empire,$public_r,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"changedata");
	//临时文件目录
	$tmppath=ECMS_PATH.'e/data/tmp';
	$hand=@opendir($tmppath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.html'||$file=='mod'||$file=='temp'||$file=='titlepic'||$file=='cj')
		{
			continue;
		}
		$filename=$tmppath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//临时模板导出目录
	$temppath=ECMS_PATH.'e/data/tmp/temp';
	$hand=@opendir($temppath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.php')
		{
			continue;
		}
		$filename=$temppath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//临时模型导出目录
	$modpath=ECMS_PATH.'e/data/tmp/mod';
	$hand=@opendir($modpath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.php')
		{
			continue;
		}
		$filename=$modpath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//临时采集导出目录
	$cjpath=ECMS_PATH.'e/data/tmp/cj';
	$hand=@opendir($cjpath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.html')
		{
			continue;
		}
		$filename=$cjpath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//采集临时表
	$empire->query("TRUNCATE `{$dbtbpre}enewslinktmp`;");
	//远程发布临时表
	$empire->query("TRUNCATE `{$dbtbpre}enewspostdata`;");
	printerror('ClearTmpFileDataSuccess','');
}

//清理多余信息
function ClearBreakInfo($add,$userid,$username){
	global $empire,$dbtbpre;
	CheckLevel($userid,$username,$classid,"changedata");//验证权限
	$tid=(int)$add['tid'];
	if(!$tid)
	{
		printerror('EmptyDocTb','');
	}
	$tbr=$empire->fetch1("select datatbs,tbname from {$dbtbpre}enewstable where tid='$tid'");
	if(!$tbr['tbname'])
	{
		printerror('EmptyDocTb','');
	}
	$affnum=0;
	if($tbr['datatbs'])
	{
		$dtbr=explode(',',$tbr['datatbs']);
		$count=count($dtbr);
		$dodatatbs='';
		$andunion='';
		for($i=1;$i<$count-1;$i++)
		{
			$dodatatbs.=$andunion."select id from {$dbtbpre}ecms_".$tbr['tbname']."_data_".$dtbr[$i];
			$andunion=' union ';
		}
		if($dodatatbs)
		{
			$empire->query("delete from {$dbtbpre}ecms_".$tbr['tbname']." where id not in (".$dodatatbs.")");
			$affnum=$empire->affectnum();
		}
	}
	$GLOBALS['cbinfoaffnum']=$affnum;
	//操作日志
	insert_dolog("tid=".$tid."<br>tbname=".$tbr['tbname']);
	printerror("ClearBreakInfoSuccess","");
}

//重置信息或评论数统计
function ResetAddDataNum($type,$from,$userid,$username){
	global $empire,$dbtbpre;
	if($type=='info')
	{
		//CheckLevel($userid,$username,$classid,"info");//验证权限
	}
	elseif($type=='pl')
	{
		//CheckLevel($userid,$username,$classid,"pl");//验证权限
	}
	else
	{
		printerror("ErrorUrl","");
	}
	CheckLevel($userid,$username,$classid,"changedata");//验证权限
	DoResetAddDataNum($type);
	$returnurl=$from?$from:$_SERVER['HTTP_REFERER'];
	//操作日志
	insert_dolog("type=".$type);
	printerror("ResetAddDataNumSuccess",$returnurl);
}
?>