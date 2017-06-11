<extend file='resource/admin/article.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#" role="tab" data-toggle="tab">文章列表</a></li>
        <li><a href="{{u('post')}}" role="tab" data-toggle="tab">发表文章</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="80">编号</th>
                    <th>标题</th>
                    <th>点击数</th>
                    <th width="150">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>{{$d['id']}}</td>
                        <td>{{$d['title']}}</td>
                        <td>{{$d['click']}}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="{{u('post',['id'=>$d['id']])}}" class="btn btn-default">编辑</a>
                                <a href="javascript:;" onclick="remove({{$d['id']}})" class="btn btn-default">删除</a>
                            </div>
                        </td>
                    </tr>
                </foreach>
                </tbody>
            </table>
            <script>
                function remove(id) {
                    if (confirm('确定删除吗?')) {
                        location.href="{{u('remove')}}&id="+id;
                    }
                }
            </script>
        </div>
    </div>
    {{$data->links()}}
</block>