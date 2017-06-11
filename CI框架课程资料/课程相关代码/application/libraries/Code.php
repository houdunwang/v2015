<?php

/**
 * 验证码类
 * @package     
 * @author      后盾马震宇 <houdunwangmzy@gmail.com>
 */

class Code{
    //资源
    private $img;
    //画布宽度
    public $width = 150;
    //画布高度
    public $height = 45;
    //背景颜色
    public $bgColor = "#ffffff";
    //验证码
    public $code;
    //验证码的随机种子
    public $codeStr = "123456789abcdefghijklmnpqrstuvwsyz";
    //验证码长度
    public $codeLen = 4;
    //验证码字体
    public $font = "";//具体环境具体需要更改路径
    //验证码字体大小
    public $fontSize = 22;
    //验证码字体颜色
    public $fontColor = "";

    /**
     * 构造函数
     */
    public function __construct($arr = array()) {

        $width = '';
        $height = '';
        $codeLen = '';
        $fontSize = '';
        $bgColor = '';
        $fontColor = '';

        if(!empty($arr)){
           extract($arr); 
        } 
        $this->font = BASEPATH . "fonts/font.ttf";       
        if (!is_file($this->font)) {
            error("验证码字体文件不存在");
        }
        $this->width = empty($width) ? $this->width : $width;
        $this->height = empty($height) ? $this->height : $height;
        $this->bgColor = empty($bgColor) ? $this->bgColor : $bgColor;
        $this->codeLen = empty($codeLen) ? $this->codeLen : $codeLen;
        $this->fontSize = empty($fontSize) ? $this->fontSize : $fontSize;
        $this->fontColor = empty($fontColor) ? $this->fontColor : $fontColor;
        $this->create();//生成验证码
    }

    /**
     * 生成验证码
     */
    private function createCode() {
        $code = '';
        for ($i = 0; $i < $this->codeLen; $i++) {
            $code .= $this->codeStr [mt_rand(0, strlen($this->codeStr) - 1)];
        }
        $this->code = strtoupper($code);
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION ['code'] = $this->code;
    }

    /**
     * 返回验证码
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * 建画布
     */
    public function create() {
        if (!$this->checkGD())
            return false;
        $w = $this->width;
        $h = $this->height;
        $bgColor = $this->bgColor;
        $img = imagecreatetruecolor($w, $h);
        $bgColor = imagecolorallocate($img, hexdec(substr($bgColor, 1, 2)), hexdec(substr($bgColor, 3, 2)), hexdec(substr($bgColor, 5, 2)));
        imagefill($img, 0, 0, $bgColor);
        $this->img = $img;
        $this->createLine();
        $this->createFont();
        $this->createPix();
        $this->createRec();
    }
    /**
    *  画线
    */
    private function createLine(){
        $w = $this->width;
        $h = $this->height;
        $line_height = $h/10;
        $line_color = "#D0D0D0";
        $color = imagecolorallocate($this->img, hexdec(substr($line_color, 1, 2)), hexdec(substr($line_color, 3, 2)), hexdec(substr($line_color, 5, 2)));
        for($i=0;$i<10;$i++){
            $step =$line_height*$i+2;
            imageline($this->img, 0, $step, $w,$step, $color);
        }
        $line_width = $w/10;
        for($i=0;$i<10;$i++){
            $step =$line_width*$i+2;
            imageline($this->img, $step-2, 0, $step+2,$h, $color);
        }
    }
    /**
     * 画矩形边框
     */
    private function createRec() {
        imagerectangle($this->img, 0, 0, $this->width - 1, $this->height - 1, $this->fontColor);
    }

    /**
     * 写入验证码文字
     */
    private function createFont() {
        $this->createCode();
        $color = $this->fontColor;
        if (!empty($color)) {
            $fontColor = imagecolorallocate($this->img, hexdec(substr($color, 1, 2)), hexdec(substr($color, 3, 2)), hexdec(substr($color, 5, 2)));
        }
        $x = ($this->width - 10) / $this->codeLen;
        for ($i = 0; $i < $this->codeLen; $i++) {
            if (empty($color)) {
                $fontColor = imagecolorallocate($this->img, mt_rand(50, 155), mt_rand(50, 155), mt_rand(50, 155));
            }
            imagettftext($this->img, $this->fontSize, mt_rand(- 30, 30), $x * $i + mt_rand(6, 10), mt_rand($this->height / 1.3, $this->height - 5), $fontColor, $this->font, $this->code [$i]);
        }
        $this->fontColor = $fontColor;
    }

    /**
     * 画线
     */
    private function createPix() {
        $pix_color = $this->fontColor;
        for ($i = 0; $i < 50; $i++) {
            imagesetpixel($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), $pix_color);
        }

        for ($i = 0; $i < 2; $i++) {
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $pix_color);
        }
        //画圆弧
        for ($i = 0; $i < 1; $i++) {
            // 设置画线宽度
           // imagesetthickness($this->img, mt_rand(1, 3));
            imagearc($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height)
                    , mt_rand(0, 160), mt_rand(0, 200), $pix_color);
        }
        imagesetthickness($this->img, 1);
    }

    /**
     * 显示验证码
     */
    public function show() {
        header("Content-type:image/png");
        imagepng($this->img);
        imagedestroy($this->img);
        exit;
    }

    /**
     * 验证GD库是不否打开imagepng函数是否可用
     */
    private function checkGD() {
        return extension_loaded('gd') && function_exists("imagepng");
    }

}