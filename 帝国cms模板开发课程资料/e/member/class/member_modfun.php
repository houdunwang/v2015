<?php
//--------------- 会员字段处理函数 ---------------

//处理注册字段值
function DoMemberFValue($val){
	$val=ehtmlspecialchars($val,ENT_QUOTES);
	return $val;
}

//删除会员字段附件
function DelYMemberTranFile($file,$tf,$username=''){
	global $empire,$dbtbpre;
	if(empty($file)){
		return "";
	}
	$r=explode("/",$file);
	$count=count($r);
	$filename=$r[$count-1];
	$fr=$empire->fetch1("select filename,path,fileid,fpath,classid from {$dbtbpre}enewsfile_member where no='Member[".$tf."]' and filename='$filename' and adduser='[EditInfo]".$username."' limit 1");
	if($fr['fileid'])
	{
		$sql=$empire->query("delete from {$dbtbpre}enewsfile_member where fileid='$fr[fileid]'");
		DoDelFile($fr);
	}
}

//组合复选框数据
function ReturnMCheckboxAddF($r,$f,$checkboxf){
	$val=$r;
	if(is_array($r)&&strstr($checkboxf,','.$f.','))
	{
		$val='';
		$count=count($r);
		for($i=0;$i<$count;$i++)
		{
			$val.=$r[$i].'|';
		}
		if($val)
		{
			$val='|'.$val;
		}
	}
	return $val;
}

