<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build\button;

use houdunwang\curl\Curl;

/**
 * 个性化菜单
 * Trait Special
 *
 * @package houdunwang\wechat\build\button
 */
trait Special
{
    /**
     * 创建个性化菜单
     *
     * @param $button
     *
     * @return array
     */
    public function createSpecialButton($button)
    {
        $url     = $this->apiUrl.'/cgi-bin/menu/addconditional?access_token='
            .$this->getAccessToken();
        $content = Curl::post($url,
            json_encode($button, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 删除个性菜单
     *
     * @param $menuId
     *
     * @return mixed
     */
    public function delSpecialButton($menuId)
    {
        $url     = $this->apiUrl.'/cgi-bin/menu/delconditional?access_token='
            .$this->getAccessToken();
        $post    = ['menuid' => $menuId];
        $content = Curl::post($url,
            json_encode($post, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 测试个性化菜单匹配结果
     *
     * @param $userId 用户openid或微信号
     *
     * @return mixed
     */
    public function trySpecialButton($userId)
    {
        $url     = $this->apiUrl.'/cgi-bin/menu/trymatch?access_token='
            .$this->getAccessToken();
        $post    = ['user_id' => $userId];
        $content = Curl::post($url,
            json_encode($post, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }
}