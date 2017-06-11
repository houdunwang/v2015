<extend file='resource/admin/wechat.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="{{url('wx.lists')}}">管理基本文字回复</a></li>
        <li><a href="{{url('wx.post')}}">添加基本文字回复</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="80">编号</th>
                    <th>关键词</th>
                    <th>创建时间</th>
                    <th width="150">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>{{$d['id']}}</td>
                        <td>{{$d['content']}}</td>
                        <td>{{$d['created_at']}}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="{{url('wx.post',['id'=>$d['id']])}}" class="btn btn-default">编辑</a>
                                <a href="javascript:;" onclick="remove({{$d['cid']}})" class="btn btn-default">删除</a>
                            </div>
                        </td>
                    </tr>
                </foreach>
                </tbody>
            </table>
            <script>
                function remove(cid) {
                    if (confirm('确定删除吗?')) {
                        location.href="{{u('remove')}}&cid="+cid;
                    }
                }
            </script>
        </div>
    </div>
    {{$data->links()}}
</block>