<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build;

use houdunwang\config\Config;
use houdunwang\request\Request;
use houdunwang\tool\Tool;

/**
 * 微信红包
 * Class cash
 *
 * @package houdunwang\wechat\build
 */
class cash extends Base
{
    /**
     * 发布现金红包
     *
     * @param $data
     *
     * @return mixed
     */
    public function sendRedPack($data)
    {
        $data['mch_billno'] = time();
        $data['mch_id']     = Config::get('wechat.mch_id');
        $data['wxappid']    = $this->appid;
        $data['client_ip']  = $_SERVER['REMOTE_ADDR'];
        $data['nonce_str']  = Tool::randStr(16);
        $data['sign']       = $this->makeSign($data);
        $xml                = \houdunwang\xml\Xml::toSimpleXml($data);
        $res
                            = $this->curl_post_ssl("https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack",
            $xml);

        return \houdunwang\xml\Xml::toSimpleArray($res);
    }

    /**
     * 发送请求
     *
     * @param       $url
     * @param       $vars
     * @param int   $second
     * @param array $aHeader
     *
     * @return bool|mixed
     */
    function curl_post_ssl($url, $vars, $second = 30, $aHeader = [])
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //cert 与 key 分别属于两个.pem文件
        //请确保您的libcurl版本是否支持双向认证，版本高于7.20.1
        curl_setopt($ch, CURLOPT_SSLCERT, Config::get('wechat.apiclient_cert'));
        curl_setopt($ch, CURLOPT_SSLKEY, Config::get('wechat.apiclient_key'));
        curl_setopt($ch, CURLOPT_CAINFO, Config::get('wechat.rootca'));
        if (count($aHeader) >= 1) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $data = curl_exec($ch);
        if ($data) {
            curl_close($ch);

            return $data;
        } else {
            curl_close($ch);

            return false;
        }
    }
}