<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>交易查询</title>
</head>
<?php

require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(__FILE__).'/service/AlipayTradeService.php';
require_once dirname(__FILE__).'/buildermodel/AlipayTradeQueryContentBuilder.php';

    //商户订单号，商户网站订单系统中唯一订单号
    $out_trade_no = trim($_POST['WIDTQout_trade_no']);

    //支付宝交易号
    $trade_no = trim($_POST['WIDTQtrade_no']);
    //请二选一设置
    //构造参数
	$RequestBuilder = new AlipayTradeQueryContentBuilder();
	$RequestBuilder->setOutTradeNo($out_trade_no);
	$RequestBuilder->setTradeNo($trade_no);

	$aop = new AlipayTradeService($config);
	
	/**
	 * alipay.trade.query (统一收单线下交易查询)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
 	 */
	$response = $aop->Query($RequestBuilder);
	var_dump($response);
?>
</body>
</html>