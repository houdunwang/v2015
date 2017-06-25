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


use houdunwang\qrcode\QrCode;
use houdunwang\wechat\WeChat;

/**
 * 微信支付
 * Trait Pay
 *
 * @package tests\app
 */
trait Pay
{
    /**
     * 公众号支付
     */
    public function jsPay()
    {
        $orderNum = time();
        $data     = [
            'total_fee'    => 1,
            'body'         => '会员充值',
            'attach'       => 'uid=1&city=北京',
            'out_trade_no' => $orderNum,
            'notify_url'   => 'http://dev.hdcms.com/component/wechat/tests/app/notifyUrl.php',
        ];
        $res      = WeChat::instance('pay')->jsapi($data);
        if ($res['errcode'] == 'SUCCESS') {
            echo "支付成功:商城定单号:{$res['out_trade_no']},并为用户显示成功页面";
        } else {
            echo "支付错误: ".$res['errmsg'];
        }
    }

    /**
     * 扫码支付
     */
    public function payByCode()
    {
        print_r($_SERVER);die;
        $data = [
            //订单总金额，单位为分
            'total_fee'    => 1,
            //商品简单描述
            'body'         => '扫码支付',
            //附加数据，在查询API和支付异步通知中原样返回，可作为自定义参数使用
            'attach'       => 'uid=1&city=扫码',
            //商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
            'out_trade_no' => time(),
            //异步接收微信支付结果通知的回调地址，通知url必须为外网可访问的url，不能携带参数。
            'notify_url'   => 'http://dev.hdcms.com/component/wechat/tests/app/notifyUrl.php',
        ];

        $res = WeChat::instance('pay')->payByCode($data);
        if (isset($res['code_url']) && $res['result_code'] == 'SUCCESS') {
            //创建二维码
            $img = QrCode::make($res['code_url']);
            die("<img src='{$img}'>");
        } else {
            echo "支付错误: ".$res['errmsg'];
        }
    }

    /**
     * 查询定单
     */
    public function orderQuery()
    {
        //测试查询定单
        $data = [
            'out_trade_no' => 1494906587,
        ];
        $res  = WeChat::instance('pay')->orderQuery($data);
        if ($res['return_code'] == 'SUCCESS'
            && $res['result_code'] == 'SUCCESS'
        ) {
            //定单查询成功
            print_r($res);
        }
    }
}