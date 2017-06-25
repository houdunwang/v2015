<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build;

use houdunwang\curl\Curl;

/**
 * 长链接转短链接接口
 * Class Shorturl
 *
 * @package houdunwang\wechat\build
 */
class Shorturl extends Base
{
    /**
     * 长链接转短链接接口
     *
     * @param $longUrl
     *
     * @return array|mixed
     */
    public function makeShortUrl($longUrl)
    {
        $url   = $this->apiUrl
            .'/cgi-bin/shorturl?access_token='
            .$this->getAccessToken();
        $param = [
            'action'   => 'long2short',
            'long_url' => $longUrl,
        ];

        $content = Curl::post($url,
            json_encode($param, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }
}