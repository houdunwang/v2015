<?php
//裁剪图片
function DoCropImage($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$class_r,$ecms_config,$efileftp_fr,$efileftp_dr;
	//参数处理
	$pic_x=(int)$add['pic_x'];
	$pic_y=(int)$add['pic_y'];
	$pic_w=(int)$add['pic_w'];
	$pic_h=(int)$add['pic_h'];
	$doing=(int)$add['doing'];
	$fileid=(int)$add['fileid'];
	$filepass=(int)$add['filepass'];
	$classid=(int)$add['classid'];
	$infoid=(int)$add['infoid'];
	$modtype=(int)$add['modtype'];
	$fstb=0;
	if(empty($modtype))
	{
		$fstb=GetInfoTranFstb($classid,$infoid,0);
	}
	//取得文件地址
	if(empty($fileid))
	{
		printerror('NotCropImage','history.go(-1)');
	}
	$filer=$empire->fetch1("select fileid,path,filename,classid,fpath,no from ".eReturnFileTable($modtype,$fstb)." where fileid='$fileid'");
	if(empty($filer['fileid']))
	{
		printerror('NotCropImage','history.go(-1)');
	}
	$path=$filer['path']?$filer['path'].'/':$filer['path'];
	$fspath=ReturnFileSavePath($filer['classid'],$filer['fpath']);
	$big_image_name=eReturnEcmsMainPortPath().$fspath['filepath'].$path.$filer['filename'];//moreport
	if(!file_exists($big_image_name))
	{
		printerror('NotCropImage','history.go(-1)');
	}
	$filetype=GetFiletype($filer['filename']);//取得文件类型
	if(!strstr($ecms_config['sets']['tranpicturetype'],','.$filetype.','))
	{
		printerror('CropImageFiletypeFail','history.go(-1)');
	}
	//目标图片
	$new_datepath=FormatFilePath($filer['classid'],'',0);
	$new_path=$new_datepath?$new_datepath.'/':$new_datepath;
	$new_insertfile=ReturnDoTranFilename($filer['filename'],0);
	$new_fspath=ReturnFileSavePath($filer['classid']);
	$new_savepath=eReturnEcmsMainPortPath().$new_fspath['filepath'].$new_path;//moreport
	$new_name=$new_savepath.$new_insertfile;
	//处理图片
	$returnr['file']='';
	$returnr['filetype']='';
    if($temp_img_type = @getimagesize($big_image_name)) {preg_match('/\/([a-z]+)$/i', $temp_img_type[mime], $tpn); $img_type = $tpn[1];}
    else {preg_match('/\.([a-z]+)$/i', $big_image_name, $tpn); $img_type = $tpn[1];}
    $all_type = array(
        "jpg"   => array("create"=>"ImageCreateFromjpeg", "output"=>"imagejpeg"  , "exn"=>".jpg"),
        "gif"   => array("create"=>"ImageCreateFromGIF" , "output"=>"imagegif"   , "exn"=>".gif"),
        "jpeg"  => array("create"=>"ImageCreateFromjpeg", "output"=>"imagejpeg"  , "exn"=>".jpg"),
        "png"   => array("create"=>"imagecreatefrompng" , "output"=>"imagepng"   , "exn"=>".png"),
        "wbmp"  => array("create"=>"imagecreatefromwbmp", "output"=>"image2wbmp" , "exn"=>".wbmp")
    );

    $func_create = $all_type[$img_type]['create'];
    if(empty($func_create) or !function_exists($func_create)) 
	{
		printerror('CropImageFiletypeFail','history.go(-1)');
	}
	//输出
    $func_output = $all_type[$img_type]['output'];
    $func_exname = $all_type[$img_type]['exn'];
	if(($func_exname=='.gif'||$func_exname=='.png'||$func_exname=='.wbmp')&&!function_exists($func_output))
	{
		$func_output='imagejpeg';
		$func_exname='.jpg';
	}
    $big_image   = $func_create($big_image_name);
    $big_width   = imagesx($big_image);
    $big_height  = imagesy($big_image);
    if(!$big_width||!$big_height||$big_width<10||$big_height<10) 
	{ 
		printerror('CropImageFilesizeFail','history.go(-1)');
	}
    if(function_exists("imagecopyresampled"))
    {
        $temp_image=imagecreatetruecolor($pic_w,$pic_h);
        imagecopyresampled($temp_image, $big_image, 0, 0, $pic_x, $pic_y, $pic_w, $pic_h, $pic_w, $pic_h);
    }
	else
	{
        $temp_image=imagecreate($pic_w,$pic_h);
        imagecopyresized($temp_image, $big_image, 0, 0, $pic_x, $pic_y, $pic_w, $pic_h, $pic_w, $pic_h);
    }
    $func_output($temp_image, $new_name.$func_exname);
    ImageDestroy($big_image);
    ImageDestroy($temp_image);
	$insert_file=$new_name.$func_exname;
	$insert_filename=$new_insertfile.$func_exname;
	if(file_exists($insert_file))
	{
		if(!$doing)
		{
			$empire->query("delete from ".eReturnFileTable($modtype,$fstb)." where fileid='$fileid'");
			DelFiletext($big_image_name);
			//FileServer
			if($public_r['openfileserver'])
			{
				$efileftp_dr[]=$big_image_name;
			}
		}
		//写入数据库
		$no='[CropImg]'.$filer['no'];
		$filesize=filesize($insert_file);
		$filesize=(int)$filesize;
		$classid=(int)$classid;
		$type=1;
		eInsertFileTable($insert_filename,$filesize,$new_datepath,$username,$classid,$no,$type,$filepass,$filepass,$public_r[fpath],0,$modtype,$fstb);
		//FileServer
		if($public_r['openfileserver'])
		{
			$efileftp_fr[]=$insert_file;
		}
	}
	echo"<script>opener.ReloadChangeFilePage();window.close();</script>";
	db_close();
	exit();
}
?>