<?php namespace app\system\controller;

use houdunwang\middleware\Middleware;
use system\model\UserPermission;
use system\model\User;
use system\model\Menu;
use system\model\Modules;
use Arr;
use Request;

/**
 * 站点权限设置
 * Class Permission
 *
 * @package app\system\controller
 */
class Permission extends Admin
{
    public function __construct()
    {
        Middleware::set('auth');
    }

    /**
     * 站点管理员设置
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function users(User $user)
    {
        if (empty(Request::get('siteid')) || $user->isManage() == false) {
            return message('你没有功能的操作权限', 'back', 'error');
        }
        //站点管理员
        $manage = $user->getSiteRole(['manage', 'operate', 'owner']);

        //移除当前用户,不允许给自己设置权限
        $uid = v('user.info.uid');
        if (isset($manage[$uid])) {
            unset($manage[$uid]);
        }

        return view()->with(compact('manage', 'user'));
    }

    /**
     * 添加站点操作员
     * 只有系统管理员或站长可以执行这个功能
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function addOperator(User $user)
    {
        if ($user->isManage() == false) {
            return message('你没有操作站点的权限', 'with');
        }
        foreach (q('post.uid', []) as $uid) {
            $has = Db::table("site_user")->where("uid", $uid)->where("siteid", SITEID)->get();
            if ( ! $has) {
                Db::table('site_user')->insert([
                    'siteid' => SITEID,
                    'uid'    => $uid,
                    'role'   => 'operate',
                ]);
            }
        }
        record('添加站点操作员');

        return message('站点操作员添加成功', '', 'success');
    }

    /**
     * 更改会员的站点角色
     * 需要站长或系统管理员才可以操作
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function changeRole(User $user)
    {
        if ($user->isManage() == false) {
            return message('你没有操作站点的权限', '', 'error');
        }
        Db::table('site_user')->where('uid', Request::post('uid'))
          ->where('siteid', SITEID)->update(['role' => $_POST['role']]);
        record('更改了站点管理员角色类型');

        return message('管理员角色更新成功');
    }

    /**
     * 删除站点用户
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function removeSiteUser(User $user)
    {
        if ($user->isManage() == false) {
            return message('你没有操作站点的权限', '', 'error');
        }
        Db::table('site_user')->where('siteid', SITEID)->whereIn('uid', Request::post('uids'))->delete();

        return message('站点管理员删除成功');
    }

    /**
     * 设置菜单权限
     *
     * @param \system\model\User    $user
     * @param \system\model\Menu    $menu
     * @param \system\model\Modules $module
     *
     * @return mixed|string
     */
    public function menu(User $user, Menu $menu, Modules $module)
    {
        if ($user->isManage() == false) {
            return message('你没有操作权限', '', 'warning');
        }
        //设置权限的用户
        $uid = Request::get('fromuid');
        if (IS_POST) {
            //删除所有旧的权限
            UserPermission::where('siteid', SITEID)->where('uid', $uid)->delete();
            //系统权限
            if ($system = Request::post('system')) {
                $model               = new UserPermission();
                $model['siteid']     = SITEID;
                $model['uid']        = $uid;
                $model['type']       = 'system';
                $model['permission'] = implode('|', $system);
                $model->save();
            }
            //模块权限
            if ($modules = Request::post('modules')) {
                foreach ($modules as $module => $actions) {
                    $model               = new UserPermission();
                    $model['siteid']     = SITEID;
                    $model['uid']        = $uid;
                    $model['type']       = $module;
                    $model['permission'] = implode('|', $actions);;
                    $model->save();
                }
            }
            return message('权限设置成功', 'refresh', 'success');
        }
        //系统菜单权限
        $menus       = $menu->getUserMenuAccess(siteid(), $uid);
        $menusAccess = Arr::channelLevel($menus, 0, '', 'id', 'pid');
        //模块权限
        $moduleAccess = $module->getExtModuleByUserPermission($uid);
        //模块权限
        $user = User::find(Request::get('fromuid'));
        return view()->with(compact('menusAccess', 'moduleAccess','user'));
    }
}