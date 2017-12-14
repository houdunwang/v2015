<?php
define('InEmpireCMSGd',TRUE);

//原文件,新文件,宽度,高度,维持比例
function ResizeImage($big_image_name, $new_name, $max_width = 400, $max_height = 400, $resize = 1){
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
		return $returnr;
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
    if($big_width <= $max_width and $big_height <= $max_height) 
	{ 
		$func_output($big_image, $new_name.$func_exname);
		$returnr['file']=$new_name.$func_exname;
		$returnr['filetype']=$func_exname;
		return $returnr; 
	}
    $ratiow      = $max_width  / $big_width;
    $ratioh      = $max_height / $big_height;
    if($resize == 1) {
        if($big_width >= $max_width and $big_height >= $max_height)
        {
            if($big_width > $big_height)
            {
            $tempx  = $max_width / $ratioh;
            $tempy  = $big_height;
            $srcX   = ($big_width - $tempx) / 2;
            $srcY   = 0;
            } else {
            $tempy  = $max_height / $ratiow;
            $tempx  = $big_width;
            $srcY   = ($big_height - $tempy) / 2;
            $srcX   = 0;
            }
        } else {
            if($big_width > $big_height)
            {
            $tempx  = $max_width;
            $tempy  = $big_height;
            $srcX   = ($big_width - $tempx) / 2;
            $srcY   = 0;
            } else {
            $tempy  = $max_height;
            $tempx  = $big_width;
            $srcY   = ($big_height - $tempy) / 2;
            $srcX   = 0;
            }
        }
    } else {
        $srcX      = 0;
        $srcY      = 0;
        $tempx     = $big_width;
        $tempy     = $big_height;
    }

    $new_width  = ($ratiow  > 1) ? $big_width  : $max_width;
    $new_height = ($ratioh  > 1) ? $big_height : $max_height;
    if(function_exists("imagecopyresampled"))
    {
        $temp_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($temp_image, $big_image, 0, 0, $srcX, $srcY, $new_width, $new_height, $tempx, $tempy);
    } else {
        $temp_image = imagecreate($new_width, $new_height);
        imagecopyresized($temp_image, $big_image, 0, 0, $srcX, $srcY, $new_width, $new_height, $tempx, $tempy);
    }
        $func_output($temp_image, $new_name.$func_exname);
        ImageDestroy($big_image);
        ImageDestroy($temp_image);
		$returnr['file']=$new_name.$func_exname;
		$returnr['filetype']=$func_exname;
    return $returnr;
}

