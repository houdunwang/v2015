<?php
/**
 * 生成验证码
 * @author chenzhouyu
 * 类用法
 * $checkcode = new checkcode();
 * $checkcode->doimage();
 * //取得验证
 * $_SESSION['code']=$checkcode->get_code();
 */
class checkcode {
	//验证码的宽度
	public $width=130;
	
	//验证码的高
	public $height=50;
	
	//设置字体的地址
	public $font;
	
	//设置字体色
	public $font_color;
	
	//设置随机生成因子
	public $charset = 'abcdefghkmnprstuvwyzABCDEFGHKLMNPRSTUVWYZ23456789';
	
	//设置背景色
	public $background = '#EDF7FF';
	
	//生成验证码字符数
	public $code_len = 4;
	
	//字体大小
	public $font_size = 20;
	
	//验证码
	private $code;
	
	//图片内存
	private $img;
	
	//文字X轴开始的地方
	private $x_start;
		
	function __construct() {
		$this->font = PC_PATH.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'font'.DIRECTORY_SEPARATOR.'elephant.ttf';
	}
	
	/**
	 * 生成随机验证码。
	 */
	protected function creat_code() {
		$code = '';
		$charset_len = strlen($this->charset)-1;
		for ($i=0; $i<$this->code_len; $i++) {
			$code .= $this->charset[rand(1, $charset_len)];
		}
		$this->code = $code;
	}
	
	/**
	 * 获取验证码
	 */
	public function get_code() {
		return strtolower($this->code);
	}
	
	/**
	 * 生成图片
	 */
	public function doimage() {
		$this->creat_code();
		$this->img = imagecreatetruecolor($this->width, $this->height);
		if (!$this->font_color) {
			$this->font_color = imagecolorallocate($this->img, rand(0,156), rand(0,156), rand(0,156));
		} else {
			$this->font_color = imagecolorallocate($this->img, hexdec(substr($this->font_color, 1,2)), hexdec(substr($this->font_color, 3,2)), hexdec(substr($this->font_color, 5,2)));
		}
		//设置背景色
		$background = imagecolorallocate($this->img,hexdec(substr($this->background, 1,2)),hexdec(substr($this->background, 3,2)),hexdec(substr($this->background, 5,2)));
		//画一个柜形，设置背景颜色。
		imagefilledrectangle($this->img,0, $this->height, $this->width, 0, $background);
		$this->creat_font();
		$this->creat_line();
		$this->output();
	}
	
	/**
	 * 生成文字
	 */
	private function creat_font() {
		$x = $this->width/$this->code_len;
		for ($i=0; $i<$this->code_len; $i++) {
			imagettftext($this->img, $this->font_size, rand(-30,30), $x*$i+rand(0,5), $this->height/1.4, $this->font_color, $this->font, $this->code[$i]);
			if($i==0)$this->x_start=$x*$i+5;
		}
	}
	
	/**
	 * 画线
	 */
	private function creat_line() {
		imagesetthickness($this->img, 3);
	    $xpos   = ($this->font_size * 2) + rand(-5, 5);
	    $width  = $this->width / 2.66 + rand(3, 10);
	    $height = $this->font_size * 2.14;
	
	    if ( rand(0,100) % 2 == 0 ) {
	      $start = rand(0,66);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(180, 246);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 110);
	
	    imagearc($this->img, $xpos, $ypos, $width, $height, $start, $end, $this->font_color);
	
	    $color = $colors[rand(0, sizeof($colors) - 1)];
	
	    if ( rand(1,75) % 2 == 0 ) {
	      $start = rand(45, 111);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(200, 250);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 100);
	
	    imagearc($this->img, $this->width * .75, $ypos, $width, $height, $start, $end, $this->font_color);
	}
	
	//输出图片
	private function output() {
		header("content-type:image/png\r\n");
		imagepng($this->img);
		imagedestroy($this->img);
	}
}