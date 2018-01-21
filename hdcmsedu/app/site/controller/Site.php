<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller;

/**
 * 多站其他功能管理
 * Class Site
 *
 * @package app\site\controller
 */
class Site extends Admin
{
    /**
     * 更新站点缓存
     *
     * @param \system\model\Site $SiteModel
     *
     * @return mixed|string
     */
    public function updateCache(\system\model\Site $SiteModel)
    {
        if (IS_POST) {
            $SiteModel->updateCache();

            return message('更新站点缓存成功', 'back', 'success');
        }

        return view();
    }
}