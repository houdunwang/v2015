<?php
require_once "lib/WxPay.Api.php";
require_once "example/WxPay.NativePay.php";

//模式二
/**
* 流程：
* 1、调用统一下单，取得code_url，生成二维码
* 2、用户扫描二维码，进行支付
* 3、支付完成之后，微信服务器会通知支付成功
* 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
*/
$input = new WxPayUnifiedOrder();
//设置商品或支付单简要描述
$input->SetBody("后盾人,人人做后盾");
//设置附加数据，在查询API和支付通知中原样返回
$input->SetAttach($_POST['orderId']);
//设置商户系统内部的订单号,32个字符内、可包含字母
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
//设置订单总金额，只能为整数,最小单位是分,我们需要通过获取到商品总价后,将价格转成分的单位
$input->SetTotal_fee("1");
//$input->SetTime_start(date("YmdHis"));
//$input->SetTime_expire(date("YmdHis", time() + 600));
//$input->SetGoods_tag("test");
//设置接收微信支付异步通知回调地址
$input->SetNotify_url("http://pay.hdphp.com/native/notify.php");
//设置取值如下：JSAPI，NATIVE，APP
$input->SetTrade_type("NATIVE");
//设置trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义。
$input->SetProduct_id($_POST['orderId']);
$notify = new NativePay();
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>微信支付 - 扫码支付</title>
    <link rel="stylesheet" href="./css/addOrder.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .main{
            width:70%;
            margin:0 auto;
        }
        .main img{
            width:100%;
        }
    </style>
</head>
<body>

<div class="main">
    <img src="./images/querenheader.png" alt="">
    <br><br>
    <div id="J-payMethod" class="main-container" style="text-align: center">
        <div id="J-rcPaymentDisabled"></div>
        <div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;text-align: center;">打开微信,扫码支付</div><br/>
        <img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/>
        <br>
    </div>
    <br>
    <img src="./images/footer.png" alt="">
</div>
<script>
    $(function () {
        setInterval(function () {
            $.ajax({
                url:'checkStatus.php',
                data:{orderId:<?php echo $_POST['orderId'] ?>},
                method:'post',
                dataType:'json',
                success:function (res) {
                    if(res.isPay == 1){
                        location.href = 'success.php';
                    }
                }
            })
        },3000)
    })
</script>
</body>
</html>