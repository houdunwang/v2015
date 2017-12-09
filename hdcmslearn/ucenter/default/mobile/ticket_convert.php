<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <link rel="stylesheet" href="{!! UCENTER_TEMPLATE_URL !!}/css/ticket.css">
    <tag action="ucenter.header" title="我的钱包-{{$_GET['t']==1?'折扣券':'代金券'}}"></tag>
    <div class="text-center">
        <div class="btn-group">
            <a href="{!! url('ticket/convert')}}&type=1" class="btn {{$_GET['type']==1?'btn-primary':'btn-default' !!}"
               role="button">折扣券</a>
            <a href="{!! url('ticket/convert')}}&type=2" class="btn {{$_GET['type']==2?'btn-primary':'btn-default' !!}"
               role="button">代金券</a>
        </div>
    </div>
    <div class="ticket">
        <foreach from="$data" value="$d">
            <div class="voucher">
                <div class="info">
                    <h3>{{$d['title']}}</h3>
                    <p class="endtime">{{date('Y.m.d',$d['starttime'])}} - {{date('Y.m.d',$d['endtime'])}}</p>
                    <div class="thumb">
                        <img src="{{$d['thumb']}}">
                    </div>
                </div>
                <div class="integral">
                    <span>使用{{$d['credit']}}{{$d['credit_title']}}兑换</span>
                    <button class="btn btn-danger btn-sm" onclick="convert({{$d['tid']}})">点击领取</button>
                </div>
                <div class="more" style="cursor: pointer;">
                    详细介绍 <i class="fa fa-arrow-circle-down"></i>
                </div>
                <div class="desc hide">
                    {!! $d['description'] !!}
                </div>
            </div>
        </foreach>
        <parent name="ticket_footer"/>
    </div>
</block>

<script>
    //显示或隐藏卡券介绍
    require(['hdjs'], function () {
        $('.more').click(function () {
            $(this).next().toggleClass('hide');
        });
    })

    //兑换
    function convert(tid) {
        $.post('{!! __URL__ !!}', {tid: tid}, function (res) {
            require(['hdjs'], function (hdjs) {
                hdjs.message(res.message, '', (res.valid ? 'success' : 'error'), 3, {
                        width: '',
                        events: {
                            'hidden.bs.modal': function () {
                                if (res.valid) {
                                    location.href = "{!! url('ticket/lists', ['type' => $_GET['type'],'status'=>1]) !!}";
                                }
                            }
                        }
                    }
                );
            })
        }, 'json')
    }
</script>
