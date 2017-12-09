<?php namespace module\article\system;

use module\HdNavigate;

/**
 * 导航菜单处理
 * Class Navigate
 *
 * @package module\article\system
 */
class Navigate extends HdNavigate
{
    /**
     * 桌面入口导航 [桌面入口导航菜单]
     * 在网站管理中将模块设置为默认执行模块然后配置好域名
     * 当使用配置的域名访问时会执行这个方法
     */
    public function web()
    {
        return controller_action('article.entry.index');
    }
}