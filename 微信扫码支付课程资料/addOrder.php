<?php
//引入连接数据库的文件
include 'connect.php';
$username = '后盾人';
$address = '后盾人,人人做后盾';
$totalPrice='100';
$status = 0;
$orderId = time() . mt_rand(0,9999999999);

//通过数据库连接方式,生成一个订单
$pdo->exec("insert into orders (orderId,username,address,status,totalPrice) values ($orderId,'{$username}','{$address}',$status,$totalPrice)");
?>



<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>选择支付方式</title>
    <link rel="stylesheet" href="./css/addOrder.css">
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
    <div id="J-payMethod" class="main-container">
        <div id="J-rcPaymentDisabled"></div>

        <form name="expressFastPayFrom" id="lightPayForm" action="./wxpay.php" method="post" autocomplete="off">
            <div id="J-rcChannels" data-url="data.html">
                <div data-reactid=".0">
                    <ul id="J_MarketinglList" data-reactid=".0.1"></ul>
                    <ul class="saved-card-list" id="J_SavecardList" data-reactid=".0.2">
                        <li class="channel-bank row-container fn-clear row-container-focus" data-reactid=".0.2.$0">
                            <div class="row-basic fn-clear" data-reactid=".0.2.$0.$/=10"><label class="channel-label"
                                                                                                for="cib1203-0"
                                                                                                data-reactid=".0.2.$0.$/=10.0"><span
                                            class="pay-amount" data-reactid=".0.2.$0.$/=10.0.0"><span class="amount"
                                                                                                      data-reactid=".0.2.$0.$/=10.0.0.0"><span
                                                    data-reactid=".0.2.$0.$/=10.0.0.0.0">支付</span><em
                                                    class="amount-font-R16" data-reactid=".0.2.$0.$/=10.0.0.0.3">434.00</em><span
                                                    data-reactid=".0.2.$0.$/=10.0.0.0.4"> 元</span></span></span><span
                                            class="channel-tit channel-icon icon banklogo-CIB_s" data-id="CIB_s"
                                            data-reactid=".0.2.$0.$/=10.0.1"></span><span class="channel-name" title="微信支付"
                                                                                          data-reactid=".0.2.$0.$/=10.0.2">微信支付</span></label>
                                <input checked="" class="channel-input" id="cib1203-0" name="apiCode" type="radio" data-reactid=".0.2.$0.$/=10.1" seed="rowBasic-cib12030" smartracker="on"></div>
                            <div class="row-extra fn-hide" data-reactid=".0.2.$0.$/=11"></div>
                        </li>
                        <li class="channel-bank row-container fn-clear" data-reactid=".0.2.$1">
                            <div class="row-basic fn-clear" data-reactid=".0.2.$1.$/=10"><label class="channel-label"
                                                                                                for="ccb702-1"
                                                                                                data-reactid=".0.2.$1.$/=10.0"><span
                                            class="pay-amount" data-reactid=".0.2.$1.$/=10.0.0"><span class="amount fn-hide"
                                                                                                      data-reactid=".0.2.$1.$/=10.0.0.0"><span
                                                    data-reactid=".0.2.$1.$/=10.0.0.0.0">支付</span><em
                                                    class="amount-font-R16" data-reactid=".0.2.$1.$/=10.0.0.0.3">463.00</em><span
                                                    data-reactid=".0.2.$1.$/=10.0.0.0.4"> 元</span></span></span><span
                                            class="channel-tit channel-icon icon banklogo-CCB_s" data-id="CCB_s"
                                            data-reactid=".0.2.$1.$/=10.0.1"></span><span class="channel-name"
                                                                                          title="其他支付方式"
                                                                                          data-reactid=".0.2.$1.$/=10.0.2">其他支付方式</span></span></label><input
                                        class="channel-input" id="ccb702-1" name="apiCode" type="radio"
                                        data-reactid=".0.2.$1.$/=10.1" seed="rowBasic-ccb7021" smartracker="on"></div>
                            <div class="row-extra fn-hide" data-reactid=".0.2.$1.$/=11"></div>
                        </li>
                    </ul>
                </div>
            </div>


            <div id="J-security" class="">
                <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">


                <div class="ui-securitycore ui-securitycore-tip J-securitycoreTip " data-link-in-xbox="">


                    <div class="ui-form-item ui-form-item-success">
                        <div class="ui-form-explain">安全设置检测成功！无需短信校验。</div>
                        <div class="J-checkResult fn-hide" data-status="">安全设置检测成功！无需短信校验。</div>
                    </div>

                </div>


                <script type="text/javascript">
                    (function () {
                        var alipay = window.alipay || (window.alipay = {});
                        var s = alipay.security = alipay.security || {};
                        s.downloadServer = "https://download.alipay.com" || alipay.security.downloadServer;
                        s.securityCenterServer = "https://securitycenter.alipay.com" || alipay.security.securityCenterServer;

                        s.hasBrowserControlPolicy = true;

                        s.certDataAccessPolicy = "";
                        s.controlCheckTimeout = Number("3000");
                        s.websocketPorts = "27382,45242";
                        s.newCertControlDownloadAddress = "https://securitycenter.alipay.com/sc/downloadCtr.htm?controlType=cert";
                        s.sid = "web|cashier_payment_3|4ae18c44-126b-446a-8e2c-3f61d738aa52RZ13";
                    })();
                </script>
                <script type="text/javascript" charset="utf-8" crossorigin="anonymous"
                        src="https://a.alipayobjects.com/static/ar/??alipay.light.base-1.11.js,alipay.light.page-1.15-sizzle.js,alipay.security.base-1.8.js,alipay.security.utils.chromeExtension-1.1.js,alipay.security.edit-1.22.js,alipay.security.utils.pcClient-1.1.js,alipay.security.cert-1.5.js,alipay.security.otp-1.2.js,alipay.security.mobile-1.7.js,alipay.security.ctuMobile-1.2.js,alipay.security.riskMobileBank-1.3.js,alipay.security.riskMobileAccount-1.3.js,alipay.security.riskMobileCredit-1.2.js,alipay.security.riskCertificate-1.0.js,alipay.security.riskSecurityQa-1.0.js,alipay.security.riskExpressPrivacy-1.0.js,alipay.security.checkCode-1.1.js,alipay.security.rds-1.0.js,alipay.security.barcode-1.1.js,alipay.security.riskOneKeyConfirm-1.2.js,alipay.security.riskSudoku-1.0.js,alipay.security.riskOriginalAccountMobile-1.0.js,alipay.security.riskOriginalSecurityQa-1.0.js"></script>
                <script type="text/javascript" charset="utf-8" crossorigin="anonymous"
                        src="https://as.alipayobjects.com/g/alipay-security-pc-3/??risk-tel/2.0.2/index.js,core2/3.0.2/index.js"></script>
                <script charset="utf-8" crossorigin="anonymous"
                        src="https://a.alipayobjects.com/security-sdk/2.1.2/index.js"></script>
                <script>
                    light.trackOn = false;
                    light.has('page/products') || light.register('page/products');
                    light.has('page/scProducts') || light.register('page/scProducts', light, []);
                    alipay.security.utils.chromeExtension.setExtensionId('lapoiohkeidniicbalnfmakkbnpejgbi');
                </script>
                <!-- Powered by Alipay Security -->


                <div class="ui-securitycore J-securitycoreMain"
                     data-request="web|cashier_payment_3|4ae18c44-126b-446a-8e2c-3f61d738aa52RZ13" data-system="cashier"
                     data-server="https://securitycore.alipay.com" data-status="" data-extension="false"
                     data-orderid="0907655d134fe7c65b0000iercNN1792">

                    <input style="display:none" seed="JSecuritycoreMain-ipt" smartracker="on">
                    <input type="password" style="display:none" seed="JSecuritycoreMain-iptT1" smartracker="on">


                    <style type="text/css">
                        .edit-section .edit-link a {
                            line-height: 24px;
                        }
                    </style>
                    <style type="text/css">
                        input.sixDigitPassword {
                            position: absolute;
                            color: #fff;
                            opacity: 0;
                            width: 1px;
                            height: 1px;
                            font-size: 1px;
                            left: 0;
                            -webkit-box-sizing: content-box;
                            box-sizing: content-box;
                            -webkit-user-select: initial; /* 取消禁用选择页面元素 */
                            outline: 'none';
                            margin-left: '-9999px';
                        }

                        div.sixDigitPassword {
                            cursor: text;
                            background: #fff;
                            outline: none;
                            position: relative;
                            padding: 8px 0;
                            height: 14px;
                            border: 1px solid #cccccc;
                            border-radius: 2px;
                        }

                        div.sixDigitPassword i {
                            float: left;
                            display: block;
                            padding: 4px 0;
                            height: 7px;
                            border-left: 1px solid #cccccc;
                        }

                        div.sixDigitPassword i.active {
                            background-image: url("https://t.alipayobjects.com/images/rmsweb/T1nYJhXalXXXXXXXXX.gif");
                            background-repeat: no-repeat;
                            background-position: center center;
                        }

                        div.sixDigitPassword b {
                            display: block;
                            margin: 0 auto;
                            width: 7px;
                            height: 7px;
                            overflow: hidden;
                            visibility: hidden;
                            background-image: url("https://t.alipayobjects.com/tfscom/T1sl0fXcBnXXXXXXXX.png");
                        }

                        div.sixDigitPassword span {
                            position: absolute;
                            display: block;
                            left: 0px;
                            top: -1px;
                            height: 30px;
                            border: 1px solid rgba(82, 168, 236, .8);
                            border: 1px solid #00ffff \9;
                            border-radius: 2px;
                            visibility: hidden;
                            -webkit-box-shadow: inset 0px 2px 2px rgba(0, 0, 0, 0.75), 0 0 8px rgba(82, 168, 236, 0.6);
                            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
                        }

                        .ui-securitycore .ui-form-item-loading .ui-form-explain {
                            background: url(https://t.alipayobjects.com/tfscom/T1hBFfXnRnXXXXXXXX.gif) 0 4px no-repeat !important;
                        }

                        .ui-securitycore .ui-form-item-error .ui-form-explain, .ui-securitycore .ui-form-item-warn .ui-form-explain, .ui-securitycore .ui-form-item-success .ui-form-explain, .ui-securitycore .ui-form-item-success .ui-form-text, .ui-securitycore-tip .ui-form-explain {
                            background-image: url(https://t.alipayobjects.com/tfscom/T1dmlfXc0dXXXXXXXX.png) !important;
                        }

                        .ui-securitycore .ui-form-item .ui-form-explain {
                            margin-top: 8px;
                        }

                    </style>
                </div>

            <div id="J-rcSubmit">
                <div class="ui-fm-item ui-fm-action j-submit" data-reactid=".1"><input class="ui-button ui-button-lblue"
                                                                                       id="J_authSubmit" type="submit"
                                                                                       value="确认付款" data-reactid=".1.1"
                                                                                       seed="jSubmit-J_authSubmit"
                                                                                       smartracker="on"></div>
            </div>
        </form>
    </div>
    <br><br>
    <img src="./images/footer.png" alt="">
</div>


</body>
</html>