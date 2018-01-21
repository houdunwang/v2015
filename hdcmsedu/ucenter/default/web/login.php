<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会员登录</title>
    <include file="resource/view/member"/>
    <link rel="stylesheet" type="text/css" href="{!! UCENTER_TEMPLATE_URL !!}/static/css/login.css"/>
</head>
<body>
<div class="container">
    <if value="v('site.setting.login.type') eq 0">
        <h1 style="margin-top: 100px;">登录暂时关闭</h1>
    </if>
    <if value="v('site.setting.login.type') gt 0">
        <h1 class="big-title">会员登录</h1>
        <form class="form-horizontal" role="form" onsubmit="post(event)">
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-lg" name="username" placeholder="{!! $placeholder !!}" required="required"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group input-group-lg">
                        <input type="password" class="form-control" name="password" placeholder="请输入密码" required="required"/>
                        <span class="input-group-btn">
                            <a class="btn btn-default" href="{!! url('entry.forgetpwd') !!}">忘记密码？</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-success btn-lg btn-block">登录</button>
                </div>
            </div>
            <if value="v('site.setting.login.pc_wechat')==1">
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-info btn-lg btn-block">微信登录</button>
                    </div>
                </div>
            </if>
        </form>

        <p class="remind">还没有帐号？ <a href="{!! url('entry.register') !!}">注册新帐号</a></p>
        <script>
            function post(event) {
                event.preventDefault();
                require(['hdjs'], function (hdjs) {
                    hdjs.submit({
                        callback: function (response) {
                            if (response.valid == 1) {
                                location.href = "{!! $url !!}";
                            } else {
                                hdjs.message(response.message, '', 'info');
                            }
                        }
                    });
                })
            }
        </script>
    </if>
    <p class="remind">
        <a href="http://www.houdunwang.com">后盾人</a>国内唯一拥有开源产品的培训机构! 基于
        <a href="http://www.hdcms.com" target="_blank">HDCMS</a> &
        <a href="http://www.hdphp.com" target="_blank">HDPHP</a>构建
        <a href="{!! web_url() !!}">返回首页</a>
    </p>
</div>
</body>
</html>