※说明※

本demo仅仅为学习参考使用，请根据实际情况自行开发，把功能嵌入您的项目或平台中。

※运行环境※

PHP5.5及以上

※业务处理注意事项※

请配置notify_url文件、return_url文件，其中，notify_url文件主要是写入业务处理逻辑代码，请结合自身情况谨慎编写。

如何验证异步通知数据？

1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号

2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）

3、校验通知中的seller_id（或者seller_email) 是否为该笔交易对应的操作方（一个商户可能有多个seller_id/seller_email）

4、验证接口调用方的app_id


※Demo使用手册※
代码简要说明
pagepay
	buildermodel ---------- 对应的接口的bizcontent业务参数进行封装处理，且做了json转换，比字符串传参更佳方便。
	service->AlipayTradeService.php      ---------- 所有接口中使用的方法。


AlipayTradeService.php 文件内方法说明

1、SDK请求方法
aopclientRequestExecute($request,$ispage=false)
$request：对应接口请求的对象
$ispage：是否为页面跳转请求（手机网站支付和电脑网站支付必须为页面跳转，查询，退款则可以无需页面跳转）

2、电脑网站支付接口的方法
pagePay($builder,$return_url,$notify_url)
$builder：业务参数，使用buildmodel中的对象生成。
$return_url：同步跳转地址
$notify_url：异步通知地址

3、电脑网站查询接口
Query($builder)
$builder：业务参数，使用buildmodel中的对象生成。

4、电脑网站退款接口
Refund($builder)
$builder：业务参数，使用buildmodel中的对象生成。

5、电脑网站关闭接口
Close($builder)
$builder：业务参数，使用buildmodel中的对象生成。

6、电脑网站退款查询接口
refundQuery($builder)
$builder：业务参数，使用buildmodel中的对象生成。

7、支付宝返回的信息验签
check($arr)
$arr：收到的支付宝返回信息数组

8、打印日志
writeLog($text)
$text：要打印的字符串