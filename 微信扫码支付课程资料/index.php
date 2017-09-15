<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>购物车</title>
    <link rel="stylesheet" href="./css/cart-min.css">
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
    <img src="./images/header.png" alt="">
    <img src="./images/cart.png" alt="">
    <div id="J_FloatBarHolder" class="float-bar-holder">
        <div id="J_FloatBar" class="float-bar clearfix default has-items" style="position: static;">
            <div id="J_SelectedItems" class="group-wrapper group-popup hidden" style="display: none;">
                <div id="J_SelectedItemsList" class="group-content"></div>
                <span class="arrow"></span></div>
            <div class="float-bar-wrapper">
                <div class="float-bar-right">
                    <div id="J_ShowSelectedItems" class="amount-sum"><span class="txt">已选商品</span><em id="J_SelectedItemsCount">2</em><span class="txt">件</span>
                        <div class="arrow-box"><span class="selected-items-arrow"></span><span class="arrow"></span>
                        </div>
                    </div>
                    <div id="J_CheckCOD" class="check-cod" style="display: none;"><span class="icon-cod"></span><span class="s-checkbox J_CheckCOD"></span>货到付款
                    </div>
                    <div class="pipe"></div>
                    <div class="price-sum"><span class="txt">合计（不含运费）：</span><strong class="price"><em id="J_Total"><span class="total-symbol">&nbsp;￥</span>434.00</em></strong></div>
                    <div class="btn-area"><a href="./jiesuan.php" id="J_Go" class="submit-btn"><span style="color:#fff;">结&nbsp;算</span><b></b></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>