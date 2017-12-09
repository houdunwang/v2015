<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <link rel="stylesheet" href="{!! UCENTER_TEMPLATE_URL !!}/css/ticket.css">
    <div class="ticket">
        <tag action="ucenter.header" title="使用{{$_GET['type']==1?'折扣券':'代金券'}}"></tag>
        <div class="employ">
            <div class="card">
                <div class="item">
                    <div class="left-i">
                        <div class="info">
                            <p class="title">{{$ticket['discount']}}元</p>

                        </div>
                        <div class="desc">
                            ★订单满{{$ticket['condition']}}元可使用
                        </div>
                    </div>
                    <div class="right-i">
                        <div class="tile">有效期</div>
                        <div class="times">
                            {{date('Y.m.d',$ticket['starttime'])}}
                            <p class="white-line">~</p>
                            {{date('Y.m.d',$ticket['endtime'])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="number">序列号：{{$ticket['sn']}}</div>
            <div class="desc">请提供序列号给工作人员或在当前页面消费</div>
        </div>
        <div class="em-btns">
            <!--        <a href="" class="btn btn-success btn-block">生成核销二维码</a>-->
            <a href="javascript:history.go(-1);" class="btn btn-default btn-block">返回</a>
        </div>
        <parent name="ticket_footer"/>
    </div>
</block>


