<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">会员中心参数</a></li>
    </ul>
    <div class="alert alert-success">
        系统会根据移动端或桌面端响应不同页面，会员中心登录模板在 ucenter 目录中,二次开发人员可参考系统默认登录风格，开发出符合自己网站风格的登录/注册界面。
        <br/><a href="{!! url('entry.login',[],'ucenter') !!}" target="_blank">会员登录</a>
    </div>
    <form class="form-horizontal" id="app" @submit.prevent="submit" v-cloak>
        <div class="panel panel-default">
            <div class="panel-heading">会员注册选项</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">注册方式</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" v-model="register.type" value="0">
                            禁止帐号注册
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="register.type" value="1">
                            手机注册
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="register.type" value="2">
                            邮箱注册
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="register.type" value="3">
                            手机或邮箱注册
                        </label>
                        <span class="help-block">
                              该项设置用户注册时用户名的格式,如果设置为:"邮箱注册",系统会判断用户的注册名是否是邮箱格式,不选时没有注册表单项
                          </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">注册验证</label>
                    <div class="col-sm-10">
                        <label class="checkbox-inline">
                            <input type="checkbox" v-model="register.auth" value="1" :true-value="1"
                                   :false-value="0">开启验证
                        </label>
                        <span class="help-block">
                            开启验证将向用户发送验证码，验证通过后才可以完成注册。<br/>
                            用户填写的是邮箱将发送邮件，如果是手机号将向用户手机发送验证码<br/>
                            <br/>邮箱验证需要先进行 <a href="{{site_url('site/setting/mail')}}" target="_blank">邮件通知设置</a>
                            短信验证需要先进行 <a href="{{site_url('site/setting/mobile')}}" target="_blank">短信通知设置</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">会员登录选项</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">登录方式</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" v-model="login.type" value="0">
                            禁止帐号登录
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="login.type" value="1">
                            手机登录
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="login.type" value="2">
                            邮箱登录
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="login.type" value="3">
                            手机或邮箱登录
                        </label>
                        <span class="help-block">
                              该项设置用户登录的方式,比如设置为:"邮箱登录"则用户必须使用邮箱才可以登录
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">第三方登录</label>
                    <div class="col-sm-10">
                        <label class="checkbox-inline">
                            <input type="checkbox" v-model="login.pc_wechat" :true-value="1"
                                   :false-value="0"> 微信扫码登录
                        </label>
                        <span class="help-block">
                            需要在 <a href="https://open.weixin.qq.com/" target="_blank">微信开放平台申请</a> 网站应用
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">微信客户端</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" v-model="login.mobile_wechat" value="0"> 不使用微信登录
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="login.mobile_wechat" value="1"> 登录按钮
                        </label>
                        <span class="help-block">
                            微信APP登录的处理方式,如果选择 "自动登录" 时系统自动使用微信号登录
                          </span>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="register" hidden>@{{register}}</textarea>
        <textarea name="login" hidden>@{{login}}</textarea>
        <button class="btn btn-default col-lg-1">保存设置</button>
    </form>
</block>
<script>
    require(['hdjs', 'vue'], function (hdjs, Vue) {
        new Vue({
            el: "#app",
            data: {
                register: <?php echo json_encode($register);?>,
                login: <?php echo json_encode($login);?>,
            },
            methods: {
                submit: function () {
                    hdjs.submit({successUrl: 'refresh'});
                }
            }
        })
    })
</script>