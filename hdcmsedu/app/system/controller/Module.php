<?php namespace app\system\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use app\system\controller\part\Domain;
use Carbon\Carbon;
use houdunwang\request\Request;
use system\model\Modules;
use system\model\Package;
use system\model\Site;
use houdunwang\zip\Zip;
use houdunwang\file\File;
use houdunwang\dir\Dir;

/**
 * 模块管理
 * Class Module
 *
 * @package app\system\controller
 */
class Module extends Admin
{
    public function __construct()
    {
        $this->superUserAuth();
    }

    /**
     * 将本地开发模块生成压缩包
     */
    public function createZip()
    {
        $name = Request::get('name');
        $dir  = "addons/{$name}";
        $zip  = $name . ".zip";
        //设置编译时间
        $config          = json_decode(file_get_contents("{$dir}/package.json"), true);
        $config['build'] = Carbon::now()->toDateTimeString();
        file_put_contents($dir . '/package.json',
            json_encode($config, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        //压缩文件
        Zip::create($zip, ["addons/{$name}"]);
        File::download($zip, $zip);
        @unlink($zip);
    }

    /**
     * 已经安装模块
     *
     * @param \system\model\Modules $db
     *
     * @return mixed
     */
    public function installed(Modules $db)
    {
        $modules = $db->getSystemAllModules();

        return view()->with(compact('modules'));
    }

    /**
     * 安装新模块列表
     *
     * @return mixed
     */
    public function prepared()
    {
        $modules = Modules::lists('name');
        //本地模块
        $locality = [];
        foreach (Dir::tree('addons') as $d) {
            if ($d['type'] == 'dir' && is_file($d['path'] . '/package.json')) {
                $config = json_decode(file_get_contents($d['path'] . '/package.json'), true);
                //去除已经安装的模块和远程模块
                if ( ! in_array($config['name'], $modules)
                     && ! is_file($d['path'] . '/cloud.php')) {
                    $locality[$config['name']] = $config;
                }
            }
        }

        return view()->with('locality', $locality);
    }


    /**
     * 根据新配置更新模块
     *
     * @return array
     */
    public function update()
    {
        $module = Request::get('module');
        //初始化模块数据
        Modules::initModuleData($module);

        return $this->success('模块更新成功');
    }

    /**
     * 重新设计模块
     *
     * @param \system\model\Modules $module
     *
     * @return array|mixed|string
     * @throws \Exception
     */
    public function resetDesign(Modules $module)
    {
        $name = Request::get('module');
        if (IS_POST) {
            $data = json_decode(Request::post('data'), true);
            $res  = $module->design($data);
            if ($module->isInstall($name)) {
                $module->initModuleData($data['name']);
            }
            if ($res !== true) {
                return message($res);
            }

            return $this->success('模块配置更新成功');
        }
        $json   = file_get_contents("addons/{$name}/package.json");
        $config = json_decode($json, true);
        if (empty($config['web']['entry'])) {
            $config['web']['entry'] = ['title' => '', 'do' => '', 'params' => ''];
        }
        $config['preview'] = 'addons/' . $config['name'] . '/' . $config['preview'];

        return view()->with('config', json_encode($config, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 设计新模块
     *
     * @param \system\model\Modules $Module
     *
     * @return mixed|string
     */
    public function design(Modules $Module)
    {
        if (IS_POST) {
            $data = json_decode(Request::post('data'), true);
            $res  = $Module->design($data);
            if ($res !== true) {
                return message($res, '', 'error');
            }

            return message('模块创建成功', 'prepared');
        }

        return view();
    }

    /**
     * 安装模块
     *
     * @param \system\model\Modules $Module
     * @param \system\model\Package $package
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function install(Modules $Module, Package $package)
    {
        $name = Request::get('module');
        if (IS_POST) {
            //安装模块
            $res = $Module->install($name);
            if ($res !== true) {
                return message($res, 'prepared', 'info');
            }
            //在服务套餐中添加模块
            $package->addModuleToPackage(Request::post('package', []), [$name]);
            Site::updateAllCache();

            return message("模块安装成功", 'installed');
        }
        //获取模块xml数据
        $config  = json_decode(file_get_contents("addons/{$name}/package.json"), true);
        $package = $package->get();

        return view()->with(compact('config', 'package'));
    }

    /**
     * 卸载模块
     *
     * @param \system\model\Modules $module
     *
     * @return mixed|string
     */
    public function uninstall(Modules $module)
    {
        $name = Request::get('name');
        if ($module->remove($name) === false) {
            return message($module->getError(), '', 'error');
        }

        return message('模块删除成功');
    }
}