<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\image\build;

use houdunwang\config\Config;

class Base
{
    //水印字体
    protected $font = '';
    //水印图像
    protected $image = '';
    //位置  1~9九个位置  0为随机
    protected $pos = 9;
    //透明度
    protected $pct = 60;
    //压缩比
    protected $quality = 80;
    //水印文字
    protected $text = 'houdunwang.com';
    //文字颜色
    protected $text_color = '#f00f00';
    //文字大小
    protected $text_size = 12;

    public function __construct()
    {
        foreach ((array)Config::get('image') as $k => $v) {
            $this->$k = $v;
        }
        $this->font = __DIR__.'/font.ttf';
    }

    public function __call($name, $arguments)
    {
        $this->$name = current($arguments);
    }

    /**
     * 图片检测
     *
     * @param string $img
     *
     * @return bool
     */
    private function check($img)
    {
        $type    = [".jpg", ".jpeg", ".png", ".gif"];
        $imgType = strtolower(strrchr($img, '.'));

        return extension_loaded('gd') && file_exists($img)
            && in_array(
                $imgType,
                $type
            );
    }

    /**
     * 获得缩略图的尺寸信息
     *
     * @param $imgWidth    原图宽度
     * @param $imgHeight   原图高度
     * @param $thumbWidth  缩略图宽度
     * @param $thumbHeight 缩略图的高度
     * @param $thumbType   处理方式
     *                     1 固定宽度  高度自增 2固定高度  宽度自增 3固定宽度  高度裁切
     *                     4 固定高度 宽度裁切 5缩放最大边 原图不裁切
     *
     * @return mixed
     */
    private function thumbSize(
        $imgWidth,
        $imgHeight,
        $thumbWidth,
        $thumbHeight,
        $thumbType
    ) {
        //初始化缩略图尺寸
        $w = $thumbWidth;
        $h = $thumbHeight;
        //初始化原图尺寸
        $cuthumbWidth  = $imgWidth;
        $cuthumbHeight = $imgHeight;
        switch ($thumbType) {
            case 1 :
                //固定宽度  高度自增
                $h = $thumbWidth / $imgWidth * $imgHeight;
                break;
            case 2 :
                //固定高度  宽度自增
                $w = $thumbHeight / $imgHeight * $imgWidth;
                break;
            case 3 :
                //固定宽度  高度裁切
                $cuthumbHeight = $imgWidth / $thumbWidth * $thumbHeight;
                break;
            case 4 :
                //固定高度  宽度裁切
                $cuthumbWidth = $imgHeight / $thumbHeight * $thumbWidth;
                break;
            case 5 :
                //缩放最大边 原图不裁切
                if (($imgWidth / $thumbWidth) > ($imgHeight / $thumbHeight)) {
                    $h = $thumbWidth / $imgWidth * $imgHeight;
                } elseif (($imgWidth / $thumbWidth) < ($imgHeight
                        / $thumbHeight)
                ) {
                    $w = $thumbHeight / $imgHeight * $imgWidth;
                } else {
                    $w = $thumbWidth;
                    $h = $thumbHeight;
                }
                break;
            default:
                //缩略图尺寸不变，自动裁切图片
                if (($imgHeight / $thumbHeight) < ($imgWidth / $thumbWidth)) {
                    $cuthumbWidth = $imgHeight / $thumbHeight * $thumbWidth;
                } elseif (($imgHeight / $thumbHeight) > ($imgWidth
                        / $thumbWidth)
                ) {
                    $cuthumbHeight = $imgWidth / $thumbWidth * $thumbHeight;
                }
        }
        $arr [0] = $w;
        $arr [1] = $h;
        $arr [2] = $cuthumbWidth;
        $arr [3] = $cuthumbHeight;

        return $arr;
    }

    /**
     * 图片裁切处理
     *
     * @param        $img         原图
     * @param string $outFile     另存文件名
     * @param int    $thumbWidth  缩略图宽度
     * @param int    $thumbHeight 缩略图高度
     * @param int    $thumbType   裁切图片的方式
     *                            1 固定宽度  高度自增 2固定高度  宽度自增 3固定宽度  高度裁切
     *                            4 固定高度 宽度裁切 5缩放最大边 原图不裁切 6缩略图尺寸不变，自动裁切最大边
     *
     * @return bool|string
     */
    public function thumb(
        $img,
        $outFile,
        $thumbWidth = 200,
        $thumbHeight = 200,
        $thumbType = 6
    ) {
        if ( ! $this->check($img)) {
            return false;
        }
        //基础配置
        $thumbType   = $thumbType;
        $thumbWidth  = $thumbWidth;
        $thumbHeight = $thumbHeight;
        //获得图像信息
        $imgInfo   = getimagesize($img);
        $imgWidth  = $imgInfo [0];
        $imgHeight = $imgInfo [1];
        $imgType   = image_type_to_extension($imgInfo [2]);
        //获得相关尺寸
        $thumb_size = $this->thumbSize(
            $imgWidth,
            $imgHeight,
            $thumbWidth,
            $thumbHeight,
            $thumbType
        );
        //原始图像资源
        $func   = "imagecreatefrom".substr($imgType, 1);
        $resImg = $func($img);
        //缩略图的资源
        if ($imgType == '.gif') {
            $res_thumb = imagecreate($thumb_size [0], $thumb_size [1]);
            $color     = imagecolorallocate($res_thumb, 255, 0, 0);
        } else {
            $res_thumb = imagecreatetruecolor($thumb_size [0], $thumb_size [1]);
            imagealphablending($res_thumb, false); //关闭混色
            imagesavealpha($res_thumb, true); //储存透明通道
        }
        //绘制缩略图X
        if (function_exists("imagecopyresampled")) {
            imagecopyresampled(
                $res_thumb,
                $resImg,
                0,
                0,
                0,
                0,
                $thumb_size [0],
                $thumb_size [1],
                $thumb_size [2],
                $thumb_size [3]
            );
        } else {
            imagecopyresized(
                $res_thumb,
                $resImg,
                0,
                0,
                0,
                0,
                $thumb_size [0],
                $thumb_size [1],
                $thumb_size [2],
                $thumb_size [3]
            );
        }
        //处理透明色
        if ($imgType == '.gif') {
            imagecolortransparent($res_thumb, $color);
        }

        is_dir(dirname($outFile)) || mkdir(dirname($outFile), 0755, true);
        $func = "image".substr($imgType, 1);
        $func($res_thumb, $outFile);
        if (isset($resImg)) {
            imagedestroy($resImg);
        }
        if (isset($res_thumb)) {
            imagedestroy($res_thumb);
        }

        return true;
    }

