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
            <br>
            <button class="paizhao">我要拍照</button>
            <img src="" style="width: 100%;" class="image">
        </div>
        <div class="images" style="width: 100%;">
            <img src="http://li.houdunren.com/image/1.jpg"  style="width: 100%;">
            <img src="http://li.houdunren.com/image/2.jpg"  style="width: 100%;">
            <img src="http://li.houdunren.com/image/3.jpg"  style="width: 100%;">
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
                'chooseImage',
                'uploadImage',
                'downloadImage',
                'previewImage',
            ] // 必填，需要使用的JS接口列表
        });

        //用ready方法来接收验证成功
        wx.ready(function() {
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
            //手机相册或者拍照选择图片接口
            // wx.chooseImage({
            //     count: 1, // 默认9
            //     sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            //     sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            //     success: function (res) {
            //         var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            //     }
            // });
            // var imageArr = [
            //     'http://li.houdunren.com/image/1.jpg',
            //     'http://li.houdunren.com/image/2.jpg',
            //     'http://li.houdunren.com/image/3.jpg',
            // ];
            // wx.previewImage({
            //     current: imageArr[0], // 当前显示图片的http链接
            //     urls: imageArr // 需要预览的图片http链接列表
            // });
        })

        //拍照点击事件
        $('.paizhao').click(function () {
            wx.chooseImage({
                count: 1, // 默认9
                sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    // $('.image').attr('src',localIds);
                    //将选择的图片上传
                    wx.uploadImage({
                        localId: localIds.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
                        isShowProgressTips: 1, // 默认为1，显示进度提示
                        success: function (res) {
                            var serverId = res.serverId; // 返回图片的服务器端ID
                            wx.downloadImage({
                                serverId: serverId, // 需要下载的图片的服务器端ID，由uploadImage接口获得
                                isShowProgressTips: 1, // 默认为1，显示进度提示
                                success: function (res) {
                                    var localId = res.localId; // 返回图片下载后的本地ID
                                    $('.image').attr('src',localIds);
                                }
                            });
                        }
                    });
                    
                }
            });
        })
        //点击图片的点击事件
        $('.images img').click(function () {
            //获取当前点击的图片src地址
            var img = $(this).attr('src');
            var imageArr = [
                    'http://li.houdunren.com/image/1.jpg',
                    'http://li.houdunren.com/image/2.jpg',
                    'http://li.houdunren.com/image/3.jpg',
                ];
            wx.previewImage({
                current: img, // 当前显示图片的http链接
                urls: imageArr // 需要预览的图片http链接列表
            });
        })
    </script>
</body>
</html>