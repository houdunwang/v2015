<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests;


use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class DbTest extends Migrate
{
    /**
     * @test
     */
    public function base()
    {
        $d = Schema::getFields('news');
        $this->assertInternalType('array', $d);

        $d = Schema::getPrimaryKey('news');
        $this->assertEquals('id', $d);

        $d = Schema::repair('news');
        $this->assertTrue($d);

        $d = Schema::optimize('news');;
        $this->assertTrue($d);

        $d = Schema::getDataBaseSize('tests');
        $this->assertInternalType('int', $d);

        $d = Schema::getTableSize('news');
        $this->assertInternalType('int', $d);

        $d = Schema::lock('news,category');
        $this->assertTrue($d);

        $d = Schema::lock('news as u,category as m');;
        $this->assertTrue($d);

        $d = Schema::unlock();
        $this->assertTrue($d);

        $d = Schema::truncate('news');
        $this->assertTrue($d);

        $d = Schema::getAllTableInfo('tests');
        $this->assertInternalType('array', $d);

        $this->assertTrue(Schema::tableExists('news'));

        $this->assertTrue(Schema::fieldExists('title', 'news'));

        $this->assertTrue(Schema::dropField('news', 'id'));

        $this->assertTrue(Schema::drop('news'));
    }

    /**
     * @test
     */
    public function sql()
    {
        $this->assertTrue(Schema::drop('a1'));
        $this->assertTrue(Schema::drop('a2'));
        $sql
            = <<<EOF
	CREATE TABLE `a1` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`uid` int(11) NOT NULL COMMENT '会员id',
	`filename` varchar(300) NOT NULL COMMENT '文件名',
	`path` varchar(300) NOT NULL COMMENT '相对路径',
	`type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
	`createtime` int(10) NOT NULL COMMENT '上传时间',
	`size` mediumint(9) NOT NULL COMMENT '文件大小',
	`user_type` tinyint(1) DEFAULT NULL COMMENT '1 管理员 0 会员',
	PRIMARY KEY (`id`),
	KEY `uid` (`uid`)
	) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='附件';

	CREATE TABLE `a2` (
	`rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
	`name` varchar(45) DEFAULT NULL COMMENT '规则名称',
	`module` varchar(45) DEFAULT NULL COMMENT '模块名称',
	`rank` tinyint(3) unsigned DEFAULT NULL COMMENT '排序',
	`status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否禁用',
	PRIMARY KEY (`rid`),
	KEY `fk_hd_rule_hd_site1_idx` (`siteid`)
	) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='回复规则';
EOF;
        $this->assertTrue(Schema::sql($sql));
    }

    public function testMigrate()
    {
        $d = Schema::create(
            'users2',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title', 100);
                $table->tinyInteger('nums')->unsigned();
                $table->char('name', 30)->nullable()->defaults('后盾网')->comment(
                    '这是注释'
                );
                $table->timestamps();
            }
        );
        $this->assertTrue($d);
    }
}