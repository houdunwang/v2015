<?php namespace app\system\controller;

use system\model\Cloud;

/**
 * 应用商店
 * Class Shop
 *
 * @package app\system\controller
 */
class Shop extends Admin
{
    /**
     * 构造函数
     * Shop constructor.
     */
    public function __construct()
    {
        $this->superUserAuth();
        if (Cloud::checkAccount() == false) {
            die($this->error('请先绑定云帐号后执行操作'));
        }
    }

    /**
     * 应用商店
     *
     * @return array|mixed
     */
    public function lists()
    {
        return view();
    }

    /**
     * 远程获取应用列表
     *
     * @return array
     */
    public function getAppList()
    {
        return Cloud::apps(Request::get('type'), Request::get('page')) ?: [];
    }

    /**
     * 已购应用
     *
     * @return array|mixed
     */
    public function buy()
    {
        if (IS_POST) {
            //远程获取已经购买的应用列表
            return Cloud::apps(Request::get('type'), Request::get('page'), 'buy') ?: [];
        }

        return view();
    }

    /**
     * 更新模块列表
     *
     * @return mixed
     */
    public function upgradeLists()
    {
        return view('upgradeLists');
    }

    /**
     * 获取模块更新列表
     *
     * @return array|bool|mixed
     */
    public function getModuleUpgradeLists()
    {
        return Cloud::getModuleUpgradeLists();
    }

    /**
     * 根据编号更新模块
     * 模板不能更新
     *
     * @return mixed|void
     */
    public function upgrade()
    {
        if (IS_POST) {
            return Cloud::upgradeModuleByName(Request::get('name'));
        }

        return view();
    }

    /**
     * 安装云模块/模板
     *
     * @return array|mixed
     */
    public function install()
    {
        return Cloud::downloadApp(Request::get('type'), Request::get('module'));
    }
}