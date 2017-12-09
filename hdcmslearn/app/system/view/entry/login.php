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
            'base': '{!!root_url() !!}/resource/hdjs',
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
    <link href="/resource/css/hdcms.css?version={{HDCMS_VERSION}}" rel="stylesheet">
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
    <div class="container logo">
        <div style="background: url('/resource/images/logo.png') no-repeat; background-size: contain;height: 60px;"></div>
    </div>
    <div class="container well">
        <div class="row ">
            <div class="col-md-6">
                <form method="post" onsubmit="post(event)">
                    <div class="form-group">
                        <label>帐号</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-w fa-user"></i></div>
                            <input type="text" name="username" class="form-control input-lg" placeholder="请输入帐号" value="{{old('username')}}">
                        </div>
                        <if value="$errors['username']">
                            <span class="help-block">{{$errors['username']}}</span>
                        </if>
                    </div>
                    <div class="form-group">
                        <label>密码</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-w fa-key"></i></div>
                            <input type="password" name="password" class="form-control input-lg" placeholder="请输入密码" value="{!! old('password') !!}">
                        </div>
                        <if value="$errors['password']">
                            <span class="help-block">{{$errors['password']}}</span>
                        </if>
                    </div>
                    <if value="v('config.register.enable_login_code')==1">
                        <div class="form-group">
                            <label>验证码</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-lg" name="code" placeholder="请输入验证码">
                                <span class="input-group-addon">
                            <img src="{!! u('system/entry/captcha') !!}" onclick="this.src='{!! u('captcha') !!}&_'+Math.random()" style="cursor: pointer">
                        </span>
                            </div>
                        </div>
                    </if>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-lg">登录</button>
                        <a class="btn btn-default btn-lg" href="{!! u('system/entry/register',['from'=>$_GET['from']]) !!}">注册</a>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div style="background: url('/resource/images/houdunwang.jpg');background-size:100% ;height:230px;"></div>
            </div>
        </div>
        <div class="copyright">
            Powered by hdcms v2.0 © 2014-2019 www.hdcms.com
        </div>
    </div>
</div>
<script>
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({
                successUrl: '',
                callback: function (response) {
                    if (response.valid == 1) {
                        hdjs.message(response.message, response.url);
                    } else {
                        hdjs.message(response.message, '', 'info');
                    }
                }
            });
        })
    }
</script>
</body>
</html>