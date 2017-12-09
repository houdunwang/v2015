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

use Request;
use houdunwang\route\Controller;
use system\model\CreditsRecord;
use system\model\Menu;
use system\model\Modules;
use system\model\ModulesBindings;
use system\model\Site;
use system\model\SiteSetting;

/**
 * 网站入口管理
 * Class Entry
 *
 * @package app\site\controller
 */
class Entry extends Controller
{
    /**
     * 通过域名访问时执行的方法
     * 执行的默认控制器动作即模块的桌面主页动作
     *
     * @param \system\model\ModulesBindings $ModulesBindings
     *
     * @return mixed
     */
    public function index(ModulesBindings $ModulesBindings)
    {
        $siteid = Request::get('siteid');
        $module = v('module.name');
        if ($siteid && $module) {
            if ( ! Site::find($siteid)->isClose()) {
                return view('close');
            }
            $do = $ModulesBindings->getWebDo($module);
            if ($module && $do) {
                $class = (v('module.is_system') ? 'module' : 'addons').'\\'.$module.'\system\Navigate';
                if (class_exists($class) && method_exists($class, $do['do'])) {
                    return call_user_func_array([new $class, $do['do']], []);
                }
            }

            //没有模块执行时，执行文章模块
            return $this->articleModuleHome();
        }

        return u('system.site.lists');
    }

    /**
     * 执行文章模块桌面主页动作
     *
     * @return mixed
     */
    public function articleModuleHome()
    {
        $class = 'module\article\system\Navigate';

        return call_user_func_array([new $class, 'web'], []);
    }

    /**
     * 模块路由动作
     *
     * @return mixed
     */
    public function moduleRoute()
    {
        $matchRoute = Route::getMatchRoute();
        $route      = Db::table('router')->where('siteid', siteid())->where('module', v('module.name'))
                        ->where('router', $matchRoute['route'])->first();
        parse_str($route['url'], $gets);
        Request::set('get.action', $gets['action']);

        return $this->action();
    }

    /**
     * 执行模块动作
     * 动作分为系统动作与控制器动作
     */
    public function action()
    {
        $info       = explode('/', Request::get('action'));
        $action     = array_pop($info);
        $controller = ucfirst(array_pop($info));
        $namespace  = v('module.name').'\\'.implode('\\', $info);
        $class      = (v('module.is_system') ? "module\\" : "addons\\")."{$namespace}\\{$controller}";

        return App::callMethod($class, $action);
    }

    /**
     * 站点入口管理主页
     *
     * @param \system\model\Menu    $menu
     * @param \system\model\Modules $Modules
     *
     * @return mixed|string
     */
    public function home(Menu $menu, Modules $Modules)
    {
        auth();
        if ( ! $mark = Request::get('mark')) {
            //获取系统菜单
            $menu = $menu->getSystemMenu();
            if (empty($menu)) {
                return message('站点没有可访问的模块', 'back', 'error');
            }
            $current = current($menu);
            $mark    = $current['mark'];
            Request::set('get.mark', $mark);
        }
        //当前用户可以使用的模块
        $modules = $Modules->getBySiteUser();

        return view(view_path().'/home/'.$mark.'.php', compact('modules'));
    }

    /**
     * 扩展功能模块
     *
     * @return mixed
     */
    public function package()
    {
        auth();
        $data = Modules::getBySiteUser();

        return view()->with(['data' => $data]);
    }

    /**
     * 后台模块主页
     *
     * @return mixed
     */
    public function module()
    {
        auth();

        return view();
    }
}