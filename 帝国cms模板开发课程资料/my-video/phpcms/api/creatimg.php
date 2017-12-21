<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
$txt = trim($_GET['txt']);
if(extension_loaded('gd') && $txt ) {
	header ("Content-type: image/png");
	$txt = urldecode(sys_auth($txt, 'DECODE'));
	$fontsize = isset($_GET['fontsize']) ? intval($_GET['fontsize']) : 16;
	$fontpath = PC_PATH.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'font'.DIRECTORY_SEPARATOR;
	$fontfile = isset($_GET['font']) && !empty($_GET['font']) ? $fontpath.trim($_GET['font']) : $fontpath.'georgia.ttf';	
	$fontcolor = isset($_GET['fontcolor']) && !empty($_GET['fontcolor']) ? trim($_GET['fontcolor']) : 'FF0000';
	$fontcolor_r = hexdec(substr($fontcolor,0,2));
	$fontcolor_g = hexdec(substr($fontcolor,2,2));
	$fontcolor_b = hexdec(substr($fontcolor,4,2));
	if(file_exists($fontfile)){
	
		//计算文本写入后的宽度，右下角 X 位置-左下角 X 位置
		$image_info = imagettfbbox($fontsize,0,$fontfile,$txt);
		$imageX = $image_info[2]-$image_info[0]+10;
		$imageY = $image_info[1]-$image_info[7]+5;
		//print_r($image_info);
		$im = @imagecreatetruecolor ($imageX, $imageY) or die ("Cannot Initialize new GD image stream");
		$white= imagecolorallocate($im, 255, 255, 255);
		$font_color= imagecolorallocate($im,$fontcolor_r,$fontcolor_g,$fontcolor_b);
		if(intval($_GET['transparent']) == 1) imagecolortransparent($im,$white); //背景透明
		imagefilledrectangle($im, 0, 0, $imageX, $imageY, $white);
		$txt = iconv(CHARSET,"UTF-8",$txt);
		imagettftext($im, $fontsize, 0, 5, $imageY-5, $font_color, $fontfile, $txt);
		
	} else {
	
		$imageX = strlen($txt)*9;
		$im = @imagecreate ($imageX, 16) or die ("Cannot Initialize new GD image stream");
		$bgColor = ImageColorAllocate($im,255,255,255);
		$white=imagecolorallocate($im,234,185,95);
		$font_color=imagecolorallocate($im,$fontcolor_r,$fontcolor_g,$fontcolor_b);		
		$fonttype = intval($_GET['fonttype']);
		imagestring ($im, $fonttype, 0, 0,$txt, $font_color);
	}
	imagepng ($im);
	imagedestroy ($im);	
}
?>