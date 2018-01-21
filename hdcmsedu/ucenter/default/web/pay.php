<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">定单信息</a></li>
    </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                订单信息
            </div>
            <div class="panel-body">
                <p>
                    商品名称:<span class="pull-right">{{$data['goods_name']}}</span>
                </p>
                <p>
                    订单编号:<span class="pull-right">{{$data['tid']}}</span>
                </p>
                <p>
                    支付金额:<span class="pull-right">{{$data['fee']}} 元</span>
                </p>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                选择支付方式
            </div>
            <div class="panel-body">
                <div class="btn-group">
                    <if value="v('site.setting.pay.wechat.open')==1">
                        <a disabled="" href="javascript:;" class="btn btn-default">微信付款</a>
                    </if>
                    <if value="v('site.setting.pay.alipay.open')==1">
                        <a href="{!! u('pay/AliPay/pay',['tid'=>$data['tid']]) !!}" class="btn btn-success">支付宝付款</a>
                    </if>
                </div>
            </div>
        </div>
</block>