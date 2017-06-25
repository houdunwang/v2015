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


use houdunwang\db\Db;
use PHPUnit\Framework\TestCase;
use tests\joinModels\ModelJoinNews;
use tests\joinModels\ModelJoinUser;

class JoinTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Db::execute('truncate model_join_user');
        Db::execute('truncate model_join_address');
        Db::execute('truncate model_join_news');
        Db::execute('truncate model_join_group');
        Db::execute('truncate model_join_user_group');
        $data = [
            ['username' => '刘德华'],
            ['username' => '郭富城'],
        ];
        foreach ($data as $d) {
            Db::table('model_join_user')->insert($d);
        }

        $data = [
            ['title' => '锤子手机发布', 'user_id' => 1],
            ['title' => 'BMW汽车', 'user_id' => 2],
            ['title' => '后盾人官网上线', 'user_id' => 1],
        ];
        foreach ($data as $d) {
            Db::table('model_join_news')->insert($d);
        }

        $data = [
            ['address' => '朝阳区', 'user_id' => 1],
            ['address' => '海淀区', 'user_id' => 2],
        ];
        foreach ($data as $d) {
            Db::table('model_join_address')->insert($d);
        }

        $data = [
            ['name' => '普通会员'],
            ['name' => 'VIP会员'],
        ];
        foreach ($data as $d) {
            Db::table('model_join_group')->insert($d);
        }

        $data = [
            ['user_id' => 1, 'group_id' => 2],
            ['user_id' => 2, 'group_id' => 1],
        ];
        foreach ($data as $d) {
            Db::table('model_join_user_group')->insert($d);
        }
    }

    public function test_has_one()
    {
        $user    = ModelJoinUser::find(1);
        $address = $user->address();
        $this->assertEquals('朝阳区', $address['address']);
    }

    public function test_has_many()
    {
        $user = ModelJoinUser::find(2);
        $news = $user->news();
        $this->assertEquals('BMW汽车', $news[0]['title']);
    }

    public function test_belongsTo()
    {
        $news = ModelJoinNews::find(2);
        $this->assertEquals('郭富城', $news->user->username);
    }

    public function test_belongsToMany()
    {
        $user  = ModelJoinUser::find(1);
        $group = $user->group;
        $this->assertEquals($group[0]->name, 'VIP会员');
    }
}