<?php
//*************************** 信息 ***************************

//增加投票
function AddInfoVote($classid,$id,$add){
	global $empire,$dbtbpre,$class_r;
	$pubid=ReturnInfoPubid($classid,$id);
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	$votename=$add['vote_name'];
	$votenum=$add['vote_num'];
	//统计总票数
	for($i=0;$i<count($votename);$i++)
	{
		$t_votenum+=$votenum[$i];
	}
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$add['vote_class'];
	$width=(int)$add['vote_width'];
	$height=(int)$add['vote_height'];
	$doip=(int)$add['dovote_ip'];
	$tempid=(int)$add['vote_tempid'];
	$add['vote_title']=hRepPostStr($add['vote_title'],1);
	$add['vote_dotime']=hRepPostStr($add['vote_dotime'],1);
	//附加字段
	$diyotherlink=(int)$add['info_diyotherlink'];
	$infouptime=0;
	if($add['info_infouptime'])
	{
		$infouptime=to_time($add['info_infouptime']);
	}
	$infodowntime=0;
	if($add['info_infodowntime'])
	{
		$infodowntime=to_time($add['info_infodowntime']);
	}
	if($num)	//修改
	{
		$votetext=ReturnVote($add['vote_name'],$add['vote_num'],$add['delvote_id'],$add['vote_id'],1);	//返回组合
		$votetext=hRepPostStr($votetext,1);
		$sql=$empire->query("update {$dbtbpre}enewsinfovote set title='$add[vote_title]',votenum='$t_votenum',votetext='$votetext',voteclass='$voteclass',doip='$doip',dotime='$add[vote_dotime]',tempid='$tempid',width='$width',height='$height',diyotherlink='$diyotherlink',infouptime='$infouptime',infodowntime='$infodowntime' where pubid='$pubid' limit 1");
	}
	else	//增加
	{
		$votetext=ReturnVote($add['vote_name'],$add['vote_num'],$add['delvote_id'],$add['vote_id'],0);	//返回组合
		if(!($votetext||$diyotherlink||$infouptime||$infodowntime))
		{
			return '';
		}
		$votetext=hRepPostStr($votetext,1);
		$sql=$empire->query("insert into {$dbtbpre}enewsinfovote(pubid,id,classid,title,votenum,voteip,votetext,voteclass,doip,dotime,tempid,width,height,diyotherlink,infouptime,infodowntime,copyids) values('$pubid','$id','$classid','$add[vote_title]','$t_votenum','','$votetext','$voteclass','$doip','$add[vote_dotime]','$tempid','$width','$height','$diyotherlink','$infouptime','$infodowntime','');");
	}
}

//更新同时发布
function UpdateInfoCopyids($classid,$id,$copyids){
	global $empire,$dbtbpre,$class_r;
	$pubid=ReturnInfoPubid($classid,$id);
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	if($num)	//修改
	{
		$empire->query("update {$dbtbpre}enewsinfovote set copyids='$copyids' where pubid='$pubid' limit 1");
	}
	else	//增加
	{
		$empire->query("insert into {$dbtbpre}enewsinfovote(pubid,id,classid,copyids) values('$pubid','$id','$classid','$copyids');");
	}
}

//返回标题是否重复
function ReturnCheckRetitle($add){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$add['classid'];
	$id=(int)$add['id'];
	$title=AddAddsData($add['title']);
	$where='';
	if($id)
	{
		$where=' and id<>'.$id;
	}
	//已审核
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where title='".addslashes($title)."'".$where." limit 1");
	//未审核
	if(empty($num))
	{
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where title='".addslashes($title)."'".$where." limit 1");
	}
	return $num;
}

//AJAX验证标题是否重复
function CheckReTitleAjax($add){
	if(ReturnCheckRetitle($add))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

//增加信息处理变量
function DoPostInfoVar($add){
	global $class_r;
	//组合标题属性
	$add[titlecolor]=RepPhpAspJspcodeText($add[titlecolor]);
	$add['my_titlefont']=TitleFont($add[titlefont],$add[titlecolor]);
	//专题
	$add['ztids']=RepPostVar($add['ztids']);
	$add['zcids']=RepPostVar($add['zcids']);
	$add['oldztids']=RepPostVar($add['oldztids']);
	$add['oldzcids']=RepPostVar($add['oldzcids']);
	//其它变量
	$add[keyboard]=RepPhpAspJspcodeText(DoReplaceQjDh($add[keyboard]));
	$add[titleurl]=RepPhpAspJspcodeText($add[titleurl]);
	$add[checked]=(int)$add[checked];
	$add[istop]=(int)$add[istop];
	$add[dokey]=(int)$add[dokey];
	$add[isgood]=(int)$add[isgood];
	$add[groupid]=(int)$add[groupid];
	$add[newstempid]=(int)$add[newstempid];
	$add[firsttitle]=(int)$add[firsttitle];
	$add[userfen]=(int)$add[userfen];
	$add[closepl]=(int)$add[closepl];
	$add[ttid]=(int)$add[ttid];
	$add[oldttid]=(int)$add[oldttid];
	$add[onclick]=(int)$add[onclick];
	$add[totaldown]=(int)$add[totaldown];
	$add[infotags]=RepPhpAspJspcodeText(DoReplaceQjDh($add[infotags]));
	$add[ispic]=$add[titlepic]?1:0;
	$add[filename]=RepFilenameQz($add[filename],1);
	$add[newspath]=RepFilenameQz($add[newspath],1);
	$add['isurl']=$add['titleurl']?1:0;
	return $add;
}

//相关链接ID处理
function DoPostDiyOtherlinkID($keyid){
	if(!$keyid||$keyid==',')
	{
		return '';
	}
	$new_keyid='';
	$dh='';
	$r=explode(',',$keyid);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=(int)$r[$i];
		if(!$r[$i])
		{
			continue;
		}
		$new_keyid.=$dh.$r[$i];
		$dh=',';
	}
	return $new_keyid;
}

