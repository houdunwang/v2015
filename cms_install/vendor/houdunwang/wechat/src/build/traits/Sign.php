<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build\traits;

use houdunwang\config\Config;

/**
 * 签名
 * Class Sign
 *
 * @package houdunwang\wechat\build\traits
 */
trait Sign
{
    /**
     * 生成签名,支付或红包等使用
     *
     * @param $data
     *
     * @return string
     */
    public function makeSign($data)
    {
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = $this->ToUrlParams($data);
        //签名步骤二：在string后加入KEY
        $string = $string."&key=".Config::get('wechat.key');
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);

        return $result;
    }


    /**
     * 格式化参数格式化成url参数 为生成签名服务
     *
     * @param $data
     *
     * @return string
     */
    protected function ToUrlParams($data)
    {
        $buff = "";
        foreach ($data as $k => $v) {
            if ($k != "sign" && $k != "key" && $v != "" && ! is_array($v)) {
                $buff .= $k."=".$v."&";
            }
        }

        $buff = trim($buff, "&");

        return $buff;
    }
}