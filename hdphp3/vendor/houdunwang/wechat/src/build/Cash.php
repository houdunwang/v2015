<?php namespace wechat\build;

//微信红包

use wechat\WeChat;

class cash extends WeChat
{
    //发布现金红包
    public function sendRedPack($data)
    {
        $data['mch_billno'] = time();
        $data['mch_id']     = c('weixin.mch_id');
        $data['wxappid']    = c('weixin.appid');
        $data['total_num']  = "1";//红包发放总人数
        $data['client_ip']  = Request::ip();
        $data['nonce_str']  = $this->getRandStr(16);
        $data['sign']       = $this->makeSign($data);
        $xml                = Xml::toSimpleXml($data);
        $res                = $this->curl_post_ssl("https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack", $xml);
        return Xml::toSimpleArray($res);
    }

    function curl_post_ssl($url, $vars, $second = 30, $aHeader = array())
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
        curl_setopt($ch, CURLOPT_SSLCERT, self::$config['apiclient_cert']);
        curl_setopt($ch, CURLOPT_SSLKEY, self::$config['apiclient_key']);
        curl_setopt($ch, CURLOPT_CAINFO, self::$config['rootca']);
        if (count($aHeader) >= 1)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $data = curl_exec($ch);
        if ($data)
        {
            curl_close($ch);
            return $data;
        }
        else
        {
            curl_close($ch);
            return false;
        }
    }
}