<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build\message;

use houdunwang\curl\Curl;

/**
 * 群发消息
 * Trait SendAll
 *
 * @package houdunwang\wechat\build\message
 */
trait SendAll
{
    /**
     * 群发消息正式发送
     *
     * @param $data
     *
     * @return mixed
     */
    public function sendAll($data)
    {
        $url = $this->apiUrl.'/cgi-bin/message/mass/sendall?access_token='
               .$this->getAccessToken();

        $content = Curl::post($url, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 群发消息预览发送
     *
     * @param $data
     *
     * @return mixed
     */
    public function preview($data)
    {
        $url = $this->apiUrl.'/cgi-bin/message/mass/preview?access_token='.$this->getAccessToken();

        $content = Curl::post($url, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 删除群发消息
     *
     * @param $data
     *
     * @return mixed
     */
    public function delMassMessage($data)
    {
        $url = $this->apiUrl.'/cgi-bin/message/mass/delete?access_token='
               .$this->getAccessToken();

        $content = Curl::post($url, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 查询群发消息发送状态
     *
     * @param $data
     *
     * @return mixed
     */
    public function getMassMessageState($data)
    {
        $url = $this->apiUrl.'/cgi-bin/message/mass/get?access_token='
               .$this->getAccessToken();

        $content = Curl::post($url, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 群发消息推送事件
     *
     * @return bool
     */
    public function isMassMessage()
    {
        return $this->message->MsgType == 'event'
               && $this->message->Event == 'MASSSENDJOBFINISH'
               && isset($this->message->TotalCount);
    }
}