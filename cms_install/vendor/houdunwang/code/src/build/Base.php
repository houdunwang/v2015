<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\code\build;

use houdunwang\config\Config;
use houdunwang\request\Request;
use houdunwang\session\Session;

/**
 * 验证码
 * Class Base
 *
 * @package houdunwang\code\build
 */
class Base
{
    //资源
    private $img;
    //验证码
    private $code;
    //画布宽度
    private $width = 100;
    //画布高度
    private $height = 30;
    //背景颜色
    private $bgColor = '#ffffff';
    //验证码的随机种子
    private $codeStr = '23456789abcdefghjkmnpqrstuvwsyz';
    //验证码长度
    private $num = 4;
    //验证码字体
    private $font = '';
    //验证码字体大小
    private $fontSize = 16;
    //验证码字体颜色
    private $fontColor = '';

    public function __construct()
    {
        foreach ((array)Config::get('code') as $k => $v) {
            $this->$k = $v;
        }
        $this->font = __DIR__.'/font.ttf';
    }

    //设置属性值
    public function __call($name, $arguments)
    {
        $this->$name = current($arguments);

        return $this;
    }

    //创建验证码
    public function make()
    {
        $this->create();//生成验证码
        if (PHP_SAPI != 'cli') {
            header("Content-type:image/png");
            imagepng($this->img);
            imagedestroy($this->img);
            exit;
        }

        return true;
    }

    /**
     * 验证验证码
     *
     * @param string $field 表单字段
     *
     * @return bool
     */
    public function auth($field = 'code')
    {
        return strtoupper(Request::post($field)) == $this->get();
    }

    //返回验证码
    public function get()
    {
        return Session::get('code');
    }

    //生成验证码
    private function createCode()
    {
        $code = '';
        for ($i = 0; $i < $this->num; $i++) {
            $code .= $this->codeStr [mt_rand(0, strlen($this->codeStr) - 1)];
        }
        $this->code = strtoupper($code);

        return Session::set('code', $this->code);
    }

    //建画布
    private function create()
    {
        if ( ! $this->checkGD()) {
            return false;
        }
        $w       = $this->width;
        $h       = $this->height;
        $bgColor = $this->bgColor;
        $img     = imagecreatetruecolor($w, $h);
        $bgColor = imagecolorallocate(
            $img,
            hexdec(substr($bgColor, 1, 2)),
            hexdec(substr($bgColor, 3, 2)),
            hexdec(substr($bgColor, 5, 2))
        );
        imagefill($img, 0, 0, $bgColor);
        $this->img = $img;
        $this->createLine();
        $this->createFont();
        $this->createPix();
        $this->createRec();
    }

    //画线
    private function createLine()
    {
        $w          = $this->width;
        $h          = $this->height;
        $line_color = "#dcdcdc";
        $color      = imagecolorallocate(
            $this->img,
            hexdec(substr($line_color, 1, 2)),
            hexdec(substr($line_color, 3, 2)),
            hexdec(substr($line_color, 5, 2))
        );
        $l          = $h / 5;
        for ($i = 1; $i < $l; $i++) {
            $step = $i * 5;
            imageline($this->img, 0, $step, $w, $step, $color);
        }
        $l = $w / 10;
        for ($i = 1; $i < $l; $i++) {
            $step = $i * 10;
            imageline($this->img, $step, 0, $step, $h, $color);
        }
    }

    //画矩形边框
    private function createRec()
    {
        //imagerectangle($this->img, 0, 0, $this->width - 1,$this->height - 1, $this->fontColor);
    }

    //写入验证码文字
    private function createFont()
    {
        $this->createCode();
        $color = $this->fontColor;
        if ( ! empty($color)) {
            $fontColor = imagecolorallocate(
                $this->img,
                hexdec(substr($color, 1, 2)),
                hexdec(substr($color, 3, 2)),
                hexdec(substr($color, 5, 2))
            );
        }
        $x = ($this->width - 10) / $this->num;
        for ($i = 0; $i < $this->num; $i++) {
            if (empty($color)) {
                $fontColor = imagecolorallocate(
                    $this->img,
                    mt_rand(50, 155),
                    mt_rand(50, 155),
                    mt_rand(50, 155)
                );
            }
            imagettftext(
                $this->img,
                $this->fontSize,
                mt_rand(-30, 30),
                $x * $i + mt_rand(6, 10),
                mt_rand($this->height / 1.3, $this->height - 5),
                $fontColor,
                $this->font,
                $this->code [$i]
            );
        }
        $this->fontColor = $fontColor;
    }

    //画线
    private function createPix()
    {
        $pix_color = $this->fontColor;
        for ($i = 0; $i < 50; $i++) {
            imagesetpixel(
                $this->img,
                mt_rand(0, $this->width),
                mt_rand(0, $this->height),
                $pix_color
            );
        }
        for ($i = 0; $i < 2; $i++) {
            imageline(
                $this->img,
                mt_rand(0, $this->width),
                mt_rand(0, $this->height),
                mt_rand(0, $this->width),
                mt_rand(0, $this->height),
                $pix_color
            );
        }
        //画圆弧
        for ($i = 0; $i < 1; $i++) {
            // 设置画线宽度
            imagearc(
                $this->img,
                mt_rand(0, $this->width),
                mt_rand(0, $this->height),
                mt_rand(0, $this->width),
                mt_rand(0, $this->height),
                mt_rand(0, 160),
                mt_rand(0, 200),
                $pix_color
            );
        }
        imagesetthickness($this->img, 1);
    }

    //验证GD库
    private function checkGD()
    {
        return extension_loaded('gd') && function_exists("imagepng");
    }

}