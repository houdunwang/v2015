<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\alipay;

require_once( "hdphp/alipay/lib/alipay_core.function.php" );
require_once( "hdphp/alipay/lib/alipay_md5.function.php" );

use hdphp\alipay\lib\AlipaySubmit;

/**
 * 支付宝
 * Class Alipay
 * @package Hdphp\Alipay
 * @author 向军
 */
class Alipay {
	public function pay( $data ) {
		//构造要请求的参数数组，无需改动
		$parameter = [
			"service"           => "create_direct_pay_by_user",
			"partner"           => C( 'alipay.partner' ),
			"seller_email"      => C( 'alipay.seller_email' ),
			"payment_type"      => C( 'alipay.payment_type' ),
			"notify_url"        => C( 'alipay.notify_url' ),
			"return_url"        => C( 'alipay.return_url' ),
			"out_trade_no"      => $data['out_trade_no'],
			"subject"           => $data['subject'],
			"total_fee"         => $data['total_fee'],
			"body"              => $data['body'],
			"show_url"          => $data['show_url'],
			"anti_phishing_key" => '',
			"exter_invoke_ip"   => '',
			"_input_charset"    => C( 'alipay.input_charset' )
		];

		//建立请求
		$alipaySubmit = new AlipaySubmit( C( 'alipay' ) );
		echo $alipaySubmit->buildRequestForm( $parameter, "get", "确认" );
	}
}