/* 
* 功能：图片加水印 (水印支持图片或文字) 
* 参数： 
*      $groundImage    背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式； 
*      $waterPos        水印位置，有10种状态，0为随机位置； 
*                        1为顶端居左，2为顶端居中，3为顶端居右； 
*                        4为中部居左，5为中部居中，6为中部居右； 
*                        7为底端居左，8为底端居中，9为底端居右； 
*      $waterImage        图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式； 
*      $waterText        文字水印，即把文字作为为水印，支持ASCII码，不支持中文； 
*      $textFont        文字大小，值为1、2、3、4或5，默认为5； 
*      $textColor        文字颜色，值为十六进制颜色值，默认为#FF0000(红色)； 
* 
* 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG 
*      $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。 
*      当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。 
*      加水印后的图片的文件名和 $groundImage 一样。 
*/ 
function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000",$myfontpath="../data/mask/cour.ttf",$w_pct,$w_quality){
	global $fun_r,$editor;
	if($editor==1){$a='../';}
	elseif($editor==2){$a='../../';}
	elseif($editor==3){$a='../../../';}
	else{$a='';}
	$waterImage=$waterImage?$a.$waterImage:'';
	$myfontpath=$myfontpath?$a.$myfontpath:'';
    $isWaterImage = FALSE; 
    $formatMsg = $fun_r['synotdotype']; 

    //读取水印文件 
    if(!empty($waterImage) && file_exists($waterImage)) 
    { 
        $isWaterImage = TRUE; 
        $water_info = getimagesize($waterImage); 
        $water_w    = $water_info[0];//取得水印图片的宽 
        $water_h    = $water_info[1];//取得水印图片的高 

        switch($water_info[2])//取得水印图片的格式 
        { 
            case 1:$water_im = imagecreatefromgif($waterImage);break; 
            case 2:$water_im = imagecreatefromjpeg($waterImage);break; 
            case 3:$water_im = imagecreatefrompng($waterImage);break; 
            default:echo $formatMsg;return ""; 
        } 
    } 

    //读取背景图片 
    if(!empty($groundImage) && file_exists($groundImage)) 
    { 
        $ground_info = getimagesize($groundImage); 
        $ground_w    = $ground_info[0];//取得背景图片的宽 
        $ground_h    = $ground_info[1];//取得背景图片的高 

        switch($ground_info[2])//取得背景图片的格式 
        { 
            case 1:$ground_im = imagecreatefromgif($groundImage);break; 
            case 2:$ground_im = imagecreatefromjpeg($groundImage);break; 
            case 3:$ground_im = imagecreatefrompng($groundImage);break; 
            default:echo $formatMsg;return ""; 
        } 
    } 
    else 
    { 
        echo $fun_r['synotdoimg'];
		return "";
    } 

    //水印位置 
    if($isWaterImage)//图片水印 
    { 
        $w = $water_w; 
        $h = $water_h; 
        $label = "图片的"; 
    } 
    else//文字水印 
    { 
        $temp = imagettfbbox(ceil($textFont*2.5),0,$myfontpath,$waterText);//取得使用 TrueType 字体的文本的范围 
        $w = $temp[2] - $temp[6]; 
        $h = $temp[3] - $temp[7]; 
        unset($temp); 
        $label = "文字区域"; 
    } 
    if( ($ground_w<$w) || ($ground_h<$h) ) 
    { 
        echo $fun_r['sytoosmall']; 
        return ''; 
    } 
    switch($waterPos) 
    { 
        case 0://随机 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break; 
        case 1://1为顶端居左 
            $posX = 0; 
            $posY = 0; 
            break; 
        case 2://2为顶端居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = 0; 
            break; 
        case 3://3为顶端居右 
            $posX = $ground_w - $w; 
            $posY = 0; 
            break; 
        case 4://4为中部居左 
            $posX = 0; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 5://5为中部居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 6://6为中部居右 
            $posX = $ground_w - $w; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 7://7为底端居左 
            $posX = 0; 
            $posY = $ground_h - $h; 
            break; 
        case 8://8为底端居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = $ground_h - $h; 
            break; 
        case 9://9为底端居右 
            $posX = $ground_w - $w; 
            $posY = $ground_h - $h; 
            break; 
        default://随机 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break;     
    } 

    //设定图像的混色模式 
    imagealphablending($ground_im, true); 

    if($isWaterImage)//图片水印 
    {
		if($water_info[2]==3)
		{
			imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件
		}
		else
		{
			imagecopymerge($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h,$w_pct);//拷贝水印到目标文件
		}
    } 
    else//文字水印 
    { 
        if( !empty($textColor) && (strlen($textColor)==7) ) 
        { 
            $R = hexdec(substr($textColor,1,2)); 
            $G = hexdec(substr($textColor,3,2)); 
            $B = hexdec(substr($textColor,5)); 
        } 
        else 
        { 
            echo $fun_r['synotfontcolor'];
			return "";
        } 
        imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));         
    } 

    //生成水印后的图片 
    @unlink($groundImage); 
    switch($ground_info[2])//取得背景图片的格式 
    { 
        case 1:imagegif($ground_im,$groundImage);break; 
        case 2:imagejpeg($ground_im,$groundImage,$w_quality);break; 
        case 3:imagepng($ground_im,$groundImage);break; 
        default:echo $formatMsg;return ""; 
    } 

    //释放内存 
    if(isset($water_info)) unset($water_info); 
    if(isset($water_im)) imagedestroy($water_im); 
    unset($ground_info); 
    imagedestroy($ground_im); 
}
?>