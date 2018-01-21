<?php namespace app\system\controller;

use system\model\User;
use system\model\Site;

/**
 * 模块菜单和菜单组欢迎页
 * Class Manage
 *
 * @package app\system\controller
 */
class Manage extends Admin
{
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 系统设置图标列表菜单
     *
     * @param \system\model\User $user
     *
     * @return mixed
     */
    public function menu(User $user)
    {
        return view()->with(compact('user'));
    }

    /**
     * 更新缓存
     *
     * @param \system\model\Site $site
     *
     * @return mixed
     */
    public function updateCache(Site $site)
    {
        if ( ! User::superUserAuth()) {
            return message('没有操作权限', '', 'warning');
        }
        if (IS_POST) {
            //更新数据缓存
            if (isset($_POST['cache'])) {
                Dir::del(ROOT_PATH.'/storage/cache');
            }
            //更新模板缓存
            if (isset($_POST['view'])) {
                Dir::del(ROOT_PATH.'/storage/view');
            }
            //站点日志
            if (isset($_POST['log'])) {
                Dir::del(ROOT_PATH.'/storage/log');
            }
            //微信缓存
            if (isset($_POST['weixin'])) {
                Dir::del(ROOT_PATH.'/storage/weixin');
            }
            //更新所有站点缓存
            if (isset($_POST['site'])) {
                Site::updateAllCache();
            }
            return message('缓存更新成功', 'menu');
        }
        Site::updateAllCache();

        return view();
    }
}