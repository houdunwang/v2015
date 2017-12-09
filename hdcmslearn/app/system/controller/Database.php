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
use system\model\Modules;

/**
 * 模块数据表设置
 * Class Database
 *
 * @package app\system\controller
 */
class Database extends Admin
{
    /**
     * @var
     */
    protected $module;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->superUserAuth();
        $this->module = Request::get('name');
        Cli::setPath([
            'migration' => "addons/{$this->module}/database/migrations",
            'seed'      => "addons/{$this->module}/database/seeds",
        ]);
    }

    /**
     * @param \system\model\Modules $Module
     *
     * @return mixed|string
     */
    public function table(Modules $Module)
    {
        if ( ! $Module->isLocalModule($this->module)) {
            return message('模块不存在', '', 'error');
        }

        return view('database/table');
    }

    /**
     * 创建新表迁移文件
     *
     * @return mixed|string
     */
    public function createMigrate()
    {
        $data = json_decode(Request::post('data'), true);
        if ( ! preg_match('/^[a-z_]+$/i', $data['migrate_table'])) {
            return message('表名必须为小写英文字母或下划线', '', 'info');
        }
        $table = $this->module.'_'.$data['migrate_table'];
        $file  = $table.'_create';
        if (Schema::tableExists($table)) {
            return message('数据表已经存在', '', 'error');
        }
        $cli = "hd make:migration {$file} --create={$table}";
        if (Cli::call($cli) === false) {
            return message(Cli::getError(), '', 'error');
        }

        return message('迁移文件创建成功');
    }

    /**
     * 创建字段迁移文件
     *
     * @return mixed|string
     */
    public function fieldMigrate()
    {
        $data = json_decode(Request::post('data'), true);
        if ( ! preg_match('/^[a-z_]+$/i', $data['migrate_table'])) {
            return message('表名必须为小写英文字母');
        }
        $table = $this->module.'_'.$data['migrate_table'];
        $file  = $table.'_field';
        $cli   = "hd make:migration {$file} --table={$table}";
        if (Cli::call($cli) === false) {
            return message(Cli::getError(), '', 'error');
        }

        return message('迁移文件创建成功');
    }

    /**
     * 执行迁移
     *
     * @param \system\model\Modules $Module
     *
     * @return mixed|string
     */
    public function makeMigrate(Modules $Module)
    {
        if ($Module->migrateMake($this->module) === false) {
            return message($Module->getError(), '', 'error');
        }

        return message('迁移文件扫行完毕');
    }

    /**
     * 重置迁移
     *
     * @param \system\model\Modules $Module
     *
     * @return mixed|string
     */
    public function resetMigrate(Modules $Module)
    {
        $Module->migrateReset($this->module);

        return message('重置迁移完毕');
    }

    /**
     * 创建填充文件
     *
     * @return mixed|string
     */
    public function createSeed()
    {
        $data = json_decode(Request::post('data'), true);
        if ( ! preg_match('/^[a-z_]+$/i', $data['seed_table'])) {
            return message('表名必须为小写字母或下划线', '', 'info');
        }
        $table = $this->module.'_'.$data['seed_table'].'_'.date("ymdhis");
        $cli   = "hd make:seed {$table}";
        if (Cli::call($cli) === false) {
            return message(Cli::getError(), '', 'error');
        }

        return message('填充文件创建成功');
    }

    /**
     * 执行数据填充
     *
     * @param \system\model\Modules $model
     *
     * @return mixed|string
     */
    public function makeSeed(Modules $model)
    {
        if ($model->seedsMake($this->module) === false) {
            return message($model->getError(), '', 'error');
        }

        return message('数据填充扫行完毕');
    }

    /**
     * 重置数据填充
     *
     * @return mixed|string
     */
    public function resetSeed()
    {
        foreach (glob("addons/{$this->module}/database/seeds/*") as $file) {
            $info = pathinfo($file);
            require $file;
            $namespace = "addons\\{$this->module}\\database\seeds";
            $class     = $namespace.'\\'.substr($info['basename'], 13, -4);
            (new $class)->down();

            Db::table('seeds')->where('seed', $info['basename'])->delete();
        }

        return message('数据填充重置完毕');
    }
}