<extend file='UCENTER_MASTER_FILE'/>
<block name="title">会员充值</block>
<block name="content">
    <parent name="header" title="订单信息"/>
    <div class="container">
        <h4>订单信息</h4>
        <div class="panel panel-default">
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
        <h4>选择支付方式</h4>
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tab1" role="tab" data-toggle="tab">直接转帐</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane fade in" id="tab1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <if value="v('site.setting.pay.wechat.open')==1">
                            <a href="{!! u('pay/WeChat/pay',['tid'=>$data['tid']]) !!}" class="btn btn-success btn-block btn-lg">微信支付</a><br/>
                        </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
</block>