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
 * 客服接口
 * Class customerTest
 *
 * @package tests
 */
class CustomerTest extends Common
{
    /**
     * 添加客服
     */
    public function test_add()
    {
        $data = [
            'kf_account' => 'hdxj@aihoudun',
            'nickname'   => '向军',
            'password'   => md5('admin888'),
        ];
        $res  = WeChat::instance('CustomService')->addCustomer($data);
        $this->assertTrue(in_array($res['errmsg'], [0, '65406']));

        $data = [
            'kf_account' => 'xj@aihoudun',
            'nickname'   => '测试客服',
            'password'   => md5('admin888'),
        ];
        $res  = WeChat::instance('CustomService')->addCustomer($data);
        $this->assertTrue(in_array($res['errmsg'], [0, '65406']));
    }

    /**
     * 更新客服
     */
    public function test_update()
    {
        $data = [
            //完整客服账号，格式为：账号前缀@公众号微信号
            'kf_account' => 'xj@aihoudun',
            'nickname'   => '客服',
            'password'   => md5('admin888'),
        ];
        $res  = WeChat::instance('CustomService')->updateCustomer($data);
        $this->assertEquals('ok', $res['errmsg']);
    }

    /**
     * 删除客服
     */
    public function test_del()
    {
        $res = WeChat::instance('CustomService')->delCustomer('xj@aihoudun');
        $this->assertEquals('ok', $res['errmsg']);
    }

    /**
     * 设置客服帐号的头像
     */
    public function test_upload_icon()
    {
        $data = [
            'kf_account' => 'hdxj@aihoudun',
            'file'       => 'tests/images/user.jpg',
        ];
        $res  = WeChat::instance('CustomService')->uploadheadimg($data);
        $this->assertEquals('ok', $res['errmsg']);
    }

    /**
     * 获取所有客服账号
     */
    public function test_get_kf_lists()
    {
        $res = WeChat::instance('CustomService')->getkflist();
        $this->assertArrayHasKey('kf_list', $res);
    }
}