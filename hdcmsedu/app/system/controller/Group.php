<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\system\controller;

use system\model\UserGroup;
use system\model\User;
use houdunwang\request\Request;
/**
 * 用户组管理
 * Class Group
 *
 * @package core\controller
 * @author  向军
 */
class Group extends Admin
{
    /**
     * 构造函数
     * Group constructor.
     *
     * @param \system\model\User $user
     */
    public function __construct(User $user)
    {
        $this->superUserAuth();
    }

    /**
     * 用户组列表
     *
     * @param \system\model\UserGroup $group
     *
     * @return mixed
     */
    public function lists(UserGroup $group)
    {
        $groups = $group->get();

        return view()->with(compact('groups'));
    }

    /**
     * 删除会员组
     *
     * @param \system\model\UserGroup $group
     *
     * @return mixed|string
     */
    public function remove(UserGroup $group)
    {
        foreach ((array)Request::post('id') as $id) {
            //更改用户组下的用户组为系统默认用户组
            Db::table('user')->where('groupid', $id)->update(['groupid' => v('config.register.groupid')]);
            $group->where('system_group', 0)->delete($id);
        }

        return message('用户组删除成功');
    }

    /**
     * 编辑用户组
     *
     * @param \system\model\UserGroup $group
     * @param \system\model\Package   $package
     *
     * @return mixed
     */
    public function post(UserGroup $group, \system\model\Package $package)
    {
        //组编号
        $id = Request::get('id', 0);
        if (IS_POST) {
            $model                   = $id ? $group::find($id) : $group;
            $model['name']           = Request::post('name');
            $model['maxsite']        = Request::post('maxsite', 1, 'intval');
            $model['daylimit']       = Request::post('daylimit', 7, 'intval');
            $model['middleware_num'] = Request::post('middleware_num', 100, 'intval');
            $model['router_num']     = Request::post('router_num', 100, 'intval');
            $model['package']        = Request::post('package', []);
            $model->save();

            return message('用户组数据保存成功', 'lists', 'success');
        }
        //系统所有套餐
        $packages = $package->getSystemAllPackageData();
        //获取当前级资料包括为组定义的独立套餐
        if ($group = $group::find($id)) {
            $group            = $group->toArray();
            $group['package'] = json_decode($group['package'], true) ?: [];
        }

        return view()->with(compact('packages', 'group'));
    }
}