<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="#">管理{{$ticket_name}}</a>
        </li>
        <li>
            <a href="{!! url('site/post')!!}&type={!! $_GET['type'] !!}">
                <i class="fa fa-plus"></i> 添加{{$ticket_name}}
            </a>
        </li>
    </ul>
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 col-lg-1 control-label">标题</label>
                    <div class="col-sm-6">
                        <input class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-lg-1 control-label">SN码</label>
                    <div class="col-sm-6">
                        <input class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-lg-1 control-label">会员组</label>
                    <div class="col-sm-6">
                        <input class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>缩略图</th>
                    <th>标题</th>
                    <th>SN码</th>
                    <th>使用条件</th>
                    <th>抵消金额</th>
                    <th>领取条件</th>
                    <th>可用次数</th>
                    <th>总量</th>
                    <th>已领取</th>
                    <th>有效时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$t">
                    <tr>
                        <td>
                            <img src="{{$t['thumb']}}"
                                 style="width:50px;height:50px;border-radius: 8px;">
                        </td>
                        <td>{{$t['title']}}</td>
                        <td>{{$t['sn']}}</td>
                        <td>{{$t['condition']}}</td>
                        <td>{{$t['discount']}}</td>
                        <td>{{$t['credit']}}</td>
                        <td>{{$t['limit']}}</td>
                        <td>{{$t['amount']}}</td>
                        <td>{{$t['usertotal']}} 张</td>
                        <td>{{date('Y-m-d',$t['starttime'])}} ~ {{date("Y-m-d",$t['endtime'])}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{!! url('site/post')!!}&type={{$t['type']}}&tid={{$t['tid']}}"
                                   class="btn btn-default">编辑</a>
                                <a href="javascript:;" onclick="del({{$t['type']}},{{$t['tid']}})"
                                   class="btn btn-default">删除</a>
                            </div>
                        </td>
                    </tr>
                </foreach>
                </tbody>
            </table>
        </div>
    </div>
</block>
<script>
    /**
     * 删除
     * @param type
     * @param tid
     */
    function del(type, tid) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确定删除卡券吗?', function () {
                var url = "{!! url('site/del') !!}&type=" + type + "&tid=" + tid;
                $.get(url, function (res) {
                    if (res.valid == 1) {
                        hdjs.message(res.message, 'refresh');
                    } else {
                        hdjs.message(res.message, '', 'error');
                    }
                }, 'json')
            });
        })
    }
</script>