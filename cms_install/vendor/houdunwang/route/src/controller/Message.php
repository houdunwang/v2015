<?php

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\route\controller;

/**
 * 响应消息处理
 * Trait Message
 *
 * @package houdunwang\route\controller
 */
trait Message
{
    /**
     * 跳转方式
     *
     * @var string
     */
    protected $redirect = 'back';

    /**
     * 跳转链接
     * @var
     */
    protected $url;

    /**
     * 获取跳转方式
     *
     * @return string
     */
    final public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * 设置跳转方式
     *
     * @param $redirect
     *
     * @return $this
     */
    final public function setRedirect($redirect)
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     * 分配错误消息
     *
     * @param $content
     *
     * @return mixed|string
     */
    final protected function withErrors($content)
    {
        $content = is_array($content) ? $content : [$content];

        return message($content, 'with', 'errors');
    }

    /**
     * 回调来源页
     *
     * @return mixed|string
     */
    final protected function back()
    {
        return message('', 'back');
    }

    /**
     * 返回成功结果
     *
     * @param mixed $content 内容
     *
     * @return array
     */
    final protected function success($content)
    {
        return message($content, $this->getRedirect(), 'success');
    }

    /**
     * 返回失败结果
     *
     * @param mixed $content 内容
     *
     * @return array
     */
    final protected function error($content)
    {
        return message($content, $this->getRedirect(), 'error');
    }

}