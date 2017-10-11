<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>laravelVideo视频管理</title>
    <meta name="csrf-token" content="67b3440b78219e1f96830264c1e183ca">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

    <script src="/node_modules/hdjs/dist/static/requirejs/require.js?version=v2.0.91"></script>
    <script src="/node_modules/hdjs/dist/static/requirejs/config.js?version=v2.0.91"></script>
    <link href="/css/hdcms.css" rel="stylesheet">
    <script>
        require(['hdjs'], function () {
            //为异步请求设置CSRF令牌
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body class="hdcms-login">
<div class="container logo">
    <div style="background: url('/images/logo.png') no-repeat; background-size: contain;height: 60px;"></div>
</div>
<div class="container well">
    <div class="row ">
        <div class="col-md-6">
            <form method="post">
                {{ csrf_field() }}
                <div class="form-group ">
                    <label>帐号</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-w fa-user"></i></div>
                        <input type="text" name="username" class="form-control input-lg" placeholder="请输入帐号" value="">
                    </div>
                </div>
                <div class="form-group ">
                    <label>密码</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-w fa-key"></i></div>
                        <input type="password" name="password" class="form-control input-lg" placeholder="请输入密码"
                               value="">
                    </div>
                </div>
                <div class="form-group">
                    <div id="embed-captcha"></div>
                    <p id="wait" class="show">正在加载验证码......</p>
                    <p id="notice" class="hide">请先完成验证</p>
                </div>
                <button class="btn btn-primary btn-lg" id="embed-submit">登录</button>
            </form>
            <script src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.js"></script>
            <script src="/js/gt.js"></script>
            <script>
                var handlerEmbed = function (captchaObj) {
                    $("#embed-submit").click(function (e) {
                        var validate = captchaObj.getValidate();
                        if (!validate) {
                            $("#notice")[0].className = "show";
                            setTimeout(function () {
                                $("#notice")[0].className = "hide";
                            }, 2000);
                            e.preventDefault();
                        }
                    });
                    // 将验证码加到id为captcha的元素里，同时会有三个input的值：geetest_challenge, geetest_validate, geetest_seccode
                    captchaObj.appendTo("#embed-captcha");
                    captchaObj.onReady(function () {
                        $("#wait")[0].className = "hide";
                    });
                    // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
                };
                $.ajax({
                    // 获取id，challenge，success（是否启用failback）
                    url: "/StartCaptchaServlet", // 加随机数防止缓存
                    type: "get",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        // 使用initGeetest接口
                        // 参数1：配置参数
                        // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                        initGeetest({
                            gt: data.gt,
                            challenge: data.challenge,
                            new_captcha: data.new_captcha,
                            product: "embed", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                            offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                            // 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
                        }, handlerEmbed);
                    }
                });
            </script>
        </div>
        <div class="col-md-6">
            <div style="background: url('http://www.houdunwang.com/resource/images/houdunwang.jpg');background-size:100% ;height:230px;"></div>
        </div>
    </div>
    <div class="copyright">
        Powered by hdcms v2.0 © 2014-2019 www.hdcms.com
    </div>
</div>
</body>
</html>