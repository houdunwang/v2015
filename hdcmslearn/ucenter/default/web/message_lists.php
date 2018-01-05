<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <link rel="stylesheet" href="/ucenter/default/web/static/css/message.css">
        <ul class="nav nav-tabs" role="tablist">
            <li class="{!! !isset($_GET['status'])?'active':'' !!}"><a href="{!! url('message.lists',[],'ucenter') !!}">全部</a></li>
            <li class="{!! Request::get('status')==='0'?'active':'' !!}"><a href="{!! url('message.lists',['status'=>0],'ucenter') !!}">未读</a></li>
            <li class="{!! Request::get('status')==='1'?'active':'' !!}"><a href="{!! url('message.lists',['status'=>1],'ucenter') !!}">已读</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane fade in" id="tab1">
                <div class="panel panel-default">
                    <table class="table table-hover">
                        <tbody>
                        <foreach from="$data" value="$d">
                            <tr>
                                <td>
                                    <if value="$d['url']">
                                        <a href="{{url('message.show',['id'=>$d['id']],'ucenter')}}" target="_blank">{{$d['content']}}</a>
                                        <else/>
                                        {{$d['content']}}
                                    </if>
                                </td>
                                <td width="100"> {{$d['status']==1?'已阅':'未读'}}</td>
                                <td width="200">{{$d['created_at']}}</td>
                            </tr>
                        </foreach>
                        </tbody>
                    </table>
                    {!!$data->links()!!}
                </div>
            </div>
        </div>
</block>