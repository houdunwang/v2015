<?php
//提示信息
function ECMS_EditorPrintError($errorNumber,$fileUrl,$fileName,$customMsg,$fileno,$filesize){
	global $public_r;
	if(empty($errorNumber))
	{
		$errorNumber=0;
		$filesize=ChTheFilesize($filesize);
	}
	else
	{
		@include '../'.LoadLang("pub/message.php");
		$customMsg=$message_r[$customMsg];
	}
	$errorNumber=(int)$errorNumber;
	echo"<script type=\"text/javascript\">window.parent.OnUploadCompleted($errorNumber,'".addslashes($fileUrl)."','".addslashes($fileName)."','".addslashes($customMsg)."','".addslashes($fileno)."','$filesize');</script>";
	db_close();
	exit();
}

//返回表格格式
function eTranMoreTbGs($r){
	if($r['tbcolor'])
	{
		$tbcolor="  bgcolor='".$r['tbcolor']."'";
	}
	if($r['tbbordercolor'])
	{
		$tbbordercolor=" bordercolor='".$r['tbbordercolor']."'";
	}
	if($r['tbsp'])
	{
		$tbsp=" cellspacing='".$r['tbsp']."'";
	}
	if($r['tbpa'])
	{
		$tbpa=" cellpadding='".$r['tbpa']."'";
	}
	if($r['tbwidth'])
	{
		$tbwidth=" width='".$r['tbwidth'].$r['tbwidthdw']."'";
	}
	$table="<table".$tbwidth." border='".$r['tbborder']."'".$tbpa.$tbsp.$tbbordercolor.$tbcolor." align='".$r['tbalign']."'>";
	return $table;
}

