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

use houdunwang\wechat\WeChat;

/**
 * 菜单管理
 * Class ButtonTest
 *
 * @package tests
 */
class ButtonTest extends Common
{

    /**
     * 删除菜单
     */
    public function test_flush()
    {
        $res = WeChat::instance('button')->flush();
        $this->assertEquals('ok', $res['errmsg']);
    }

    /**
     * 创建菜单
     */
    public function test_create()
    {
        $button = [
            'button' => [
                [
                    'type' => 'click',
                    'name' => '后盾框架',
                    'key'  => 'hdphp',
                ],
                [
                    'name'       => 'scope',
                    'sub_button' => [
                        [
                            'type' => 'view',
                            'name' => '不用确认',
                            'url'  => 'http://dev.hdcms.com/component/wechat/tests/app/App.php?action=snsapiBase',
                        ],
                        [
                            'type' => 'view',
                            'name' => '需要确认',
                            'url'  => 'http://dev.hdcms.com/component/wechat/tests/app/App.php?action=snsapiUserinfo',
                        ],
                    ],
                ],
                [
                    'name'       => '后盾',
                    'sub_button' => [
                        [
                            'type' => 'view',
                            'name' => '后盾网',
                            'url'  => 'http://www.houdunwang.com/',
                        ],
                        [
                            'type' => 'view',
                            'name' => '后盾人',
                            'url'  => 'http://www.houdunren.com/',
                        ],
                    ],
                ],
            ],
        ];
        $res    = WeChat::instance('button')->create($button);
        $this->assertEquals($res['errmsg'], 'ok');
    }

    /**
     * 查询菜单
     */
    public function test_query()
    {
        $res = WeChat::instance('button')->query();
        $this->assertArrayHasKey('menu', $res);
    }

    /**
     * 获取自定义菜单配置接口
     */
    public function test_getCurrentSelfMenuInfo()
    {
        $res = WeChat::instance('button')->getCurrentSelfMenuInfo();
        $this->assertArrayHasKey('is_menu_open', $res);
    }
}