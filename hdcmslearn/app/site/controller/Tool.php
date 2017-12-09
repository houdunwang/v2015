<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller;

use houdunwang\route\Controller;
use system\model\Message;

/**
 * 工具处理类
 * Class Tool
 *
 * @package app\site\controller
 */
class Tool extends Controller
{
    /**
     * 发送验证码
     *
     * @param \system\model\Message $message
     *
     * @return array
     */
    public function sendValidCode(Message $message)
    {
        return $message->sendCode([
            'user' => Request::post('username'),
        ]);
    }

    /**
     * 获取验证码发送间隔时间
     *
     * @return int
     */
    public function getMessageCodeDiffTime()
    {
        return Message::sendDiffTime();;
    }
}