//编辑器上传多图片
function eTranMorePic($file,$file_name,$file_type,$file_size,$add,$userid,$username){
	global $empire,$public_r,$dbtbpre,$fun_r;
	//导入gd处理文件
	if($add['getsmall']||$add['getmark'])
	{
		@include(ECMS_PATH."e/class/gd.php");
	}
	$tranfrom=(int)$add['tranfrom'];
	$j=0;
	$line=(int)$add['line'];
	if($line==0)
	{
		$line=1;
    }
	$add['classid']=(int)$add['classid'];
	$modtype=(int)$add['modtype'];
	$infoid=(int)$add['infoid'];
	$fstb=0;
	if(empty($modtype))
	{
		$fstb=GetInfoTranFstb($add['classid'],$infoid,0);
	}
	//远程保存
	if($add['saveurl'])
	{
		$url_r=explode("\r\n",$add['saveurl']);
		$count=count($url_r);
		for($i=0;$i<$count;$i++)
		{
			if(empty($url_r[$i]))
			{continue;}
			//验证图片
			$check=eTranMorePicCheck($url_r[$i],0);
			if($check==0)
			{continue;}
			//开始上传
			$r=DoTranUrl($url_r[$i],$add['classid']);
			if(empty($r[tran]))
		    {
				continue;
			}
			$imgurl=$r['url'];
			$bimgurl=$r['url'];
			//写入数据库
			$r[filesize]=(int)$r[filesize];
			$add[classid]=(int)$add[classid];
			$add[type]=(int)$add[type];
			$add[filepass]=(int)$add[filepass];
			eInsertFileTable($r[filename],$r[filesize],$r[filepath],$username,$add[classid],$r[filename],$add[type],$add[filepass],$add[filepass],$public_r[fpath],0,$modtype,$fstb);
			//缩略图
			if($add['getsmall'])
			{
				$sfiler=GetMySmallImg($add['classid'],$r[filename],$r[insertfile],$r[filepath],$r[yname],$add[swidth],$add[sheight],$r[name],$add['filepass'],$add['filepass'],$userid,$username,$modtype,$fstb);
				$imgurl=str_replace("/".$r[filename],"/small".$r[insertfile].$sfiler['filetype'],$r[url]);
			}
			//水印
			if($add['getmark'])
			{
				GetMyMarkImg($r['yname']);
			}
			//开始输出字符
			$j++;
			//分页
			if($add['exptype']==1)
			{
				$classtext.="<p align='".$add['align']."'>".eTranMorePicGs($bimgurl,$imgurl,$add)."</p>";
				if($j%$line==0)
				{
					$classtext.="[!--empirenews.page--]";
				}
			}
			//表格
			else
			{
				if(($j-1)%$line==0||$j==1)
				{$classtext.="<tr>";}
				$classtext.="<td align=".$add['align'].">".eTranMorePicGs($bimgurl,$imgurl,$add)."</td>";
				if($j%$line==0)
				{$classtext.="</tr>";}
			}
		}
		//表格
		if($add['exptype']==0)
		{
			if($j<>0)
			{
		      $table=eTranMoreTbGs($add);
			  $table1="</table>";
              $ys=$line-$j%$line;
			  $p=0;
              for($k=0;$k<$ys&&$ys!=$line;$k++)
			  {
				$p=1;
				$classtext.="<td></td>";
              }
			  if($p==1)
			  {
				 $classtext.="</tr>";
			  }
			}
			$classtext=$table.$classtext.$table1;
		}
		//分页
		else
		{
			if($j%$line==0)
			{
				$classtext=substr($classtext,0,strlen($classtext)-22);
			}
		}
	}
	//本地上传
	else
	{
		$count=count($file_name);
		if($count==0)
		{
			$tranfrom==0?printerror("MustChangeTranOneFile","history.go(-1)",8):ECMS_EditorPrintError(1,'','','MustChangeTranOneFile','','');
	    }
		$GLOBALS['doetran']=1;
		for($i=0;$i<$count;$i++)
		{
			if(empty($file_name[$i]))
			{
				continue;
			}
			//验证图片
			$check=eTranMorePicCheck($file_name[$i],$file_size[$i]);
			if($check==0)
			{
				continue;
			}
			//上传
			$r=DoTranFile($file[$i],$file_name[$i],$file_type[$i],$file_size[$i],$add['classid']);
			if(empty($r[tran]))
		    {
				continue;
			}
			$imgurl=$r['url'];
			$bimgurl=$r['url'];
			//写入数据库
			$r[filesize]=(int)$r[filesize];
			$add[classid]=(int)$add[classid];
			$add[type]=(int)$add[type];
			$add[filepass]=(int)$add[filepass];
			eInsertFileTable($r[filename],$r[filesize],$r[filepath],$username,$add[classid],$file_name[$i],$add[type],$add[filepass],$add[filepass],$public_r[fpath],0,$modtype,$fstb);
			//缩略图
			if($add['getsmall'])
			{
				$sfiler=GetMySmallImg($add['classid'],$r[filename],$r[insertfile],$r[filepath],$r[yname],$add[swidth],$add[sheight],$r[name],$add['filepass'],$add['filepass'],$userid,$username,$modtype,$fstb);
				$imgurl=str_replace("/".$r[filename],"/small".$r[insertfile].$sfiler['filetype'],$r[url]);
			}
			//水印
			if($add['getmark'])
			{
				GetMyMarkImg($r['yname']);
			}
			//开始输出字符
			$j++;
			//分页
			if($add['exptype']==1)
			{
				$classtext.="<p align=".$add['align'].">".eTranMorePicGs($bimgurl,$imgurl,$add)."</p>";
				if($j%$line==0)
				{
					$classtext.="[!--empirenews.page--]";
				}
			}
			//表格
			else
			{
				if(($j-1)%$line==0||$j==1)
				{$classtext.="<tr>";}
				$classtext.="<td align=".$add['align'].">".eTranMorePicGs($bimgurl,$imgurl,$add)."</td>";
				if($j%$line==0)
				{$classtext.="</tr>";}
			}
		}
		//表格
		if($add['exptype']==0)
		{
			if($j<>0)
			{
		      $table=eTranMoreTbGs($add);
			  $table1="</table>";
              $ys=$line-$j%$line;
			  $p=0;
              for($k=0;$k<$ys&&$ys!=$line;$k++)
			  {
			   $p=1;
               $classtext.="<td></td>";
               }
			   if($p==1)
				{
				   $classtext.="</tr>";
			   }
			}
			$classtext=$table.$classtext.$table1;
		}
		//分页
		else
		{
			if($j%$line==0)
			{
			$classtext=substr($classtext,0,strlen($classtext)-22);
			}
		}
	}
	echo "<script>window.parent.DoFile(\"".$classtext."\");</script>";
	db_close();
	exit();
}

