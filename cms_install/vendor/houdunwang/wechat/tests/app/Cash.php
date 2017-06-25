<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\app;

use houdunwang\wechat\WeChat;

/**
 * 发送红包
 * Trait Cash
 *
 * @package tests\app
 */
trait Cash
{
    /**
     * 发红包
     */
    public function sendRedPack()
    {
        $data = [
            //商户名称
            'send_name'    => '后盾网HDCMS',
            //付款金额,单位分,必须大于1元小于200元
            'total_amount' => 100,
            //红包发放总人数
            'total_num'    => '1',
            //红包祝福语
            'wishing'      => '恭喜发财',
            //活动名称
            'act_name'     => '开学红包',
            //红包祝福语
            'wishing'      => '祝同学们学业有成,心想事成',
            //备注
            'remark'       => '新班开课红包鼓励',
        ];
        //用户openid
        $user              = WeChat::instance('oauth')->snsapiBase();
        $data['re_openid'] = $user['openid'];
        $res               = WeChat::instance('cash')->sendRedPack($data);
        file_put_contents('a.php',var_export($res,true));
        if ($res['return_code'] == 'SUCCESS'
            && $res['result_code'] == 'SUCCESS'
        ) {
            echo '红包发送成功';
        }
    }
}