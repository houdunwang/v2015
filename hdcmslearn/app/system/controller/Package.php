<?php namespace app\system\controller;

use system\model\Package as PackageModel;
use system\model\User;

/**
 * 套餐管理
 * Class Package
 *
 * @package app\system\controller
 */
class Package extends Admin
{
    public function __construct()
    {
        $this->superUserAuth();
    }

    /**
     * 套餐列表
     *
     * @param \system\model\Package $model
     *
     * @return mixed
     */
    public function lists(PackageModel $model)
    {
        $packages = $model::get();
        $packages = $packages ? $packages->toArray() : [];
        foreach ($packages as $k => $v) {
            //套餐模块
            $modules                 = json_decode($v['modules']) ?: [];
            $packages[$k]['modules'] = $modules ? Db::table('modules')->whereIn('name', $modules)->lists('title') : [];
            //套餐模板
            $templates                = json_decode($v['template']) ?: [];
            $packages[$k]['template'] = $templates ? Db::table('template')->whereIn('name', $templates)->lists('title') : [];
        }
        return view()->with('data', $packages);
    }

    /**
     * 编辑&添加套餐
     *
     * @return mixed
     */
    public function post()
    {
        //套餐编号
        $id = Request::get('id');
        if (IS_POST) {
            $model             = $id ? PackageModel::find($id) : new PackageModel();
            $model['name']     = Request::post('name');
            $model['modules']  = Request::post('modules');
            $model['template'] = Request::post('template');
            $model->save();

            return message('套餐更新成功');
        }
        //编辑时获取套餐
        if ($id) {
            $package = PackageModel::find($id);
            $package = $package->toArray();
            $package['modules']  = json_decode($package['modules'], true) ?: [];
            $package['template'] = json_decode($package['template'], true) ?: [];
        }
        $modules   = Db::table('modules')->orderBy('is_system', 'DESC')->get();
        $templates = Db::table('template')->orderBy('is_system', 'DESC')->get();

        return view('', compact('modules', 'templates', 'package'));
    }

    /**
     * 删除套餐
     *
     * @param \system\model\Package $package
     *
     * @return mixed|string
     */
    public function remove(PackageModel $package)
    {
        foreach ((array)Request::post('id') as $id) {
            $package->remove($id);
        }

        return message('删除套餐成功');
    }
}