//返回图片格式
function eTranMorePicGs($bimgurl,$imgurl,$r){
	if($r['width'])
	{
		$width=" width=".$r['width'];
	}
	if($r['height'])
	{
		$height=" height=".$r['height'];
	}
	$pic="<a href='".$bimgurl."' target='_blank'><img src='".$imgurl."' border=".$r['imgborder'].$width.$height."></a>";
	return $pic;
}

//验证图片是否合法
function eTranMorePicCheck($url,$filesize){
	global $public_r,$ecms_config;
	$filetype=GetFiletype($url);//扩展名
	//如果是.php文件
	if(CheckSaveTranFiletype($filetype))
	{
		return 0;
	}
	if(!strstr($public_r['filetype'],"|".$filetype."|"))
	{
		return 0;
	}
	if($filesize>$public_r['filesize']*1024)
	{
		return 0;
	}
	//扩展名是否合法
	if(!strstr($ecms_config['sets']['tranpicturetype'],','.$filetype.','))
	{
		return 0;
	}
	return 1;
}

//上传文件
function TranFile($file,$file_name,$file_type,$file_size,$tranurl,$no,$classid,$type,$post,$userid,$username){
	global $empire,$public_r,$loginrnd,$dbtbpre,$ecms_config;
	if(!$no)
	{
		$no=$file_name;
	}
	$tranfrom=(int)$post['tranfrom'];
	$classid=(int)$classid;
	$modtype=(int)$post['modtype'];
	$infoid=(int)$post['infoid'];
	$fstb=0;
	if(empty($modtype))
	{
		$fstb=GetInfoTranFstb($classid,$infoid,0);
	}
	//是否为空
	if(!$file_name)
	{
		if(empty($tranurl)||$tranurl=="http://")
		{
			$tranfrom==0?printerror("EmptyHttp","history.go(-1)",8):ECMS_EditorPrintError(1,'','','EmptyHttp','','');
		}
		$filetype=GetFiletype($tranurl);//取得文件类型
		$file_size=0;
    }
	else
	{
		$filetype=GetFiletype($file_name);//取得文件类型
	}
	//如果是.php文件
	if(CheckSaveTranFiletype($filetype))
	{
		$tranfrom==0?printerror("TranPHP","history.go(-1)",8):ECMS_EditorPrintError(1,'','','TranPHP','','');
	}
	$type_r=explode("|".$filetype."|",$public_r['filetype']);
	if(count($type_r)<2)
	{
		$tranfrom==0?printerror("TranFiletypeFail","history.go(-1)",8):ECMS_EditorPrintError(1,'','','TranFiletypeFail','','');
	}
	if($file_size>$public_r['filesize']*1024)
	{
		$tranfrom==0?printerror("TranFilesizeFail","history.go(-1)",8):ECMS_EditorPrintError(1,'','','TranFilesizeFail','','');
	}
	if($type==1)//上传图片
	{
		if(!strstr($ecms_config['sets']['tranpicturetype'],','.$filetype.','))
		{
			$tranfrom==0?printerror("NotTranImg","history.go(-1)",8):ECMS_EditorPrintError(1,'','','NotTranImg','','');
		}
	}
	elseif($type==2)//上传flash
	{
		if(!strstr($ecms_config['sets']['tranflashtype'],','.$filetype.','))
		{
			$tranfrom==0?printerror("NotTranFlash","history.go(-1)",8):ECMS_EditorPrintError(1,'','','NotTranFlash','','');
		}
	}
	elseif($type==3)//上传多媒体
	{}
	else//上传附件
	{}
	//远程保存
	if(empty($file_name))
	{
		$r=DoTranUrl($tranurl,$classid);
		if(empty($r[tran]))
		{
			$tranfrom==0?printerror("TranHttpFail","history.go(-1)",8):ECMS_EditorPrintError(1,'','','TranHttpFail','','');
		}
	}
	//本地上传
	else
	{
		$r=DoTranFile($file,$file_name,$file_type,$file_size,$classid);
		if(empty($r[tran]))
		{
			$tranfrom==0?printerror("TranFail","history.go(-1)",8):ECMS_EditorPrintError(1,'','','TranFail','','');
		}
	}
	if(!$no)
	{
		$no=$r[filename];
	}
	//写入数据库
	$r[filesize]=(int)$r[filesize];
	$classid=(int)$classid;
	$post[filepass]=(int)$post[filepass];
	$type=(int)$type;
	$sql=eInsertFileTable($r[filename],$r[filesize],$r[filepath],$username,$classid,$no,$type,$post[filepass],$post[filepass],$public_r[fpath],0,$modtype,$fstb);
	$fileid=$empire->lastid();
	//导入gd.php文件
	if($type==1&&($post['getsmall']||$post['getmark']))
	{
		@include(ECMS_PATH."e/class/gd.php");
	}
	//缩略图
	if($type==1&&$post['getsmall'])
	{
		GetMySmallImg($classid,$no,$r[insertfile],$r[filepath],$r[yname],$post[width],$post[height],$r[name],$post['filepass'],$post['filepass'],$userid,$username,$modtype,$fstb);
	}
	//水印
	if($type==1&&$post['getmark'])
	{
		GetMyMarkImg($r['yname']);
	}
	if($sql)
	{
		if($tranfrom==1)//编辑器上传
		{
			//$imgstr=EditorSetTranPic($r[url],$r[url],$post);
			ECMS_EditorPrintError(0,$r[url],$r[filename],'',$no,$r[filesize]);
			db_close();
			exit();
		}
		echo"<script>parent.location.reload();</script>";
		db_close();
		exit();
	}
	else
	{
		$tranfrom==0?printerror("InTranRecordFail","history.go(-1)",8):ECMS_EditorPrintError(1,'','','InTranRecordFail','','');
	}
}

