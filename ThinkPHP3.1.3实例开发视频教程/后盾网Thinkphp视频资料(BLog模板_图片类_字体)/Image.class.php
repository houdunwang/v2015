<?php
/**
 * 图像处理类
 *
 * @author Carmen <e.carmen.hyc@gmail.com>
 * 
 *
 * 生成验证码：Image::verify(长度， 宽， 高)
 *
 * 加盖图片水印：Image::water(图片路径, 水印图路径, 保存路径)
 *
 * 加盖文字水印：Image::text(图片路径, 文字内容, 保存路径)
 *
 * 生成缩略图：Image::thumb(图片路径, 宽, 高, 保存路径)
 *
 * ps:保存路径参数均为留空则替换原图
 * 
 * 为了减少参数，部份配置项采用常量定义
 * 嵌入框架时，找到每个方法的初始处把常量替换成配置文件项
 * 如 ThinkPHP 可采用 C() 函数代替常量定义
 */


/**********验证码配置项**********/
//验证码长度
define('VERIFY_LENGTH', 4);
//验证码图片宽度(像素)
define('VERIFY_WIDTH', 250);
//验证码图片高度(像素)
define('VERIFY_HEIGHT', 60);
//验证码背影颜色(16进制色值)
define('VERIFY_BGCOLOR', '#F3FBFE');
//验证码种子
define('VERIFY_SEED', '3456789aAbBcCdDeEfFgGhHjJkKmMnNpPqQrRsStTuUvVwWxXyY');
//验证码字体文件
define('VERIFY_FONTFILE', 'font.ttf');
//验证码字体大小
define('VERIFY_SIZE', 30);
//验证码字体颜色(16进制色值)
define('VERIFY_COLOR', '#444444');
//SESSION识别名称
define('VERIFY_NAME', 'verify');
//存储验证码到SESSION时使用函数
define('VERIFY_FUNC', 'strtolower');


/**********水印配置项**********/
//水印图路径
define('WATER_IMAGE', './water.png');
//水印位置
define('WATER_POS', 9);
//水印透明度
define('WATER_ALPHA', 60);
//JPEG图片压缩比
define('WATER_COMPRESSION', 80);
//水印文字
define('WATER_TEXT', 'HouDunWang.com');
//水印文字旋转角色
define('WATER_ANGLE', 0);
//水印文字大小
define('WATER_FONTSIZE', 30);
//水印文字颜色
define('WATER_FONTCOLOR', '#670768');
//水印文字字体文件(写入中文字时需使用支持中文的字体文件)
define('WATER_FONTFILE', './font.ttf');
//水印文字字符编码
define('WATER_CHARSET', 'UTF-8');


/**********缩略图配置项**********/
//缩略图宽度
define('THUMB_WIDTH', 200);
//缩略图高度
define('THUMB_HEIGHT', 120);