//返回会员字段
function ReturnDoMemberF($fid,$add,$mr,$ecms=0,$username='',$admin=0){
	global $empire,$dbtbpre,$ecms_config,$public_r;
	$pr=$empire->fetch1("select openmembertranimg,memberimgsize,memberimgtype,openmembertranfile,memberfilesize,memberfiletype from {$dbtbpre}enewspublic limit 1");
	$formr=$empire->fetch1("select fid,enter,mustenter,filef,imgf,canaddf,caneditf,checkboxf from {$dbtbpre}enewsmemberform where fid='$fid'");
	//检测必填字段
	$mustr=explode(",",$formr['mustenter']);
	$mustcount=count($mustr);
	for($i=1;$i<$mustcount-1;$i++)
	{
		$mf=$mustr[$i];
		if(strstr($formr['filef'],",".$mf.",")||strstr($formr['imgf'],",".$mf.","))//附件
		{
			$mfilef=$mf."file";
			//上传文件
			if($_FILES[$mfilef]['name'])
			{
				if(strstr($formr['imgf'],",".$mf.","))//图片
				{
					if(!$pr['openmembertranimg'])
					{
						printerror("CloseQTranPic","",1);
					}
				}
				else//附件
				{
					if(!$pr['openmembertranfile'])
					{
						printerror("CloseQTranFile","",1);
					}
				}
			}
			elseif(!trim($add[$mf])&&!$mr[$mf])
			{
				printerror("EmptyQMustF","",1);
			}
		}
		else
		{
			$chmustval=ReturnMCheckboxAddF($add[$mf],$mf,$formr['checkboxf']);
			if(!trim($chmustval))
			{
				printerror("EmptyQMustF","",1);
			}
		}
	}
	//字段处理
	$dh="";
	$tranf="";
	$record="<!--record-->";
	$field="<!--field--->";
	$fr=explode($record,$formr['enter']);
	$count=count($fr);
	for($i=0;$i<$count-1;$i++)
	{
		$fr1=explode($field,$fr[$i]);
		$f=$fr1[1];
		if($admin==0&&(($ecms==0&&!strstr($formr['canaddf'],','.$f.','))||($ecms==1&&!strstr($formr['caneditf'],','.$f.','))))
		{continue;}
		//附件
		$add[$f]=str_replace('[!#@-','ecms',$add[$f]);
		if(strstr($formr['filef'],",".$f.",")||strstr($formr['imgf'],",".$f.","))
		{
			//上传附件
			$filetf=$f."file";
			if($_FILES[$filetf]['name'])
			{
				$filetype=GetFiletype($_FILES[$filetf]['name']);//取得文件类型
				if(CheckSaveTranFiletype($filetype))
				{
					printerror("NotQTranFiletype","",1);
				}
				if(strstr($formr['imgf'],",".$f.","))//图片
				{
					if(!$pr['openmembertranimg'])
					{
						printerror("CloseQTranPic","",1);
					}
					if(!strstr($pr['memberimgtype'],"|".$filetype."|"))
					{
						printerror("NotQTranFiletype","",1);
					}
					if($_FILES[$filetf]['size']>$pr['memberimgsize']*1024)
					{
						printerror("TooBigQTranFile","",1);
					}
					if(!strstr($ecms_config['sets']['tranpicturetype'],','.$filetype.','))
					{
						printerror("NotQTranFiletype","",1);
					}
				}
				else//附件
				{
					if(!$pr['openmembertranfile'])
					{
						printerror("CloseQTranFile","",1);
					}
					if(!strstr($pr['memberfiletype'],"|".$filetype."|"))
					{
						printerror("NotQTranFiletype","",1);
					}
					if($_FILES[$filetf]['size']>$pr['memberfilesize']*1024)
					{
						printerror("TooBigQTranFile","",1);
					}
				}
				$tranf.=$dh.$f;
				$dh=",";
				$fval="[!#@-".$f."-@!]";
			}
			else
			{
				if($public_r['modmemberedittran']==1)
				{
					$fval=$add[$f];
					if($ecms==1&&$mr[$f]&&!trim($fval))
					{
						$fval=$mr[$f];
					}
				}
				else
				{
					$fval='';
					if($ecms==1)
					{
						$fval=$mr[$f];
					}
				}
			}
		}
		else
		{
			$add[$f]=ReturnMCheckboxAddF($add[$f],$f,$formr['checkboxf']);
			$fval=$add[$f];
		}
		$fval=DoMemberFValue($fval);
		$fval=RepPostStr2($fval);
		$fval=addslashes($fval);
		if($ecms==0)//添加
		{
			$ret_r[0].=",`".$f."`";
			$ret_r[1].=",'".$fval."'";
		}
		else//编辑
		{
			$ret_r[0].=",`".$f."`='".$fval."'";
		}
	}
	//上传附件
	if($tranf)
	{
		$infoid=0;
		$filepass=0;
		$classid=0;
		$filepass=(int)$mr['add_filepass'];
		$tranr=explode(",",$tranf);
		$count=count($tranr);
		for($i=0;$i<$count;$i++)
		{
			$tf=$tranr[$i];
			$tffile=$tf."file";
			$tfr=DoTranFile($_FILES[$tffile]['tmp_name'],$_FILES[$tffile]['name'],$_FILES[$tffile]['type'],$_FILES[$tffile]['size'],$classid);
			if($tfr['tran'])
			{
				if(strstr($formr['imgf'],",".$tf.","))//图片
				{
					$type=1;
				}
				else//附件
				{
					$type=0;
				}
				//写入数据库
				$filesize=(int)$_FILES[$tffile]['size'];
				eInsertFileTable($tfr[filename],$filesize,$tfr[filepath],'[EditInfo]'.$username,$classid,'Member['.$tf.']',$type,$filepass,$filepass,$public_r[fpath],0,6,0);
				//删除旧文件
				if($ecms==1&&$mr[$tf])
				{
					DelYMemberTranFile($mr[$tf],$tf,$username);
				}
				$repfval=$tfr['url'];
			}
			else
			{
				$repfval=$mr[$tf];
			}
			if($ecms==0)//添加
			{
				$ret_r[1]=str_replace("[!#@-".$tf."-@!]",$repfval,$ret_r[1]);
			}
			else//编辑
			{
				$ret_r[0]=str_replace("[!#@-".$tf."-@!]",$repfval,$ret_r[0]);
			}
		}
	}
	return $ret_r;
}

//删除会员附件
function DoDelMemberF($fid,$userid,$username){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid='$userid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsmemberadd where userid='$userid'");
	$sql2=$empire->query("delete from {$dbtbpre}enewsmemberpub where userid='$userid'");
	if(empty($r[userid]))
	{
		return '';
	}
	$formr=$empire->fetch1("select fid,filef,imgf from {$dbtbpre}enewsmemberform where fid='$fid'");
	if(empty($formr['filef']))
	{
		$formr['filef']=',';
	}
	if(empty($formr['imgf']))
	{
		$formr['imgf']=',';
	}
	$fields=substr($formr['filef'],0,strlen($formr['filef'])-1).$formr['imgf'];
	$fr=explode(',',$fields);
	$count=count($fr);
	for($i=1;$i<$count-1;$i++)
	{
		$f=$fr[$i];
		if($r[$f])
		{
			DelYMemberTranFile($r[$f],$f,$username);
		}
	}
}
?>