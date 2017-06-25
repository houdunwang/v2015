<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>退款查询</title>
</head>
<?php

require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(__FILE__).'/service/AlipayTradeService.php';
require_once dirname(__FILE__).'/buildermodel/AlipayTradeFastpayRefundQueryContentBuilder.php';

    //商户订单号，商户网站订单系统中唯一订单号
    $out_trade_no = trim($_POST['WIDRQout_trade_no']);

    //支付宝交易号
    $trade_no = trim($_POST['WIDRQtrade_no']);
    //请二选一设置

    //请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号，必填
    $out_request_no = trim($_POST['WIDRQout_request_no']);

    //构造参数
	$RequestBuilder=new AlipayTradeFastpayRefundQueryContentBuilder();
	$RequestBuilder->setOutTradeNo($out_trade_no);
	$RequestBuilder->setTradeNo($trade_no);
	$RequestBuilder->setOutRequestNo($out_request_no);

	$aop = new AlipayTradeService($config);
	
	/**
	 * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	$response = $aop->refundQuery($RequestBuilder);
	var_dump($response);
?>
</body>
</html>