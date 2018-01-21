<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会员注册</title>
    <include file="resource/view/member"/>
    <link rel="stylesheet" type="text/css" href="{!! UCENTER_TEMPLATE_URL !!}/static/css/register.css"/>
</head>
<body>
<div class="container" >
    <if value="v('site.setting.register.type') eq 0">
        <h1 style="margin-top: 100px;">网站暂时关闭注册</h1>
    </if>
    <if value="v('site.setting.register.type') gt 0">
        <h1 class="big-title">会员注册</h1>
        <form method="post" class="form-horizontal" role="form" onsubmit="post(event)">
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-lg" name="username" placeholder="{!! $placeholder !!}" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="password" name="password" class="form-control input-lg" placeholder="请输入不少于5位的密码" required="required"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="password" name="cpassword" class="form-control input-lg" placeholder="请再次输入密码" required="required"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group input-group-lg">
                        <input class="form-control" placeholder="请输入验证码" name="valid_code" required="required">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="sendValidCode">发送验证码</button>
                    </span>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">选择头像</h3>
                </div>
                <div class="panel-body">
                    <input type="hidden" name="icon" value="">
                    <div class="icon">
                        <ul class="row">
                            <?php for ($i = 1; $i <= 24; $i++): ?>
                                <li class="col-xs-3" onclick="selectIcon('resource/images/icon/{!! $i !!}.jpg',this)">
                                    <img src="{!! root_url() !!}/resource/images/icon/{!! $i !!}.jpg" alt="">
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-success btn-lg btn-block">注册</button>
                </div>
            </div>
        </form>
        <script>
            function isMobile() {
                var userAgentInfo = navigator.userAgent;
                var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
                var flag = false;
                for (var v = 0; v < Agents.length; v++) {
                    if (userAgentInfo.indexOf(Agents[v]) > 0) {
                        flag = true;
                        break;
                    }
                }
                return flag;
            }

            require(['hdjs'], function (hdjs) {
                var option = {
                    el: '#sendValidCode', url: '{!! url("entry.sendRegisterValidCode") !!}',
                    timeout: '60', input: '[name="username"]'
                }
                hdjs.validCode(option);
            })

            function selectIcon(img, obj) {
                $("[name='icon']").val(img);
                $("div.icon ul li").removeClass('sel');
                $(obj).addClass('sel');
            }

            //发送表单
            function post(event) {
                event.preventDefault();
                require(['hdjs'], function (hdjs) {
                    var msg = '';
                    var username = $.trim($("[name='username']").val());
                    if (username == '') {
                        msg = '注册帐号不能为空<br/>';
                    }
                    if (!/^\d{11}$/.test(username) && !/^.+@.+$/.test(username)) {
                        msg += '{!! $placeholder !!}格式错误<br/>';
                    }
                    if ($.trim($("[name='icon']").val()) == '') {
                        msg += '请选择头像<br/>';
                    }
                    if ($.trim($("[name='password']").val()) == '') {
                        msg += '密码不能为空<br/>';
                    }
                    if ($("[name='password']").val() != $("[name='cpassword']").val()) {
                        msg += '两次密码输入不一致<br/>';
                    }
                    if (msg.length > 0) {
                        hdjs.message(msg, '', 'info');
                        return false;
                    }
                    hdjs.submit({
                        callback: function (response) {
                            if (response.valid == 1) {
                                hdjs.message('注册成功，系统将跳转到登录页面', "{!! url('entry.login') !!}", 'info');
                            } else {
                                hdjs.message(response.message, '', 'info');
                            }
                        }
                    });
                })
            }
        </script>
        <p class="remind">已有账号？ <a href="{!! url('entry.login',[],'ucenter') !!}">点此登录</a></p>
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