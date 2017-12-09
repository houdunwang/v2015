<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <link rel="stylesheet" href="/ucenter/default/web/static/css/message.css">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">消息列表</a></li>
    </ul>
    <?php if ( ! $data->toArray()) { ?>
        <div class="alert alert-success">
            暂时没有消息
        </div>
    <?php } else { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">系统通知</h3>
            </div>
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
        </div>
        {!!$data->links()!!}
    <?php } ?>
</block>