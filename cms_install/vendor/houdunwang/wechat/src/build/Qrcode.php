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
 * 二维码
 * Class Qrcode
 *
 * @package houdunwang\wechat\build
 */
class Qrcode extends Base
{
    protected $api = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=';

    /**
     * 创建临时二维码
     *
     * @param array $param 参数
     *
     * @return bool
     */
    public function create(array $param)
    {
        $expire  = isset($param['expire_seconds']) ? $param['expire_seconds'] : 604800;
        $data    = [
            'action_name'    => 'QR_SCENE',
            'expire_seconds' => $expire,
            'action_info'    => ['scene' => $param],
        ];
        $url     = $this->api.$this->getAccessToken();
        $content = Curl::post($url, json_encode($data));

        return $this->get($content, true);
    }

    /**
     * 创建永久二维码
     *
     * @param array $param 二维码参数
     *
     * @return bool
     */
    public function createLimitCode(array $param)
    {
        $data    = [
            'action_name' => 'QR_LIMIT_SCENE',
            'action_info' => ['scene' => $param],
        ];
        $url     = $this->api.$this->getAccessToken();
        $content = Curl::post($url, json_encode($data));

        return $this->get($content, true);
    }

    /**
     * 获取二维码图片
     *
     * @param $ticket
     *
     * @return string
     */
    public function getQrcode($ticket)
    {
        return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket="
            .urlencode($ticket);
    }
}