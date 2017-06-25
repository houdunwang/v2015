<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build\customservice;

use houdunwang\curl\Curl;

/**
 * 客服接口-发消息
 * Class Message
 *
 * @package houdunwang\wechat\build\customservice
 */
trait CustomMessage
{
    /**
     * 发送消息
     *
     * @param $data
     *
     * @return mixed
     */
    public function send($data)
    {
        $url    = $this->apiUrl.'/cgi-bin/message/custom/send?access_token='
            .$this->getAccessToken();
        $result = Curl::post($url, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->get($result);
    }

    /**
     * 发送文本消息
     *
     * @param $toUser
     * @param $content
     *
     * @return mixed
     */
    public function sendTest($toUser, $content)
    {
        return $this->send($toUser, 'text', ['content' => $content]);
    }

    /**
     * 发送图片消息
     *
     * @param $toUser
     * @param $media_id
     *
     * @return mixed
     */
    public function sendImage($toUser, $media_id)
    {
        return $this->send($toUser, 'image', ['media_id' => $media_id]);
    }

    /**
     * 发送语音消息
     *
     * @param $toUser
     * @param $media_id
     *
     * @return mixed
     */
    public function sendVoice($toUser, $media_id)
    {
        return $this->send($toUser, 'voice', ['media_id' => $media_id]);
    }

    /**
     * 发送视频消息
     *
     * @param        $toUser
     * @param        $media_id
     * @param        $title
     * @param string $desc
     *
     * @return mixed
     */
    public function sendVideo($toUser, $media_id, $title, $desc = '')
    {
        return $this->send($toUser, 'video', [
            'media_id'    => $media_id,
            'title'       => $title,
            'description' => $desc,
        ]);
    }

    /**
     * 发送音乐消息
     *
     * @param        $toUser
     * @param        $thumb_media_id
     * @param        $url
     * @param        $title
     * @param string $desc
     * @param string $hq_url
     *
     * @return mixed
     */
    public function sendMusic(
        $toUser,
        $thumb_media_id,
        $url,
        $title,
        $desc = '',
        $hq_url = ''
    ) {
        return $this->send($toUser, 'music', [
            'title'          => $title,
            'description'    => $desc,
            'musicurl'       => $url,
            'thumb_media_id' => $thumb_media_id,
            'hqmusicurl'     => $hq_url || $url,
        ]);
    }

    /**
     * 发送图文消息
     *
     * @param $toUser
     * @param $articles
     *
     * @return mixed
     */
    public function sendNews($toUser, $articles)
    {
        return $this->send($toUser, 'news', [
            'articles' => $articles,
        ]);
    }
}