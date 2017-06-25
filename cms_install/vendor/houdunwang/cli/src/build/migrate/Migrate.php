<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cli\build\migrate;

use houdunwang\cli\build\Base;
use houdunwang\config\Config;
use houdunwang\database\Schema;
use houdunwang\db\Db;

class Migrate extends Base
{
    protected $namespace;
    //当前执行的数据库中的编号
    protected static $batch;

    public function __construct()
    {
        $this->namespace = str_replace('/', '\\', self::$path['migration']);
        if ( ! Schema::tableExists('migrations')) {
            $sql = "CREATE TABLE ".Config::get('database.prefix')
                .'migrations(migration varchar(255) not null,batch int)CHARSET UTF8';
            Db::execute($sql);
        }
        if (empty(self::$batch)) {
            self::$batch = Db::table('migrations')->max('batch') ?: 0;
        }
    }

    //执行迁移
    public function make()
    {
        $files = glob(self::$path['migration'].'/*.php');
        sort($files);
        foreach ((array)$files as $file) {
            //只执行没有执行过的migration
            if ( ! Db::table('migrations')->where('migration', basename($file))
                ->first()
            ) {
                require $file;
                preg_match('@\d{12}_(.+)\.php@', $file, $name);
                $class = $this->namespace.'\\'.$name[1];
                (new $class)->up();
                Db::table('migrations')->insert(
                    [
                        'migration' => basename($file),
                        'batch'     => self::$batch + 1,
                    ]
                );
            }
        }
    }

    //回滚到上次迁移
    public function rollback()
    {
        $batch = Db::table('migrations')->max('batch');
        $files = Db::table('migrations')->where('batch', $batch)->lists(
            'migration'
        );
        foreach ((array)$files as $f) {
            $file = self::$path['migration'].'/'.$f;
            if (is_file($file)) {
                require $file;
                $class = $this->namespace.'\\'.substr($f, 13, -4);
                (new $class)->down();
            }
            Db::table('migrations')->where('migration', $f)->delete();
        }
    }

    //迁移重置
    public function reset()
    {
        $files = Db::table('migrations')->lists('migration');
        foreach ((array)$files as $f) {
            $file = self::$path['migration'].'/'.$f;
            if (is_file($file)) {
                require $file;
                $class = $this->namespace.'\\'.substr($f, 13, -4);
                (new $class)->down();
            }
            Db::table('migrations')->where('migration', $f)->delete();
        }
    }
}