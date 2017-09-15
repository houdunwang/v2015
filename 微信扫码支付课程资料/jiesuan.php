
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/jiesuan.css">
    <title>确认订单</title>
    <style>
        .main {
            width: 70%;
            margin: 0 auto;
        }

        .main img {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="main">
    <img src="./images/jiesuan1.png" alt="">
    <img src="./images/jiesuan2.png" alt="">
    <form action="./addOrder.php" method="post">
        <div class="order-payInfo" id="payInfo_1">
            <div class="payInfo-wrapper">
                <div class="payInfo-shadow">
                    <div class="order-realPay" id="realPay_1">
                        <div>
                            <span class="realPay-title">实付款：</span>
                            <span class="order-price">￥</span>
                            <span class="realPay-price">434.00</span>
                        </div>
                    </div>
                    <div class="order-confirmAddr" id="confirmAddr_1">
                        <div class="confirmAddr-addr">
                            <span class="confirmAddr-title">寄送至：</span>
                            <span class="confirmAddr-addr-bd">
                            <span class="prov">上海</span>
                            <span class="city">上海</span>
                            <span class="dist">松江</span>
                            <span class="town">松江工业区</span>
                            <span class="street">江田东路185号宏亿创新科技园9号楼402</span>
                        </span>
                        </div>
                        <div class="confirmAddr-addr-user">
                            <span class="confirmAddr-title">收货人：</span>
                            <span class="confirmAddr-addr-bd">
                            <span>后盾人</span>
                            <span>15921776069</span>
                        </span>
                        </div>
                    </div>
                    <div></div>
                    <div class="order-confirmAddr"></div>
                </div>
            </div>
        </div>
        <input type="text" name="username" value="zhangsan">
        <input type="text" name="totalPrice" value="434">
        <input type="text" name="address" value="上海市松江区松江工业园江田东路185号">
        <div class="order-submitOrder" id="submitOrder_1">
            <div class="wrapper">
                <a class="go-back" target="_self" href="index.php">
                    <i></i>
                    <span>返回购物车</span>
                </a>
                <button class="go-btn" style="border:none;">提交订单</button>
            </div>
        </div>
    </form>
    <img src="./images/footer.png" alt="">
</div>
</body>
</html>