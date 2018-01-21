<?php
//修改采集信息
function EditCjNews($add,$newstext,$userid,$username){
	global $empire,$class_r,$dbtbpre,$public_r;
	$add[classid]=(int)$add[classid];
	$add[id]=(int)$add[id];
	if(empty($add[classid])||empty($add[id])||empty($add[title]))
	{printerror("EmptyCjTitle","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"cj");
	//取得采集字段
	$record="<!--record-->";
	$field="<!--field--->";
	$cr=$empire->fetch1("select newsclassid,tbname from {$dbtbpre}enewsinfoclass where classid='$add[classid]'");
	$r=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$cr[newsclassid]][modid]."'");
	$cjr=explode($record,$r[cj]);
	$count=count($cjr);
	$update="";
	for($i=0;$i<$count-1;$i++)
	{
		$cjr1=explode($field,$cjr[$i]);
		$dofield=$cjr1[1];
		//图片集
		if($dofield=="morepic")
		{
			$add[$dofield]=ReturnMorepicpath($add['msmallpic'],$add['mbigpic'],$add['mpicname'],$add['mdelpicid'],$add['mpicid'],$add,$add['mpicurl_qz'],1,0,$public_r['filedeftb']);
		}
		//下载地址
		if($dofield=="downpath")
		{
			$add[$dofield]=ReturnDownpath($add['downname'],$add['downpath'],$add['delpathid'],$add['pathid'],$add['downuser'],$add['fen'],$add['thedownqz'],$add,$add['foruser'],$add['downurl'],0);
		}
		//在线地址
		if($dofield=="onlinepath")
		{
			$add[$dofield]=ReturnDownpath($add['odownname'],$add['odownpath'],$add['odelpathid'],$add['opathid'],$add['odownuser'],$add['ofen'],$add['othedownqz'],$add,$add['oforuser'],$add['onlineurl_qz'],1);
		}
		//发布时间
		if($dofield=="newstime")
		{continue;}
		$update.=",".$dofield."='".eaddslashes2($add[$dofield])."'";
	}
	$sql=$empire->query("update {$dbtbpre}ecms_infotmp_".$cr[tbname]." set keyboard='".eaddslashes2($add[keyboard])."',newstime='$add[newstime]'".$update." where id='$add[id]'");
	if($sql)
	{
		//操作日志
		insert_dolog("id=".$add[id]."<br>title=".$add[title]);
		printerror("EditCjNewsSuccess","CheckCj.php?classid=$add[classid]&from=".ehtmlspecialchars($_POST[from]).hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除采集信息
function DelCjNews($classid,$id,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($classid)||empty($id))
	{printerror("NotDelCjNewsid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"cj");
	$cr=$empire->fetch1("select newsclassid,tbname from {$dbtbpre}enewsinfoclass where classid='$classid'");
	$r=$empire->fetch1("select title from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where id='$id'");
	$sql=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where id='$id'");
	if($sql)
	{
		//操作日志
		insert_dolog("id=".$id."<br>title=".$r[title]);
		printerror("DelCjNewsSuccess","CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//批量删除采集信息
function DelCjNews_all($classid,$id,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"cj");
	$count=count($id);
	if(!$count)
	{printerror("NotDelCjNewsid","history.go(-1)");}
	$cr=$empire->fetch1("select newsclassid,tbname,classname from {$dbtbpre}enewsinfoclass where classid='$classid'");
	for($i=0;$i<count($id);$i++)
	{
		$add.="id='".$id[$i]."' or ";
    }
	//去掉最后一个 or
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where ".$add);
	if($sql)
	{
		//操作日志
	    insert_dolog("classid=".$classid."<br>classname=".$cr[classname]);
		printerror("DelCjNewsAllSuccess",$_SERVER['HTTP_REFERER']);
    }
	else
	{
		printerror("DbError","history.go(-1)");
    }
}

//清除简介字符
function DoClearSmalltextVal($value){
	$value=str_replace(array("\r\n","<br />","<br>","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","\r\n","\r\n"," ","",""),$value);
	$value=strip_tags($value);
	$value=trim($value,"\r\n");
	return $value;
}

//采集入库
function CjNewsIn($classid,$id,$checked,$uptime,$userid,$username){
	global $class_r,$empire,$public_r,$dbtbpre,$emod_r;
	$checked=(int)$checked;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"cj");//操作权限
	$count=count($id);
	if(empty($count))
	{
		printerror("NotCjNewsIn","history.go(-1)");
	}
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//副表
	$cra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$cr[tbname]." where classid='$classid'");
	//组合两数组
    $cr=TogTwoArray($cr,$cra);
	//导入gd处理文件
	if($cr['mark']||$cr['getfirstspic'])
	{
		@include_once("gd.php");
	}
	$mid=$class_r[$cr[newsclassid]][modid];
	$savetxtf=$emod_r[$mid]['savetxtf'];
	$stb=$emod_r[$mid]['deftb'];
	//取得采集字段
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$cr[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$ccount=count($cjr);
	//取得优化字段
	for($ci=0;$ci<$ccount-1;$ci++)
	{
		$cir=explode($field,$cjr[$ci]);
		$cifield=$cir[1];
		if($cifield=="title")
		{
			continue;
		}
		$updatefield.=",".$cifield."=''";
	}
	for($i=0;$i<count($id);$i++)
	{
		$a.="id='".$id[$i]."' or ";
	}
	//去掉最后一个 or
	$a=substr($a,0,strlen($a)-4);
	$sql=$empire->query("select * from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where ".$a." and checked=0 order by id desc");
	$todaytime=time();
	$filetime=$todaytime;
	while($r=$empire->fetch($sql))
	{
		$ivalue='';
		$ifield='';
		$dataivalue='';
		$dataifield='';
		$titlepicnoval=0;
		for($j=0;$j<$ccount-1;$j++)
		{
			$cjr1=explode($field,$cjr[$j]);
			$dofield=$cjr1[1];
			$var="zz_".$dofield;
			$var1="z_".$dofield;
			$var2="qz_".$dofield;
			$var3="save_".$dofield;
			$value=$r[$dofield];
			//自身链接
			if($dofield=="empireselfurl")
			{
				$value=$r['oldurl'];
			}
			//内容
			if($dofield=="newstext")
			{
				if($cr[copyimg]||$cr[copyflash])
				{
					$GLOBALS['cjnewsurl']=$r[oldurl];
					$value=addslashes(CopyImg(stripSlashes($value),$cr[copyimg],$cr[copyflash],$cr[newsclassid],$cr[imgurl],$username,0,$r['id'],$cr['mark'],$public_r['filedeftb']));
				}
				//替换关键字和字符
				$value=DoReplaceKeyAndWord($value,1,$cr[newsclassid]);
			}
			//简介
			if($dofield=="smalltext")
			{
				if(empty($value))
				{
					$value=SubSmalltextVal($r[newstext],$cr[smalltextlen]);
				}
				else
				{
					$value=DoClearSmalltextVal($value);
				}
			}
			//图片集
			if($dofield=="morepic")
			{
				if($cr[$var3]==" checked")
				{
					$msavepic=1;
					$r['filepass']=$r['id'];
					$value=LoadInSaveMorepicFile($value,$msavepic,$cr[newsclassid],0,$r,0,$public_r['filedeftb']);
				}
			}
			//信息时间
			if($dofield=="newstime")
			{continue;}
			//图片标题
			if($dofield=="titlepic"&&$cr[zz_titlepicl])
			{
				$cr[$var]=$cr[zz_titlepicl];
				$cr[$var1]=$cr[z_titlepicl];
				$cr[$var2]=$cr[qz_titlepicl];
				$cr[$var3]=$cr[save_titlepicl];
			}
			if($dofield=="titlepic"&&empty($value))
			{
				$titlepicnoval=1;
			}
			//是否远程保存
			if($value&&!$cr[$var1]&&$cr[$var3]==" checked"&&$dofield!="morepic")
			{
				$tranr=DoTranUrl($value,$cr[newsclassid]);
				if($tranr[tran])
				{
					$tranr[filesize]=(int)$tranr[filesize];
					$tranr[type]=(int)$tranr[type];
					$r[id]=(int)$r[id];
					//记录数据库
					eInsertFileTable($tranr[filename],$tranr[filesize],$tranr[filepath],$username,$cr[newsclassid],'[URL]'.$tranr[filename],$tranr[type],0,$r[id],$public_r[fpath],0,0,$public_r['filedeftb']);
					$value=$tranr[url];
				}
			}
			//存放文本
			if($savetxtf==$dofield)
			{
				//建立目录
				$thetxtfile=GetFileMd5();
				$truevalue=MkDirTxtFile(date("Y/md"),$thetxtfile);
				//写放文件
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			$value=addslashes($value);
			if(strstr($emod_r[$mid]['tbdataf'],','.$dofield.','))//副表
			{
				$dataifield.=",".$dofield;
				$dataivalue.=",'".$value."'";
			}
			else
			{
				$ifield.=",".$dofield;
				$ivalue.=",'".$value."'";
			}
		}
		$r[keyboard]=addslashes($r[keyboard]);
		//时间
		if($uptime)//当前时间
		{
			$r[newstime]=$todaytime;
			$r[truetime]=$todaytime;
		}
		else
		{
			if($r[newstime]=="0000-00-00 00:00:00")
			{
				$r[newstime]=$todaytime;
			}
			else
			{
				$r[newstime]=to_time($r[newstime]);
			}
		}
		//查看目录是否存在，不存在则建立
		$newspath=FormatPath($cr[newsclassid],"",0);
		//强制签发
		if($class_r[$cr[newsclassid]][wfid])
		{
			$checked=0;
			$isqf=1;
		}
		else
		{
			$checked=$checked;
			$isqf=0;
		}
		//变量处理
		$newstempid=0;
		$ispic=$r[titlepic]?1:0;
		//取得返回关键字
		$keyid=GetKeyid($r[keyboard],$cr[newsclassid],0,$class_r[$cr[newsclassid]][link_num]);
		//索引表
		$havehtml=0;
		$indexsql=$empire->query("insert into {$dbtbpre}ecms_".$class_r[$cr[newsclassid]][tbname]."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$cr[newsclassid]','$checked','$r[newstime]','$r[truetime]','$r[truetime]','$havehtml');");
		$id=$empire->lastid();
		$infotbr=ReturnInfoTbname($class_r[$cr[newsclassid]][tbname],$checked,$stb);
		//主表
		$isurl=$r['titleurl']?1:0;
		$isql=$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard,newstime".$ifield.") values('$id','$cr[newsclassid]',0,0,0,0,'$newspath','$filename','$r[userid]','$r[username]',0,0,'$ispic',0,'$isqf',0,'$isurl','$r[truetime]','$r[truetime]','$havehtml',0,0,'$r[titlefont]','$r[titleurl]','$stb','$public_r[filedeftb]','$public_r[pldeftb]','$r[keyboard]','$r[newstime]'".$ivalue.");");
		//副表
		$fisql=$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$dataifield.") values('$id','$cr[newsclassid]','$keyid',1,'$newstempid',0,0,''".$dataivalue.");");
		//更新栏目信息数
		AddClassInfos($cr['newsclassid'],'+1','+1',$checked);
		//更新新信息数
		DoUpdateAddDataNum('info',$class_r[$cr['newsclassid']]['tid'],1);
		//签发
		if($isqf==1)
		{
			InfoInsertToWorkflow($id,$cr[newsclassid],$class_r[$cr[newsclassid]][wfid],$userid,$username);
		}
		//更新附件
		UpdateTheFile($id,$r['id'],$cr['newsclassid'],$public_r['filedeftb']);
		//取第一张图片为标题图片
		$addtitlepic="";
		if($cr['getfirstpic']&&$titlepicnoval)
		{
			$firsttitlepic=GetFpicToTpic($cr[newsclassid],$id,$cr['getfirstpic'],$cr['getfirstspic'],$cr['getfirstspicw'],$cr['getfirstspich'],$public_r['filedeftb']);
			if($firsttitlepic)
			{
				$addtitlepic=",titlepic='".addslashes($firsttitlepic)."',ispic=1";
			}
		}
		//文件命名
		$filename=ReturnInfoFilename($cr[newsclassid],$id,$r[filenameqz]);
		//信息地址
		$updateinfourl='';
		if(!$isurl)
		{
			$infourl=GotoGetTitleUrl($cr['newsclassid'],$id,$newspath,$filename,0,$isurl,'');
			$updateinfourl=",titleurl='$infourl'";
		}
        $usql=$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl.$addtitlepic." where id='$id'");
	}
	//状态原记录
	if($cr['delloadinfo'])//删除
	{
		$del=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where ".$a);
	}
	else
	{
		$del=$empire->query("update {$dbtbpre}ecms_infotmp_".$cr[tbname]." set checked=1,keyboard=''".$updatefield." where ".$a);
	}
	//操作日志
	insert_dolog("classid=".$classid);
	printerror("CjLoadDbSuccess","CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_POST[from]).hReturnEcmsHashStrHref2(0));
}

//全部采集入库
function CjNewsIn_all($classid,$checked,$uptime,$start,$userid,$username){
	global $class_r,$empire,$public_r,$dbtbpre,$fun_r,$emod_r;
	$checked=(int)$checked;
	$classid=(int)$classid;
	$start=(int)$start;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//操作权限
	CheckLevel($userid,$username,$classid,"cj");
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//副表
	$cra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$cr[tbname]." where classid='$classid'");
	//组合两数组
    $cr=TogTwoArray($cr,$cra);
	//导入gd处理文件
	if($cr['mark']||$cr['getfirstspic'])
	{
		@include_once("gd.php");
	}
	if(empty($cr[insertnum]))
	{$cr[insertnum]=10;}
	$mid=$class_r[$cr[newsclassid]][modid];
	$savetxtf=$emod_r[$mid]['savetxtf'];
	$stb=$emod_r[$mid]['deftb'];
	//取得采集字段
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$cr[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$ccount=count($cjr);
	$sql=$empire->query("select * from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where classid='$classid' and checked=0 and id>$start order by id limit ".$cr[insertnum]);
	$todaytime=time();
	$filetime=$todaytime;
	$b=0;
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[id];
		$ivalue='';
		$ifield='';
		$dataivalue='';
		$dataifield='';
		$titlepicnoval=0;
		for($j=0;$j<$ccount-1;$j++)
		{
			$cjr1=explode($field,$cjr[$j]);
			$dofield=$cjr1[1];
			$var="zz_".$dofield;
			$var1="z_".$dofield;
			$var2="qz_".$dofield;
			$var3="save_".$dofield;
			$value=$r[$dofield];
			//自身链接
			if($dofield=="empireselfurl")
			{
				$value=$r['oldurl'];
			}
			//内容
			if($dofield=="newstext")
			{
				if($cr[copyimg]||$cr[copyflash])
				{
					$GLOBALS['cjnewsurl']=$r[oldurl];
					$value=addslashes(CopyImg(stripSlashes($value),$cr[copyimg],$cr[copyflash],$cr[newsclassid],$cr[imgurl],$username,0,$r['id'],$cr['mark'],$public_r['filedeftb']));
				}
				//替换关键字和字符
				$value=DoReplaceKeyAndWord($value,1,$cr[newsclassid]);
			}
			//简介
			if($dofield=="smalltext")
			{
				if(empty($value))
				{
					$value=SubSmalltextVal($r[newstext],$cr[smalltextlen]);
				}
				else
				{
					$value=DoClearSmalltextVal($value);
				}
			}
			//图片集
			if($dofield=="morepic")
			{
				if($cr[$var3]==" checked")
				{
					$msavepic=1;
					$r['filepass']=$r['id'];
					$value=LoadInSaveMorepicFile($value,$msavepic,$cr[newsclassid],0,$r,0,$public_r['filedeftb']);
				}
			}
			//时间
			if($dofield=="newstime")
			{continue;}
			//图片标题
			if($dofield=="titlepic"&&$cr[zz_titlepicl])
			{
				$cr[$var]=$cr[zz_titlepicl];
				$cr[$var1]=$cr[z_titlepicl];
				$cr[$var2]=$cr[qz_titlepicl];
				$cr[$var3]=$cr[save_titlepicl];
			}
			if($dofield=="titlepic"&&empty($value))
			{
				$titlepicnoval=1;
			}
			//是否远程保存
			if($value&&!$cr[$var1]&&$cr[$var3]==" checked"&&$dofield!="morepic")
			{
				$tranr=DoTranUrl($value,$cr[newsclassid]);
				if($tranr[tran])
				{
					$tranr[filesize]=(int)$tranr[filesize];
					$tranr[type]=(int)$tranr[type];
					$r[id]=(int)$r[id];
					//记录数据库
					eInsertFileTable($tranr[filename],$tranr[filesize],$tranr[filepath],$username,$cr[newsclassid],'[URL]'.$tranr[filename],$tranr[type],0,$r[id],$public_r[fpath],0,0,$public_r['filedeftb']);
					$value=$tranr[url];
				}
			}
			//存放文本
			if($savetxtf==$dofield)
			{
				//建立目录
				$thetxtfile=GetFileMd5();
				$truevalue=MkDirTxtFile(date("Y/md"),$thetxtfile);
				//写放文件
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			$value=addslashes($value);
			if(strstr($emod_r[$mid]['tbdataf'],','.$dofield.','))//副表
			{
				$dataifield.=",".$dofield;
				$dataivalue.=",'".$value."'";
			}
			else
			{
				$ifield.=",".$dofield;
				$ivalue.=",'".$value."'";
			}
		}
		$r[keyboard]=addslashes($r[keyboard]);
		//时间
		if($uptime)//当前时间
		{
			$r[newstime]=$todaytime;
			$r[truetime]=$todaytime;
		}
		else
		{
			if($r[newstime]=="0000-00-00 00:00:00")
			{
				$r[newstime]=$todaytime;
			}
			else
			{
				$r[newstime]=to_time($r[newstime]);
			}
		}
		//查看目录是否存在，不存在则建立
		$newspath=FormatPath($cr[newsclassid],"",0);
		//强制签发
		if($class_r[$cr[newsclassid]][wfid])
		{
			$checked=0;
			$isqf=1;
		}
		else
		{
			$checked=$checked;
			$isqf=0;
		}
		//变量处理
		$newstempid=0;
		$ispic=$r[titlepic]?1:0;
		//返回关键字
		$keyid=GetKeyid($r[keyboard],$cr[newsclassid],0,$class_r[$cr[newsclassid]][link_num]);
		//索引表
		$havehtml=0;
		$indexsql=$empire->query("insert into {$dbtbpre}ecms_".$class_r[$cr[newsclassid]][tbname]."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$cr[newsclassid]','$checked','$r[newstime]','$r[truetime]','$r[truetime]','$havehtml');");
		$id=$empire->lastid();
		$infotbr=ReturnInfoTbname($class_r[$cr[newsclassid]][tbname],$checked,$stb);
		//主表
		$isurl=$r['titleurl']?1:0;
		$isql=$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard,newstime".$ifield.") values('$id','$cr[newsclassid]',0,0,0,0,'$newspath','$filename','$r[userid]','$r[username]',0,0,'$ispic',0,'$isqf',0,'$isurl','$r[truetime]','$r[truetime]','$havehtml',0,0,'$r[titlefont]','$r[titleurl]','$stb','$public_r[filedeftb]','$public_r[pldeftb]','$r[keyboard]','$r[newstime]'".$ivalue.");");
		//副表
		$fisql=$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$dataifield.") values('$id','$cr[newsclassid]','$keyid',1,'$newstempid',0,0,''".$dataivalue.");");
		//更新栏目信息数
		AddClassInfos($cr['newsclassid'],'+1','+1',$checked);
		//更新新信息数
		DoUpdateAddDataNum('info',$class_r[$cr['newsclassid']]['tid'],1);
		//签发
		if($isqf==1)
		{
			InfoInsertToWorkflow($id,$cr[newsclassid],$class_r[$cr[newsclassid]][wfid],$userid,$username);
		}
		//更新附件
		UpdateTheFile($id,$r['id'],$cr[newsclassid],$public_r['filedeftb']);
		//取第一张图片为标题图片
		$addtitlepic="";
		if($cr['getfirstpic']&&$titlepicnoval)
		{
			$firsttitlepic=GetFpicToTpic($cr[newsclassid],$id,$cr['getfirstpic'],$cr['getfirstspic'],$cr['getfirstspicw'],$cr['getfirstspich'],$public_r['filedeftb']);
			if($firsttitlepic)
			{
				$addtitlepic=",titlepic='".addslashes($firsttitlepic)."',ispic=1";
			}
		}
		//文件命名
		$filename=ReturnInfoFilename($cr[newsclassid],$id,$r[filenameqz]);
		//信息地址
		$updateinfourl='';
		if(!$isurl)
		{
			$infourl=GotoGetTitleUrl($cr['newsclassid'],$id,$newspath,$filename,0,$isurl,'');
			$updateinfourl=",titleurl='$infourl'";
		}
        $usql=$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl.$addtitlepic." where id='$id'");
	}
	$fm=ehtmlspecialchars($_GET['fm']);
	//全部入库完毕
	if(empty($b))
	{
		//取得忧化字段
		for($ci=0;$ci<$ccount-1;$ci++)
	    {
			$cir=explode($field,$cjr[$ci]);
			$cifield=$cir[1];
			if($cifield=="title")
			{
				continue;
			}
			$updatefield.=",".$cifield."=''";
		}
		//状态原记录
		if($cr['delloadinfo'])//删除
		{
			$del=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where classid='$classid'");
		}
		else
		{
			$del=$empire->query("update {$dbtbpre}ecms_infotmp_".$cr[tbname]." set checked=1,keyboard=''".$updatefield." where classid='$classid'");
		}
		if($fm)
		{
			echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><body topmargin=0><font color=red>".$cr[classname]."  ".$fun_r['CjLoadInInfosSuccess']."</font>,  <input type=button name=button value='".$fun_r['OnlickLoadInCj']."' onclick=\"window.open('CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref2(0)."');\"></body>";
			exit();
		}
		else
		{
			printerror("CjLoadDbSuccess","CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref2(0));
		}
	}
	echo "<b>$cr[classname]</b>&nbsp;&nbsp;".$fun_r['OneCjLoadDbSuccess']."(ID:<font color=red><b>".$newstart."</b></font>)<script>self.location.href='ecmscj.php?enews=CjNewsIn_all&checked=$checked&uptime=$uptime&classid=$classid&start=$newstart&fm=$fm&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//##############################采集功能开始###############################

//替换回车
function ReplaceFc($text){
	$text=str_replace("\n","",$text);
	$text=str_replace("\r","",$text);
	return $text;
}

//返回字符正则
function GetInfoStr($text,$exp,$enews=0){
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$rep="[!--".$exp."--]";
	$mode="*";
	//匹配多个
	if($enews==1)
	{
		$cr=explode($rep,$text);
		$cer=explode($mode,$cr[0]);
		$num=count($cer)-1;
	}
	//转换字符
	$text=str_replace($rep,$mode,$text);
	$er=explode($mode,$text);
	$newtext="";
	for($i=0;$i<count($er);$i++)
	{
		$j=$i+1;
		//加标签
		if($enews==1)
		{
			if($i==$num)
			{
				$newtext.=$er[$i].$e1."\\".$j.$e2;
			}
			else
			{
				$newtext.=$er[$i]."\\".$j;
			}
		}
		//过滤广告
		elseif($enews==2)
		{
			if($i==$num)
			{
				$newtext.=$er[$i]."";
			}
			else
			{
				$newtext.=$er[$i]."\\".$j;
			}
		}
		else
		{
			$newtext.=$er[$i]."\\".$j;
		}
	}
	//去掉最后一个//
	$newtext=substr($newtext,0,strlen($newtext)-2);
	return $newtext;
}

//过滤广告
function RepAd($repad,$text){
	if(empty($repad))
	{return $text;}
	$repad=stripSlashes($repad);
	//替换回车
	$repad=ReplaceFc($repad);
	$r=explode(",",$repad);
	$exp="ad";
	for($i=0;$i<count($r);$i++)
	{
		$zztext=RepInfoZZ($r[$i],$exp,0);
		//$strtext=GetInfoStr($r[$i],$exp,2);
		$strtext="";
		$text=stripSlashes(preg_replace($zztext,$strtext,$text));
	}
	return $text;
}

//过滤整个页面广告
function RepPageAd($repad,$text){
	if(empty($repad))
	{return $text;}
	$repad=stripSlashes($repad);
	//替换回车
	$repad=ReplaceFc($repad);
	$r=explode(",",$repad);
	$exp="pad";
	for($i=0;$i<count($r);$i++)
	{
		$zztext=RepInfoZZ($r[$i],$exp,0);
		//$strtext=GetInfoStr($r[$i],$exp,2);
		$strtext="";
		$text=stripSlashes(preg_replace($zztext,$strtext,$text));
	}
	return $text;
}

//地址
function eCheckCjUrl($url,$ecms=0){
	if(!strstr($url,'://'))
	{
		if($ecms)
		{
			return false;
		}
		else
		{
			printerror('ErrorUrl','history.go(-1)');
		}
	}
	return true;
}

//取得符号位置
function CountCJ_site($text,$exp){
	$rep="[!--".$exp."--]";
	$mode="*";
	$cr=explode($rep,$text);
	$cer=explode($mode,$cr[0]);
	$num=count($cer);
	return $num;
}

//取得替换空余出来的值
function ReturnCJ_str($text,$exp,$info){
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$text=stripSlashes(stripSlashes($text));
	//替换回车
	$text=ReplaceFc($text);
	$rep="[!--".$exp."--]";
	//替换
	$num=CountCJ_site($text,$exp);//取得符号位置
	$zztext=RepInfoZZ($text,$exp,0);
	$text1=stripSlashes(preg_replace($zztext,$e1."\\".$num.$e2,$info));
	$r=explode($e1,$text1);
	$r1=explode($e2,$r[1]);
	$text1=$r1[0];
	return $text1;
}

//替换链接
function RepCjUrlStr($url){
	$url=strip_tags($url);
	$url=str_replace("\"","",$url);
	$url=str_replace("'","",$url);
	$url=str_replace("&amp;","&",$url);
	return $url;
}

//编码转换
function doCjUtfAndGbk($str,$phome=0){
	//正常编码
	if($phome==0)
	{
		return $str;
	}
	if($phome==1)//UTF8->GB2312
	{
		$str=DoIconvVal("UTF8","GB2312",$str);
	}
	elseif($phome==2)//UTF8->BIG5
	{
		$str=DoIconvVal("UTF8","BIG5",$str);
	}
	elseif($phome==3)//BIG5->GB2312
	{
		$str=DoIconvVal("BIG5","GB2312",$str);
	}
	elseif($phome==4)//GB2312->BIG5
	{
		$str=DoIconvVal("GB2312","BIG5",$str);
	}
	elseif($phome==5)//UNICODE->GB2312
	{
		$str=DoIconvVal("UNICODE","GB2312",$str);
	}
	elseif($phome==6)//UNICODE->BIG5
	{
		$str=DoIconvVal("UNICODE","BIG5",$str);
	}
	elseif($phome==7)//GB2312->UTF8
	{
		$str=DoIconvVal("GB2312","UTF8",$str);
	}
	elseif($phome==8)//BIG5->UTF8
	{
		$str=DoIconvVal("BIG5","UTF8",$str);
	}
	elseif($phome==9)//UNICODE->UTF8
	{
		$str=DoIconvVal("UNICODE","UTF8",$str);
	}
	else
	{}
	return $str;
}

//替换采集页面内容
function RepCjPagetextStr($text,$r){
	$text=str_replace("\\","/",$text);
	//编码转换
	$text=doCjUtfAndGbk($text,$r['enpagecode']);
	//替换
	$text=RepInfoWord($text,$r['oldpagerep'],$r['newpagerep']);
	//替换页面过滤正则
	$text=RepPageAd($r['pagerepad'],$text);
	return $text;
}

//取得地址
function EchoUrl($text,$exp,$exp1,$dr,$url,$classid,$num,$checkrnd){
	global $empire,$fun_r,$dbtbpre;
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$r=explode($e1,$text);
	//图片链接
	if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	{
		$rp=explode($ep1,$text);
	}
	else
	{
		$titlepic=$dr[z_titlepicl];
	}
	for($i=1;$i<count($r)&&$i<=$num;$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		//是否有http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$url.$dourl;
		}
		//替换地址
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=addslashes($dourl);
		//---------------检查数据库是否有记录
		if(empty($dr[recjtheurl]))//重复采集
		{
			$dbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$dr[tbname]." where oldurl='$dourl' limit 1");
			if($dbnum)
			{continue;}
		}
		//图片链接
		if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	    {
			$rp1=explode($ep2,$rp[$i]);
			$titlepic=trim($rp1[0]);
			//是否有http
			if(strstr($titlepic,"http://")||strstr($titlepic,"https://"))
			{}
			else
			{$titlepic=$dr[qz_titlepicl].$titlepic;}
			//替换地址
			$titlepic=RepCjUrlStr($titlepic);
			$titlepic=addslashes($titlepic);
	    }
		//将地址写入数据库
		$sql=$empire->query("insert into {$dbtbpre}enewslinktmp(newsurl,checkrnd,titlepic) values('$dourl','$checkrnd','$titlepic');");
		echo $dourl."<br>";
	}
}

//采集直接内容页地址
function PageEchoUrl($classid,$cr,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	//取得条数
	if(empty($cr[num]))
	{$cr[num]=10000;}
	//生成检测值
	$checkrnd=md5(uniqid(microtime()));

	$url_r=explode("\r\n",$cr[infourl]);
	$count=count($url_r);
	if($count>$cr[num])
	{
		$count=$cr[num];
	}
	for($i=0;$i<$count;$i++)
	{
		$dourl=trim($url_r[$i]);
		if(empty($dourl))
		{
			continue;
		}
		//是否有http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$cr[httpurl].$dourl;
		}
		//替换地址
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=addslashes($dourl);
		//---------------检查数据库是否有记录
		if(empty($cr[recjtheurl]))//重复采集
		{
			$dbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where oldurl='$dourl' limit 1");
			if($dbnum)
			{continue;}
		}
		//将地址写入数据库
		$sql=$empire->query("insert into {$dbtbpre}enewslinktmp(newsurl,checkrnd,titlepic) values('$dourl','$checkrnd','');");
		echo $dourl."<br>";
	}
	echo $fun_r['GetUrlOver']."<script>self.location.href='ecmscj.php?enews=GetNewsInfo&classid=$classid&start=0&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//开始采集远程地址
function CJUrl($classid,$start,$checkrnd,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{printerror("NotChangeCjid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select endday,num,zz_smallurl,zz_newsurl,httpurl,infourl,newsclassid,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,tbname,recjtheurl,enpagecode,pagerepad,oldpagerep,newpagerep,keeptime,infourlispage from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[newsclassid]))
	{printerror("NotCjid","history.go(-1)");}
	//直接内容页链接列表
	if($r['infourlispage'])
	{
		PageEchoUrl($classid,$r,$userid,$username);
	}
	//导入编码文件
	if($r['enpagecode'])
	{
		@include_once("doiconv.php");
	}
	//取得条数
	if(empty($r[num]))
	{$r[num]=10000;}
	if(empty($r[relistnum]))
	{$r[relistnum]=1;}
	if(empty($start))
	{
		$start=0;
		//生成检测值
		$checkrnd=md5(uniqid(microtime()));
	}
	$exp="newsurl";
	$exp1="titlepic";
	//查看是否过期
	$b=0;
	$p=0;
	$url_r=explode("\r\n",$r[infourl]);
	$j=count($url_r);
	for($i=$start;$i<$j&&$p<$r[relistnum];$i++)
	{
		$p++;
		$b=1;
		$dourl=trim($url_r[$i]);
		if(empty($dourl)||!eCheckCjUrl($dourl,1))
		{continue;}
		//读取页面
		for($readnum=0;$readnum<3;$readnum++)
		{
			$text1=ReadFiletext($dourl);
			if(!empty($text1))
			{break;}
		}
		if(empty($text1))
		{continue;}
		//替换回车
		$text1=ReplaceFc($text1);
		//替换网页变量
		$text1=RepCjPagetextStr($text1,$r);
		//区域块
		if($r[zz_smallurl])
		{
			$text1=ReturnCJ_str($r[zz_smallurl],"smallurl",$text1);
			if(empty($text1))
			{
				continue;
			}
		}
		//替换内容链接
		$text=stripSlashes(stripSlashes($r[zz_newsurl]));
		//替换回车
		$text=ReplaceFc($text);
		$zztext=RepInfoZZ($text,$exp,0);
		$strtext=GetInfoStr($text,$exp,1);
		if($text)
		{
			$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
		}
		//替换标题图片地址
		if($r[zz_titlepicl]&&!$r[z_titlepicl])
		{
			$text=stripSlashes(stripSlashes($r[zz_titlepicl]));
			//替换回车
			$text=ReplaceFc($text);
			$zztext=RepInfoZZ($text,$exp1,0);
			$strtext=GetInfoStr($text,$exp1,1);
			if($text)
			{
				$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
			}
		}
		//链接写入数据库
		EchoUrl($text1,$exp,$exp1,$r,$r[httpurl],$classid,$r[num],$checkrnd);
	}
	$newstart=$i;
	//采集链接完毕
	if(empty($b))
	{
		echo $fun_r['GetUrlOver']."<script>self.location.href='ecmscj.php?enews=GetNewsInfo&classid=$classid&start=0&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	//echo $fun_r['GetOneListUrl']."<script>self.location.href='ecmscj.php?enews=CjUrl&classid=$classid&start=$newstart&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."';</script>";
	echo"<meta http-equiv=\"refresh\" content=\"".$r['keeptime'].";url=ecmscj.php?enews=CjUrl&classid=$classid&start=$newstart&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."\">".$fun_r['GetOneListUrl'];
	exit();
}

//###################采集页面列表##################
function ViewCjList($classid,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{printerror("NotChangeCjid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select endday,num,zz_smallurl,zz_newsurl,httpurl,infourl,newsclassid,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,infourlispage from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[newsclassid]))
	{printerror("NotCjid","history.go(-1)");}
	//直接内容页列表
	if($r[infourlispage])
	{
		PageViewCjList($classid,$r,$userid,$username);
	}
	$url_r=explode("\r\n",$r[infourl]);
	$j=count($url_r);
	$ecmshashhref=hReturnEcmsHashStrHref(0);
	for($i=0;$i<$j;$i++)
	{
		if(empty($url_r[$i]))
		{continue;}
		$dourl=urlencode($url_r[$i]);
		$data.="<tr><td><a href='".$url_r[$i]."' target=_blank>".$url_r[$i]."</a></td><td align=center>[<a href='ecmscj.php?enews=ViewCjUrl&classid=$classid".$ecmshashhref."&listpage=".$dourl."' target=_blank>".$fun_r['view']."</a>]</td></tr>";
    }
	$data="<p align=center><b>".$fun_r['CjListUrl']."</b></p><table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=70% align=center><b>URL</b></td><td align=center><b>VIEW</b></td></tr>".$data."</table>";
	echo $data;
	exit();
}

//###################采集内容页面列表##################
function PageViewCjList($classid,$cr,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	//取得条数
	if(empty($cr[num]))
	{$cr[num]=10000;}
	$url_r=explode("\r\n",$cr[infourl]);
	$count=count($url_r);
	if($count>$cr[num])
	{
		$count=$cr[num];
	}
	$ecmshashhref=hReturnEcmsHashStrHref(0);
	for($i=0;$i<$count;$i++)
	{
		$dourl=trim($url_r[$i]);
		if(empty($dourl))
		{
			continue;
		}
		//是否有http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$cr[httpurl].$dourl;
		}
		//替换地址
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=urlencode($dourl);
		$data.="<tr><td><a href='".$url_r[$i]."' target=_blank>".$url_r[$i]."</a></td><td align=center>[<a href='ecmscj.php?enews=ViewGetNewsInfo&classid=$classid".$ecmshashhref."&newspage=".$dourl."' target=_blank>".$fun_r['view']."</a>]</td></tr>";
    }
	$data="<p align=center><b>".$fun_r['CjListUrl']."</b></p><table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=70% align=center><b>URL</b></td><td align=center><b>VIEW</b></td></tr>".$data."</table>";
	echo $data;
	exit();
}

//#################预览采集列表
function ViewCjUrl($classid,$listpage,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid)||empty($listpage))
	{printerror("NotChangeCjid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select endday,num,zz_smallurl,zz_newsurl,httpurl,infourl,newsclassid,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,tbname,recjtheurl,enpagecode,pagerepad,oldpagerep,newpagerep from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[newsclassid]))
	{printerror("NotCjid","history.go(-1)");}
	//导入编码文件
	if($r['enpagecode'])
	{
		@include_once("doiconv.php");
	}
	//取得条数
	if(empty($r[num]))
	{$r[num]=10000;}
	$exp="newsurl";
	$exp1="titlepic";
	$dourl=$listpage;
	eCheckCjUrl($dourl,0);
	//读取页面
	for($readnum=0;$readnum<3;$readnum++)
	{
		$text1=ReadFiletext($dourl);
		if(!empty($text1))
		{break;}
	}
	if(empty($text1))
	{
		printerror("FailCjUrl","history.go(-1)");
	}
	//替换回车
	$text1=ReplaceFc($text1);
	//替换网页变量
	$text1=RepCjPagetextStr($text1,$r);
	//区域块
	if($r[zz_smallurl])
	{
		$text1=ReturnCJ_str($r[zz_smallurl],"smallurl",$text1);
		if(empty($text1))
		{
			printerror("EmptyCjSmallUrl","history.go(-1)");
		}
	 }
	 //替换内容链接
	$text=stripSlashes(stripSlashes($r[zz_newsurl]));
	 //替换回车
	$text=ReplaceFc($text);
	$zztext=RepInfoZZ($text,$exp,0);
	$strtext=GetInfoStr($text,$exp,1);
	if($text)
	{
		$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
	}
	//替换标题图片地址
	if($r[zz_titlepicl]&&!$r[z_titlepicl])
	{
		$text=stripSlashes(stripSlashes($r[zz_titlepicl]));
		//替换回车
		$text=ReplaceFc($text);
		$zztext=RepInfoZZ($text,$exp1,0);
		$strtext=GetInfoStr($text,$exp1,1);
		if($text)
		{
			$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
		}
	}
	//输出地址
	echo"<p align=center><b>".$fun_r['CjListPageUrl']."</b></p><table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=70% align=center><b>URL</b></td><td align=center><b>VIEW</b></td></tr>";
	ViewEchoUrl($text1,$exp,$exp1,$r,$r[httpurl],$classid,$r[num],$checkrnd);
	echo"</table>";
	exit();
}

//################输入采集页面
function ViewEchoUrl($text,$exp,$exp1,$dr,$url,$classid,$num,$checkrnd){
	global $empire,$fun_r,$dbtbpre;
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$r=explode($e1,$text);
	//图片链接
	if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	{
		$rp=explode($ep1,$text);
	}
	else
	{
		$titlepic=$dr[z_titlepicl];
	}
	$ecmshashhref=hReturnEcmsHashStrHref(0);
	for($i=1;$i<count($r)&&$i<=$num;$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		//是否有http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$url.$dourl;
		}
		//替换地址
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=addslashes($dourl);
		//检查数据库是否有记录
		if(empty($dr[recjtheurl]))
		{
			$dbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$dr[tbname]." where oldurl='$dourl' limit 1");
			if($dbnum)
			{continue;}
		}
		//图片链接
		if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	    {
			$rp1=explode($ep2,$rp[$i]);
			$titlepic=trim($rp1[0]);
			//是否有http
			if(strstr($titlepic,"http://")||strstr($titlepic,"https://"))
			{}
			else
			{$titlepic=$dr[qz_titlepicl].$titlepic;}
			//替换地址
			$titlepic=RepCjUrlStr($titlepic);
			$titlepic=addslashes($titlepic);
	    }
		if($titlepic)
		{$a="<br>(PIC:<a href='".$titlepic."' target=_blank>".$titlepic."</a>)";}
		echo "<tr><td><a href='".$dourl."' target=_blank>".$dourl."</a>".$a."</td><td align=center>[<a href='ecmscj.php?enews=ViewGetNewsInfo&classid=$classid".$ecmshashhref."&newspage=".urlencode($dourl)."' target=_blank>".$fun_r['view']."</a>]</td></tr>";
	}
}


//#################################
//取得下载地址
function GetCjDownpath($text,$text1,$exp,$exp1,$url,$online=0){
	global $empire,$fun_r;
	if($online)
	{
		$fun_r[DownPath]="";
    }
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$r=explode($e1,$text);
	//名称
	if($text1)
	{
		$rp=explode($ep1,$text1);
	}
	$p=0;
	for($i=1;$i<count($r);$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		if(empty($dourl))
		{continue;}
		if(!strstr($dourl,"://"))
		{
			$dourl=$url.$dourl;
		}
		if($text1)
		{
			$rp1=explode($ep2,$rp[$i]);
			$doname=trim($rp1[0]);
			if(empty($doname))
			{
				$doname=$fun_r[DownPath].($p+1);
			}
		}
		else
		{
			$doname=$fun_r[DownPath].($p+1);
		}
		$downname[$p]=$doname;
		$downpath[$p]=$dourl;
		$p++;
	}
	$down=ReturnDownpath($downname,$downpath,$delpathid,$pathid,$downuser,$fen,$thedownqz,$add,$foruser,$downurl,0);
	return $down;
}

//取得图片集地址
function GetCjMorepicpath($text,$text1,$text2,$exp,$exp1,$exp2,$url){
	global $empire,$public_r;
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$epp1="[phome-".$exp2."]";
	$epp2="[/phome-".$exp2."]";
	$r=explode($e1,$text);
	//大图
	if($text1)
	{
		$rp=explode($ep1,$text1);
	}
	//名称
	if($text2)
	{
		$rpp=explode($epp1,$text2);
	}
	$p=0;
	for($i=1;$i<count($r);$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		if(empty($dourl))
		{continue;}
		if(!strstr($dourl,"://"))
		{
			$dourl=$url.$dourl;
		}
		//大图
		if($text1)
		{
			$rp1=explode($ep2,$rp[$i]);
			$dobigurl=trim($rp1[0]);
			if(!empty($dobigurl))
			{
				if(!strstr($dobigurl,"://"))
				{
					$dobigurl=$url.$dobigurl;
				}
			}
		}
		else
		{
			$dobigurl="";
		}
		//图片名称
		if($text2)
		{
			$rpp1=explode($epp2,$rpp[$i]);
			$doname=trim($rpp1[0]);
		}
		else
		{
			$doname="";
		}
		$smallpic[$p]=$dourl;
		$bigpic[$p]=$dobigurl;
		$picname[$p]=$doname;
		$p++;
	}
	$down=ReturnMorepicpath($smallpic,$bigpic,$picname,$delpicid,$picid,$add,$downurl,0,0,$public_r['filedeftb']);
	return $down;
}

//内容页分页处理-下一页式
function GetMoreCjPagetext($self,$newstextzz,$smallpagezz,$pagezz,$pagetype,$firsttext,$the_r){
	if(empty($pagezz)||empty($newstextzz))
	{return "";}
	//是否保留分页
	$addpagetag=empty($the_r['doaddtextpage'])?'[!--empirenews.page--]':'';
	//取得地址前缀
	$sr=GetPageurlQz($self);
	$pagetext=$firsttext;
	$allpagetext="";
	for($i=0;$i<100;$i++)
	{
		//区域正则
		if($smallpagezz)
		{
			$pagetext=ReturnCJ_str($smallpagezz,"smallpagezz",$pagetext);
		}
		$nextlink=ReturnCJ_str($pagezz,"pagezz",$pagetext);
		if(empty($nextlink))
		{
			break;
		}
		if(!strstr($nextlink,"http://"))
		{
			//根目录开始
			if(strstr($nextlink,"/"))
			{
				$nextlink=$sr[domain].$nextlink;
			}
			else
			{
				$nextlink=$sr[selfqz].$nextlink;
			}
		}
		$nextlink=RepCjUrlStr($nextlink);
		if($nextlink==$self||!eCheckCjUrl($nextlink,1))
		{continue;}
		//取得远程数据
		for($j=0;$j<3;$j++)
		{
			$pagetext=ReadFiletext($nextlink);
			if($pagetext)
			{
				break;
			}
		}
		//页面不存在
		if(empty($pagetext))
		{
			break;
		}
		//替换网页变量
	    $pagetext=RepCjPagetextStr($pagetext,$the_r);
		//替换回车
		$pagetext=ReplaceFc($pagetext);
		$newstext=ReturnCJ_str($newstextzz,"newstext",$pagetext);
		if($newstext)
		{
			$allpagetext.=$addpagetag.$newstext;
		}
	}
	return $allpagetext;
}

//内容页分页处理-全部列表式
function GetMoreCjPagetextall($self,$newstextzz,$smallpagezz,$pagezz,$pagetype,$firsttext,$the_r){
	if(empty($pagezz)||empty($newstextzz))
	{return "";}
	//是否保留分页
	$addpagetag=empty($the_r['doaddtextpage'])?'[!--empirenews.page--]':'';
	$exp="pageallzz";
	//取得地址前缀
	$sr=GetPageurlQz($self);
	$pagetext=$firsttext;
	$allpagetext="";
	//区域正则
	if($smallpagezz)
	{
		$pagetext=ReturnCJ_str($smallpagezz,"smallpageallzz",$pagetext);
	}
	//分页
	$text=stripSlashes(stripSlashes($pagezz));
	//替换回车
	$text=ReplaceFc($text);
	$zztext=RepInfoZZ($text,$exp,0);
	$strtext=GetInfoStr($text,$exp,1);
	$pagetext=stripSlashes(preg_replace($zztext,$strtext,$pagetext));
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$r=explode($e1,$pagetext);
	$count=count($r);
	for($i=1;$i<$count;$i++)
	{
		$r1=explode($e2,$r[$i]);
		$nextlink=trim($r1[0]);
		if(empty($nextlink))
		{continue;}
		if(!strstr($nextlink,"http://"))
		{
			//根目录开始
			if(strstr($nextlink,"/"))
			{
				$nextlink=$sr[domain].$nextlink;
			}
			else
			{
				$nextlink=$sr[selfqz].$nextlink;
			}
		}
		$nextlink=RepCjUrlStr($nextlink);
		if($nextlink==$self||!eCheckCjUrl($nextlink,1))
		{continue;}
		//取得远程数据
		for($j=0;$j<3;$j++)
		{
			$pagetext=ReadFiletext($nextlink);
			if($pagetext)
			{
				break;
			}
		}
		//页面不存在
		if(empty($pagetext))
		{
			continue;
		}
		//替换网页变量
	    $pagetext=RepCjPagetextStr($pagetext,$the_r);
		//替换回车
		$pagetext=ReplaceFc($pagetext);
		$newstext=ReturnCJ_str($newstextzz,"newstext",$pagetext);
		if($newstext)
		{
			$allpagetext.=$addpagetag.$newstext;
		}
	}
	return $allpagetext;
}

//采集时间格式转换
function CjFormatNewstime($newstime){
	$newstime=str_replace(array('年','月','日','.','时','分','秒','/'),array('-','-','','-',':',':','','-'),$newstime);
	return $newstime;
}

//采集信息文件
function GetNewsInfo($classid,$checkrnd,$start,$userid,$username){
	global $empire,$class_r,$fun_r,$dbtbpre;
	$userid=(int)$userid;
	$classid=(int)$classid;
	$start=(int)$start;
	$checkrnd=RepPostVar($checkrnd);
	if(empty($classid)||empty($checkrnd))
	{printerror("FailCX","ListInfoClass.php".hReturnEcmsHashStrHref2(1));}
	//验证权限
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//副表
	$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
	//组合两数组
	$r=TogTwoArray($r,$ra);
	//导入编码文件
	if($r['enpagecode'])
	{
		@include_once(ECMS_PATH."e/class/doiconv.php");
	}
	//取得模型
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj,tid,tbname from {$dbtbpre}enewsmod where mid='".$class_r[$r[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$count=count($cjr);
	if(empty($start))
	{$start=0;}
	$b=0;
	$sql=$empire->query("select linkid,newsurl,titlepic from {$dbtbpre}enewslinktmp where checkrnd='$checkrnd' and linkid>".$start." order by linkid limit ".$r[renum]);
	//采集时间
	$newstime=date("Y-m-d H:i:s");
    $truetime=time();
	$tmptime=$newstime;
	while($nr=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$nr[linkid];
		if(!eCheckCjUrl($nr[newsurl],1))
		{
			continue;
		}
		//入库数据库是否有记录
		if(empty($r[recjtheurl]))
		{
			$tmpnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$r[tbname]." where oldurl='$nr[newsurl]' limit 1");
			if($tmpnum)
			{continue;}
		}
		//取得远程页面，三次取不到值的将不取值
		for($i=1;$i<=3;$i++)
		{
			$info=ReadFiletext($nr[newsurl]);
			if(!empty($info))
			{
				break;
			}
		}
		if(empty($info))
		{continue;}
		//替换网页变量
	    $info=RepCjPagetextStr($info,$r);
		//替换回车
		$info=ReplaceFc($info);
		//-----------------
		$ifield="";
		$ivalue="";
		$next=0;
		for($c=0;$c<$count-1;$c++)
		{
			$zzvalue="";
			$cjr1=explode($field,$cjr[$c]);
			$dofield=$cjr1[1];
			$var="zz_".$dofield;
			$var1="z_".$dofield;
			$var2="qz_".$dofield;
			$var3="save_".$dofield;
			//标题图片
			if($dofield=="titlepic")
			{
				if($nr[titlepic])
				{
					$zzvalue=$nr[titlepic];
					$ifield.=",".$dofield;
			        $ivalue.=",'".addslashes($zzvalue)."'";
					continue;
				}
			}
			//图片集
			if($dofield=="morepic"&&$r[$var])
			{
				//替换下载链接
	            $text=$r[$var];
				//替换回车
				$text=ReplaceFc($text);
				$down=explode("[!empirecms!]",$text);
				//小图
	            $zztext=RepInfoZZ($down[0],"ecmsspicurl",0);
	            $strtext=GetInfoStr($down[0],"ecmsspicurl",1);
	            $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
				//大图
				if($down[1])
				{
					$zztext=RepInfoZZ($down[1],"ecmsbpicurl",0);
	                $strtext=GetInfoStr($down[1],"ecmsbpicurl",1);
	                $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				//名称
				if($down[2])
				{
					$zztext=RepInfoZZ($down[2],"ecmspicname",0);
	                $strtext=GetInfoStr($down[2],"ecmspicname",1);
	                $text3=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				$zzvalue=GetCjMorepicpath($text1,$text2,$text3,"ecmsspicurl","ecmsbpicurl","ecmspicname",$r[$var2]);
				$ifield.=",".$dofield;
			    $ivalue.=",'".addslashes($zzvalue)."'";
				continue;
			}
			//下载地址
			if($dofield=="downpath"&&$r[$var])
			{
				//替换下载链接
	            $text=$r[$var];
				//替换回车
				$text=ReplaceFc($text);
				$down=explode("[!empirecms!]",$text);
				//地址
	            $zztext=RepInfoZZ($down[0],"ecmsdownpathurl",0);
	            $strtext=GetInfoStr($down[0],"ecmsdownpathurl",1);
	            $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
				//名称
				if($down[1])
				{
					$zztext=RepInfoZZ($down[1],"ecmsdownpathname",0);
	                $strtext=GetInfoStr($down[1],"ecmsdownpathname",1);
	                $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				$zzvalue=GetCjDownpath($text1,$text2,"ecmsdownpathurl","ecmsdownpathname",$r[$var2],0);
				$ifield.=",".$dofield;
			    $ivalue.=",'".addslashes($zzvalue)."'";
				continue;
			}
			//在线地址
			if($dofield=="onlinepath"&&$r[$var])
			{
				//替换下载链接
	            $text=$r[$var];
				//替换回车
				$text=ReplaceFc($text);
				$down=explode("[!empirecms!]",$text);
				//地址
	            $zztext=RepInfoZZ($down[0],"ecmsonlinepathurl",0);
	            $strtext=GetInfoStr($down[0],"ecmsonlinepathurl",1);
	            $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
				//名称
				if($down[1])
				{
					$zztext=RepInfoZZ($down[1],"ecmsonlinepathname",0);
	                $strtext=GetInfoStr($down[1],"ecmsonlinepathname",1);
	                $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				$zzvalue=GetCjDownpath($text1,$text2,"ecmsonlinepathurl","ecmsonlinepathname",$r[$var2],1);
				$ifield.=",".$dofield;
			    $ivalue.=",'".addslashes($zzvalue)."'";
				continue;
			}
			if(empty($r[$var1]))
			{
				if($r[$var])
				{
					$zzvalue=ReturnCJ_str($r[$var],$dofield,$info);
					if($zzvalue)
					{
						$zzvalue=$r[$var2].$zzvalue;
				    }
				}
			}
			else
			{$zzvalue=$r[$var1];}
			//------------------------------信息时间
			if($dofield=="newstime")
			{
				$newstime=$zzvalue;
				if(empty($newstime))
				{
					$newstime=$tmptime;
				}
				else
				{
					$newstime=CjFormatNewstime($newstime);//时间转换
				}
				continue;
			}
			//------------------------------信息来源
			if($dofield=="befrom"||$dofield=="writer")
			{
				//标题去除html代码
		        $zzvalue=strip_tags(str_replace("\r\n","",$zzvalue));
			}
			//------------------------------标题
			if($dofield=="title")
			{
				//标题去除html代码
		        $zzvalue=ehtmlspecialchars(strip_tags(str_replace("\r\n","",$zzvalue)));
				if(empty($zzvalue))
				{
					$next=1;
					break;
				}
				$keyboard=sub($zzvalue,0,$r[keynum],false);
				//标题是否包含关键字
				if($r[keyboard])
				{
					$t=HaveKeyboard($zzvalue,$r[keyboard]);
					if(empty($t))
					{
						$next=1;
						break;
					}
				}
				if($r[retitlewriter])//标题完全一样
				{
					//入库比较
					$onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title='".addslashes($zzvalue)."' and classid='$r[newsclassid]' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					/*采集库比较
					$onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title='".addslashes($zzvalue)."' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					*/
				}
				if($r[titlelen])//标题相似
				{
					//入库比较
					$c_title=addslashes(sub($zzvalue,0,$r[titlelen],false));
					$onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title like '%$c_title%' and classid='$r[newsclassid]' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					/*采集比较
					$onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title like '%$c_title%' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					*/
				}
			}
			//新闻内容分页
			if($dofield=="newstext")
			{
				//是否有分页
				if($r[pagezz]||$r[pageallzz])
				{
					//上下页式
					if(empty($r[pagetype]))
					{
						$zzvalue.=GetMoreCjPagetext($nr[newsurl],$r[$var],$r[smallpagezz],$r[pagezz],$r[pagetype],$info,$r);
					}
					//全部列表式
					else
					{
						$zzvalue.=GetMoreCjPagetextall($nr[newsurl],$r[$var],$r[smallpageallzz],$r[pageallzz],$r[pagetype],$info,$r);
					}
				}
			}
			//替换关键字
			if($dofield=="title"||$dofield=="newstext")
			{
				$zzvalue=RepInfoWord($zzvalue,$r[oldword],$r[newword]);
			}
			//新闻内容
			if($dofield=="newstext")
			{
				$zzvalue=RepAd($r[repad],$zzvalue);
				if($r['newstextisnull']==1&&empty($zzvalue))
				{
					$next=1;
					break;
				}
			}

			$ifield.=",".$dofield;
			$ivalue.=",'".addslashes($zzvalue)."'";
		}
		if($next)
		{continue;}
		//入临时库
		$isql=$empire->query("insert into {$dbtbpre}ecms_infotmp_".$r[tbname]."(classid,oldurl,checked,keyboard,newstime,truetime,tmptime,userid,username".$ifield.") values($classid,'$nr[newsurl]',0,'".addslashes($keyboard)."','$newstime',$truetime,'$tmptime',$userid,'".addslashes($username)."'".$ivalue.");");
    }
	//采集结束
	if(empty($b))
	{
		//删除记录
		$del=$empire->query("delete from {$dbtbpre}enewslinktmp where checkrnd='$checkrnd'");
		//更新最后时间
		$ucjsql=$empire->query("update {$dbtbpre}enewsinfoclass set lasttime='".time()."' where classid='$classid'");
		//自动入库
		if($r['justloadin'])
		{
			echo $fun_r['cjLoadInInfos']."<script>self.location.href='ecmscj.php?enews=CjNewsIn_all&classid=$classid&checked=$r[justloadcheck]&fm=1".hReturnEcmsHashStrHref(0)."';</script>";
			exit();
		}
		//单个节点
		if(getcvar('recjnum',1)==1)
		{
			echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><font color=red>".$fun_r['CjSuccess']."</font><script>parent.location.href='CheckCj.php?classid=$classid".hReturnEcmsHashStrHref2(0)."';</script>";
		}
		else
		{
			echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><body topmargin=0><font color=red>".$r[classname]."  ".$fun_r['CjSuccess']."</font>,  <input type=button name=button value='".$fun_r['OnlickLoadInCj']."' onclick=\"window.open('CheckCj.php?classid=$classid".hReturnEcmsHashStrHref2(0)."');\">";
			echo"<script>parent.checkrecj.location.href='CheckReCj.php".hReturnEcmsHashStrHref2(1)."';</script></body>";
		}
		exit();
	}
	//echo"(ID:<font color=red><b>".$newstart."</b></font>)<script>self.location.href='ecmscj.php?enews=GetNewsInfo&checkrnd=$checkrnd&classid=$classid&start=$newstart".hReturnEcmsHashStrHref(0)."';</script>";
	echo"<meta http-equiv=\"refresh\" content=\"".$r['keeptime'].";url=ecmscj.php?enews=GetNewsInfo&checkrnd=$checkrnd&classid=$classid&start=$newstart".hReturnEcmsHashStrHref(0)."\">".$r[classname]." (ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

//#################单个采集文件预览################
function ViewGetNewsInfo($classid,$newspage,$userid,$username){
	global $empire,$class_r,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid)||empty($newspage))
	{printerror("FailCX","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[classid]))
	{printerror("FailCX","history.go(-1)");}
	//副表
	$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
	//组合两数组
	$r=TogTwoArray($r,$ra);
	//导入编码文件
	if($r['enpagecode'])
	{
		@include_once("doiconv.php");
	}
	//取得模型
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$r[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$count=count($cjr);
	//采集时间
	$newstime=date("Y-m-d H:i:s");
	eCheckCjUrl($newspage,0);
	//入库数据库是否有记录
	if(empty($r[recjtheurl]))
	{
		$tmpnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$r[tbname]." where oldurl='$newspage' limit 1");
		if($tmpnum)
		{
			echo $fun_r['ReCj'];
			exit();
	    }
	}
	//取得远程页面，三次取不到值的将不取值
	for($i=1;$i<=3;$i++)
	{
		$info=ReadFiletext($newspage);
		if(!empty($info))
		{
			break;
	    }
	}
	if(empty($info))
	{
		echo $fun_r['CanNotOpenUrl'];
		exit();
	}
	//替换网页变量
	$info=RepCjPagetextStr($info,$r);
	//替换回车
	$info=ReplaceFc($info);
	//-----------------
	$ifield="";
	$ivalue="";
	$next=0;
	for($c=0;$c<$count-1;$c++)
	{
		$zzvalue="";
		$cjr1=explode($field,$cjr[$c]);
		$dofield=$cjr1[1];
		$dofieldname=$cjr1[0];
		$var="zz_".$dofield;
		$var1="z_".$dofield;
		$var2="qz_".$dofield;
		$var3="save_".$dofield;
		//图片集
		if($dofield=="morepic"&&$r[$var])
		{
			//替换下载链接
	        $text=stripSlashes(stripSlashes($r[$var]));
			//替换回车
			$text=ReplaceFc($text);
			$down=explode("[!empirecms!]",$text);
			//小图
	        $zztext=RepInfoZZ($down[0],"ecmsspicurl",0);
	        $strtext=GetInfoStr($down[0],"ecmsspicurl",1);
	        $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
			//大图
			if($down[1])
			{
				$zztext=RepInfoZZ($down[1],"ecmsbpicurl",0);
	            $strtext=GetInfoStr($down[1],"ecmsbpicurl",1);
	            $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			//名称
			if($down[2])
			{
				$zztext=RepInfoZZ($down[2],"ecmspicname",0);
	            $strtext=GetInfoStr($down[2],"ecmspicname",1);
	            $text3=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			$zzvalue=GetCjMorepicpath($text1,$text2,$text3,"ecmsspicurl","ecmsbpicurl","ecmspicname",$r[$var2]);
			$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
				continue;
		}
		//下载地址
		if($dofield=="downpath"&&$r[$var])
		{
			//替换下载链接
	        $text=stripSlashes(stripSlashes($r[$var]));
			//替换回车
			$text=ReplaceFc($text);
			$down=explode("[!empirecms!]",$text);
			//地址
	        $zztext=RepInfoZZ($down[0],"ecmsdownpathurl",0);
	        $strtext=GetInfoStr($down[0],"ecmsdownpathurl",1);
	        $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
			//名称
			if($down[1])
			{
				$zztext=RepInfoZZ($down[1],"ecmsdownpathname",0);
	            $strtext=GetInfoStr($down[1],"ecmsdownpathname",1);
	            $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			$zzvalue=GetCjDownpath($text1,$text2,"ecmsdownpathurl","ecmsdownpathname",$r[$var2],0);
			$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
			continue;
		}
		//在线地址
		if($dofield=="onlinepath"&&$r[$var])
		{
			//替换下载链接
	        $text=stripSlashes(stripSlashes($r[$var]));
			//替换回车
			$text=ReplaceFc($text);
			$down=explode("[!empirecms!]",$text);
			//地址
	        $zztext=RepInfoZZ($down[0],"ecmsonlinepathurl",0);
	        $strtext=GetInfoStr($down[0],"ecmsonlinepathurl",1);
	        $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
			//名称
			if($down[1])
			{
				$zztext=RepInfoZZ($down[1],"ecmsonlinepathname",0);
	            $strtext=GetInfoStr($down[1],"ecmsonlinepathname",1);
	            $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			$zzvalue=GetCjDownpath($text1,$text2,"ecmsonlinepathurl","ecmsonlinepathname",$r[$var2],1);
			$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
			continue;
		}

		if(empty($r[$var1]))
		{
			if($r[$var])
			{
				$zzvalue=ReturnCJ_str($r[$var],$dofield,$info);
				if($zzvalue)
				{
					$zzvalue=$r[$var2].$zzvalue;
				}
			}
		}
		else
		{$zzvalue=$r[$var1];}
		//------------------------------信息来源
		if($dofield=="befrom"||$dofield=="writer")
		{
			//标题去除html代码
		    $zzvalue=strip_tags(str_replace("\r\n","",$zzvalue));
		}
		//------------------------------标题
		if($dofield=="title")
		{
			//标题去除html代码
		    $zzvalue=ehtmlspecialchars(strip_tags(str_replace("\r\n","",$zzvalue)));
			if(empty($zzvalue))
			{
				echo $fun_r['CjEmptyTitle'];
			    exit();
			}
			//标题是否包含关键字
			if($r[keyboard])
			{
				$t=HaveKeyboard($zzvalue,$r[keyboard]);
		        if(empty($t))
			    {
					echo $fun_r['CjTitleKey'];
			        exit();
		        }
			}
			if($r[retitlewriter])//标题完全一样
		    {
			   //入库比较
			   $onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title='".addslashes($zzvalue)."' and classid='$r[newsclassid]' limit 1");
			   if($onum)
			   {
					echo $fun_r['CjReTitleWriter'];
					exit();
			   }
				/*采集库比较
				$onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title='".addslashes($zzvalue)."' limit 1");
				if($onum)
				{
					echo $fun_r['CjReTitleWriter'];
					exit();
				}
				*/
		    }
		    if($r[titlelen])//标题相似
		    {
			  //入库比较
			  $c_title=addslashes(sub($zzvalue,0,$r[titlelen],false));
			  $onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title like '%$c_title%' and classid='$r[newsclassid]' limit 1");
			  if($onum)
			  {
				echo $fun_r['CjSingTitlelen'].$r[titlelen].$fun_r['CjSingTitlelenL'];
				exit();
			  }
			  /*采集比较
			  $onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title like '%$c_title%' limit 1");
			  if($onum)
			  {
				echo $fun_r['CjSingTitlelen'].$r[titlelen].$fun_r['CjSingTitlelenL'];
				exit();
			  }
			  */
		    }
		}
		//新闻内容分页
		if($dofield=="newstext")
		{
			//是否有分页
			if($r[pagezz]||$r[pageallzz])
			{
				//上下页式
				if(empty($r[pagetype]))
				{
					$zzvalue.=GetMoreCjPagetext($newspage,$r[$var],$r[smallpagezz],$r[pagezz],$r[pagetype],$info,$r);
				}
				//全部列表式
				else
				{
					$zzvalue.=GetMoreCjPagetextall($newspage,$r[$var],$r[smallpageallzz],$r[pageallzz],$r[pagetype],$info,$r);
				}
			}
		}
		//替换关键字
		if($dofield=="title"||$dofield=="newstext")
		{
			$zzvalue=RepInfoWord($zzvalue,$r[oldword],$r[newword]);
		}
		//新闻内容
		if($dofield=="newstext")
		{
			$zzvalue=RepAd($r[repad],$zzvalue);
			if($r['newstextisnull']==1&&empty($zzvalue))
			{
				echo $fun_r['CjEmptyNewstext'];
			    exit();
			}
		}
		$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
	}
	//输出数据
	$data="<table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=30% align=center><b>VAR</b></td><td align=center><b>GET</b></td></tr><tr><td><b>".$fun_r['ViewCjPage']."</b></td><td><a href='".$newspage."' target=_blank>".$newspage."</a></td></tr>".$data."</table>";
	echo $data;
	exit();
}

//是否有关键字
function HaveKeyboard($title,$keyboard) {
	$r=explode(",",$keyboard);
	$b=0;
	for($i=0;$i<count($r);$i++)
	{
		$cr=explode($r[$i],$title);
		if(count($cr)<>1)
		{
			$b=1;
			break;
		}
	}
	return $b;
}

//替换关键字
function RepInfoWord($title,$oldword,$newword){
	if(empty($oldword))
	{
		return $title;
	}
	$oldword=stripSlashes($oldword);
	$newword=stripSlashes($newword);
	//替换回车
	$oldword=ReplaceFc($oldword);
	$newword=ReplaceFc($newword);
	$repmore=0;
	if(strstr($newword,","))
	{
		$repmore=1;
		$nr=explode(",",$newword);
	}
	$r=explode(",",$oldword);
	for($i=0;$i<count($r);$i++)
	{
		//替换多项
		if($repmore)
		{
			$title=str_replace($r[$i],$nr[$i],$title);
		}
		else
		{
			$title=str_replace($r[$i],$newword,$title);
		}
	}
	return $title;
}

//导出采集规则
function LoadOutCj($classid,$userid,$username){
	global $empire,$dbtbpre;
	$lineexp='<!-#-|-line-|-#-!>';
	$recordexp='<!-#-|-record-|-#-!>';
	$fieldexp='<!-#-|-field-|-#-!>';
	$sfieldexp='<!-#-|-smallfield-|-#-!>';
	CheckLevel($userid,$username,$classid,"loadcj");//验证权限
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror('LoadOutCjEmptyClassid','');
	}
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(!$cr['classid'])
	{
		printerror('LoadOutCjEmptyClassid','');
	}
	if(!$cr['newsclassid'])//非采集节点
	{
		printerror('LoadOutCjMustNewsclassid','');
	}
	//主表
	$mainfield=LoadOutCjMainField();
	$mainstr=LoadOutCjMainstr($cr,$mainfield,$fieldexp,$sfieldexp);
	//副表
	$infocr=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$cr[tbname]." where classid='$classid'");
	$datafield=LoadOutCjDataField($cr['tid'],$cr['tbname']);
	$datastr=LoadOutCjDatastr($infocr,$datafield,$fieldexp,$sfieldexp);
	@include('../class/EmpireCMS_version.php');
	$cjstr=EmpireCMS_VERSION.$recordexp.$mainstr.$recordexp.$datafield.$recordexp.$datastr;
	$file=$cr['tbname'].time().".cj";
	$filepath=ECMS_PATH."e/data/tmp/cj/".$file;
	WriteFiletext_n($filepath,$cjstr);
	DownLoadFile($file,$filepath,1);
	//操作日志
	insert_dolog("classid=$classid&classname=$cr[classname]");
	exit();
}

//返回主表字段列表
function LoadOutCjMainField(){
	$field='classname,infourl,bz,num,copyimg,renum,keyboard,oldword,newword,titlelen,retitlewriter,smalltextlen,zz_smallurl,zz_newsurl,httpurl,repad,imgurl,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,keynum,insertnum,copyflash,pagetype,smallpagezz,pagezz,smallpageallzz,pageallzz,mark,enpagecode,recjtheurl,hiddenload,justloadin,justloadcheck,delloadinfo,pagerepad,getfirstpic,oldpagerep,newpagerep,keeptime,newstextisnull,getfirstspic,getfirstspicw,getfirstspich,doaddtextpage,infourlispage';
	return $field;
}

//返回主表组合
function LoadOutCjMainstr($r,$field,$fieldexp,$sfieldexp){
	$mainstr='';
	$addexp='';
	$fr=explode(',',$field);
	$fcount=count($fr);
	for($i=0;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$mainstr.=$addexp.$r[$f];
		$addexp=$fieldexp;
	}
	return $mainstr;
}

//返回副表字段列表
function LoadOutCjDataField($tid,$tbname){
	global $empire,$dbtbpre;
	$field='';
	$dh='';
	$fsql=$empire->query("select f from {$dbtbpre}enewsf where tid='$tid' and iscj=1");
	while($fr=$empire->fetch($fsql))
	{
		$field.=$dh.$fr['f'];
		$dh=',';
	}
	return $field;
}

//返回副表组合
function LoadOutCjDatastr($r,$field,$fieldexp,$sfieldexp){
	if(empty($field))
	{
		return '';
	}
	$datastr='';
	$addexp='';
	$fr=explode(',',$field);
	$fcount=count($fr);
	for($i=0;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$zzf='zz_'.$f;
		$zf='z_'.$f;
		$qzf='qz_'.$f;
		$savef='save_'.$f;
		$datastr.=$addexp.$r[$zzf].$sfieldexp.$r[$zf].$sfieldexp.$r[$qzf].$sfieldexp.$r[$savef];
		$addexp=$fieldexp;
	}
	return $datastr;
}

//导入采集规则
function LoadInCj($add,$file,$file_name,$file_type,$file_size,$userid,$username){
	global $empire,$dbtbpre;
	$lineexp='<!-#-|-line-|-#-!>';
	$recordexp='<!-#-|-record-|-#-!>';
	$fieldexp='<!-#-|-field-|-#-!>';
	$sfieldexp='<!-#-|-smallfield-|-#-!>';
	//验证权限
    CheckLevel($userid,$username,$classid,"loadcj");
	$classid=(int)$add['classid'];
	if(!$classid)
	{
		printerror("EmptyLoadInCjFile","history.go(-1)");
	}
	$cr=$empire->fetch1("select classid,islast,tid,tbname from {$dbtbpre}enewsclass where classid='$classid' and islast=1");
	if(!$cr['classid'])
	{
		printerror("LoadInCjMustLastClass","history.go(-1)");
	}
	if(!$file_name||!$file_size)
	{
		printerror("EmptyLoadInCjFile","history.go(-1)");
	}
	//扩展名
	$filetype=GetFiletype($file_name);
	if($filetype!=".cj")
	{
		printerror("LoadInCjErrorfiletype","history.go(-1)");
	}
	$path=ECMS_PATH.'e/data/tmp/cj/uploadcj'.time().'.cj';
	//上传文件
	$cp=@move_uploaded_file($file,$path);
	DoChmodFile($path);
	$data=ReadFiletext($path);
	DelFiletext($path);
	$r=explode($recordexp,$data);
	$empirecmsver=$r[0];
	$mainstr=$r[1];
	$datafield=$r[2];
	$datastr=$r[3];
	if(empty($mainstr))
	{
		printerror("EmptyLoadInCjFile","history.go(-1)");
	}
	//主表
	$infoclassid=LoadInCjInsertMainstr($classid,$cr['tid'],$cr['tbname'],$mainstr,$fieldexp,$sfieldexp);
	//副表
	LoadInCjInsertDatastr($classid,$cr['tid'],$cr['tbname'],$infoclassid,$datafield,$datastr,$fieldexp,$sfieldexp);
	$cjr=$empire->fetch1("select classname from {$dbtbpre}enewsinfoclass where classid='$infoclassid'");
	//操作日志
	insert_dolog("classid=".$infoclassid."<br>classname=".$cjr[classname]);
	printerror("LoadInCjSuccess","cj/LoadInCj.php?from=".ehtmlspecialchars($_POST[from]).hReturnEcmsHashStrHref2(0));
}

//写入主表组合
function LoadInCjInsertMainstr($classid,$tid,$tbname,$mainstr,$fieldexp,$sfieldexp){
	global $empire,$dbtbpre;
	$mainfield=LoadOutCjMainField();
	$mainr=explode($fieldexp,$mainstr);
	$mainvalues='';
	$count=count($mainr);
	for($i=0;$i<$count;$i++)
	{
		if($i==0)
		{
			$mainr[$i]=ehtmlspecialchars($mainr[$i],ENT_QUOTES);
		}
		$mainvalues.=",'".addslashes($mainr[$i])."'";
	}
	$empire->query("insert into {$dbtbpre}enewsinfoclass(classid,bclassid,newsclassid,tid,tbname,".$mainfield.") values(NULL,'0','$classid','$tid','$tbname'".$mainvalues.");");
	$lastid=$empire->lastid();
	return $lastid;
}

//写入副表组合
function LoadInCjInsertDatastr($classid,$tid,$tbname,$infoclassid,$dataf,$datastr,$fieldexp,$sfieldexp){
	global $empire,$dbtbpre;
	if(empty($dataf))
	{
		$empire->query("insert into {$dbtbpre}ecms_infoclass_".$tbname."(classid) values('$infoclassid');");
		return '';
	}
	//返回表字段
	$tbfield=LoadOutCjDataField($tid,$tbname);
	$datafr=explode(',',$dataf);
	$datar=explode($fieldexp,$datastr);
	$datafield='';
	$datavalues='';
	$count=count($datafr);
	for($i=0;$i<$count;$i++)
	{
		$f=$datafr[$i];
		if(!stristr(','.$tbfield.',',','.$f.','))
		{
			continue;
		}
		$zzf='zz_'.$f;
		$zf='z_'.$f;
		$qzf='qz_'.$f;
		$savef='save_'.$f;
		$zzr=explode($sfieldexp,$datar[$i]);
		$datafield.=",$zzf,$zf,$qzf,$savef";
		$datavalues.=",'".addslashes($zzr[0])."','".addslashes($zzr[1])."','".addslashes($zzr[2])."','".addslashes($zzr[3])."'";
	}
	$empire->query("insert into {$dbtbpre}ecms_infoclass_".$tbname."(classid".$datafield.") values('$infoclassid'".$datavalues.");");
}
?>