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

/**
 * 消息类型
 * Trait Mold
 *
 * @package houdunwang\wechat\build\traits
 */
trait Basic
{
    /**
     * 文本消息
     *
     * @return bool
     */
    public function isTextMsg()
    {
        return $this->message->MsgType == self::MSG_TYPE_TEXT;
    }

    /**
     * 图像消息
     *
     * @return bool
     */
    public function isImageMsg()
    {
        return $this->message->MsgType == self::MSG_TYPE_IMAGE;
    }

    /**
     * 语音消息
     *
     * @return bool
     */
    public function isVoiceMsg()
    {
        return $this->message->MsgType == self::MSG_TYPE_VOICE;
    }

    /**
     * 地址消息
     *
     * @return bool
     */
    public function isLocationMsg()
    {
        return $this->message->MsgType == self::MSG_TYPE_LOCATION;
    }

    /**
     * 链接消息
     *
     * @return bool
     */
    public function isLinkMsg()
    {
        return $this->message->MsgType == self::MSG_TYPE_LINK;
    }

    /**
     * 视频消息
     *
     * @return bool
     */
    public function isVideoMsg()
    {
        return $this->message->MsgType == self::MSG_TYPE_VIDEO;
    }

    /**
     * 小视频消息
     *
     * @return bool
     */
    public function isSmallVideoMsg()
    {
        return $this->message->MsgType == self::MSG_TYPE_SMALL_VIDEO;
    }
}