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
 * Class UserTest
 *
 * @package tests
 */
class UserTest extends Common
{
    /**
     * 修改备注
     */
    public function test_remark()
    {
        $data = [
            //用户标识
            "openid" => "oGiQGuNCkJCTsc_t61XTrqbyY3rM",
            //新的备注名，长度必须小于30字符
            "remark" => "向军老师",
        ];
        $res  = WeChat::instance('user')->setRemark($data);
        $this->assertEquals(0, $res['errcode']);
    }

    /**
     *
     */
    public function test_getUserInfo()
    {
        //openid:普通用户的标识，对当前公众号唯一
        $openid = 'oGiQGuNCkJCTsc_t61XTrqbyY3rM';
        $user   = WeChat::instance('user')->getUserInfo($openid);
        $this->assertArrayHasKey('openid', $user);
    }

    /**
     * 批量获取用户基本信息
     */
    public function test_getUserInfoLists()
    {
        $data = [
            "user_list" => [
                [
                    "openid" => "oGiQGuNCkJCTsc_t61XTrqbyY3rM",
                    "lang"   => "zh-CN",
                ],
            ],
        ];
        $user = WeChat::instance('user')->getUserInfoLists($data);
        $this->assertArrayHasKey('user_info_list', $user);
    }

    /**
     *
     */
    public function test_getUserLists()
    {
        $user = WeChat::instance('user')->getUserLists();
        $this->assertArrayHasKey('total', $user);
        //从上次拉取最后一个用户摘取
        $user = WeChat::instance('user')->getUserLists($user['next_openid']);
        $this->assertArrayHasKey('total', $user);
    }

    /**
     * 获取黑名单列表
     */
    public function test_getblacklist()
    {
        $user = WeChat::instance('user')->getblacklist();
        $this->assertArrayHasKey('total', $user);
    }

    /**
     * 拉黑用户
     */
    public function test_batchBlackList()
    {
        $openids = ['oGiQGuNCkJCTsc_t61XTrqbyY3rM'];
        $user    = WeChat::instance('user')->batchBlackList($openids);
        $this->assertEquals('ok', $user['errmsg']);
    }

    /**
     * 取消拉黑用户
     */
    public function test_batchUnBlackList()
    {
        $openids = ['oGiQGuNCkJCTsc_t61XTrqbyY3rM'];
        $user    = WeChat::instance('user')->batchUnBlackList($openids);
        $this->assertEquals('ok', $user['errmsg']);
    }
}