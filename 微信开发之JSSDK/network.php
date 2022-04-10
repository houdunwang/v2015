<?php
//调用wx类中的sign方法获取签名所需参数
//引入类文件
include 'sdk/Wx.php';
$obj = new Wx();
$result = $obj->sign();
//echo '<pre>';
//print_r($result);die;


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>jssdk开发</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="jweixin-1.2.0.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default" role="navigation" style="margin-top:20px;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="#">后盾人 人人做后盾</a>
            </div>
        </nav>
        <div class="jumbotron" style="text-align: center">
            <h1>专注实战视频 助你提升技能</h1>
            <p>线下系统培训:www.houdunwang.com </p>
            <p><a class="btn btn-primary btn-lg" href="http://www.houdunren.com" target="_blank">houdunren.com</a></p>
        </div>
    </div>
    <script>
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?php echo $result["appId"]; ?>', // 必填，公众号的唯一标识
            timestamp: <?php echo $result["timestamp"]; ?>, // 必填，生成签名的时间戳
            nonceStr: '<?php echo $result["nonceStr"]; ?>', // 必填，生成签名的随机串
            signature: '<?php echo $result["signature"]; ?>',// 必填，签名
            jsApiList: [
                'getNetworkType',
                'getLocation',
                'openLocation'
            ] // 必填，需要使用的JS接口列表
        });

        //用ready方法来接收验证成功
        wx.ready(function() {
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
            wx.getNetworkType({
                success: function (res) {
                    var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
                }
            });
            //获取地理位置接口
            wx.getLocation({
                type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var speed = res.speed; // 速度，以米/每秒计
                    var accuracy = res.accuracy; // 位置精度
                    // alert('纬度是:' + latitude);
                    // alert('经度是:' + longitude);
                    // alert('速度是:' + speed);
                    // alert('位置精度是:' + accuracy);
                    wx.openLocation({
                        latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
                        longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
                        name: '我当前的位置', // 位置名
                        address: '后盾人北京校区', // 地址详情说明
                        scale: 1, // 地图缩放级别,整形值,范围从1~28。默认为最大
                        infoUrl: 'http://www.houdunren.com' // 在查看位置界面底部显示的超链接,可点击跳转
                    });
                }
            });
        })

    </script>
</body>
</html>