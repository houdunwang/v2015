<?php
//删除文件
function DelFile($fileid,$userid,$username){
	global $empire,$class_r,$dbtbpre;
	$fileid=(int)$fileid;
	if(!$fileid)
	{printerror("NotFileid","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"file");
	$modtype=(int)$_GET['modtype'];
	$fstb=(int)$_GET['fstb'];
	$r=$empire->fetch1("select filename,path,classid,fpath from ".eReturnFileTable($modtype,$fstb)." where fileid='$fileid' limit 1");
	$sql=$empire->query("delete from ".eReturnFileTable($modtype,$fstb)." where fileid='$fileid'");
	DoDelFile($r);
	if($sql)
	{
		//操作日志
		insert_dolog("fileid=".$fileid."<br>filename=".$r[filename]);
		printerror("DelFileSuccess",$_SERVER['HTTP_REFERER']);
    }
	else
	{
		printerror("DbError","history.go(-1)");
    }
}

//批量删除文件
function DelFile_all($fileid,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	//操作权限
	if($_POST['enews']=='TDelFile_all')
	{
		$userid=(int)$userid;
		$ur=$empire->fetch1("select groupid,adminclass,filelevel from {$dbtbpre}enewsuser where userid='$userid' limit 1");
		if($ur['filelevel'])
		{
			$gr=$empire->fetch1("select dofile from {$dbtbpre}enewsgroup where groupid='$ur[groupid]'");
			if(!$gr['dofile'])
			{
				$classid=(int)$_POST['classid'];
				$searchclassid=(int)$_POST['searchclassid'];
				$classid=$searchclassid?$searchclassid:$classid;
				if(!$class_r[$classid]['classid'])
				{
					printerror("NotLevel","history.go(-1)");
				}
				if(!strstr($ur['adminclass'],'|'.$classid.'|'))
				{
					printerror("NotLevel","history.go(-1)");
				}
			}
		}
		else
		{
			CheckLevel($userid,$username,$classid,"file");
		}
	}
	else
	{
		CheckLevel($userid,$username,$classid,"file");
	}
	$count=count($fileid);
	if(!$count)
	{printerror("NotFileid","history.go(-1)");}
	$modtype=(int)$_POST['modtype'];
	$fstb=(int)$_POST['fstb'];
	for($i=0;$i<count($fileid);$i++)
	{
		$fileid[$i]=(int)$fileid[$i];
		$r=$empire->fetch1("select filename,path,classid,fpath from ".eReturnFileTable($modtype,$fstb)." where fileid='$fileid[$i]' limit 1");
		$sql=$empire->query("delete from ".eReturnFileTable($modtype,$fstb)." where fileid='$fileid[$i]'");
		DoDelFile($r);
    }
	if($sql)
	{
		//操作日志
		insert_dolog("");
		printerror("DelFileAllSuccess",$_SERVER['HTTP_REFERER']);
    }
	else
	{
		printerror("DbError","history.go(-1)");
    }
}

//删除多余附件
function DelFreeFile($userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"file");
	//清理信息附件
	DelFileAllTable("cjid<>0 and (id=0 or cjid=id)");
	//会员附件
	DelFileOtherTable("cjid<>0 and (id=0 or cjid=id)","member");
	//其他附件
	DelFileOtherTable("cjid<>0 and (id=0 or cjid=id)","other");
	//操作日志
	insert_dolog("");
	printerror("DelFreeFileSuccess",$_SERVER['HTTP_REFERER']);
}

//删除目录文件
function DelPathFile($filename,$userid,$username){
	global $empire,$dbtbpre,$public_r,$efileftp_dr;
	//操作权限
	CheckLevel($userid,$username,$classid,"file");
	$count=count($filename);
	if(empty($count))
	{
		printerror("NotFileid","history.go(-1)");
	}
	//基目录
	$basepath=eReturnEcmsMainPortPath()."d/file";//moreport
	for($i=0;$i<$count;$i++)
	{
		if(strstr($filename[$i],".."))
		{
			continue;
	    }
		if(!file_exists($basepath."/".$filename[$i]))
		{
			continue;
		}
		DelFiletext($basepath."/".$filename[$i]);
		$dfile=ReturnPathFile($filename[$i]);
		$dfile=hRepPostStr($dfile,1);
		$dfnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsfile_1 where filename='$dfile'");
		if($dfnum)
		{
			$empire->query("delete from {$dbtbpre}enewsfile_1 where filename='$dfile'");
			//FileServer
			if($public_r['openfileserver'])
			{
				$efileftp_dr[]=$basepath."/".$filename[$i];
			}
		}
    }
	//操作日志
	insert_dolog("");
	printerror("DelFileSuccess",$_SERVER['HTTP_REFERER']);
}

//批量加水印/缩略图
function DoMarkSmallPic($add,$userid,$username){
	global $empire,$class_r,$dbtbpre,$public_r,$efileftp_fr;
	//导入gd处理文件
	if($add['getsmall']||$add['getmark'])
	{
		@include(ECMS_PATH."e/class/gd.php");
	}
	else
	{
		printerror("EmptyDopicFileid","history.go(-1)");
	}
	$fileid=$add['fileid'];
	$count=count($fileid);
	if($count==0)
	{
		printerror("EmptyDopicFileid","history.go(-1)");
	}
	$add['classid']=(int)$add['classid'];
	$modtype=(int)$add['modtype'];
	$fstb=(int)$add['fstb'];
	$fstb=eReturnFileStb($fstb);
	for($i=0;$i<$count;$i++)
	{
		$fileid[$i]=intval($fileid[$i]);
		$r=$empire->fetch1("select classid,filename,path,no,fpath from ".eReturnFileTable($modtype,$fstb)." where fileid='$fileid[$i]'");
		$rpath=$r['path']?$r['path'].'/':$r['path'];
		$fspath=ReturnFileSavePath($r[classid],$r[fpath]);
		$path=eReturnEcmsMainPortPath().$fspath['filepath'].$rpath;//moreport
		$yname=$path.$r[filename];
		//缩略图
		if($add['getsmall'])
		{
			$filetype=GetFiletype($r[filename]);
			$insertfile=substr($r[filename],0,strlen($r[filename])-strlen($filetype)).time();
			$name=$path."small".$insertfile;
			GetMySmallImg($add['classid'],$r[no],$insertfile,$r[path],$yname,$add[width],$add[height],$name,$add['filepass'],$add['filepass'],$userid,$username,$modtype,$fstb);
		}
		//水印
		if($add['getmark'])
		{
			GetMyMarkImg($yname);
			//FileServer
			if($public_r['openfileserver'])
			{
				$efileftp_fr[]=$yname;
			}
		}
	}
	printerror("DoMarkSmallPicSuccess",$_SERVER['HTTP_REFERER']);
}

//上传多附件
function TranMoreFile($file,$file_name,$file_type,$file_size,$no,$type,$userid,$username){
	global $empire,$public_r,$dbtbpre;
	$count=count($file_name);
	if(empty($count))
	{
		printerror("MustChangeTranOneFile","history.go(-1)");
    }
	//操作权限
	CheckLevel($userid,$username,$classid,"file");
	$type=(int)$type;
	for($i=0;$i<$count;$i++)
	{
		if(empty($file_name[$i]))
		{
			continue;
		}
		//取得文件类型
		$filetype=GetFiletype($file_name[$i]);
		//如果是.php文件
		if(CheckSaveTranFiletype($filetype))
		{continue;}
	    $type_r=explode("|".$filetype."|",$public_r['filetype']);
	    if(count($type_r)<2)
		{continue;}
		if($file_size[$i]>$public_r['filesize']*1024)
		{continue;}
		//上传
		$r=DoTranFile($file[$i],$file_name[$i],$file_type[$i],$file_size[$i],$classid);
		//写入数据库
		$r[filesize]=(int)$r[filesize];
		$classid=(int)$classid;
		if(empty($no[$i]))
		{$no[$i]=$file_name[$i];}

		eInsertFileTable($r[filename],$r[filesize],$r[filepath],$username,$classid,$no[$i],$type,0,0,$public_r[fpath],0,5,0);
	}
	insert_dolog("");//操作日志
	printerror("TranMoreFileSuccess","file/TranMoreFile.php".hReturnEcmsHashStrHref2(1));
}

//************************************ 附件分表管理 ************************************

//增加附件分表
function AddFileDataTable($add,$userid,$username){
	echo'This is the Free Version of EmpireCMS.';
	exit();
}

//默认附件存放表
function DefFileDataTable($add,$userid,$username){
	echo'This is the Free Version of EmpireCMS.';
	exit();
}

//删除附件分表
function DelFileDataTable($add,$userid,$username){
	echo'This is the Free Version of EmpireCMS.';
	exit();
}
?>