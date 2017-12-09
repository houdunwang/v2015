<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">支付参数</a></li>
    </ul>
    <form class="form-horizontal" id="app" v-cloak="" @submit.prevent="submit()">
        <div class="panel panel-default">
            <div class="panel-heading">
                设置支付宝参数
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">支付宝支付</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="pay[alipay][open]" v-model="pay.alipay.open" value="1"> 开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="pay[alipay][open]" v-model="pay.alipay.open" value="0"> 关闭
                        </label>
                        <span class="help-block">是否开启支付宝支付</span>
                    </div>
                </div>
                <div v-show="pay.alipay.open==1">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">APPID</label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="pay.alipay.app_id">
                            <span class="help-block">应用ID,您的APPID</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">商户私钥</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" v-model="pay.alipay.merchant_private_key" rows="5"></textarea>
                            <span class="help-block">请查看支付宝商户后台获取</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">支付宝公钥</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" v-model="pay.alipay.alipay_public_key" rows="5"></textarea>
                            <span class="help-block">查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥</span>
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
                    pay: <?php echo json_encode($data);?>
                },
                methods: {
                    submit: function () {
                        hdjs.submit({successUrl: 'refresh'});
                    },
                }
            })
        })
    </script>
</block>