//插入图片
function EditorSetTranPic($picurl,$smallpic,$add){
	$imgstr="<img src='$picurl'";
	if($add[pic_autosize])
	{
		$imgstr.=" onload='autosimg(this);' onmousewheel='return zoomimg(this);'";
	}
	if($add[pic_height])
	{
		$imgstr.=" height='$add[pic_height]'";
	}
	if($add[pic_width])
	{
		$imgstr.=" width='$add[pic_width]'";
	}
	$imgstr.=" border='$add[pic_border]'";
	if($add[pic_alt])
	{
		$imgstr.=" alt='$add[pic_alt]'";
	}
	if($add[pic_vspace])
	{
		$imgstr.=" vspace='$add[pic_vspace]'";
	}
	if($add[pic_hspace])
	{
		$imgstr.=" hspace='$add[pic_hspace]'";
	}
	if($add[pic_align])
	{
		$imgstr.=" align='$add[pic_align]'";
	}
	if(empty($add[pic_link]))
	{
		$add[pic_link]=$picurl;
	}
	$imgstr="<a href='$add[pic_link]' target='$add[pic_linktarget]'>".$imgstr."></a>";
	if($add[pic_say])
	{
		$imgstr.="<br><span style='line-height=18pt'>".ehtmlspecialchars($add[pic_say])."</span>";
	}
	if($add[pic_align]=='center')
	{
		$imgstr='<center>'.$imgstr.'</center>';
	}
	return $imgstr;
}
?>