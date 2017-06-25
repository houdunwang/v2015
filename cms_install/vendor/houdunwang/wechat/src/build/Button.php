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
use houdunwang\wechat\build\button\Event;
use houdunwang\wechat\build\button\Special;

/**
 * 微信菜单管理
 * Class Button
 *
 * @package houdunwang\wechat\build
 */
class Button extends Base
{
    use Event, Special;

    /**
     * 获取自定义菜单配置接口
     *
     * @return array|mixed
     */
    public function getCurrentSelfMenuInfo()
    {
        $url     = $this->apiUrl
            .'/cgi-bin/get_current_selfmenu_info?access_token='
            .$this->getAccessToken();
        $content = Curl::get($url);

        return $this->get($content);
    }

    /**
     * 创建菜单
     *
     * @param $button
     *
     * @return array|mixed
     */
    public function create($button)
    {
        $url     = $this->apiUrl.'/cgi-bin/menu/create?access_token='
            .$this->getAccessToken();
        $content = Curl::post($url,
            json_encode($button, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 查询微信服务器上菜单
     *
     * @return array|mixed
     */
    public function query()
    {
        $url     = $this->apiUrl.'/cgi-bin/menu/get?access_token='
            .$this->getAccessToken();
        $content = Curl::get($url);

        return $this->get($content);
    }

    /**
     * 删除菜单
     *
     * @return array|mixed
     */
    public function flush()
    {
        $url     = $this->apiUrl.'/cgi-bin/menu/delete?access_token='
            .$this->getAccessToken();
        $content = Curl::get($url);

        return $this->get($content);
    }
}