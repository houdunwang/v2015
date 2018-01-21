<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <link rel="stylesheet" type="text/css" href="{!! UCENTER_TEMPLATE_URL !!}/css/login.css"/>
    <div class="container-fluid">
        <if value="v('site.setting.login.type') eq 0">
            <h1 style="margin-top: 100px;">登录暂时关闭</h1>
        </if>
        <if value="v('site.setting.login.type') gt 0">
            <h1 class="big-title">会员登录</h1>

            <form class="form-horizontal" role="form" onsubmit="post(event)">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" class="form-control input-lg" name="username" placeholder="{{$placeholder}}" required="required"/>
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
                <if value="\houdunwang\request\Request::isWeChat() && v('site.setting.login.mobile_wechat')==1">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <a href="{!! url('entry.wechatLogin') !!}" class="btn btn-info btn-lg btn-block">微信登录</a>
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
        <parent name="hdcmsCopyright"/>
    </div>
</block>