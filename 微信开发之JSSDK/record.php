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
    <div>
        <button class="start">开始录音</button>
        <button class="end">结束录音</button>
        <button class="bofang">播放语音</button>
        <button class="zanting">暂停播放</button>
        <button class="tingzhi">停止播放</button>
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
            'startRecord',
            'stopRecord',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'playVoice',
            'onVoicePlayEnd',
            'uploadVoice',
            'downloadVoice',
            'translateVoice',

        ] // 必填，需要使用的JS接口列表
    });

    //用ready方法来接收验证成功
    wx.ready(function () {
        // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
        //开始录音
        // wx.startRecord();
        wx.onVoicePlayEnd({
            success: function (res) {
                var localId = res.localId; // 返回音频的本地ID
                alert('语音播放完毕');
            }
        })



        //定义全局语音变量
        var yuyin = '';
        //开始录音按钮点击事件
        $('.start').click(function () {
            wx.startRecord();
            wx.onVoiceRecordEnd({
// 录音时间超过一分钟没有停止的时候会执行 complete 回调
                complete: function (res) {
                    var localId = res.localId;
                    alert('录音时间太长了');
                }
            });
        })
        //结束录音按钮点击事件
        $('.end').click(function () {
            wx.stopRecord({
                success: function (res) {
                    var localId = res.localId;
                    yuyin = res.localId;
                    //只能识别语音
                    wx.translateVoice({
                        localId: yuyin, // 需要识别的音频的本地Id，由录音相关接口获得
                        isShowProgressTips: 1, // 默认为1，显示进度提示
                        success: function (res) {
                            alert(res.translateResult); // 语音识别的结果
                        }
                    });
                    //结束之后自动播放语音
                    // wx.playVoice({
                    //     localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
                    // });
                    wx.uploadVoice({
                        localId: localId, // 需要上传的音频的本地ID，由stopRecord接口获得
                        isShowProgressTips: 1, // 默认为1，显示进度提示
                        success: function (res) {
                            var serverId = res.serverId; // 返回音频的服务器端ID
                            // alert('回调结果是:' + serverId);
                            wx.downloadVoice({
                                serverId: serverId, // 需要下载的音频的服务器端ID，由uploadVoice接口获得
                                isShowProgressTips: 1, // 默认为1，显示进度提示
                                success: function (res) {
                                    var downloadlocalId = res.localId; // 返回音频的本地ID
                                    //播放下载的音频
                                    wx.playVoice({
                                        localId: downloadlocalId // 需要播放的音频的本地ID，由stopRecord接口获得
                                    });
                                }
                            });
                        }
                    });
                }
            });
        })
        //暂停播放点击事件
        $('.zanting').click(function () {
            wx.pauseVoice({
                localId: yuyin // 需要暂停的音频的本地ID，由stopRecord接口获得
            });
        })

        //停止播放点击事件
        $('.tingzhi').click(function () {
            wx.stopVoice({
                localId: yuyin // 需要停止的音频的本地ID，由stopRecord接口获得
            });
        })
        //播放语音点击事件
        $('.bofang').click(function () {
            wx.playVoice({
                localId: yuyin // 需要播放的音频的本地ID，由stopRecord接口获得
            });
        });
    })


</script>
</body>
</html>