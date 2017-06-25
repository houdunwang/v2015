<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\alipay\service;

use houdunwang\config\Config;

require_once dirname(__FILE__).'/../org/pagepay/service/AlipayTradeService.php';
require_once dirname(__FILE__).'/../org/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

/**
 * 桌面端支付
 * Trait PagePay
 *
 * @package houdunwang\alipay\service
 */
trait PagePayService
{
    /**
     * 桌面支付
     *
     * @param $data
     */
    public function PagePay($data)
    {
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($data['WIDout_trade_no']);

        //订单名称，必填
        $subject = trim($data['WIDsubject']);

        //付款金额，必填
        $total_amount = trim($data['WIDtotal_amount']);

        //商品描述，可空
        $body = trim($data['WIDbody']);

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService(Config::get('alipay'));

        /**
         * pagePay 电脑网站支付请求
         *
         * @param $builder    业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         *
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder, Config::get('alipay.return_url'), Config::get('alipay.notify_url'));
        //输出表单
        var_dump($response);
    }
}