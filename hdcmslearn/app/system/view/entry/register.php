<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>HDCMS开源免费-微信/桌面/移动三网通CMS系统</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <script>
        //HDJS组件需要的配置
        window.hdjs = {
            'base': '{!! root_url() !!}/resource/hdjs',
            'uploader': '{!! u("component/upload/uploader") !!}',
            'filesLists': '{!! u("component/upload/filesLists") !!}',
            'removeImage': '{!! u("component/upload/removeImage") !!}',
            'ossSign': '{!! u("component/oss/sign") !!}',
        };
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
    </script>
    <script src="{!! root_url() !!}/resource/hdjs/dist/static/requirejs/require.js?version={{HDCMS_VERSION}}"></script>
    <script src="{!! root_url() !!}/resource/hdjs/dist/static/requirejs/config.js?version={{HDCMS_VERSION}}"></script>
    <link href="{!! root_url() !!}/resource/css/hdcms.css?version={{HDCMS_VERSION}}" rel="stylesheet">
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
</head>
<body class="hdcms-login">
<div>
    <div class="container logo" style="width:800px;">
        <div style="background: url('/resource/images/logo.png') no-repeat; background-size: contain;height: 60px;"></div>
    </div>
    <br/>
    <div class="container well" style="width:800px;">
        <div class="row ">
            <div class="col-md-12">
                <form method="post" onsubmit="post(event)" class="form-horizontal">
                    <div class="form-group">
                        <label class="star">用户名</label>
                        <input name="username" class="form-control input-lg" placeholder="请输入用户名">
                    </div>
                    <div class="form-group">
                        <label class="star">密码</label>
                        <input type="password" name="password" class="form-control input-lg" placeholder="请输入不少于5位的密码">
                    </div>
                    <div class="form-group">
                        <label class="star">确认密码</label>
                        <input type="password" name="password2" class="form-control input-lg" placeholder="请再次输入不少于5位的密码">
                    </div>
                    <div class="form-group">
                        <label class="star">邮箱</label>
                        <input name="email" class="form-control input-lg" placeholder="请输入邮箱">
                    </div>
                    <div class="form-group">
                        <label class="star">手机号</label>
                        <input name="mobile" class="form-control input-lg" placeholder="请输入手机号">
                    </div>
                    <if value="v('config.register.enable_register_code')==1">
                        <div class="form-group">
                            <label style="display: block" class="star">验证码</label>
                            <input name="code" class="form-control input-lg" placeholder="请输入验证码"
                                   style="display: inline;width:65%">
                            <img src="{!! u('captcha') !!}" onclick="this.src='{!! u('captcha') !!}&_Math.random()'"
                                 style="cursor: pointer">
                        </div>
                    </if>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-lg">注册</button>
                        <a class="btn btn-default btn-lg" href="{!! u('system/entry/login',['from'=>$_GET['from']]) !!}">登录</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="copyright">
            <br/>
            Powered by hdcms v2.0 © 2014-2019 www.hdcms.com
        </div>
    </div>
    <script>
        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit({'successUrl': "{!! u('login') !!}"});
            })
        }
    </script>
</div>
</body>
</html>