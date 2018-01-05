<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\ucenter\controller;

use houdunwang\request\Request;
use system\model\Notification;

/**
 * 消息中心
 * Class Message
 *
 * @package module\ucenter\controller
 */
class Message extends Auth
{
    /**
     * 分页列表
     *
     * @param \system\model\Notification $model
     *
     * @return string
     */
    public function lists(Notification $model)
    {
        $data = $model->getPageLists(30, Request::get('status'));

        return $this->view($this->template.'/message_lists', compact('data'));
    }

    /**
     * 显示日志
     *
     * @return mixed
     */
    public function show()
    {
        $model           = Notification::find(Request::get('id'));
        $model['status'] = 1;
        $model->save();

        return $model['url'];
    }
}