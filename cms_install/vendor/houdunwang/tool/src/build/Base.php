<?php namespace houdunwang\tool\build;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

class Base
{
    /**
     * 批量执行函数
     *
     * @param $functions 函数
     * @param $value
     *
     * @return mixed
     */
    public function batchFunctions($functions, $value)
    {
        $functions = is_array($functions) ? $functions : [$functions];
        foreach ($functions as $func) {
            $value = $func($value);
        }

        return $value;
    }


    /**
     * 生成随机数字
     *
     * @param int $len 数量
     *
     * @return string
     */
    public function rand($len = 4)
    {
        $str = '0123456789';
        $s   = '';
        for ($i = 0; $i < $len; $i++) {
            $pos = mt_rand(0, strlen($str) - 1);
            $s   .= $str[$pos];
        }

        return $s;
    }

     /**
     * 产生随机字符串
     *
     * @param int $length
     *
     * @return string
     */
    public function randStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str   = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    /**
     * 根据大小返回标准单位 KB  MB GB等
     *
     * @param int $size
     * @param int $decimals 小数位
     *
     * @return string
     */
    public function getSize($size, $decimals = 2)
    {
        switch (true) {
            case $size >= pow(1024, 3):
                return round($size / pow(1024, 3), $decimals)." GB";
            case $size >= pow(1024, 2):
                return round($size / pow(1024, 2), $decimals)." MB";
            case $size >= pow(1024, 1):
                return round($size / pow(1024, 1), $decimals)." KB";
            default:
                return $size.'B';
        }
    }
}