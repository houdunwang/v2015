<extend file='UCENTER_MASTER_FILE'/>
<block name="title">我的钱包-代金券</block>
<block name="content">
    <link rel="stylesheet" href="{!! UCENTER_TEMPLATE_URL !!}/css/ticket.css">
    <tag action="ucenter.header" title="我的钱包-{{$_GET['type']==1?'折扣券':'代金券'}}"></tag>
    <div class="text-center">
        <div class="btn-group">
            <a href="{!! url('ticket/lists') !!}&type={{$_GET['type']}}&status=1" class="btn {{$_GET['status']==1?'btn-primary':'btn-default'}}" role="button">未使用</a>
            <a href="{!! url('ticket/lists') !!}&type={{$_GET['type']}}&status=2" class="btn {{$_GET['status']==2?'btn-primary':'btn-default'}}" role="button">已使用</a>
            <a href="{!! url('ticket/lists') !!}&type={{$_GET['type']}}&status=3" class="btn {{$_GET['status']==3?'btn-primary':'btn-default'}}" role="button">已过期</a>
        </div>
    </div>
    <div class="ticket">
        <foreach from="$data" value="$d">
            <div class="card status{{$_GET['status']}}">
                <div class="item">
                    <div class="left-i">
                        <div class="info">
                            <p class="title">
                                <if value="$_GET['type']==1">
                                   {{$d['discount']*10}}折
                                    <else/>
                                    {{$d['discount']*1}}元
                                </if>
                            </p>
                            <if value="$_GET['status']==1">
                                <p class="nums">
                                    <i class="fa fa-ship"></i> 剩余{{$d['nums']}}张
                                </p>
                            </if>
                        </div>
                        <div class="desc">
                            ★ 订单满{{$d['condition']}}元可使用
                        </div>
                    </div>
                    <div class="right-i">
                        <div class="tile">有效期</div>
                        <div class="times">
                            {{date('Y.m.d',$d['starttime'])}}
                            <p class="white-line">~</p>
                            {{date('Y.m.d',$d['endtime'])}}
                        </div>
                    </div>
                </div>
                <div class="convert">
                    <if value="$_GET['status']==1">
                        <a href="{!! url('ticket/employ') !!}&tid={{$d['tid']}}&type={{$_GET['type'] !!}">立即使用</a>
                    </if>
                    <if value="$_GET['status']==2">
                        <a href="javascript:;">已经使用</a>
                    </if>
                    <if value="$_GET['status']==3">
                        <a href="javascript:;">已经过期</a>
                    </if>
                </div>
            </div>
        </foreach>
        <tag action="ucenter.ticket_footer"></tag>
    </div>
</block>


