<?php namespace app\system\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use houdunwang\cli\Cli;
use houdunwang\request\Request;
use system\model\Cloud as CloudModel;

/**
 * 云帐号管理
 * Class Cloud
 *
 * @package app\system\controller
 */
class Cloud extends Admin
{
    public function __construct()
    {
        $this->superUserAuth();
    }

    /**
     * 绑定云帐号
     * 这是进行系统更新的前提
     *
     * @return mixed|string
     */
    public function account()
    {
        if (IS_POST) {
            $data           = json_decode(Request::post('data'), true);
            $data['weburl'] = root_url();

            return CloudModel::connect($data);
        }
        $field = CloudModel::find(1)->toArray();
        if (empty($field['secret'])) {
            $field['secret'] = md5(time().mt_rand(1, 9999));
        }
        $field['password'] = '';

        return view()->with('field', $field);
    }

    /**
     * 检测有没有新版本
     *
     * @return array
     */
    public function getUpgradeVersion()
    {
        return CloudModel::getUpgradeVersion();
    }

    /**
     * 更新HDCMS
     *
     * @return array|mixed|string
     */
    public function upgrade()
    {
        switch (Request::get('action')) {
            case 'download':
                return view('download');
            case 'downloadFile':
                //下载更新包
                return CloudModel::downloadUpgradeVersion();
            case 'sql':
                //更新SQL
                if (IS_POST) {
                    if ($this->updateDatabase() !== true) {
                        return ['valid' => 0, 'message' => Cli::getError()];
                    }

                    return ['valid' => 1, 'message' => '数据表更新成功'];
                }

                return view('updateSql');
            case 'finish':
                $this->updateVersionInfo();

                return message('恭喜! 系统更新完成', 'upgrade', 'success');
            default:
                //获取更新版本
                $upgrade = CloudModel::getUpgradeVersion();
                //获取系统公告
                $systemNotice = CloudModel::getSystemNotice();
                //当前版本
                $current = CloudModel::find(1);
                //更新列表
                $upgradeLists = CloudModel::getUpgradeList();

                return view('', compact('upgrade', 'current', 'upgradeLists', 'systemNotice'));
        }
    }

    /**
     * 更新版本信息
     *
     * @return bool
     */
    protected function updateVersionInfo()
    {
        if (is_file('version.php')) {
            $version = include 'version.php';
            Db::table('cloud')->where('id', 1)->update(['build' => $version['build'], 'version' => $version['version'],]);
            CloudModel::updateHDownloadNum();
        }

        return true;
    }

    /**
     * 执行数据库与初始数据操作
     *
     * @return bool
     */
    protected function updateDatabase()
    {
        if ( ! Cli::call('hd migrate:make')) {
            return false;
        }
        if ( ! Cli::call('hd seed:make')) {
            return false;
        }

        return true;
    }

    /**
     * 手动下载压缩包更新
     */
    public function localUpdate()
    {
        if ($this->updateDatabase() !== true) {
            die('更新数据表失败');
        }
        //更新数据表
        $this->updateVersionInfo();
        die('更新成功');
    }
}