    /**
     * 水印处理
     *
     * @param string $img      原图像
     * @param string $outImg   加水印后的图像
     * @param string $pos      水印位置
     * @param string $waterImg 水印图片
     * @param string $pct      透明度
     * @param string $text     文字水印内容
     *
     * @return bool
     */
    public function water(
        $img,
        $outImg,
        $pos = null,
        $waterImg = null,
        $text = null,
        $pct = null
    ) {
        //验证原图像
        if ( ! $this->check($img)) {
            return false;
        }
        //验证水印图像
        $waterImg   = $waterImg ?: $this->image;
        $waterImgOn = $this->check($waterImg) ? 1 : 0;

        //水印位置
        $pos = $pos ?: $this->pos;
        //水印文字
        $text = $text ?: $this->text;
        //水印透明度
        $pct       = $pct ?: $this->pct;
        $imgInfo   = getimagesize($img);
        $imgWidth  = $imgInfo [0];
        $imgHeight = $imgInfo [1];
        //获得水印信息
        if ($waterImgOn) {
            $waterInfo   = getimagesize($waterImg);
            $waterWidth  = $waterInfo [0];
            $waterHeight = $waterInfo [1];
            switch ($waterInfo [2]) {
                case 1 :
                    $w_img = imagecreatefromgif($waterImg);
                    break;
                case 2 :
                    $w_img = imagecreatefromjpeg($waterImg);
                    break;
                case 3 :
                    $w_img = imagecreatefrompng($waterImg);
                    break;
            }
        } else {
            if (empty($text) || strlen($this->text_color) != 7) {
                return false;
            }
            $textInfo    = imagettfbbox(
                $this->text_size,
                0,
                $this->font,
                $text
            );
            $waterWidth  = $textInfo [2] - $textInfo [6];
            $waterHeight = $textInfo [3] - $textInfo [7];
        }
        //建立原图资源
        if ($imgHeight < $waterHeight || $imgWidth < $waterWidth) {
            return false;
        }
        switch ($imgInfo [2]) {
            case 1 :
                $resImg = imagecreatefromgif($img);
                break;
            case 2 :
                $resImg = imagecreatefromjpeg($img);
                break;
            case 3 :
                $resImg = imagecreatefrompng($img);
                break;
        }
        //水印位置处理方法
        switch ($pos) {
            case 1 :
                $x = $y = 25;
                break;
            case 2 :
                $x = ($imgWidth - $waterWidth) / 2;
                $y = 25;
                break;
            case 3 :
                $x = $imgWidth - $waterWidth;
                $y = 25;
                break;
            case 4 :
                $x = 25;
                $y = ($imgHeight - $waterHeight) / 2;
                break;
            case 5 :
                $x = ($imgWidth - $waterWidth) / 2;
                $y = ($imgHeight - $waterHeight) / 2;
                break;
            case 6 :
                $x = $imgWidth - $waterWidth;
                $y = ($imgHeight - $waterHeight) / 2;
                break;
            case 7 :
                $x = 25;
                $y = $imgHeight - $waterHeight;
                break;
            case 8 :
                $x = ($imgWidth - $waterWidth) / 2;
                $y = $imgHeight - $waterHeight;
                break;
            case 9 :
                $x = $imgWidth - $waterWidth - 10;
                $y = $imgHeight - $waterHeight;
                break;
            default :
                $x = mt_rand(25, $imgWidth - $waterWidth);
                $y = mt_rand(25, $imgHeight - $waterHeight);
        }
        if ($waterImgOn) {
            if ($waterInfo [2] == 3) {
                imagecopy(
                    $resImg,
                    $w_img,
                    $x,
                    $y,
                    0,
                    0,
                    $waterWidth,
                    $waterHeight
                );
            } else {
                imagecopymerge(
                    $resImg,
                    $w_img,
                    $x,
                    $y,
                    0,
                    0,
                    $waterWidth,
                    $waterHeight,
                    $pct
                );
            }
        } else {
            $r     = hexdec(substr($this->text_color, 1, 2));
            $g     = hexdec(substr($this->text_color, 3, 2));
            $b     = hexdec(substr($this->text_color, 5, 2));
            $color = imagecolorallocate($resImg, $r, $g, $b);
            imagettftext(
                $resImg,
                $this->text_size,
                0,
                $x,
                $y,
                $color,
                $this->font,
                $text
            );
        }
        switch ($imgInfo [2]) {
            case 1 :
                imagegif($resImg, $outImg);
                break;
            case 2 :
                imagejpeg($resImg, $outImg, $this->quality);
                break;
            case 3 :
                imagepng($resImg, $outImg);
                break;
        }
        if (isset($resImg)) {
            imagedestroy($resImg);
        }
        if (isset($w_img)) {
            imagedestroy($w_img);
        }

        return true;
    }
}