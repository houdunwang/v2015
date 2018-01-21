<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">支付参数</a></li>
    </ul>
    <form class="form-horizontal" id="app" v-cloak="" @submit.prevent="submit()">
        <div class="panel panel-default">
            <div class="panel-heading">
                设置微信支付参数
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">微信支付</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="pay[wechat][open]" v-model="pay.wechat.open" value="1"> 开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="pay[wechat][open]" v-model="pay.wechat.open" value="0"> 关闭
                        </label>
                        <span class="help-block">是否使用微信支付</span>
                    </div>
                </div>
                <div v-show="pay.wechat.open==1">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">接口类型</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="pay[wechat][version]" v-model="version" value="0"> 旧版
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="pay[wechat][version]" v-model="version" value="1"> 新版(2014年9月之后申请的)
                            </label>
                            <span class="help-block">由于微信支付接口调整，需要根据申请时间来区分支付接口</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">微信类型</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$weChatLevel}}</p>
                            <if value="$wechat['level']!=4">
                                <strong class="text-danger">微信支付要求公众号为“认证服务号”，该公众号没有微信支付的权限</strong>
                            </if>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">身份标识<br/>(appId)</label>
                        <div class="col-sm-10">
                            <input class="form-control" readonly="readonly" value="{{$wechat['appid']}}">
                            <span class="help-block">公众号身份标识 请通过修改公众号信息来保存</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">身份密钥<br/>(appSecret)</label>
                        <div class="col-sm-10">
                            <input class="form-control" readonly="readonly" value="{{$wechat['appsecret']}}">
                            <span class="help-block">公众平台API(参考文档API 接口部分)的权限获取所需密钥Key 请通过修改公众号信息来保存</span>
                        </div>
                    </div>
                    <!--新版start-->
                    <div class="form-group" v-show="version==1">
                        <label class="col-sm-2 control-label">微信支付商户号<br/>(MchId)</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="pay[wechat][mch_id]" v-model="pay.wechat.mch_id">
                            <span class="help-block">公众号支付请求中用于加密的密钥Key</span>
                        </div>
                    </div>
                    <div class="form-group" v-show="version==1">
                        <label class="col-sm-2 control-label">商户支付密钥<br/>(API密钥)</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input class="form-control" name="pay[wechat][key]" v-model="pay.wechat.key">
                                <span class="input-group-addon" style="cursor: pointer" @click="createWeichatApi()">生成新的</span>
                            </div>
                            <span class="help-block">此值需要手动在腾讯商户后台API密钥保持一致。查看设置教程</span>
                        </div>
                    </div>
                    <!--新版end-->
                    <!--旧版start-->
                    <div class="form-group" v-show="version==0">
                        <label class="col-sm-2 control-label">商户身份<br/>(partnerId)</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="pay[wechat][partnerid]" v-model="pay.wechat.partnerid">
                            <span class="help-block">财付通商户身份标识</span>
                            <span class="help-block">公众号支付请求中用于加密的密钥Key</span>
                        </div>
                    </div>
                    <div class="form-group" v-show="version==0">
                        <label class="col-sm-2 control-label">商户密钥<br/>(partnerKey)</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="pay[wechat][partnerkey]" v-model="pay.wechat.partnerkey">
                            <span class="help-block">财付通商户权限密钥Key</span>
                        </div>
                    </div>
                    <div class="form-group" v-show="version==0">
                        <label class="col-sm-2 control-label">通信密钥<br/>(paySignKey)</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="pay[wechat][paysignkey]" v-model="pay.wechat.paysignkey">
                            <span class="help-block">公众号支付请求中用于加密的密钥Key</span>
                        </div>
                    </div>
                    <!--旧版start-->
                    <!--证书-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">证书格式<br/>(apiclient_cert.pem)</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input class="form-control" name="pay[wechat][apiclient_cert]" readonly="" v-model="pay.wechat.apiclient_cert">
                                <div class="input-group-btn">
                                    <button @click="upFile('apiclient_cert')" class="btn btn-default" type="button">选择证书文件</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">证书密钥格式<br/>(apiclient_key.pem)</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input class="form-control" name="pay[wechat][apiclient_key]" readonly="" v-model="pay.wechat.apiclient_key">
                                <div class="input-group-btn">
                                    <button @click="upFile('apiclient_key')" class="btn btn-default" type="button">选择证书文件</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">CA证书<br/>(rootca.pem)</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input class="form-control" name="pay[wechat][rootca]" readonly="" v-model="pay.wechat.rootca">
                                <div class="input-group-btn">
                                    <button @click="upFile('rootca')" class="btn btn-default" type="button">选择证书文件</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="data" hidden>@{{pay}}</textarea>
        <button class="col-lg-1 btn btn-default">保存</button>
    </form>
    <script>
        require(['hdjs', 'vue'], function (hdjs, Vue) {
            var vm = new Vue({
                el: "#app",
                data: {
                    pay: <?php echo json_encode($data);?>,
                    version: 1
                },
                methods: {
                    createWeichatApi: function () {
                        this.pay.wechat.key = hdjs.util.md5(Math.random());
                    },
                    //上传证书
                    upFile: function (name) {
                        hdjs.file(function (files) {
                            vm.pay.wechat[name] = files[0]
                        }, {extensions: 'pem', multiple: false,})
                    },
                    submit: function () {
                        hdjs.submit({successUrl:'refresh'});
                    },
                }
            })
        })
    </script>
</block>