Class Image {

	/**
	 * 生成验证码
	 * @param  [Integer] $length [验证码长度]
	 * @param  [Integer] $width  [验证码宽度]
	 * @param  [Integer] $height [验证码高度]
	 * @return [boolean]
	 */
	Static Public function verify ($length = NULL, $width = NULL, $height = NULL) {

		//环境检测
		if (!self::checkCondition()) return false;

		//初始化参数(放进框架时把常量换成 读取配置文件项 )
		$length = empty($length) ? VERIFY_LENGTH : $length;
		$width = empty($width) ? VERIFY_WIDTH : $width;
		$height= empty($height) ? VERIFY_HEIGHT : $height;
		$bgColor = VERIFY_BGCOLOR;
		$seed = VERIFY_SEED;
		$fontFile = VERIFY_FONTFILE;
		$size = VERIFY_SIZE;
		$fontColor = VERIFY_COLOR;
		$name = VERIFY_NAME;
		$fn = VERIFY_FUNC;

		//创建画布图像
		$verify = imagecreatetruecolor($width, $height);

		//画布背景色
		$rgb = self::colorTrans($bgColor);
		$color = imagecolorallocate($verify, $rgb['red'], $rgb['green'], $rgb['blue']);
		imagefill($verify, 0, 0, $color);

		//写入背景干扰字体
		$len = strlen($seed) - 1;
		for ($i = 0; $i < 20; $i++) {
			$color = imagecolorallocate($verify, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagestring($verify, 5, mt_rand(0, $width), mt_rand(0, $height), $seed[mt_rand(0, $len)], $color);
		}

		$rgb = self::colorTrans($fontColor);
		$fontColor = imagecolorallocate($verify, $rgb['red'], $rgb['green'], $rgb['blue']);


		//写入验证码
		$code = '';
		$left = ($width - $size * $length) / 2;
		$y = $height - ($height - $size) / 2;
		for ($i = 0; $i < $length; $i++) {
			$font = $seed[mt_rand(0, $len)];
			$x = $size * $i + $left;
			imagettftext($verify, $size, mt_rand(-30, 30), $x, $y, $fontColor, $fontFile, $font);
			$code .= $font;
		}
		$_SESSION[$name] = $fn($code);

		//干扰线
		for ($i = 0, $h = $height / 2 - 2; $i < 5; $i++, $h++) {
			$color = imagecolorallocate($verify, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			$cx = mt_rand(-10, $width + 10);
			$cy = mt_rand(-10, $height + 10);
			$cw = mt_rand(-10, $width + 10);
			$ch = mt_rand(-10, $height + 10);
			imageellipse($verify, $cx, $cy, $cw, $ch, $color);
			imageellipse($verify, $cx + 1, $cy + 1, $cw + 1, $ch + 1, $color);

			imageline($verify, 0, $h, $width, $h, $fontColor);
		}

		//输入图像
		header('Content-type:image/png');
		imagepng($verify);
		imagedestroy($verify);
		return true;
	}

	/**
	 * 加盖图片水印
	 * @param  [String] $img   [图片路径]
	 * @param  [String] $water [水印图路径]
	 * @param  [String] $save  [保存路径|留空则替换原图]
	 * @return [Boolean]
	 */
	Static Public function water ($img, $water = '', $save = NULL) {
		if (!self::checkCondition($img)) return false;
		
		//初始化参数(放进框架时把常量换成 读取配置文件项 )
		$water = empty($water) ? WATER_IMAGE : $water;
		$pos = WATER_POS;
		$alpha = WATER_ALPHA;
		$compression = WATER_COMPRESSION;

		if (!file_exists($water)) return false;

		//原图宽、高与类型
		$imgInfo = getimagesize($img);
		$imgW = $imgInfo[0];
		$imgH = $imgInfo[1];
		$imgT = self::getImageType($imgInfo[2]);

		//水印图宽、高与类型
		$waterInfo = getimagesize($water);
		$waterW = $waterInfo[0];
		$waterH = $waterInfo[1];
		$waterT = self::getImageType($waterInfo[2]);

		//水印图大于原图时不作处理
		if ($imgW < $waterW || $imgH < $waterH) return false;

		//计算水印位置
		$pos = self::getPosition($imgW, $imgH, $waterW, $waterH, $pos);
		$x = $pos['x'];
		$y = $pos['y'];

		//打开原图资源
		$fn = 'imagecreatefrom' . $imgT;
		$image = $fn($img);

		//打开水印图资源
		$fn = 'imagecreatefrom' . $waterT;
		$water = $fn($water);

		//盖上水印图
		if ($waterT == 'png') {
			imagecopy($image, $water, $x, $y, 0, 0, $waterW, $waterH);
		} else {
			imagecopymerge($image, $water, $x, $y, 0, 0, $waterW, $waterH, $alpha);
		}

		//保存路径
		$save = self::savePath($save, $img);
		$fn = 'image' . $imgT;
		if ($imgT == 'jpeg') {
			$fn($image, $save, $compression);
		} else {
			$fn($image, $save);
		}

		//释放资源
		imagedestroy($image);
		imagedestroy($water);
		return true;
	}

	/**
	 * 加盖文字水印
	 * @param  [String] $img  [图片路径]
	 * @param  [String] $text [文字内容]
	 * @param  [String] $save [保存路径|留空则替换原图]
	 * @return [Boolean]
	 */
	Static Public function text ($img, $text = '', $save = NULL) {
		if (!self::checkCondition($img)) return false;

		//初始化参数(放进框架时把常量换成 读取配置文件项 )
		$text = empty($text) ? WATER_TEXT : $text;
		$pos = WATER_POS;
		$angle = WATER_ANGLE;
		$fontSize = WATER_FONTSIZE;
		$fontColor = WATER_FONTCOLOR;
		$fontFile = WATER_FONTFILE;
		$charset = WATER_CHARSET;
		$compression = WATER_COMPRESSION;

		//文字水印宽、高
		$waterInfo = imagettfbbox($fontSize, $angle, $fontFile, $text);
		$waterW = $waterInfo[2] - $waterInfo[0];
		$waterH = $waterInfo[1] - $waterInfo[7];

		//原图宽、高、类型
		$imgInfo = getimagesize($img);
		$imgW = $imgInfo[0];
		$imgH = $imgInfo[1];
		$type = self::getImageType($imgInfo[2]);

		//计算水印位置
		$pos = self::getPosition($imgW, $imgH, $waterW, $waterH, $pos);
		$x = $pos['x'];
		$y = $pos['y'] + $fontSize / 2;

		//打开原图资源
		$fn = 'imagecreatefrom' . $type;
		$image = $fn($img);

		//写入水印文字
		$rgb = self::colorTrans($fontColor);
		$color = imagecolorallocate($image, $rgb['red'], $rgb['green'], $rgb['blue']);
		$text = iconv($charset, 'UTF-8', $text);
		imagettftext($image, $fontSize, $angle, $x, $y, $color, $fontFile, $text);

		//保存路径
		$save = self::savePath($save, $img);
		$fn = 'image' . $type;
		if ($type == 'jpeg') {
			$fn($image, $save, $compression);
		} else {
			$fn($image, $save);
		}

		//释放资源
		imagedestroy($image);
		return true;

	}

	/**
	 * 生成缩略图(等比例缩放)
	 * @param  [String] $img    [图片路径]
	 * @param  [String] $width  [缩略宽度]
	 * @param  [String] $height [缩略高度]
	 * @param  [String] $save   [保存路径|留空则替换原图]
	 * @return [Boolean]
	 */
	Static Public function thumb ($img, $width = '', $height = '', $save = NULL) {
		if (!self::checkCondition($img)) return false;

		//初始化参数(放进框架时把常量换成 读取配置文件项 )
		$width = empty($width) ? THUMB_WIDTH : $width;
		$height = empty($height) ? THUMB_HEIGHT : $height;

		//原图宽、高、类型
		$imgInfo = getimagesize($img);
		$imgW = $imgInfo[0];
		$imgH = $imgInfo[1];
		$type = self::getImageType($imgInfo[2]);

		//缩放比
		$ratio = max($width / $imgW, $height / $imgH);
		//缩略图大于原图不作处理
		if ($ratio >= 1) return false;

		//等比例缩放后宽、高
		$width = floor($imgW * $ratio);
		$height = floor($imgH * $ratio);

		//创建缩略图画布
		if ($type == 'gif') {
			$thumb = imagecreate($width, $height);
			$color = imagecolorallocate($thumb, 0, 255, 0);
		} else {
			$thumb = imagecreatetruecolor($width, $height);
			//PNG图片透明处理
			if ($type == 'png') {
				//关闭混色模式
				imagealphablending($thumb, false);
				//保存透明通道
				imagesavealpha($thumb, true);
			}
		}

		//打开原图资源
		$fn = 'imagecreatefrom' . $type;
		$image = $fn($img);

		//原图移至缩略图画布并调整大小
		if (function_exists('imagecopyresampled')) {
			imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $height, $imgW, $imgH);
		} else {
			imagecopyresized($thumb, $image, 0, 0, 0, 0, $width, $height, $imgW, $imgH);
		}

		//GIF图透明处理
		if ($type == 'gif') imagecolortransparent($thumb, $color);

		//保存路径
		$save = self::savePath($save, $img);
		$fn = 'image' . $type;
		$fn($thumb, $save);

		//释放资源
		imagedestroy($image);
		imagedestroy($thumb);
		return true;

	}

	/**
	 * 图片保存路径
	 * @param  [String] $save [保存路径]
	 * @param  [String] $img  [原图路径]
	 * @return [String]
	 */
	Static Private function savePath ($save, $img) {
		if (!$save) return $img;

		$pathInfo = pathinfo($img);
		$path = rtrim($save, '/') . '/';
		is_dir($path) || mkdir($path, 0777, true);
		return $path . time() . mt_rand(1000, 9999) . '.' . $pathInfo['extension'];
	}

	/**
	 * 计算水印图位置
	 * @param  [Integer] $IW  [原图宽]
	 * @param  [Integer] $IH  [原图高]
	 * @param  [Integer] $WW  [水印宽]
	 * @param  [Integer] $WH  [水印高]
	 * @param  [Integer] $pos [九宫格位置]
	 * @return [Array]      [x, y]
	 */
	Static Private function getPosition ($IW, $IH, $WW, $WH, $pos) {
		$x = 20;
		$y = 20;
		switch ($pos) {
			case 1 : 
				break;

			case 2 :
				$x = ($IW - $WW) / 2;
				break;

			case 3 :
				$x = $IW - $WW - 20;
				break;

			case 4 :
				$y = ($IH - $WH) / 2;
				break;

			case 5 :
				$x = ($IW - $WW) / 2;
				$y = ($IH - $WH) / 2;
				break;

			case 6 :
				$x = $IW - $WW - 20;
				$y = ($IH - $WH) / 2;
				break;

			case 7 :
				$y = $IH - $WH - 20;
				break;

			case 8 :
				$x = ($IW - $WW) / 2;
				$y = $IH - $WH - 20;
				break;

			case 9 :
				$x = $IW - $WW - 20;
				$y = $IH - $WH - 20;
				break;

			default :
				$x = mt_rand(0, $IW - $WW);
				$y = mt_rand(0, $IH - $WH);
		}

		return array('x' => $x, 'y' => $y);
	}

	/**
	 * 图片类型
	 * @param  [Integer] $typeNum [类型识别号]
	 * @return [String]
	 */
	Static Private function getImageType ($typeNum) {
		switch($typeNum) {
			case 1 : 
				return 'gif';
			case 2 :
				return 'jpeg';
			case 3 :
				return 'png';
		}
	}

	/**
	 * 16进制色值转换为RGB
	 * @param  [Sting] $color [16进制色值]
	 * @return [Array]        [red, green, blue]
	 */
	Static Private function colorTrans($color) {
		$color = ltrim($color, '#');
		return array(
			'red' => hexdec($color[0] . $color[1]),
			'green' => hexdec($color[2] . $color[3]),
			'blue' => hexdec($color[4] . $color[5])
			);
	}

	/**
	 * 图像处理环境检测
	 * @return boolean
	 */
	Static Private function checkCondition ($file = NULL) {
		return is_null($file) ? extension_loaded('GD') && function_exists('imagecreatetruecolor') && function_exists('imagepng') : extension_loaded('GD') && file_exists($file);
	}
}
?>