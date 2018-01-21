<?php namespace system\model;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use houdunwang\db\Db;
use houdunwang\arr\Arr;
use houdunwang\request\Request;

/**
 * 系统菜单管理
 * Class Menu
 *
 * @package system\model
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Menu extends Common
{
    protected $table = 'menu';

    protected $validate
        = [
            ['title', 'required', '标题不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['permission', 'unique', '权限标识已经被使用', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['append_url', 'unique', '右侧图标链接已经被使用', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['orderby', 'num:0,255', '排序数字为0~255', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['is_display', 'num:0,1', '[显示]字段参数错误', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['is_display', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['mark', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['is_system', 0, 'string', self::MUST_AUTO, self::MODEL_INSERT],
            ['icon', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['url', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['append_url', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['permission', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['pid', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 获取菜单组合的父子级多维数组
     *
     * @return mixed
     */
    public function getLevelMenuLists()
    {
        $menu = Db::table('menu')->get() ?: [];

        return Arr::channelLevel($menu ?: [], 0, '', 'id', 'pid');
    }

    /**
     * 获取当前用户在站点后台可以使用的系统菜单
     *
     * @return mixed
     */
    public function getSystemMenu()
    {
        /**
         * 系统管理
         * 1 移除系统菜单
         * 2 将没有三级或二级菜单的菜单移除
         */
        //移除用户没有使用权限的系统菜单
        $permission = Db::table('user_permission')->where('siteid', SITEID)->where('uid', v('user.info.uid'))->lists('type,permission');
        //所有系统菜单
        $menus = Db::table('menu')->orderBy('id', 'asc')->get();
        //设置系统菜单权限时移除没有权限的菜单
        if ( ! User::isManage() && $permission) {
            $access = [];
            if (isset($permission['system'])) {
                $access = explode('|', $permission['system']);
            }
            $tmp = $menus;
            foreach ($tmp as $k => $m) {
                if ($m['permission'] != '' && ! in_array($m['permission'], $access)) {
                    unset($menus[$k]);
                }
            }
        }
        $menus = Arr::channelLevel($menus, 0, '', 'id', 'pid');
        //移除没有三级菜单的一级与二级菜单
        $tmp = $menus;
        foreach ($tmp as $k => $t) {
            //二级菜单为空时删除些菜单
            foreach ($t['_data'] as $n => $d) {
                if (empty($d['_data'])) {
                    unset($menus[$k]['_data'][$n]);
                }
            }
            //一级菜单没有子菜单时移除
            if (empty($menus[$k]['_data'])) {
                unset($menus[$k]);
            }
        }

        return $menus;
    }

    /**
     * 获取模块动作列表
     */
    public function getModuleMenu()
    {
        $menu = [];
        //当前访问的模块数据
        if ($m = Request::get('m')) {
            $Module     = new Modules();
            $allModules = $Module->getExtModuleByUserPermission();
            $tmp        = $menu = isset($allModules[$m]) ? $allModules[$m] : [];
            //移除没有权限的模块动作
            foreach ((array)$tmp['access'] as $k => $lists) {
                foreach ($lists as $n => $m) {
                    if ($m['_status'] == 0) {
                        unset($menu['access'][$k][$n]);
                    }
                }
            }
        }

        return $menu;
    }

    /**
     * 分配菜单数据到模板
     *
     * @return mixed
     */
    public function getMenus()
    {
        static $menus = null;
        if (is_null($menus)) {
            //模块列表
            $module      = new Modules();
            $moduleLists = $module->getModulesByIndustry(array_keys($module->getBySiteUser()));
            //当前模块的菜单数据
            $menus = [
                //系统菜单数据
                'menus'       => $this->getSystemMenu(),
                //当前模块
                'module'      => $this->getModuleMenu(),
                //用户在站点可以使用的模块列表
                'moduleLists' => $moduleLists,
            ];
        }

        return $menus;
    }

    /**
     * 获取快捷导航菜单
     *
     * @return array|mixed
     */
    public function getQuickMenu()
    {
        $data = Db::table('site_quickmenu')->where('siteid', siteid())->where('uid', v('user.info.uid'))->pluck('data');

        return $data ? json_decode($data, true) : [];
    }

    /**
     * 根据权限获取菜单
     *
     * @param string $siteId 站点编号
     * @param string $uid    用户编号
     *
     * @return mixed
     */
    public function getUserMenuAccess($siteId = '', $uid = '')
    {
        $siteId     = $siteId ?: SITEID;
        $uid        = $uid ?: v('user.info.uid');
        $user       = new User;
        $permission = $user->getUserAtSiteAccess($siteId, $uid);
        $menus      = Db::table('menu')->get();
        foreach ($menus as $k => $v) {
            $menus[$k]['_status'] = 0;
            if (empty($permission)) {
                $menus[$k]['_status'] = 1;
            } elseif (isset($permission['system']) && in_array($v['permission'], $permission['system'])) {
                $menus[$k]['_status'] = 1;
            }
        }

        return $menus;
    }

    /**
     * 获取模块菜单类型
     *
     * @param string $entry 类型 member桌面会员中心
     * @param int    $groupId
     *
     * @return array
     */
    public static function moduleMenus($entry, $groupId = 0)
    {
        //读取菜单
        $module = Db::table('navigate')->where('entry', 'member')->where('siteid', SITEID)->groupBy('module')->lists('module');
        $data   = [];
        foreach ($module as $m) {
            if ($moduleData = Db::table('modules')->where('name', $m)->first()) {
                $data[] = [
                    'module' => $moduleData,
                    'menus'  => Db::table('navigate')->where('entry', $entry)->where('status', 1)->where('module', $m)->where('siteid', siteid())->get(),
                ];
            }
        }
        $menus = $data;
        foreach ($data as $k => $v) {
            foreach ($v['menus'] as $n => $m) {
                $menus[$k]['menus'][$n]['css'] = json_decode($m['css'], true);
                $groups                        = json_decode($m['groups'], true);
                $groups                        = is_array($groups) ? array_filter($groups) : [];
                //指定会员组时只显示可访问的菜单
                if ($groupId && ! empty($groups) && ! in_array($groupId, $groups)) {
                    unset($menus[$k]['menus'][$n]);
                }
            }
        }
        //删除没有菜单的模块
        foreach ($menus as $k => $v) {
            if (empty($v['menus'])) {
                unset($menus[$k]);
            }
        }

        return $menus;
    }

    /**
     * 删除菜单
     *
     * @param int $id 编号
     *
     * @return bool|void
     */
    public function delMenu($id)
    {
        if (self::where('id', $id)->where('is_system', 1)->get()) {
            return $this->setError('系统菜单不允许删除');
        }
        $data         = $this->get();
        $menu         = Arr::channelList($data, $id, "&nbsp;", 'id', 'pid');
        $menu[]['id'] = $id;
        foreach ($menu as $m) {
            self::where('id', $m['id'])->delete();
        }

        return true;
    }
}