//增加信息
function AddNews($add,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r;
	$add[classid]=(int)$add[classid];
	$userid=(int)$userid;
	if(!$add[title]||!$add[classid])
	{
		printerror("EmptyTitle","history.go(-1)");
	}
	//操作权限
	$doselfinfo=CheckLevel($userid,$username,$add[classid],"news");
	if(!$doselfinfo['doaddinfo'])//增加权限
	{
		printerror("NotAddInfoLevel","history.go(-1)");
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,sametitle,addreinfo,wburl,repreinfo from {$dbtbpre}enewsclass where classid='$add[classid]' and islast=1 limit 1");
	if(!$ccr['classid']||$ccr['wburl'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if($ccr['sametitle'])//验证标题重复
	{
		if(ReturnCheckRetitle($add))
		{
			printerror("ReInfoTitle","history.go(-1)");
	    }
    }
	$add=DoPostInfoVar($add);//返回变量
	$ret_r=ReturnAddF($add,$class_r[$add[classid]][modid],$userid,$username,0,0,1);//返回自定义字段
	$newspath=FormatPath($add[classid],$add[newspath],1);//查看目录是否存在，不存在则建立
	//审核权限
	if(!$doselfinfo['docheckinfo'])
	{
		$add['checked']=$class_r[$add[classid]][checked];
	}
	//必须审核
	if($doselfinfo['domustcheck'])
	{
		$add['checked']=0;
	}
	//推荐权限
	if(!$doselfinfo['dogoodinfo'])
	{
		$add['isgood']=0;
		$add['firsttitle']=0;
		$add['istop']=0;
	}
	//签发
	$isqf=0;
	if($class_r[$add[classid]][wfid])
	{
		$add[checked]=0;
		$isqf=1;
	}
	$newstime=empty($add['newstime'])?time():to_time($add['newstime']);
	$truetime=time();
	$lastdotime=$truetime;
	//是否生成
	$havehtml=0;
	if($add['checked']==1&&$ccr['addreinfo'])
	{
		$havehtml=1;
	}
	//返回关键字组合
	if($add['info_diyotherlink'])
	{
		$keyid=DoPostDiyOtherlinkID($add['info_keyid']);
	}
	else
	{
		$keyid=GetKeyid($add[keyboard],$add[classid],0,$class_r[$add[classid]][link_num]);
	}
	//附加链接参数
	$addecmscheck=empty($add['checked'])?'&ecmscheck=1':'';
	//索引表
	$sql=$empire->query("insert into {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$add[classid]','$add[checked]','$newstime','$truetime','$lastdotime','$havehtml');");
	$id=$empire->lastid();
	$pubid=ReturnInfoPubid($add['classid'],$id);
	$infotbr=ReturnInfoTbname($class_r[$add[classid]][tbname],$add['checked'],$ret_r['tb']);
	//主表
	$infosql=$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r['fields'].") values('$id','$add[classid]','$add[ttid]','$add[onclick]',0,'$add[totaldown]','$newspath','$filename','$userid','".addslashes($username)."','$add[firsttitle]','$add[isgood]','$add[ispic]','$add[istop]','$isqf',0,'$add[isurl]','$truetime','$lastdotime','$havehtml','$add[groupid]','$add[userfen]','".addslashes($add[my_titlefont])."','".addslashes($add[titleurl])."','$ret_r[tb]','$public_r[filedeftb]','$public_r[pldeftb]','".addslashes($add[keyboard])."'".$ret_r['values'].");");
	//副表
	$finfosql=$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r['datafields'].") values('$id','$add[classid]','$keyid','$add[dokey]','$add[newstempid]','$add[closepl]',0,'".addslashes($add[infotags])."'".$ret_r['datavalues'].");");
	//更新栏目信息数
	AddClassInfos($add['classid'],'+1','+1',$add['checked']);
	//更新新信息数
	DoUpdateAddDataNum('info',$class_r[$add['classid']]['tid'],1);
	//签发
	if($isqf==1)
	{
		InfoInsertToWorkflow($id,$add[classid],$class_r[$add[classid]][wfid],$userid,$username);
	}
	//更新附件表
	UpdateTheFile($id,$add['filepass'],$add['classid'],$public_r['filedeftb']);
	//取第一张图作为标题图片
	if($add['getfirsttitlepic']&&empty($add['titlepic']))
	{
		$firsttitlepic=GetFpicToTpic($add['classid'],$id,$add['getfirsttitlepic'],$add['getfirsttitlespic'],$add['getfirsttitlespicw'],$add['getfirsttitlespich'],$public_r['filedeftb']);
		if($firsttitlepic)
		{
			$addtitlepic=",titlepic='".addslashes($firsttitlepic)."',ispic=1";
		}
	}
	//文件命名
	if($add['filename'])
	{
		$filename=$add['filename'];
	}
	else
	{
		$filename=ReturnInfoFilename($add[classid],$id,'');
	}
	//信息地址
	$updateinfourl='';
	if(!$add['isurl'])
	{
		$infourl=GotoGetTitleUrl($add['classid'],$id,$newspath,$filename,$add['groupid'],$add['isurl'],$add['titleurl']);
		$updateinfourl=",titleurl='$infourl'";
	}
	$usql=$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl.$addtitlepic." where id='$id'");
	//替换图片下一页
	if($add['repimgnexturl'])
	{
		UpdateImgNexturl($add[classid],$id,$add['checked']);
	}
	//投票
	AddInfoVote($add['classid'],$id,$add);
	//加入专题
	InsertZtInfo($add['ztids'],$add['zcids'],$add['oldztids'],$add['oldzcids'],$add['classid'],$id,$newstime);
	//TAGS
	if($add[infotags]&&$add[infotags]<>$add[oldinfotags])
	{
		eInsertTags($add[infotags],$add['classid'],$id,$newstime);
	}
	//增加信息是否生成文件
	if($ccr['addreinfo']&&$add['checked'])
	{
		GetHtml($add['classid'],$id,'',0);
	}
	//生成上一篇
	if($ccr['repreinfo']&&$add['checked'])
	{
		$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id<$id and classid='$add[classid]' order by id desc limit 1");
		GetHtml($add['classid'],$prer['id'],$prer,1);
	}
	//生成栏目
	if($ccr['haddlist']&&$add['checked'])
	{
		hAddListHtml($add['classid'],$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//生成信息列表
		if($add['ttid'])//生成标题分类列表
		{
			ListHtml($add['ttid'],'',5);
		}
	}
	//同时发布
	$copyclassid=$add[copyclassid];
	$cpcount=count($copyclassid);
	if($cpcount)
	{
		$copyids=AddInfoToCopyInfo($add[classid],$id,$copyclassid,$userid,$username,$doselfinfo);
		if($copyids)
		{
			UpdateInfoCopyids($add['classid'],$id,$copyids);
		}
	}
	if($sql)
	{
		//返回地址
		if($add['ecmsfrom']&&(stristr($add['ecmsfrom'],'ListNews.php')||stristr($add['ecmsfrom'],'ListAllInfo.php')))
		{
			$ecmsfrom=$add['ecmsfrom'];
		}
		else
		{
			$ecmsfrom=$add['ecmsnfrom']==1?"ListNews.php?bclassid=$add[bclassid]&classid=$add[classid]":"ListAllInfo.php?tbname=".$class_r[$add[classid]][tbname];
			$ecmsfrom.=hReturnEcmsHashStrHref2(0);
		}
		$GLOBALS['ecmsadderrorurl']=$ecmsfrom.$addecmscheck;
		insert_dolog("classid=$add[classid]<br>id=".$id."<br>title=".$add[title],$pubid);//操作日志
		printerror("AddNewsSuccess","AddNews.php?enews=AddNews&ecmsnfrom=$add[ecmsnfrom]&bclassid=$add[bclassid]&classid=$add[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","");
	}
}

//修改信息
function EditNews($add,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r;
	$add[classid]=(int)$add[classid];
	$userid=(int)$userid;
	$add[id]=(int)$add[id];
	if(!$add[id]||!$add[title]||!$add[classid]||!$add[filename])
	{
		printerror("EmptyTitle","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$add[classid],"news");//操作权限
	if(!$doselfinfo['doeditinfo'])//编辑权限
	{
		printerror("NotEditInfoLevel","history.go(-1)");
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,sametitle,addreinfo,wburl,repreinfo from {$dbtbpre}enewsclass where classid='$add[classid]' and islast=1 limit 1");
	if(!$ccr['classid']||$ccr['wburl'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//索引表
	$index_checkr=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index where id='$add[id]' limit 1");
	if(!$index_checkr['id']||$index_checkr['classid']!=$add['classid'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//主表
	$infotb=ReturnInfoMainTbname($class_r[$add[classid]][tbname],$index_checkr['checked']);
	$checkr=$empire->fetch1("select id,classid,userid,username,ismember,stb,newspath,filename,isqf,fstb,isgood,firsttitle,istop from ".$infotb." where id='$add[id]' limit 1");
	if($doselfinfo['doselfinfo']&&($checkr['userid']<>$userid||$checkr['ismember']))//只能编辑自己的信息
	{
		printerror("NotDoSelfinfo","history.go(-1)");
    }
	//已审核信息不可修改
	if($doselfinfo['docheckedit']&&$index_checkr['checked'])
	{
		printerror("NotEditCheckInfoLevel","history.go(-1)");
	}
	//审核权限
	if(!$doselfinfo['docheckinfo'])
	{
		$add['checked']=$index_checkr['checked'];
	}
	//必须审核
	if($doselfinfo['domustcheck']&&!$index_checkr['checked'])
	{
		$add['checked']=0;
	}
	//推荐权限
	if(!$doselfinfo['dogoodinfo'])
	{
		$add['isgood']=$checkr['isgood'];
		$add['firsttitle']=$checkr['firsttitle'];
		$add['istop']=$checkr['istop'];
	}
	if($ccr['sametitle'])//验证标题重复
	{
		if(ReturnCheckRetitle($add))
		{
			printerror("ReInfoTitle","history.go(-1)");
	    }
    }
	//公共表
	$pubid=ReturnInfoPubid($add['classid'],$add['id']);
	$pubcheckr=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	$mid=$class_r[$add[classid]][modid];
	$pf=$emod_r[$mid]['pagef'];
	$add=DoPostInfoVar($add);//返回变量
	$add['fstb']=$checkr['fstb'];
	$ret_r=ReturnAddF($add,$class_r[$add[classid]][modid],$userid,$username,1,0,1);//返回自定义字段
	$deloldfile=0;
	if($add[groupid]<>$add[oldgroupid]||($index_checkr['checked']&&!$add[checked]))//改变文件权限
	{
        DelNewsFile($checkr[filename],$checkr[newspath],$add[classid],$add[$pf],$add[oldgroupid]);//删除旧的文件
		$deloldfile=1;
	}
	//签发
	$newchecked=$index_checkr['checked'];
	$a='';
	if($class_r[$add[classid]][wfid]&&$checkr['isqf'])
	{
		$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$add[id]' and classid='$add[classid]' limit 1");
		if($qfr['checktno']=='100')//已通过
		{
			$aqf=",checked='$add[checked]'";
			$newchecked=$add[checked];
		}
		else
		{
			if($add[reworkflow])
			{
				InfoUpdateToWorkflow($add[id],$add[classid],$class_r[$add[classid]][wfid],$userid,$username);
			}
			$aqf='';
		}
	}
	else
	{
		$aqf=",checked='$add[checked]'";
		$newchecked=$add[checked];
	}
	//日期目录
	$updatefile='';
	$urlnewspath=$checkr['newspath'];
	if($add['newspath']!=$checkr[newspath])
	{
		$add[newspath]=FormatPath($add[classid],$add[newspath],1);//查看目录是否存在，不存在则建立
		$updatefile.=",newspath='$add[newspath]'";
		if($deloldfile==0)
		{
			DelNewsFile($checkr[filename],$checkr[newspath],$add[classid],$add[$pf],$add[oldgroupid]);//删除旧文件
			$deloldfile=1;
		}
		$urlnewspath=$add['newspath'];
	}
	//文件名
	$urlfilename=$checkr['filename'];
	if($add['filename']&&$add['filename']!=$checkr[filename])
	{
		$newfilename=$add['filename'];
		$updatefile.=",filename='$newfilename'";
		if($deloldfile==0)
		{
			DelNewsFile($checkr[filename],$checkr[newspath],$add[classid],$add[$pf],$add[oldgroupid]);//删除旧文件
			$deloldfile=1;
		}
		$urlfilename=$newfilename;
	}
	$newstime=empty($add['newstime'])?time():to_time($add['newstime']);
	$lastdotime=time();
	//返回关键字组合
	if($add['info_diyotherlink'])
	{
		$keyid=DoPostDiyOtherlinkID($add['info_keyid']);
	}
	else
	{
		$keyid=GetKeyid($add[keyboard],$add[classid],$add[id],$class_r[$add[classid]][link_num]);
	}
	//附加链接参数
	$addecmscheck=empty($newchecked)?'&ecmscheck=1':'';
	//信息地址
	$infourl=GotoGetTitleUrl($add['classid'],$add['id'],$urlnewspath,$urlfilename,$add['groupid'],$add['isurl'],$add['titleurl']);
	//返回表信息
	$infotbr=ReturnInfoTbname($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb']);
	//索引表
	$indexsql=$empire->query("update {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index set newstime='$newstime',lastdotime='$lastdotime'".$aqf." where id='$add[id]' limit 1");
	//主表
	$sql=$empire->query("update ".$infotbr['tbname']." set classid='$add[classid]',ttid='$add[ttid]',onclick='$add[onclick]',totaldown='$add[totaldown]',firsttitle=$add[firsttitle],isgood=$add[isgood],ispic='$add[ispic]',istop=$add[istop],isurl='$add[isurl]',lastdotime=$lastdotime,groupid=$add[groupid],userfen=$add[userfen],titlefont='".addslashes($add[my_titlefont])."',titleurl='".addslashes($infourl)."',keyboard='".addslashes($add[keyboard])."'".$updatefile.$ret_r[values]." where id='$add[id]' limit 1");
	//副表
	$stb=$checkr['stb'];
	$fsql=$empire->query("update ".$infotbr['datatbname']." set classid='$add[classid]',keyid='$keyid',dokey=$add[dokey],newstempid=$add[newstempid],closepl=$add[closepl],infotags='".addslashes($add[infotags])."'".$ret_r[datavalues]." where id='$add[id]' limit 1");
	//取第一张图作为标题图片
	if($add['getfirsttitlepic']&&empty($add['titlepic']))
	{
		$firsttitlepic=GetFpicToTpic($add['classid'],$add['id'],$add['getfirsttitlepic'],$add['getfirsttitlespic'],$add['getfirsttitlespicw'],$add['getfirsttitlespich'],$checkr['fstb']);
		if($firsttitlepic)
		{
			$usql=$empire->query("update ".$infotbr['tbname']." set titlepic='".addslashes($firsttitlepic)."',ispic=1 where id='$add[id]'");
		}
	}
	//更新附件
	UpdateTheFileEdit($add['classid'],$add['id'],$checkr['fstb']);
	//替换图片下一页
	if($add['repimgnexturl'])
	{
		UpdateImgNexturl($add['classid'],$add['id'],$index_checkr['checked']);
	}
	//投票
	AddInfoVote($add['classid'],$add['id'],$add);
	//写入专题
	InsertZtInfo($add['ztids'],$add['zcids'],$add['oldztids'],$add['oldzcids'],$add['classid'],$add['id'],$newstime);
	//TAGS
	if($add[infotags]&&$add[infotags]<>$add[oldinfotags])
	{
		eInsertTags($add[infotags],$add['classid'],$add['id'],$newstime);
	}
	//是否改变审核状态
	if($index_checkr['checked']!=$newchecked)
	{
		MoveCheckInfoData($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb'],"id='$add[id]'");
		//更新栏目信息数
		if($newchecked)
		{
			AddClassInfos($add['classid'],'','+1');
		}
		else
		{
			AddClassInfos($add['classid'],'','-1');
		}
	}
	//生成文件
	if($ccr['addreinfo']&&$newchecked)
	{
		GetHtml($add['classid'],$add['id'],'',0);
	}
	//生成上一篇
	if($ccr['repreinfo']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id<$add[id] and classid='$add[classid]' order by id desc limit 1");
		GetHtml($prer['classid'],$prer['id'],$prer,1);
	}
	//生成栏目
	if($ccr['haddlist']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		hAddListHtml($add[classid],$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//生成信息列表
		if($add['ttid'])//生成标题分类列表
		{
			ListHtml($add['ttid'],'',5);
		}
		//改变标题分类
		if($add['oldttid']&&$add['ttid']<>$add['oldttid'])
		{
			ListHtml($add['oldttid'],'',5);
		}
	}
	//同时更新
	if($pubcheckr['copyids']&&$pubcheckr['copyids']<>'1')
	{
		EditInfoToCopyInfo($add[classid],$add[id],$userid,$username,$doselfinfo);
	}
	else
	{
		$copyclassid=$add[copyclassid];
		$cpcount=count($copyclassid);
		if($cpcount)
		{
			$copyids=AddInfoToCopyInfo($add[classid],$add[id],$copyclassid,$userid,$username,$doselfinfo);
			if($copyids)
			{
				UpdateInfoCopyids($add['classid'],$add['id'],$copyids);
			}
		}
	}
	if($sql)
	{
		//返回地址
		if($add['ecmsfrom']&&(stristr($add['ecmsfrom'],'ListNews.php')||stristr($add['ecmsfrom'],'ListAllInfo.php')))
		{
			$ecmsfrom=$add['ecmsfrom'];
		}
		else
		{
			$ecmsfrom="ListNews.php?bclassid=$add[bclassid]&classid=$add[classid]".hReturnEcmsHashStrHref2(0);
		}
		insert_dolog("classid=$add[classid]<br>id=".$add[id]."<br>title=".$add[title],$pubid);//操作日志
		printerror("EditNewsSuccess",$ecmsfrom.$addecmscheck);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改信息(快速)
function EditInfoSimple($add,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r;
	$add[classid]=(int)$add[classid];
	$userid=(int)$userid;
	$add[id]=(int)$add[id];
	$closeurl='info/EditInfoSimple.php?isclose=1&reload=1'.hReturnEcmsHashStrHref2(0);
	if(!$add[id]||!$add[title]||!$add[classid])
	{
		printerror("EmptyTitle","history.go(-1)",8);
	}
	$doselfinfo=CheckLevel($userid,$username,$add[classid],"news");//操作权限
	if(!$doselfinfo['doeditinfo'])//编辑权限
	{
		printerror("NotEditInfoLevel","history.go(-1)",8);
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,sametitle,addreinfo,wburl,repreinfo from {$dbtbpre}enewsclass where classid='$add[classid]' and islast=1 limit 1");
	if(!$ccr['classid']||$ccr['wburl'])
	{
		printerror("ErrorUrl","history.go(-1)",8);
	}
	//索引表
	$index_checkr=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index where id='$add[id]' limit 1");
	if(!$index_checkr['id']||$index_checkr['classid']!=$add['classid'])
	{
		printerror("ErrorUrl","history.go(-1)",8);
	}
	//主表
	$infotb=ReturnInfoMainTbname($class_r[$add[classid]][tbname],$index_checkr['checked']);
	$checkr=$empire->fetch1("select id,classid,userid,username,ismember,stb,newspath,filename,isqf,fstb,isgood,firsttitle,istop,groupid from ".$infotb." where id='$add[id]' limit 1");
	if($doselfinfo['doselfinfo']&&($checkr['userid']<>$userid||$checkr['ismember']))//只能编辑自己的信息
	{
		printerror("NotDoSelfinfo","history.go(-1)",8);
    }
	//已审核信息不可修改
	if($doselfinfo['docheckedit']&&$index_checkr['checked'])
	{
		printerror("NotEditCheckInfoLevel","history.go(-1)");
	}
	//审核权限
	if(!$doselfinfo['docheckinfo'])
	{
		$add['checked']=$index_checkr['checked'];
	}
	//必须审核
	if($doselfinfo['domustcheck']&&!$index_checkr['checked'])
	{
		$add['checked']=0;
	}
	//推荐权限
	if(!$doselfinfo['dogoodinfo'])
	{
		$add['isgood']=$checkr['isgood'];
		$add['firsttitle']=$checkr['firsttitle'];
		$add['istop']=$checkr['istop'];
	}
	if($ccr['sametitle'])//验证标题重复
	{
		if(ReturnCheckRetitle($add))
		{
			printerror("ReInfoTitle","history.go(-1)",8);
	    }
    }
	//公共表
	$pubid=ReturnInfoPubid($add['classid'],$add['id']);
	$pubcheckr=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	$mid=$class_r[$add[classid]][modid];
	$pf=$emod_r[$mid]['pagef'];
	$add=DoPostInfoVar($add);//返回变量
	//签发
	$newchecked=$index_checkr['checked'];
	$a="";
	if($class_r[$add[classid]][wfid]&&$checkr['isqf'])
	{
		$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$add[id]' and classid='$add[classid]' limit 1");
		if($qfr['checktno']=='100')//已通过
		{
			$aqf=",checked='$add[checked]'";
			$newchecked=$add[checked];
		}
		else
		{
			if($add[reworkflow])
			{
				InfoUpdateToWorkflow($add[id],$add[classid],$class_r[$add[classid]][wfid],$userid,$username);
			}
			$aqf='';
		}
	}
	else
	{
		$aqf=",checked='$add[checked]'";
		$newchecked=$add[checked];
	}
	$lastdotime=time();
	//发布时间
	$newstime=empty($add['newstime'])?time():to_time($add['newstime']);
	//附加链接参数
	$addecmscheck=empty($newchecked)?'&ecmscheck=1':'';
	//信息地址
	$infourl=GotoGetTitleUrl($add['classid'],$add['id'],$checkr['newspath'],$checkr['filename'],$checkr['groupid'],$add['isurl'],$add['titleurl']);
	//返回表信息
	$infotbr=ReturnInfoTbname($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb']);
	//索引表
	$indexsql=$empire->query("update {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index set newstime='$newstime',lastdotime='$lastdotime'".$aqf." where id='$add[id]' limit 1");
	//主表
	$sql=$empire->query("update ".$infotbr['tbname']." set classid='$add[classid]',ttid='$add[ttid]',onclick='$add[onclick]',totaldown='$add[totaldown]',firsttitle='$add[firsttitle]',isgood='$add[isgood]',ispic='$add[ispic]',istop='$add[istop]',isurl='$add[isurl]',lastdotime='$lastdotime',titlefont='".addslashes($add[my_titlefont])."',titleurl='".addslashes($infourl)."',title='".addslashes($add[title])."',titlepic='".addslashes($add[titlepic])."',newstime='$newstime' where id='$add[id]' limit 1");
	//副表
	$fsql=$empire->query("update ".$infotbr['datatbname']." set classid='$add[classid]',closepl='$add[closepl]'".$ret_r[datavalues]." where id='$add[id]' limit 1");
	//更新附件
	UpdateTheFileEdit($add['classid'],$add['id'],$checkr['fstb']);
	//是否改变审核状态
	if($index_checkr['checked']!=$newchecked)
	{
		MoveCheckInfoData($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb'],"id='$add[id]'");
		//更新栏目信息数
		if($newchecked)
		{
			AddClassInfos($add['classid'],'','+1');
		}
		else
		{
			AddClassInfos($add['classid'],'','-1');
		}
	}
	//生成文件
	if($ccr['addreinfo']&&$newchecked)
	{
		GetHtml($add['classid'],$add['id'],'',0);
	}
	//生成上一篇
	if($ccr['repreinfo']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id<$add[id] and classid='$add[classid]' order by id desc limit 1");
		GetHtml($prer['classid'],$prer['id'],$prer,1);
	}
	//生成栏目
	if($ccr['haddlist']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		hAddListHtml($add[classid],$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//生成信息列表
	}
	//同时更新
	if($checkr['copyids']&&$checkr['copyids']<>'1')
	{
		EditInfoToCopyInfo($add[classid],$add[id],$userid,$username,$doselfinfo);
	}
	if($sql)
	{
		//返回地址
		if($add['ecmsfrom']&&(stristr($add['ecmsfrom'],'ListNews.php')||stristr($add['ecmsfrom'],'ListAllInfo.php')))
		{
			$ecmsfrom=$add['ecmsfrom'];
		}
		else
		{
			$ecmsfrom="ListNews.php?bclassid=$add[bclassid]&classid=$add[classid]".hReturnEcmsHashStrHref2(0);
		}
		$ecmsfrom=$ecmsfrom.$addecmscheck;
		insert_dolog("classid=$add[classid]<br>id=".$add[id]."<br>title=".$add[title],$pubid);//操作日志
		printerror("EditNewsSuccess",$closeurl,8);
	}
	else
	{
		printerror("DbError","history.go(-1)",8);
	}
}

//删除信息
function DelNews($id,$classid,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r,$adddatar;
	$id=(int)$id;
	$classid=(int)$classid;
	if(!$id||!$classid)
	{
		printerror("NotDelNewsid","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");//操作权限
	if(!$doselfinfo['dodelinfo'])//删除权限
	{
		printerror("NotDelInfoLevel","history.go(-1)");
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,repreinfo from {$dbtbpre}enewsclass where classid='$classid' limit 1");
	if(!$ccr['classid'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//索引表
	$index_r=$empire->fetch1("select classid,checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index  where id='$id' limit 1");
	if(!$index_r[classid]||$index_r[classid]!=$classid)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//返回表
	$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
	$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
	if($doselfinfo['doselfinfo']&&($r[userid]<>$userid||$r[ismember]))//只能编辑自己的信息
	{
		printerror("NotDoSelfinfo","history.go(-1)");
    }
	$pubid=ReturnInfoPubid($classid,$id);
	//附加链接参数
	$addecmscheck=empty($index_r['checked'])?'&ecmscheck=1':'';
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$pf=$emod_r[$mid]['pagef'];
	$stf=$emod_r[$mid]['savetxtf'];
	//返回表信息
	$infotbr=ReturnInfoTbname($class_r[$classid][tbname],$index_r['checked'],$r['stb']);
	//分页字段
	if($pf)
	{
		if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
		{
			$finfor=$empire->fetch1("select ".$pf." from ".$infotbr['datatbname']." where id='$id' limit 1");
			$r[$pf]=$finfor[$pf];
		}
	}
	//存文本
	if($stf)
	{
		$newstextfile=$r[$stf];
		$r[$stf]=GetTxtFieldText($r[$stf]);
		DelTxtFieldText($newstextfile);//删除文件
	}
	DelNewsFile($r[filename],$r[newspath],$classid,$r[$pf],$r[groupid]);//删除信息文件
	$sql=$empire->query("delete from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id'");
	$sql=$empire->query("delete from ".$infotbr['tbname']." where id='$id'");
	$fsql=$empire->query("delete from ".$infotbr['datatbname']." where id='$id'");
	//更新栏目信息数
	AddClassInfos($classid,'-1','-1',$index_r['checked']);
	//删除其它表记录和附件
	DelSingleInfoOtherData($r['classid'],$id,$r,0,0);
	if($index_r['checked'])
	{
		//生成上一篇
		if($ccr['repreinfo'])
		{
			$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id<$id and classid='$classid' order by id desc limit 1");
			GetHtml($prer['classid'],$prer['id'],$prer,1);
			//下一篇
			$nextr=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id>$id and classid='$classid' order by id limit 1");
			if($nextr['id'])
			{
				GetHtml($nextr['classid'],$nextr['id'],$nextr,1);
			}
		}
		hAddListHtml($classid,$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//生成信息列表
		if($r['ttid'])//如果是标题分类
		{
			ListHtml($r['ttid'],'',5);
		}
	}
	//同步删除
	if($r['copyids']&&$r['copyids']<>'1')
	{
		DelInfoToCopyInfo($classid,$id,$r,$userid,$username,$doselfinfo);
	}
	if($sql)
	{
		$returl=$_SERVER['HTTP_REFERER'];
		//发送通知
		if($adddatar['causetext'])
		{
			DoInfoSendNotice($userid,$username,$r['userid'],$r['username'],$adddatar['causetext'],$r,1);
			if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
			{
				$returl=$adddatar['ecmsfrom'];
			}
			else
			{
				$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
			}
		}
		else
		{
			if($_POST['enews']=='DoInfoAndSendNotice')
			{
				$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
			}
		}
		insert_dolog("classid=$classid<br>id=".$id."<br>title=".$r[title],$pubid);//操作日志
		printerror("DelNewsSuccess",$returl);
	}
	else
	{
		printerror("ErrorUrl","history.go(-1)");
	}
}

//批量删除信息
function DelNews_all($id,$classid,$userid,$username,$ecms=0){
	global $empire,$class_r,$class_zr,$public_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$count=count($id);
	if(!$count)
	{
		printerror("NotDelNewsid","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");//操作权限
	if(!$doselfinfo['dodelinfo'])//删除权限
	{
		printerror("NotDelInfoLevel","history.go(-1)");
	}
	$dopubid=0;
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$pf=$emod_r[$mid]['pagef'];
	$stf=$emod_r[$mid]['savetxtf'];
	if($ecms==1)
	{
		$doctb="_doc";
	}
	elseif($ecms==2)
	{
		$doctb="_check";
	}
	for($i=0;$i<$count;$i++)
	{
		$add.="id='".intval($id[$i])."' or ";
    }
	$donum=0;
	$dolog='';
	$add=substr($add,0,strlen($add)-4);
	for($i=0;$i<$count;$i++)//删除信息文件
	{
		$id[$i]=intval($id[$i]);
		$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname.$doctb." where id='$id[$i]'");
		if($doselfinfo['doselfinfo']&&($r[userid]<>$userid||$r[ismember]))//只能编辑自己的信息
		{
			continue;
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$id[$i]);
			$dolog="classid=".$r['classid']."<br>id=".$r['id']."&ecms=$ecms<br>title=".$r['title'];
		}
		//分页字段
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				if($ecms==1)
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_doc_data where id='$id[$i]'");
				}
				elseif($ecms==2)
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_check_data where id='$id[$i]'");
				}
				else
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$id[$i]'");
				}
				$r[$pf]=$finfor[$pf];
			}
		}
		//存文本
		if($stf)
		{
			$newstextfile=$r[$stf];
			$r[$stf]=GetTxtFieldText($r[$stf]);
			DelTxtFieldText($newstextfile);//删除文件
		}
		DelNewsFile($r[filename],$r[newspath],$r[classid],$r[$pf],$r[groupid]);
		//删除副表
		if($ecms==0)
		{
			$empire->query("delete from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$id[$i]'");
		}
		//删除其它表记录和附件
		DelSingleInfoOtherData($r['classid'],$id[$i],$r,0,0);
		//更新栏目信息数
		if($ecms==0||$ecms==2)
		{
			AddClassInfos($r['classid'],'-1','-1',$ecms==2?0:1);
		}
    }
	//删除信息
	$sql=$empire->query("delete from {$dbtbpre}ecms_".$tbname.$doctb." where ".$add);
	if($ecms==0)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where ".$add);
		$ccr=$empire->fetch1("select classid,modid,listdt,haddlist from {$dbtbpre}enewsclass where classid='$classid'");
		hAddListHtml($classid,$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//生成信息列表
	}
	elseif($ecms==1)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_doc_index where ".$add);
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_doc_data where ".$add);
	}
	elseif($ecms==2)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where ".$add);
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_check_data where ".$add);
	}
	if($sql)
	{
		//操作日志
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."&ecms=$ecms");
		}
		printerror("DelNewsAllSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//批量修改发布时间
function EditMoreInfoTime($add,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$add['classid'];
	$infoid=$add['infoid'];
	$newstime=$add['newstime'];
	$count=count($infoid);
	$tbname=$class_r[$classid]['tbname'];
	if(!$classid||!$tbname||!$count)
	{
		printerror('EmptyMoreInfoTime','');
	}
	//操作权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	if(!$doselfinfo['doeditinfo'])//编辑权限
	{
		printerror('NotEditInfoLevel','history.go(-1)');
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//主表
	$infotb='';
	for($i=0;$i<$count;$i++)
	{
		$doinfoid=(int)$infoid[$i];
		if(empty($infotb))
		{
			//索引表
			$index_r=$empire->fetch1("select classid,checked from {$dbtbpre}ecms_".$tbname."_index where id='$doinfoid' limit 1");
			if(!$index_r['classid'])
			{
				continue;
			}
			//返回表
			$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($classid,$doinfoid);
			$dolog="classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>id=".$doinfoid;
		}
		$donewstime=$newstime[$i]?to_time($newstime[$i]):time();
		$empire->query("update {$dbtbpre}ecms_".$tbname."_index set newstime='$donewstime' where id='$doinfoid'");
		$empire->query("update ".$infotb." set newstime='$donewstime' where id='$doinfoid'");
	}
	//操作日志
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=$classid<br>classname=".$class_r[$classid][classname]);
	}
	printerror('EditMoreInfoTimeSuccess',$_SERVER['HTTP_REFERER']);
}

//刷新页面
function AddInfoToReHtml($classid,$dore){
	global $class_r;
	hAddListHtml($classid,$class_r[$classid]['modid'],$dore,$class_r[$classid]['listdt']);//生成信息列表
	insert_dolog("classid=".$classid."<br>do=".$dore);//操作日志
	printerror('AddInfoToReHtmlSuccess','history.go(-1)');
}

//增加信息生成页面
function hAddListHtml($classid,$mid,$qaddlist,$listdt){
	global $class_r;
	if($qaddlist==0)//不生成
	{
		return "";
	}
	elseif($qaddlist==1)//生成当前栏目
	{
		if(!$listdt)
		{
			$sonclass="|".$classid."|";
			hReClassHtml($sonclass);
		}
	}
	elseif($qaddlist==2)//生成首页
	{
		hReIndex();
	}
	elseif($qaddlist==3)//生成父栏目
	{
		$featherclass=$class_r[$classid]['featherclass'];
		if($featherclass&&$featherclass!="|")
		{
			hReClassHtml($featherclass);
		}
	}
	elseif($qaddlist==4)//生成当前栏目与父栏目
	{
		$featherclass=$class_r[$classid]['featherclass'];
		if(empty($featherclass))
		{
			$featherclass="|";
		}
		if(!$listdt)
		{
			$featherclass.=$classid."|";
		}
		hReClassHtml($featherclass);
	}
	elseif($qaddlist==5)//生成父栏目与首页
	{
		hReIndex();
		$featherclass=$class_r[$classid]['featherclass'];
		if($featherclass&&$featherclass!="|")
		{
			hReClassHtml($featherclass);
		}
	}
	elseif($qaddlist==6)//生成当前栏目、父栏目与首页
	{
		hReIndex();
		$featherclass=$class_r[$classid]['featherclass'];
		if(empty($featherclass))
		{
			$featherclass="|";
		}
		if(!$listdt)
		{
			$featherclass.=$classid."|";
		}
		hReClassHtml($featherclass);
	}
}

//增加信息生成栏目
function hReClassHtml($sonclass){
	global $empire,$dbtbpre,$class_r;
	$r=explode("|",$sonclass);
	$count=count($r);
	for($i=1;$i<$count-1;$i++)
	{
		//终极栏目
		if($class_r[$r[$i]]['islast'])
		{
			if(!$class_r[$r[$i]]['listdt'])
			{
				ListHtml($r[$i],'',0,$userlistr);
			}
		}
		elseif($class_r[$r[$i]]['islist']==1)//列表式父栏目
		{
			if(!$class_r[$r[$i]]['listdt'])
			{
				ListHtml($r[$i],'',3);
			}
		}
		elseif($class_r[$r[$i]]['islist']==3)//栏目绑定信息
		{
			ReClassBdInfo($r[$i]);
		}
		else//父栏目
		{
			$cr=$empire->fetch1("select classtempid from {$dbtbpre}enewsclass where classid='$r[$i]'");
			$classtemp=$class_r[$r[$i]]['islist']==2?GetClassText($r[$i]):GetClassTemp($cr['classtempid']);
			NewsBq($r[$i],$classtemp,0,0);
		}
	}
}

//增加信息生成首页
function hReIndex(){
	$indextemp=GetIndextemp();
	NewsBq($classid,$indextemp,1,0);
}

//发布同时复制
function AddInfoToCopyInfo($classid,$id,$to_classid,$userid,$username,$usergroupr){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$id=(int)$id;
	$cr=$to_classid;
	$count=count($cr);
	if(empty($classid)||empty($id)||empty($count))
	{
		return '';
	}
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//索引表
	$index_r=$empire->fetch1("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id='$id' limit 1");
	if(empty($index_r['id']))
	{
		return '';
	}
	//返回表
	$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
	//主表
	$r=$empire->fetch1("select * from ".$infotb." where id='$id'");
	//返回表信息
	$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
	//副表
	$fr=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$infotbr['datatbname']." where id='$id' limit 1");
	$r=array_merge($r,$fr);
	if($stf)//存放文本
	{
		$r[newstext_url]=$r[$stf];
		$r[$stf]=GetTxtFieldText($r[$stf]);
	}
	//返回信息地址
	$copyinfourl=0;
	if($_POST['copyinfotitleurl']&&!$r['isurl'])
	{
		$r['titleurl']=sys_ReturnBqTitleLink($r);
		$r['isurl']=1;
		$copyinfourl=1;
	}
	$ids=',';
	for($i=0;$i<$count;$i++)
	{
		$newclassid=(int)$cr[$i];
		//发布权限
		if(empty($usergroupr['doall'])&&!strstr($usergroupr['add_adminclass'],'|'.$newclassid.'|'))
		{
			continue;
		}
		if(!$newclassid||!$class_r[$newclassid][islast]||$mid<>$class_r[$newclassid][modid]||$newclassid==$classid)
		{
			continue;
		}
		//查看目录是否存在，不存在则建立
		$newspath=FormatPath($newclassid,"",0);
		$newstempid=0;
		$copyids='1';
		//返回自定义字段
		$ret_r=ReturnAddF($r,$mid,$userid,$username,9,1,0);
		if($class_r[$newclassid][wfid])
		{
			$checked=0;
			$isqf=1;
	    }
		else
		{
			$checked=$class_r[$newclassid][checked];
			$isqf=0;
	    }
		//必须审核
		if($usergroupr['domustcheck'])
		{
			$checked=0;
		}
		$checked=(int)$checked;
		//索引表
		$empire->query("insert into {$dbtbpre}ecms_".$tbname."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$newclassid','$checked','$r[newstime]','$r[truetime]','$r[truetime]','$r[havehtml]');");
		$l_id=$empire->lastid();
		$infotbr=ReturnInfoTbname($tbname,$checked,$ret_r['tb']);
		//主表
		$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r[fields].") values('$l_id','$newclassid','$r[ttid]',0,0,0,'$newspath','$filename','$r[userid]','".StripAddsData($r[username])."',0,0,'$r[ispic]',0,'$isqf',0,'$r[isurl]','$r[truetime]',$r[truetime],$r[havehtml],$r[groupid],$r[userfen],'".StripAddsData($r[titlefont])."','".StripAddsData($r[titleurl])."','$ret_r[tb]','$public_r[filedeftb]','$public_r[pldeftb]','".StripAddsData($r[keyboard])."'".$ret_r[values].");");
		//副表
		$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r[datafields].") values('$l_id','$newclassid','$r[keyid]',$r[dokey],'".$newstempid."',$r[closepl],0,''".$ret_r[datavalues].");");
		//公共表
		UpdateInfoCopyids($newclassid,$l_id,$copyids);
		//更新栏目信息数
		AddClassInfos($newclassid,'+1','+1',$checked);
		//更新新信息数
		DoUpdateAddDataNum('info',$class_r[$newclassid]['tid'],1);
		//签发
		if($isqf==1)
		{
			InfoInsertToWorkflow($l_id,$newclassid,$class_r[$newclassid][wfid],$userid,$username);
		}
		//文件命名
		$filename=ReturnInfoFilename($newclassid,$l_id,$r[filenameqz]);
		//信息地址
		$updateinfourl='';
		if(!$copyinfourl)
		{
			$infourl=GotoGetTitleUrl($newclassid,$l_id,$newspath,$filename,$r['groupid'],$r['isurl'],$r['titleurl']);
			$updateinfourl=",titleurl='$infourl'";
		}
		$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl." where id='$l_id' limit 1");
		//生成信息文件
		if($checked)
		{
			$addr=$empire->fetch1("select * from ".$infotbr['tbname']." where id='$l_id' limit 1");
			GetHtml($addr['classid'],$addr['id'],$addr,1);
		}
		$ids.=$l_id.',';
    }
	if($ids==',')
	{
		$ids='';
	}
	return $ids;
}

//发布同步修改
function EditInfoToCopyInfo($classid,$id,$userid,$username,$usergroupr){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($classid)||empty($id))
	{
		return '';
	}
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//公共表
	$pubid=ReturnInfoPubid($classid,$id);
	$pub_r=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid'");
	$cr=explode(',',$pub_r['copyids']);
	$count=count($cr);
	if($count<3)
	{
		return '';
	}
	//索引表
	$index_r=$empire->fetch1("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id='$id' limit 1");
	//返回表
	$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
	//主表
	$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
	//返回表信息
	$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
	//副表
	$fr=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$infotbr['datatbname']."  where id='$id' limit 1");
	$r=array_merge($r,$fr);
	if($stf)//存放文本
	{
		$r[newstext_url]=$r[$stf];
		$r[$stf]=GetTxtFieldText($r[$stf]);
	}
	//信息链接地址
	$titleurl=sys_ReturnBqTitleLink($r);
	for($i=1;$i<$count-1;$i++)
	{
		$infoid=(int)$cr[$i];
		if(empty($infoid))
		{
			continue;
		}
		//索引表
		$index_infor=$empire->fetch1("select classid,checked from {$dbtbpre}ecms_".$tbname."_index where id='$infoid' limit 1");
		//返回表
		$update_infotb=ReturnInfoMainTbname($tbname,$index_infor['checked']);
		if($stf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$stf.','))
			{
				$infor=$empire->fetch1("select stb,isurl,newspath,filename from ".$update_infotb." where id='$infoid' limit 1");
				if(!$infor[stb])
				{
					continue;
				}
				//返回表信息
				$update_infotbr=ReturnInfoTbname($tbname,$index_infor['checked'],$infor['stb']);
				$infodr=$empire->fetch1("select ".$stf." from ".$update_infotbr['datatbname']." where id='$infoid' limit 1");
				$r[newstext_url]=$infodr[$stf];
			}
			else
			{
				$infor=$empire->fetch1("select ".$stf.",stb,isurl,newspath,filename from ".$update_infotb." where id='$infoid' limit 1");
				if(!$infor[stb])
				{
					continue;
				}
				$r[newstext_url]=$infor[$stf];
			}
		}
		else
		{
			$infor=$empire->fetch1("select stb,isurl,newspath,filename from ".$update_infotb." where id='$infoid' limit 1");
			if(!$infor[stb])
			{
				continue;
			}
		}
		if($infor['isurl'])
		{
			$r['titleurl']=$titleurl;
			$r['isurl']=1;
		}
		else
		{
			//信息地址
			$infourl=GotoGetTitleUrl($index_infor['classid'],$infoid,$infor['newspath'],$infor['filename'],$r['groupid'],$infor['isurl'],$r['titleurl']);
			$r['titleurl']=$infourl;
		}
		//返回自定义字段
		$ret_r=ReturnAddF($r,$mid,$userid,$username,8,1,0);
		//返回表信息
		$update_infotbr=ReturnInfoTbname($tbname,$index_infor['checked'],$infor['stb']);
		//索引表
		$empire->query("update {$dbtbpre}ecms_".$tbname."_index set checked='$index_r[checked]',newstime='$r[newstime]',lastdotime='$r[lastdotime]' where id='$infoid'");
		//主表
		$empire->query("update ".$update_infotb." set ttid='$r[ttid]',ispic='$r[ispic]',isurl='$r[isurl]',lastdotime=$r[lastdotime],groupid=$r[groupid],userfen=$r[userfen],titlefont='".StripAddsData($r[titlefont])."',titleurl='".StripAddsData($r[titleurl])."',keyboard='".StripAddsData($r[keyboard])."'".$ret_r[values]." where id='$infoid'");
		//副表
		$empire->query("update ".$update_infotbr['datatbname']." set keyid='$r[keyid]',dokey=$r[dokey],closepl=$r[closepl]".$ret_r[datavalues]." where id='$infoid'");
		//是否改变审核状态
		if($index_infor['checked']!=$index_r['checked'])
		{
			MoveCheckInfoData($tbname,$index_infor['checked'],$infor['stb'],"id='$infoid'");
			//更新栏目信息数
			if($index_r['checked'])
			{
				AddClassInfos($index_infor['classid'],'','+1');
			}
			else
			{
				AddClassInfos($index_infor['classid'],'','-1');
			}
		}
		if($index_r['checked'])
		{
			//生成信息文件
			$addr=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id='$infoid' limit 1");
			GetHtml($addr['classid'],$addr['id'],$addr,1);
		}
	}
}

//发布同步删除
function DelInfoToCopyInfo($classid,$id,$r,$userid,$username,$usergroupr){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($classid)||empty($id))
	{
		return '';
	}
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//公共表
	$pubid=ReturnInfoPubid($classid,$id);
	$pub_r=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid'");
	$cr=explode(',',$pub_r['copyids']);
	$count=count($cr);
	if(empty($r['id'])||$count<3)
	{
		return '';
	}
	$selectdataf='';
	$dh='';
	if($stf&&strstr($emod_r[$mid]['tbdataf'],','.$stf.','))
	{
		$selectdataf.=$stf;
		$dh=',';
	}
	$pf=$emod_r[$mid]['pagef'];
	if($pf&&strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
	{
		$selectdataf.=$dh.$pf;
	}
	for($i=1;$i<$count-1;$i++)
	{
		$infoid=(int)$cr[$i];
		if(empty($infoid))
		{
			continue;
		}
		//索引表
		$index_infor=$empire->fetch1("select checked from {$dbtbpre}ecms_".$tbname."_index where id='$infoid' limit 1");
		//返回表
		$update_infotb=ReturnInfoMainTbname($tbname,$index_infor['checked']);
		//主表
		$infor=$empire->fetch1("select * from ".$update_infotb." where id='$infoid' limit 1");
		if(!$infor[stb])
		{
			continue;
		}
		//返回表信息
		$update_infotbr=ReturnInfoTbname($tbname,$index_infor['checked'],$infor['stb']);
		if($selectdataf)
		{
			$infodr=$empire->fetch1("select ".$selectdataf." from ".$update_infotbr['datatbname']." where id='$infoid' limit 1");
			$infor=array_merge($infor,$infodr);
		}
		//存文本
		if($stf)
		{
			$newstextfile=$infor[$stf];
			$infor[$stf]=GetTxtFieldText($infor[$stf]);
			DelTxtFieldText($newstextfile);//删除文件
		}
		DelNewsFile($infor[filename],$infor[newspath],$infor[classid],$infor[$pf],$infor[groupid]);//删除信息文件
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where id='$infoid'");
		$empire->query("delete from ".$update_infotbr['tbname']." where id='$infoid'");
		$empire->query("delete from ".$update_infotbr['datatbname']." where id='$infoid'");
		//更新栏目信息数
		AddClassInfos($infor['classid'],'-1','-1',$index_infor['checked']);
		//删除其它表记录与附件
		DelSingleInfoOtherData($infor['classid'],$infoid,$infor,0,0);
	}
}

//信息置顶
function TopNews_all($classid,$id,$istop,$userid,$username){
	global $empire,$bclassid,$class_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");//验证权限
	if(!$doselfinfo['dogoodinfo'])//权限
	{
		printerror("NotGoodInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotTopNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	$infotb='';
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		$add.="id='".$infoid."' or ";
		if($infoid&&empty($infotb))
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$infoid' limit 1");
			//返回表
			$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($classid,$infoid);
			$dolog="classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>id=".$infoid;
		}
	}
	if(empty($infotb))
	{
		printerror("NotTopNewsid","history.go(-1)");
	}
	$istop=(int)$istop;
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update ".$infotb." set istop=$istop where ".$add);
	if($index_r['checked'])
	{
		//刷新列表
		ReListHtml($classid,1);
	}
	if($sql)
	{
		//操作日志
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
		}
		printerror("TopNewsSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//审核信息
function CheckNews_all($classid,$id,$userid,$username){
	global $empire,$class_r,$dbtbpre,$emod_r,$adddatar;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//验证权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//权限
	if(!$doselfinfo['docheckinfo'])
	{
		printerror("NotCheckInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotCheckNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//附加链接参数
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$add='';
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		if(empty($infoid))
		{
			continue;
		}
		$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$infoid' limit 1");
		if(!$infor['id']||$infor['isqf']==1)
		{
			continue;
		}
		$sql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$infoid'");
		//投稿增加积分
		if($infor['ismember']&&$infor['userid'])
		{
			$cr=$empire->fetch1("select classid,addinfofen from {$dbtbpre}enewsclass where classid='$infor[classid]'");
			if($cr['addinfofen'])
			{
				$finfor=$empire->fetch1("select haveaddfen from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check_data where id='$infoid' limit 1");
				if(!$finfor['haveaddfen'])
				{
					AddInfoFen($cr[addinfofen],$infor[userid]);
					if($cr['addinfofen']<0)
					{
						BakDown($infor[classid],$infor[id],0,$infor[userid],$infor[username],$infor[title],abs($cr[addinfofen]),3);
					}
				}
			}
			$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check_data set haveaddfen=1 where id='$infoid'");
		}
		//未审核表转换
		MoveCheckInfoData($class_r[$classid][tbname],0,$infor['stb'],"id='$infoid'");
		//更新栏目信息数
		AddClassInfos($infor['classid'],'','+1');
		//刷新信息
		GetHtml($infor['classid'],$infor['id'],$infor,1);
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($infor['classid'],$infor['id']);
			$dolog="classid=".$infor['classid']."<br>id=".$infor['id']."<br>title=".$infor['title'];
		}
    }
	//刷新列表
	//ReListHtml($classid,1);
	$returl=$_SERVER['HTTP_REFERER'];
	//发送通知
	if($adddatar['causetext']&&$infoid)
	{
		if(!$infor['id'])
		{
			$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$infoid' limit 1");
		}
		DoInfoSendNotice($userid,$username,$infor['userid'],$infor['username'],$adddatar['causetext'],$infor,2);
		if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
		{
			$returl=$adddatar['ecmsfrom'];
		}
		else
		{
			$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
		}
	}
	//操作日志
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
	}
	printerror("CheckNewsSuccess",$returl);
}

//取消审核信息
function NoCheckNews_all($classid,$id,$userid,$username){
	global $empire,$class_r,$public_r,$dbtbpre,$emod_r,$adddatar;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//验证权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//权限
	if(!$doselfinfo['docheckinfo'])
	{
		printerror("NotCheckInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotNoCheckNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//附加链接参数
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$pf=$emod_r[$mid]['pagef'];
	$stf=$emod_r[$mid]['savetxtf'];
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		//主表
		$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$infoid' limit 1");
		if(!$r['id']||$r['isqf']==1)
		{
			continue;
		}
		$sql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=0 where id='$infoid'");
		//未审核互转
		MoveCheckInfoData($class_r[$classid][tbname],1,$r['stb'],"id='$infoid'");
		//更新栏目信息数
		AddClassInfos($r['classid'],'','-1');
		//分页字段
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$infoid'");
				$r[$pf]=$finfor[$pf];
			}
			if($stf&&$stf==$pf)//存放文本
			{
				$r[$pf]=GetTxtFieldText($r[$pf]);
			}
		}
		DelNewsFile($r[filename],$r[newspath],$r[classid],$r[$pf],$r[groupid]);
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$r['id']);
			$dolog="classid=".$r['classid']."<br>id=".$r['id']."<br>title=".$r['title'];
		}
	}
	//刷新列表
	ReListHtml($classid,1);
	$returl=$_SERVER['HTTP_REFERER'];
	//发送通知
	if($adddatar['causetext']&&$infoid)
	{
		if(!$r['id'])
		{
			$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$infoid' limit 1");
		}
		DoInfoSendNotice($userid,$username,$r['userid'],$r['username'],$adddatar['causetext'],$r,3);
		if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
		{
			$returl=$adddatar['ecmsfrom'];
		}
		else
		{
			$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
		}
	}
	//操作日志
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
	}
	printerror("NoCheckNewsSuccess",$returl);
}

//移动信息
function MoveNews_all($classid,$id,$to_classid,$userid,$username){
	global $empire,$class_r,$dbtbpre,$emod_r,$adddatar;
	$classid=(int)$classid;
	$to_classid=(int)$to_classid;
	if(empty($classid)||empty($to_classid))
	{
		printerror("EmptyMoveClassid","history.go(-1)");
	}
	if(empty($class_r[$classid][islast])||empty($class_r[$to_classid][islast]))
	{
		printerror("EmptyMoveClassid","history.go(-1)");
	}
	if($class_r[$classid][modid]<>$class_r[$to_classid][modid])
	{
		printerror("DefModid","history.go(-1)");
    }
	//验证权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//权限
	if(!$doselfinfo['domoveinfo'])
	{
		printerror("NotMoveInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotMoveNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//附加链接参数
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$infotb='';
	$tbname=$class_r[$classid][tbname];
	for($i=0;$i<$count;$i++)
	{
		$id[$i]=(int)$id[$i];
		$add.="id='".$id[$i]."' or ";
		if(empty($infotb))
		{
			//索引表
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$tbname."_index where id='".$id[$i]."' limit 1");
			//返回表
			$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
		}
		//主表
		$r=$empire->fetch1("select stb,classid,fstb,restb,id,isurl,filename,groupid,newspath,titleurl,title,ismember,userid,username,newstime,truetime from ".$infotb." where id='".$id[$i]."' limit 1");
		$pubid=ReturnInfoPubid($r['classid'],$id[$i]);
		//信息地址
		$infourl=GotoGetTitleUrl($to_classid,$id[$i],$r['newspath'],$r['filename'],$r['groupid'],$r['isurl'],$r['titleurl']);
		//返回表信息
		$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
		//主表
		$empire->query("update ".$infotb." set classid='$to_classid',titleurl='$infourl' where id='".$id[$i]."'");
		//副表
		$empire->query("update ".$infotbr['datatbname']." set classid='$to_classid' where id='".$id[$i]."'");
		//更新栏目信息数
		AddClassInfos($r['classid'],'-1','-1',$index_r['checked']);
		AddClassInfos($to_classid,'+1','+1',$index_r['checked']);
		//更新信息附加表
		UpdateSingleInfoOtherData($r['classid'],$id[$i],$to_classid,$r,0,0);
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$id[$i]);
			$dolog="classid=".$r['classid']."<br>classname=".$class_r[$r['classid']][classname]."<br>id=".$id[$i]."<br>to_classid=".$to_classid;
		}
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update {$dbtbpre}ecms_".$tbname."_index set classid='$to_classid' where ".$add);
	//刷新列表
	ReListHtml($classid,1);
	ReListHtml($to_classid,1);
	$returl=$_SERVER['HTTP_REFERER'];
	//发送通知
	if($donum==1&&$r['id'])
	{
		DoInfoSendNotice($userid,$username,$r['userid'],$r['username'],$adddatar['causetext'],$r,4);
		if($adddatar['causetext'])
		{
			if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
			{
				$returl=$adddatar['ecmsfrom'];
			}
			else
			{
				$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
			}
		}
	}
	if($sql)
	{
		//操作日志
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>to_classid=".$to_classid);
		}
		printerror("MoveNewsSuccess",$returl);
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//复制信息
function CopyNews_all($classid,$id,$to_classid,$userid,$username){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$to_classid=(int)$to_classid;
	if(empty($classid)||empty($to_classid))
	{
		printerror("EmptyCopyClassid","history.go(-1)");
	}
	if(empty($class_r[$classid][islast])||empty($class_r[$to_classid][islast]))
	{
		printerror("EmptyCopyClassid","history.go(-1)");
	}
	if($class_r[$classid][modid]<>$class_r[$to_classid][modid])
	{
		printerror("DefModid","history.go(-1)");
    }
	$userid=(int)$userid;
	//验证权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//权限
	if(!$doselfinfo['domoveinfo'])
	{
		printerror("NotMoveInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotCopyNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//附加链接参数
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	for($i=0;$i<$count;$i++)
	{
		$add.="id='".intval($id[$i])."' or ";
    }
	$add=substr($add,0,strlen($add)-4);
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//查看目录是否存在，不存在则建立
	$newspath=FormatPath($to_classid,"",0);
    $newstime=time();
    $truetime=$newstime;
	$newstempid=0;
	$dosql=$empire->query("select id,classid,checked from {$dbtbpre}ecms_".$tbname."_index where ".$add);
	while($index_r=$empire->fetch($dosql))
	{
		//返回表
		$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
		//主表
		$r=$empire->fetch1("select * from ".$infotb." where id='$index_r[id]' limit 1");
		//返回表信息
		$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
		//副表
		$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$infotbr['datatbname']." where id='$r[id]' limit 1");
		$r=array_merge($r,$finfor);
		if($stf)//存放文本
		{
			$r[$stf]=GetTxtFieldText($r[$stf]);
		}
		//返回自定义字段
		$ret_r=ReturnAddF($r,$class_r[$to_classid][modid],$userid,$username,9,1,0);
		if($class_r[$to_classid][wfid])
		{
			$checked=0;
			$isqf=1;
	    }
		else
		{
			$checked=$class_r[$to_classid][checked];
			$isqf=0;
	    }
		$checked=(int)$checked;
		//索引表
		$empire->query("insert into {$dbtbpre}ecms_".$tbname."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$to_classid','$checked','$r[newstime]','$truetime','$truetime','$r[havehtml]');");
		$l_id=$empire->lastid();
		$update_infotbr=ReturnInfoTbname($tbname,$checked,$ret_r['tb']);
		//主表
		$sql=$empire->query("insert into ".$update_infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r[fields].") values('$l_id','$to_classid','$r[ttid]',0,0,0,'$newspath','$filename',$userid,'$username',0,0,'$r[ispic]',0,'$isqf',0,'$r[isurl]',$truetime,$truetime,$r[havehtml],$r[groupid],$r[userfen],'$r[titlefont]','$r[titleurl]','$ret_r[tb]','$public_r[filedeftb]','$public_r[pldeftb]','$r[keyboard]'".$ret_r[values].");");		
		//副表
		$empire->query("insert into ".$update_infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r[datafields].") values('$l_id','$to_classid','$r[keyid]',$r[dokey],'".$newstempid."',$r[closepl],0,'$r[infotags]'".$ret_r[datavalues].");");
		//签发
		if($isqf==1)
		{
			InfoInsertToWorkflow($l_id,$to_classid,$class_r[$to_classid][wfid],$userid,$username);
		}
		//文件命名
		$filename=ReturnInfoFilename($to_classid,$l_id,$r[filenameqz]);
		//信息地址
		$updateinfourl='';
		if(!$r['isurl'])
		{
			$infourl=GotoGetTitleUrl($to_classid,$l_id,$newspath,$filename,$r['groupid'],$r['isurl'],$r['titleurl']);
			$updateinfourl=",titleurl='$infourl'";
		}
		$usql=$empire->query("update ".$update_infotbr['tbname']." set filename='$filename'".$updateinfourl." where id='$l_id'");
		//更新栏目信息数
		AddClassInfos($to_classid,'+1','+1',$index_r['checked']);
		//生成信息文件
		if($checked)
		{
			$addr=$empire->fetch1("select * from ".$update_infotbr['tbname']." where id='$l_id'");
			GetHtml($addr['classid'],$addr['id'],$addr,1);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$r['id']);
			$dolog="classid=".$r['classid']."<br>id=".$r['id']."<br>title=".$r['title']."<br>to_classid=".$to_classid;
		}
	}
	//刷新列表
	ReListHtml($to_classid,1);
	//操作日志
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>to_classid=".$to_classid);
	}
	printerror("CopyNewsSuccess",$_SERVER['HTTP_REFERER']);
}

//批量转移信息
function MoveClassNews($add,$userid,$username){
	global $empire,$class_r,$dbtbpre,$emod_r;
	$add[classid]=(int)$add[classid];
	$add[toclassid]=(int)$add[toclassid];
	if(empty($add[classid])||empty($add[toclassid]))
	{
		printerror("EmptyMovetoClassid","history.go(-1)");
	}
	if($class_r[$add[classid]][modid]<>$class_r[$add[toclassid]][modid])
	{
		printerror("DefModid","history.go(-1)");
    }
	//验证权限
	CheckLevel($userid,$username,$classid,"movenews");
	//终极栏目
	if(!$class_r[$add[classid]][islast]||!$class_r[$add[toclassid]][islast])
	{
		printerror("MovetoClassidMustLastid","history.go(-1)");
	}
	if($add[classid]==$add[toclassid])
	{
		printerror("MoveClassidsame","history.go(-1)");
	}
	$mid=$class_r[$add[classid]][modid];
	$tbname=$class_r[$add[classid]][tbname];
	//主表
	$indexsql=$empire->query("update {$dbtbpre}ecms_".$tbname."_index set classid=$add[toclassid] where classid='$add[classid]'");
	$sql=$empire->query("update {$dbtbpre}ecms_".$tbname." set classid=$add[toclassid] where classid='$add[classid]'");
	$empire->query("update {$dbtbpre}ecms_".$tbname."_check set classid=$add[toclassid] where classid='$add[classid]'");
	$empire->query("update {$dbtbpre}ecms_".$tbname."_doc set classid=$add[toclassid] where classid='$add[classid]'");
	//副表
	UpdateAllDataTbField($tbname,"classid='$add[toclassid]'"," where classid='$add[classid]'",1,1);
	//更新栏目信息数
	$cr=$empire->fetch1("select classid,allinfos,infos from {$dbtbpre}enewsclass where classid='$add[classid]'");
	AddClassInfos($add[classid],'-'.$cr[allinfos],'-'.$cr[infos]);
	$tocr=$empire->fetch1("select classid,allinfos,infos from {$dbtbpre}enewsclass where classid='$add[toclassid]'");
	AddClassInfos($add[toclassid],'+'.$cr[allinfos],'+'.$cr[infos]);
	//更新信息附加表与附件表
	UpdateMoreInfoOtherData($add[classid],$add[toclassid],0,0);
	//生成信息列表
	ListHtml($add[toclassid],$ret_r,0);
	//移动数据
	$opath=ECMS_PATH.$class_r[$add[classid]][classpath];
    DelPath($opath);//删除旧的栏目目录
	$mk=DoMkdir($opath);
	if($sql)
	{
		//操作日志
		insert_dolog("classid=".$add[classid]."&nbsp;(".$class_r[$add[classid]][classname].")<br>toclassid=".$add[toclassid]."(".$class_r[$add[toclassid]][classname].")");
		printerror("MoveClassNewsSuccess","MoveClassNews.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//批量推荐/头条信息
function GoodInfo_all($classid,$id,$isgood,$doing=0,$userid,$username){
	global $empire,$class_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//验证权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//权限
	if(!$doselfinfo['dogoodinfo'])
	{
		printerror("NotGoodInfoLevel","history.go(-1)");
	}
	//附加链接参数
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$isgood=(int)$isgood;
	$doing=(int)$doing;
	if($doing==0)//推荐
	{
		$mess="EmptyGoodInfoId";
		$domess="GoodInfoSuccess";
		$setf="isgood=$isgood";
	}
	else//头条
	{
		$mess="EmptyFirsttitleInfoId";
		$domess="FirsttitleInfoSuccess";
		$setf="firsttitle=$isgood";
	}
	$count=count($id);
	if(empty($count))
	{
		printerror($mess,"history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	$infotb='';
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		$add.="id='".$infoid."' or ";
		if($infoid&&empty($infotb))
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$infoid' limit 1");
			//返回表
			$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($classid,$infoid);
			$dolog="classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>id=".$infoid."&doing=$doing";
		}
    }
	if(empty($infotb))
	{
		printerror($mess,"history.go(-1)");
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update ".$infotb." set ".$setf." where ".$add);
	if($sql)
	{
		//操作日志
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>doing=".$doing);
		}
		printerror($domess,$_SERVER['HTTP_REFERER']);
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//本栏目信息全部审核
function SetAllCheckInfo($bclassid,$classid,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//验证权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//权限
	if(!$doselfinfo['docheckinfo'])
	{
		printerror("NotCheckInfoLevel","history.go(-1)");
	}
	//附加链接参数
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$sql=$empire->query("select id,classid,userid,ismember,isqf,stb from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where classid='$classid'");
	$n=0;
	while($r=$empire->fetch($sql))
	{
		//只能操作自己的信息
		if($doselfinfo['doselfinfo']&&($userid!=$r['userid']||$r['ismember']==1))
		{
			continue;
		}
		if($r['isqf']==1)
		{
			continue;
		}
		$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$r[id]'");
		//审核表转换
		MoveCheckInfoData($class_r[$classid][tbname],0,$r['stb'],"id='$r[id]'");
		$n++;
	}
	//更新栏目信息数
	AddClassInfos($classid,'','+'.$n);
	//操作日志
	insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
	printerror("CheckNewsSuccess",$_SERVER['HTTP_REFERER']);
}

//签发信息
function DoWfInfo($add,$userid,$username){
	global $empire,$dbtbpre,$class_r,$emod_r,$lur;
	$id=(int)$add[id];
	$classid=(int)$add[classid];
	$doing=(int)$add['doing'];
	if(!$id||!$classid||!$doing)
	{
		printerror('EmptyDoWfInfo','');
	}
	$wfinfor=$empire->fetch1("select id,checknum,wfid,tid,groupid,userclass,username,checktno from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid' limit 1");
	if(!$wfinfor[id])
	{
		printerror('ErrorUrl','');
	}
	if($wfinfor[checktno]=='100'||$wfinfor[checktno]=='101'||$wfinfor[checktno]=='102')
	{
		printerror('DoWfInfoOver','');
	}
	$wfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where tid='$wfinfor[tid]'");
	if(!(strstr(','.$wfitemr[groupid].',',','.$lur[groupid].',')||strstr(','.$wfitemr[userclass].',',','.$lur[classid].',')||strstr(','.$wfitemr[username].',',','.$lur[username].',')))
	{
		printerror("NotDoCheckUserLevel","history.go(-1)");
	}
	if(!(strstr(','.$wfinfor[groupid].',',','.$lur[groupid].',')||strstr(','.$wfinfor[userclass].',',','.$lur[classid].',')||strstr(','.$wfinfor[username].',',','.$lur[username].',')))
	{
		printerror("HaveDoWfInfo","history.go(-1)");
	}
	$pubid=ReturnInfoPubid($classid,$id);
	//附加链接参数
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$checktext=ehtmlspecialchars($add[checktext]);
	if($doing==1)//通过
	{
		if($wfitemr[lztype]==0)//普签
		{
			if($wfitemr['tno']=='100')//全部通过
			{
				$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$id'");
				$ar=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$id'");
				//未审核表转换
				MoveCheckInfoData($class_r[$classid][tbname],0,$ar['stb'],"id='$id'");
				//更新栏目信息数
				AddClassInfos($classid,'','+1');
				$empire->query("update {$dbtbpre}enewswfinfo set tstatus='',checktno='100' where id='$id' and classid='$classid' limit 1");
				//日志
				InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
				//生成
				GetHtml($ar['classid'],$ar['id'],$ar,1);
				ListHtml($classid,$fr,0);
			}
			else//流转
			{
				$newwfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfitemr[wfid]' and tno>$wfitemr[tno] order by tno limit 1");
				$empire->query("update {$dbtbpre}enewswfinfo set tid='$newwfitemr[tid]',groupid='$newwfitemr[groupid]',userclass='$newwfitemr[userclass]',username='$newwfitemr[username]',tstatus='$newwfitemr[tstatus]',checktno='0' where id='$id' and classid='$classid' limit 1");
				//日志
				InsertWfLog($classid,$id,$newwfitemr[wfid],$newwfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
			}
		}
		else//会签
		{
			$newgroupid=str_replace(','.$lur[groupid].',',',',$wfinfor[groupid]);
			$newuserclass=str_replace(','.$lur[classid].',',',',$wfinfor[userclass]);
			$newusername=str_replace(','.$lur[username].',',',',$wfinfor[username]);
			//下一个节点
			if(($newgroupid==''||$newgroupid==',')&&($newuserclass==''||$newuserclass==',')&&($newusername==''||$newusername==','))
			{
				if($wfitemr['tno']=='100')//全部通过
				{
					$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$id'");
					$ar=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$id'");
					//未审核表转换
					MoveCheckInfoData($class_r[$classid][tbname],0,$ar['stb'],"id='$id'");
					//更新栏目信息数
					AddClassInfos($classid,'','+1');
					$empire->query("update {$dbtbpre}enewswfinfo set tstatus='',checktno='100' where id='$id' and classid='$classid' limit 1");
					//日志
					InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
					//生成
					GetHtml($ar['classid'],$ar['id'],$ar,1);
					ListHtml($classid,$fr,0);
				}
				else//流转
				{
					$newwfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfitemr[wfid]' and tno>$wfitemr[tno] order by tno limit 1");
					$empire->query("update {$dbtbpre}enewswfinfo set tid='$newwfitemr[tid]',groupid='$newwfitemr[groupid]',userclass='$newwfitemr[userclass]',username='$newwfitemr[username]',tstatus='$newwfitemr[tstatus]',checktno='0' where id='$id' and classid='$classid' limit 1");
					//日志
					InsertWfLog($classid,$id,$newwfitemr[wfid],$newwfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
				}
			}
			else//本节点继续
			{
				$empire->query("update {$dbtbpre}enewswfinfo set groupid='$newgroupid',userclass='$newuserclass',username='$newusername' where id='$id' and classid='$classid' limit 1");
				//日志
				InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
			}
		}
		$mess='DoWfInfoCkSuccess';
	}
	elseif($doing==2)//返工
	{
		if(empty($checktext))
		{
			printerror('EmptyChecktext','history.go(-1)');
		}
		if($wfitemr[tbdo]==0)//发给作者
		{
			$empire->query("update {$dbtbpre}enewswfinfo set tid=0,tstatus='',checktno='101' where id='$id' and classid='$classid' limit 1");
		}
		else//发给节点
		{
			$newwfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfitemr[wfid]' and tid='$wfitemr[tbdo]' limit 1");
			$empire->query("update {$dbtbpre}enewswfinfo set tid='$newwfitemr[tid]',groupid='$newwfitemr[groupid]',userclass='$newwfitemr[userclass]',username='$newwfitemr[username]',tstatus='$newwfitemr[tstatus]',checktno='101' where id='$id' and classid='$classid' limit 1");
		}
		//日志
		InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],2);
		$mess='DoWfInfoTbSuccess';
	}
	else//否决
	{
		if(empty($checktext))
		{
			printerror('EmptyChecktext','history.go(-1)');
		}
		$empire->query("update {$dbtbpre}enewswfinfo set tid=0,tstatus='',checktno='102' where id='$id' and classid='$classid' limit 1");
		//日志
		InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],3);
		if($wfitemr[tddo])//删除信息
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id' limit 1");
			//返回表
			$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
			$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
			$mid=$class_r[$classid][modid];
			$tbname=$class_r[$classid][tbname];
			$pf=$emod_r[$mid]['pagef'];
			$stf=$emod_r[$mid]['savetxtf'];
			//返回表信息
			$infotbr=ReturnInfoTbname($class_r[$classid][tbname],$index_r['checked'],$r['stb']);
			//分页字段
			if($pf)
			{
				if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
				{
					$finfor=$empire->fetch1("select ".$pf." from ".$infotbr['datatbname']." where id='$id' limit 1");
					$r[$pf]=$finfor[$pf];
				}
			}
			//存文本
			if($stf)
			{
				$newstextfile=$r[$stf];
				$r[$stf]=GetTxtFieldText($r[$stf]);
				DelTxtFieldText($newstextfile);//删除文件
			}
			DelNewsFile($r[filename],$r[newspath],$classid,$r[$pf],$r[groupid]);//删除信息文件
			$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where id='$id'");
			$sql=$empire->query("delete from ".$infotbr['tbname']." where id='$id'");
			$fsql=$empire->query("delete from ".$infotbr['datatbname']." where id='$id'");
			//更新栏目信息数
			AddClassInfos($r[classid],'-1','-1',$index_r['checked']);
			//删除其它表记录与附件
			DelSingleInfoOtherData($r['classid'],$id,$r,0,0);
		}
		$mess='DoWfInfoTdSuccess';
		$isclose=1;
	}
	//操作日志
	insert_dolog("classid=$classid&id=$id",$pubid);
	printerror($mess,"workflow/DoWfInfo.php?classid=$classid&id=$id&isclose=$isclose".hReturnEcmsHashStrHref2(0));
}

//批量删除信息
function DelInfoData($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$add,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre,$emod_r;
	//验证权限
	CheckLevel($userid,$username,$classid,"delinfodata");
	$search='';
	$start=(int)$start;
	$tbname=RepPostVar($tbname);
	if(empty($tbname))
	{
		printerror("ErrorUrl","history.go(-1)");
    }
	$search.="&tbname=$tbname";
	//查询表
	$infotb="{$dbtbpre}ecms_".$tbname;
	//按栏目
	$classid=(int)$classid;
	if($classid)
	{
		if(empty($class_r[$classid][islast]))//大栏目
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//终极栏目
		{
			$where="classid='$classid'";
		}
		$add1=" and (".$where.")";
		$search.="&classid=$classid";
    }
	//按ID刷新
	$search.="&retype=$retype";
	if($retype)
	{
		$startid=(int)$startid;
		$endid=(int)$endid;
		if($endid)
		{
			$add1.=" and id>=$startid and id<=$endid";
	    }
		$search.="&startid=$startid&endid=$endid";
    }
	else
	{
		$startday=RepPostVar($startday);
		$endday=RepPostVar($endday);
		if($startday&&$endday)
		{
			$add1.=" and truetime>=".to_time($startday." 00:00:00")." and truetime<=".to_time($endday." 23:59:59");
	    }
		$search.="&startday=$startday&endday=$endday";
    }
	//信息类型
	$delckinfo=0;
	$infost=(int)$add['infost'];
	if($infost)
	{
		if($infost==1)//已审核
		{
			$delckinfo=1;
		}
		else//未审核
		{
			$infotb="{$dbtbpre}ecms_".$tbname."_check";
			$delckinfo=2;
		}
		$search.="&infost=$infost";
	}
	else
	{
		$dodelcheck=(int)$add['dodelcheck'];
		if($dodelcheck)
		{
			$infotb="{$dbtbpre}ecms_".$tbname."_check";
			$delckinfo=2;
			$search.="&dodelcheck=1";
		}
	}
	//用户发布
	$ismember=(int)$add['ismember'];
	if($ismember)
	{
		if($ismember==1)//游客
		{
			$add1.=" and userid=0";
		}
		elseif($ismember==2)//会员+用户
		{
			$add1.=" and userid>0";
		}
		elseif($ismember==3)//会员
		{
			$add1.=" and userid>0 and ismember=1";
		}
		elseif($ismember==4)//用户
		{
			$add1.=" and userid>0 and ismember=0";
		}
		$search.="&ismember=$ismember";
	}
	//是否外部链接
	$isurl=(int)$add['isurl'];
	if($isurl)
	{
		if($isurl==1)//外部链接
		{
			$add1.=" and isurl=1";
		}
		else//内部信息
		{
			$add1.=" and isurl=0";
		}
		$search.="&isurl=$isurl";
	}
	//评论数
	$plnum=(int)$add['plnum'];
	if($plnum)
	{
		$add1.=" and plnum<".$plnum;
		$search.="&plnum=$plnum";
	}
	//点击数
	$onclick=(int)$add['onclick'];
	if($onclick)
	{
		$add1.=" and onclick<".$onclick;
		$search.="&onclick=$onclick";
	}
	//下载数
	$totaldown=(int)$add['totaldown'];
	if($totaldown)
	{
		$add1.=" and totaldown<".$totaldown;
		$search.="&totaldown=$totaldown";
	}
	//用户ID
	$userids=RepPostVar($add['userids']);
	$usertype=(int)$add['usertype'];
	if($userids)
	{
		$uidsr=explode(',',$userids);
		$uidscount=count($uidsr);
		$uids='';
		$udh='';
		for($ui=0;$ui<$uidscount;$ui++)
		{
			$uids.=$udh.intval($uidsr[$ui]);
			$udh=',';
		}
		if($usertype==1)//用户
		{
			$add1.=" and userid in (".$uids.") and ismember=0";
		}
		else//会员
		{
			$add1.=" and userid in (".$uids.") and ismember=1";
		}
		$search.="&userids=$userids&usertype=$usertype";
	}
	//标题
	$title=RepPostStr($add['title']);
	if($title)
	{
		$titler=explode('|',$title);
		$titlecount=count($titler);
		$titlewhere='';
		$titleor='';
		for($ti=0;$ti<$titlecount;$ti++)
		{
			$titlewhere.=$titleor."title like '%".$titler[$ti]."%'";
			$titleor=' or ';
		}
		$add1.=" and (".$titlewhere.")";
		$search.="&title=$title";
	}
	$b=0;
	$sql=$empire->query("select * from ".$infotb." where id>$start".$add1." order by id limit ".$public_r[delnewsnum]);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r[id];
		$mid=$emod_r[$r[classid]]['modid'];
		$pf=$emod_r[$mid]['pagef'];
		$stf=$emod_r[$mid]['savetxtf'];
		//未审核表
		if($delckinfo==2)
		{
			$infodatatb="{$dbtbpre}ecms_".$tbname."_check_data";
		}
		else
		{
			$infodatatb="{$dbtbpre}ecms_".$tbname."_data_".$r['stb'];
		}
		//分页字段
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				$finfor=$empire->fetch1("select ".$pf." from ".$infodatatb." where id='$r[id]' limit 1");
				$r[$pf]=$finfor[$pf];
			}
		}
		//存文本
		if($stf)
		{
			$newstextfile=$r[$stf];
			$r[$stf]=GetTxtFieldText($r[$stf]);
			DelTxtFieldText($newstextfile);//删除文件
		}
		//删除信息文件
		if($add['delhtml']!=1&&$delckinfo!=2)
		{
			DelNewsFile($r[filename],$r[newspath],$r[classid],$r[$pf],$r[groupid]);
		}
		//删除表信息
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where id='$r[id]'");
		$empire->query("delete from ".$infotb." where id='$r[id]'");
		$empire->query("delete from ".$infodatatb." where id='$r[id]'");
		//更新栏目信息数
		AddClassInfos($r['classid'],'-1','-1',($delckinfo==2?0:1));
		//删除其它表记录和附件
		DelSingleInfoOtherData($r['classid'],$r['id'],$r,0,0);
	}
	if(empty($b))
	{
		if($delckinfo==0&&!$dodelcheck)
		{
			echo $fun_r[DelDataSuccess]."<script>self.location.href='ecmsinfo.php?enews=DelInfoData&start=0&from=".urlencode($from)."&delhtml=$add[delhtml]&dodelcheck=1".$search.hReturnEcmsHashStrHref(0)."';</script>";
			exit();
		}
	    //操作日志
	    insert_dolog("");
		printerror("DelNewsAllSuccess","db/DelData.php".hReturnEcmsHashStrHref2(1));
	}
	echo $fun_r[OneDelDataSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmsinfo.php?enews=DelInfoData&start=$new_start&from=".urlencode($from)."&delhtml=$add[delhtml]".$search.hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//归档信息(栏目)
function InfoToDoc_class($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$class_r;
	//操作权限
	CheckLevel($userid,$username,$classid,"class");
	$classid=(int)$add['classid'];
	if(!$classid)
	{
		printerror("EmptyDocClass","");
	}
	$start=(int)$add['start'];
	$cr=$empire->fetch1("select tbname,doctime from {$dbtbpre}enewsclass where classid='$classid' and islast=1");
	if(!$cr['tbname']||!$cr['doctime'])
	{
		printerror("EmptyDocTimeClass","");
	}
	$line=$public_r['docnewsnum'];
	$b=0;
	$doctime=time()-$cr['doctime']*24*3600;
	$sql=$empire->query("select * from {$dbtbpre}ecms_".$cr[tbname]." where id>$start and classid='$classid' and truetime<$doctime order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['id'];
		DoDocInfo($cr[tbname],$r,0);
	}
	if(empty($b))
	{
		//未审核信息
		DoDocCkInfo($cr['tbname'],"classid='$classid' and truetime<$doctime",0);
		$add['docfrom']=urldecode($add['docfrom']);
		//操作日志
		insert_dolog("tbname=".$cr['tbname']."&classid=$classid&do=1");
		printerror("InfoToDocSuccess",$add['docfrom']);
	}
	echo $fun_r[OneInfoToDocSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmsinfo.php?enews=InfoToDoc&ecmsdoc=1&classid=$classid&start=$new_start&docfrom=".urlencode($add[docfrom]).hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//归档信息(按条件批量)
function InfoToDoc($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$class_r;
	//操作权限
	CheckLevel($userid,$username,$classid,"infodoc");
	$tbname=RepPostVar($add['tbname']);
	if(empty($tbname))
	{
		printerror("EmptyDocTb","");
	}
	$selecttbname=$tbname;
	if($add['doing']==1)
	{
		$selecttbname=$tbname.'_doc';
	}
	$search="&retype=$add[retype]";
	if($add['retype']==0)//按天数归档
	{
		if($add['doing']==1)//还原
		{
			$doctime=(int)$add['doctime1'];
			$dx=">";
		}
		else//归档
		{
			$doctime=(int)$add['doctime'];
			$dx="<";
		}
		if(!$doctime)
		{
			printerror("EmptyDoctime","");
		}
		$chtime=time()-$doctime*24*3600;
		$where='truetime'.$dx.$chtime;
		$log="doctime=$doctime";
		$search.="&doctime=$add[doctime]&doctime1=$add[doctime1]";
	}
	elseif($add['retype']==1)//按时间归档
	{
		$startday=RepPostVar($add['startday']);
		$endday=RepPostVar($add['endday']);
		if(!$endday)
		{
			printerror("EmptyDocDay","");
		}
		if($startday)
		{
			$where="truetime>=".to_time($startday." 00:00:00")." and ";
		}
		$where.="truetime<=".to_time($endday." 23:59:59");
		$log="startday=$startday&endday=$endday";
		$search.="&startday=$add[startday]&endday=$add[endday]";
	}
	else//按ID归档
	{
		$startid=(int)$add['startid'];
		$endid=(int)$add['endid'];
		if(!$endid)
		{
			printerror("EmptyDocId","");
		}
		if($startid)
		{
			$where="id>=".$startid." and ";
		}
		$where.="id<=".$endid;
		$log="startid=$startid&endid=$endid";
		$search.="&startid=$add[startid]&endid=$add[endid]";
	}
	//栏目
	$classid=$add['classid'];
	$count=count($classid);
	if($count)
	{
		for($i=0;$i<$count;$i++)
		{
			$dh=",";
			if($i==0)
			{
				$dh="";
			}
			$ids.=$dh.intval($classid[$i]);
			$search.='&classid[]='.$classid[$i];
		}
		$where.=" and classid in (".$ids.")";
	}
	$log.="<br>doing=$add[doing]";
	$start=(int)$add['start'];
	$line=$public_r['docnewsnum'];
	$b=0;
	$sql=$empire->query("select * from {$dbtbpre}ecms_".$selecttbname." where id>$start and ".$where." order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['id'];
		DoDocInfo($tbname,$r,$add['doing']);
	}
	if(empty($b))
	{
		//未审核信息归档
		DoDocCkInfo($tbname,$where,$add['doing']);
		$add['docfrom']=urldecode($add['docfrom']);
		//操作日志
		insert_dolog("tbname=".$tbname.$log."&doing=$add[doing]&do=2");
		printerror("InfoToDocSuccess",$add['docfrom']);
	}
	echo $fun_r[OneInfoToDocSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmsinfo.php?enews=InfoToDoc&ecmsdoc=2&doing=$add[doing]&tbname=$tbname&start=$new_start&docfrom=".urlencode($add[docfrom]).$search.hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//归档信息(选择信息)
function InfoToDoc_info($add,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$add['classid'];
	//操作权限
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//权限
	if(!$doselfinfo['dodocinfo'])
	{
		printerror("NotDocInfoLevel","history.go(-1)");
	}
	$id=$add['id'];
	$count=count($id);
	if($count==0)
	{
		printerror("EmptyDocInfo","");
	}
	$tbname=$class_r[$classid]['tbname'];
	if(empty($tbname))
	{
		printerror("EmptyDocInfo","");
	}
	$selecttbname=$tbname;
	if($add['doing']==1)
	{
		$selecttbname=$tbname.'_doc';
	}
	for($i=0;$i<$count;$i++)
	{
		$dh=",";
		if($i==0)
		{
			$dh="";
		}
		$ids.=$dh.intval($id[$i]);
	}
	$where="id in (".$ids.")";
	$sql=$empire->query("select * from {$dbtbpre}ecms_".$selecttbname." where ".$where);
	while($r=$empire->fetch($sql))
	{
		DoDocInfo($tbname,$r,$add['doing']);
	}
	//未审核信息归档
	DoDocCkInfo($tbname,$where,$add['doing']);
	$add['docfrom']=urldecode($add['docfrom']);
	//操作日志
	insert_dolog("tbname=".$tbname."&doing=$add[doing]&do=0");
	printerror("InfoToDocSuccess",$add['docfrom']);
}

//处理归档
function DoDocInfo($tb,$r,$ecms=0){
	global $empire,$dbtbpre,$class_r,$emod_r;
	if($ecms==1)//还原
	{
		$table=$dbtbpre.'ecms_'.$tb.'_doc_index';	//索引表
		$table1=$dbtbpre.'ecms_'.$tb.'_doc';	//主表
		$table2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//副表
		$ytable=$dbtbpre.'ecms_'.$tb.'_index';	//目标索引表
		$ytable1=$dbtbpre.'ecms_'.$tb;	//目标主表
		$ytable2=$dbtbpre.'ecms_'.$tb.'_data_'.$r[stb];	//目标副表
	}
	else//归档
	{
		$table=$dbtbpre.'ecms_'.$tb.'_index';	//索引表
		$table1=$dbtbpre.'ecms_'.$tb;	//主表
		$table2=$dbtbpre.'ecms_'.$tb.'_data_'.$r[stb];	//副表
		$ytable=$dbtbpre.'ecms_'.$tb.'_doc_index';	//目标索引表
		$ytable1=$dbtbpre.'ecms_'.$tb.'_doc';	//目标主表
		$ytable2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//目标副表
	}
	$mid=$class_r[$r[classid]][modid];
	//索引表
	$index_r=$empire->fetch1("select * from ".$table." where id='$r[id]' limit 1");
	if($index_r['checked']==0)
	{
		return '';
	}
	//副表
	$fr=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$table2." where id='$r[id]' limit 1");
	$r=array_merge($r,$fr);
	$ret_r=ReturnAddF($r,$mid,$userid,$username,10,0,0);//返回自定义字段
	//索引表
	$empire->query("insert into ".$ytable."(id,classid,checked,newstime,truetime,lastdotime,havehtml) values('$index_r[id]','$index_r[classid]','$index_r[checked]','$index_r[newstime]','$index_r[truetime]','$index_r[lastdotime]','$index_r[havehtml]');");
	//主表
	$empire->query("replace into ".$ytable1."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r[fields].") values('$r[id]','$r[classid]','$r[ttid]','$r[onclick]','$r[plnum]','$r[totaldown]','".StripAddsData($r[newspath])."','".StripAddsData($r[filename])."','$r[userid]','".StripAddsData($r[username])."','$r[firsttitle]','$r[isgood]','$r[ispic]','$r[istop]','$r[isqf]','$r[ismember]','$r[isurl]','$r[truetime]','$r[lastdotime]','$r[havehtml]','$r[groupid]','$r[userfen]','".StripAddsData($r[titlefont])."','".StripAddsData($r[titleurl])."','$r[stb]','$r[fstb]','$r[restb]','".StripAddsData($r[keyboard])."'".$ret_r[values].");");
	//副表
	$empire->query("replace into ".$ytable2."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r[datafields].") values('$r[id]','$r[classid]','$r[keyid]','$r[dokey]','$r[newstempid]','$r[closepl]','$r[haveaddfen]','".StripAddsData($r[infotags])."'".$ret_r[datavalues].");");
	//删除
	$empire->query("delete from ".$table." where id='$r[id]'");
	$empire->query("delete from ".$table1." where id='$r[id]'");
	$empire->query("delete from ".$table2." where id='$r[id]'");
	//更新栏目信息数
	if($ecms==1)//还原
	{
		AddClassInfos($r['classid'],'+1','+1');
	}
	else//归档
	{
		AddClassInfos($r['classid'],'-1','-1');
	}
}

//处理归档(未审核信息)
function DoDocCkInfo($tb,$where,$ecms=0){
	global $empire,$dbtbpre,$class_r,$emod_r;
	if($ecms==1)//还原
	{
		$table=$dbtbpre.'ecms_'.$tb.'_doc_index';	//主表
		$table1=$dbtbpre.'ecms_'.$tb.'_doc';	//主表
		$table2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//副表
		$ytable=$dbtbpre.'ecms_'.$tb.'_index';	//目标主表
		$ytable1=$dbtbpre.'ecms_'.$tb.'_check';	//目标主表
		$ytable2=$dbtbpre.'ecms_'.$tb.'_check_data';	//目标副表
	}
	else//归档
	{
		$table=$dbtbpre.'ecms_'.$tb.'_index';	//主表
		$table1=$dbtbpre.'ecms_'.$tb.'_check';	//主表
		$table2=$dbtbpre.'ecms_'.$tb.'_check_data';	//副表
		$ytable=$dbtbpre.'ecms_'.$tb.'_doc_index';	//目标主表
		$ytable1=$dbtbpre.'ecms_'.$tb.'_doc';	//目标主表
		$ytable2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//目标副表
	}
	//转换副表
	$fids='';
	$dh='';
	$sql=$empire->query("select id,classid from ".$table1." where ".$where);
	while($r=$empire->fetch($sql))
	{
		$fids.=$dh.$r['id'];
		$dh=',';
		//更新栏目信息数
		if($ecms==1)//还原
		{
			AddClassInfos($r['classid'],'+1','',0);
		}
		else//归档
		{
			AddClassInfos($r['classid'],'-1','',0);
		}
	}
	if(empty($fids))
	{
		return '';
	}
	$empire->query("replace into ".$ytable." select * from ".$table." where ".$where);
	$empire->query("replace into ".$ytable1." select * from ".$table1." where ".$where);
	$empire->query("replace into ".$ytable2." select * from ".$table2." where id in (".$fids.")");
	//删除
	$empire->query("delete from ".$table." where ".$where);
	$empire->query("delete from ".$table1." where ".$where);
	$empire->query("delete from ".$table2." where id in (".$fids.")");
}

//发送信息操作通知
function DoInfoSendNotice($userid,$username,$to_userid,$to_username,$causetext,$infor,$ecms=0){
	global $empire,$dbtbpre,$class_r;
	if(!$infor['ismember'])
	{
		return '';
	}
	//操作者
	$user_r=$empire->fetch1("select truename from {$dbtbpre}enewsuser where userid='$userid'");
	$dousername=$user_r['truename']?$user_r['truename']:$username;
	//操作类型
	if($ecms==1)
	{
		$doing='删除';
		$title='您的信息被删除';
	}
	elseif($ecms==2)
	{
		$doing='审核通过';
		$title='您的信息已审核通过';
	}
	elseif($ecms==3)
	{
		$doing='取消审核';
		$title='您的信息被取消审核';
	}
	elseif($ecms==4)
	{
		$doing='转移';
		$title='您的信息被转移';
	}
	//操作信息
	$title=RepPostStr($title);
	$causetext=RepPostStr($causetext);
	$dotime=date("Y-m-d H:i:s");
	//信息内容
	$titleurl=sys_ReturnBqTitleLink($infor);
	$infotitle=$infor['title'];
	$infotime=date("Y-m-d H:i:s",$infor[truetime]);
	$classname=$class_r[$infor[classid]]['classname'];
	$classurl=sys_ReturnBqClassname($infor,9);
	$isadmin=$infor['ismember']==1?0:1;

	$msgtext="您发布的信息被 <strong>$dousername</strong> 执行 <strong>$doing</strong> 操作<br>
<br>
<strong>信息标题：</strong><a href='".$titleurl."'>".$infotitle."</a><br>
<strong>发布时间：</strong>".$infotime."<br>
<strong>所在栏目：</strong><a href='".$classurl."'>".$classname."</a><br>
<strong>操作时间：</strong>$dotime<br>
<strong>操作理由：</strong>".$causetext."<br>";
	
	eSendMsg(addslashes($title),addslashes($msgtext),$to_username,0,'',1,1,$isadmin);
}
?>