<?php

namespace tests;

use houdunwang\config\Config;
use houdunwang\db\Db;
use PHPUnit\Framework\TestCase;

abstract class Migrate extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('config');
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