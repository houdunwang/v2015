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

use houdunwang\curl\Curl;

/**
 * 网页授权获取用户基本信息
 * Class Oauth
 *
 * @package houdunwang\wechat\build
 */
class Oauth extends Base
{
    /**
     * 公共请求方法
     *
     * @param string $type   用户资料类型
     * @param bool   $qrCode 使用用二维码获取资料
     *
     * @return array|bool|mixed
     */
    private function request($type, $qrCode = false)
    {
        $status = isset($_GET['code']) && isset($_GET['state'])
            && $_GET['state'] == 'STATE';
        if ($status) {
            $url = $this->apiUrl."/sns/oauth2/access_token?appid="
                .$this->appid."&secret=".$this->appsecret."&code=".$_GET['code']
                ."&grant_type=authorization_code";
            return $this->get(Curl::get($url));
        } else {
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
                .$this->appid."&redirect_uri="
                .urlencode($this->currentPageURL())
                ."&response_type=code&scope=".$type
                ."&state=STATE#wechat_redirect";
            if ($qrCode) {
                \houdunwang\qrcode\QrCode::make($url);
            } else {
                header('location:'.$url);
            }
            die;
        }
    }

    /**
     * 获取用户openid
     *
     * @return bool
     */
    public function snsapiBase()
    {
        return $this->request('snsapi_base');
    }

    /**
     * 是用来获取用户的基本信息的
     *
     * @return array|bool|mixed
     */
    public function snsapiUserinfo()
    {
        $data = $this->request('snsapi_userinfo');
        if (isset($data['openid'])) {
            $url = $this->apiUrl."/sns/userinfo?access_token="
                .$data['access_token']."&openid=".$data['openid']."&lang=zh_CN";

            return $this->get(Curl::get($url));
        }
    }

    /**
     * 当前请求页面地址
     *
     * @return string
     */
    public function currentPageURL()
    {
        $pageURL = 'http';

        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]
                .$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }
}
