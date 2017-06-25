<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cli\build\seed;

use houdunwang\cli\build\Base;
use houdunwang\database\Schema;
use houdunwang\db\Db;

class Seed extends Base
{
    protected static $batch;
    protected $namespace;

    public function __construct()
    {
        $this->namespace = str_replace('/', '\\', self::$path['seed']);
        //创建migration表用于记录动作
        if ( ! Schema::tableExists('seeds')) {
            $sql = "CREATE TABLE ".c('database.prefix')
                .'seeds(seed varchar(255) not null,batch int)CHARSET UTF8';
            Db::execute($sql);
        }
        if (empty(self::$batch)) {
            self::$batch = Db::table('seeds')->max('batch') ?: 0;
        }
    }

    //运行数据填充
    public function make()
    {
        $files = glob(self::$path['seed'].'/*.php');
        sort($files);
        foreach ((array)$files as $file) {
            //只执行没有执行过的migration
            if ( ! Db::table('seeds')->where('seed', basename($file))->first()
            ) {
                require $file;
                preg_match('@\d{12}_(.+)\.php@', $file, $name);
                $class = $this->namespace.'\\'.$name[1];
                (new $class)->up();
                Db::table('seeds')->insert(
                    ['seed' => basename($file), 'batch' => self::$batch + 1]
                );
            }
        }
    }

    //回滚所有的数据填充
    public function reset()
    {
        $files = Db::table('seeds')->lists('seed');
        foreach ((array)$files as $f) {
            $file = self::$path['seed'].'/'.$f;
            if (is_file($file)) {
                require $file;
                $class = $this->namespace.'\\'.substr($f, 13, -4);
                (new $class)->down();
            }
            Db::table('seeds')->where('seed', $f)->delete();
        }
    }

    //回滚最近一次填充
    public function rollback()
    {
        $batch = Db::table('seeds')->max('batch');
        $files = Db::table('seeds')->where('batch', $batch)->lists('seed');
        foreach ((array)$files as $f) {
            $file = self::$path['seed'].'/'.$f;
            if (is_file($file)) {
                require $file;
                $class = $this->namespace.'\\'.substr($f, 13, -4);
                (new $class)->down();
            }
            Db::table('seeds')->where('seed', $f)->delete();
        }
    }
}