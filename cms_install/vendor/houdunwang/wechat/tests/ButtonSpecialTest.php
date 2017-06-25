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
 * 个性菜单
 * Class ButtonSpecial
 *
 * @package tests
 */
class ButtonSpecialTest extends Common
{
    /**
     * 创建菜单
     */
    public function test_createAddconditional()
    {
        $data = [
            'button'    => [
                [
                    'type' => 'click',
                    'name' => '今日歌曲',
                    'key'  => 'V1001_TODAY_MUSIC',
                ],
                [
                    'name'       => '菜单',
                    'sub_button' =>
                        [
                            [
                                'type' => 'view',
                                'name' => '搜索',
                                'url'  => 'http://www.soso.com/',
                            ],
                        ],
                ],
            ],
            'matchrule' => [
                'tag_id'               => '2',
                'sex'                  => '1',
                'country'              => '中国',
                'province'             => '广东',
                'city'                 => '广州',
                'client_platform_type' => '2',
                'language'             => 'zh_CN',
            ],
        ];
        $button  = WeChat::instance('button')->createSpecialButton($data);
        $this->assertArrayHasKey('menuid', $button);

        $res = WeChat::instance('button')->trySpecialButton('houdunwangxj');
        $this->assertArrayHasKey('menu', $res);

        //删除个性菜单
        $res = WeChat::instance('button')->delSpecialButton($button['menuid']);
        $this->assertEquals($res['errmsg'], 'ok');
    }
}