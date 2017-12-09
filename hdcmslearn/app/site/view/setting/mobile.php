<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">邮件通知</a></li>
    </ul>
    <form class="form-horizontal" id="app" v-cloak @submit.prevent="submit">
        <div class="alert alert-success">
            必须将 <a href="http://houdunren.hdcms.com/?s=site/setting/aliyun&siteid=18&mark=feature&mi=103&mt="> 阿里云基本设置</a> 配置正确才可以使用阿里云短信
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">短信通知设置</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">短信服务商</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="aliyun" v-model="field.provider"> 阿里云
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">endPoint</label>
                    <div class="col-sm-10">
                        <input class="form-control" v-model="field.aliyun.endPoint">
                        <span class="help-block">
                          访问MNS的接入地址，登陆MNS控制台 单击右上角 获取Endpoint 查看
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">topic</label>
                    <div class="col-sm-10">
                        <input class="form-control" v-model="field.aliyun.topic">
                        <span class="help-block">短信专用主题</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">短信验证码</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">sign</label>
                    <div class="col-sm-10">
                        <input class="form-control" v-model="field.aliyun.code.sign">
                        <span class="help-block">短信签名</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">template</label>
                    <div class="col-sm-10">
                        <input class="form-control" v-model="field.aliyun.code.template">
                        <span class="help-block">
                            验证码短信模板，模板中必须存在 code(验证码) 与 product(站点名称） 变量，建议使用阿里云默认的模板即可。
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">发送验证码</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input class="form-control" placeholder="请填写手机号" v-model="field.aliyun.code.test_mobile">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" @click="aliyunCodeTest">发送</button>
                            </span>
                        </div>
                        <span class="help-block">保存配置后发送验证码进行测试</span>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="data" v-html="field" hidden></textarea>
        <button class="col-lg-1 btn btn-default">保存</button>
    </form>
</block>

<script>
    require(['vue', 'hdjs'], function (Vue, hdjs) {
        new Vue({
            el: '#app',
            data: {
                field: <?php echo $sms?>
            },
            methods: {
                submit() {
                    hdjs.submit({successUrl: 'refresh'});
                },
                //发送测试验证码
                aliyunCodeTest() {
                    hdjs.submit({successUrl: '', url: '{{site_url("setting.aliyunCodeTest")}}'});
                }
            }
        })
    })
</script>