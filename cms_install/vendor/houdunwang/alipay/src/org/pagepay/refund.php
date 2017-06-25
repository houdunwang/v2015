<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>退款</title>
</head>
<?php

require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(__FILE__).'/service/AlipayTradeService.php';
require_once dirname(__FILE__).'/buildermodel/AlipayTradeRefundContentBuilder.php';

    //商户订单号，商户网站订单系统中唯一订单号
    $out_trade_no = trim($_POST['WIDTRout_trade_no']);

    //支付宝交易号
    $trade_no = trim($_POST['WIDTRtrade_no']);
    //请二选一设置

    //需要退款的金额，该金额不能大于订单金额，必填
    $refund_amount = trim($_POST['WIDTRrefund_amount']);

    //退款的原因说明
    $refund_reason = trim($_POST['WIDTRrefund_reason']);

    //标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传
    $out_request_no = trim($_POST['WIDTRout_request_no']);

    //构造参数
	$RequestBuilder=new AlipayTradeRefundContentBuilder();
	$RequestBuilder->setOutTradeNo($out_trade_no);
	$RequestBuilder->setTradeNo($trade_no);
	$RequestBuilder->setRefundAmount($refund_amount);
	$RequestBuilder->setOutRequestNo($out_request_no);
	$RequestBuilder->setRefundReason($refund_reason);

	$aop = new AlipayTradeService($config);
	
	/**
	 * alipay.trade.refund (统一收单交易退款接口)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	$response = $aop->Refund($RequestBuilder);
	var_dump($response);;
?>
</body>
</html>