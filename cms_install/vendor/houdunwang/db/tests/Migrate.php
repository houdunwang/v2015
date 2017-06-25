<?php

namespace tests;

use houdunwang\db\Db;
use PHPUnit\Framework\TestCase;

abstract class Migrate extends TestCase
{
    protected $config
        = [
            //缓存表字段
            'cache_field' => true,
            //表字段缓存目录
            'cache_dir'   => 'storage/field',
            //读库列表
            'read'        => [],
            //写库列表
            'write'       => [],
            //开启读写分离
            'proxy'       => false,
            //主机
            'host'        => 'localhost',
            //类型
            'driver'      => 'mysql',
            //帐号
            'user'        => 'root',
            //密码
            'password'    => 'admin888',
            //数据库
            'database'    => 'tests',
            //表前缀
            'prefix'      => '',
        ];

    public function setUp()
    {
        parent::setUp();
        \houdunwang\config\Config::set('database', $this->config);
        $this->Migrate();
    }

    protected function Migrate()
    {
        Db::execute('drop table if exists news');
        $sql
            = <<<str
CREATE TABLE if not exists `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '',
  `click` int DEFAULT 0,
  `category_id` int default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
str;
        Db::execute($sql);

        //栏目表
        Db::execute('drop table if exists category');
        $sql
            = <<<str
CREATE TABLE if not exists `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
str;
        Db::execute($sql);
        $data = [
            ['title' => 'hdphp', 'click' => 1, 'category_cid' => 1],
            ['title' => 'hdcms', 'click' => 2, 'category_cid' => 2],
            ['title' => '后盾网', 'click' => 3, 'category_cid' => 1],
        ];
        foreach ($data as $d) {
            Db::table('news')->insert($d);
        }

        $data = [
            ['catname' => '新闻'],
            ['catname' => '汽车'],
        ];
        foreach ($data as $d) {
            Db::table('category')->insert($d);
        }
    }
}