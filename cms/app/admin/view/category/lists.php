<extend file='resource/admin/article.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="u('lists')}}">栏目列表</a></li>
        <li><a href="{{u('post')}}">添加栏目</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="80">编号</th>
                    <th>栏目名称</th>
                    <th>封面栏目</th>
                    <th width="180">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>{{$d['cid']}}</td>
                        <td>{{$d['_catname']}}</td>
                        <td>
                            <if value="$d['ishome']">
                                <i class="fa fa-check-circle alert-success"></i>
                                <else/>
                                <i class="fa fa-times-circle"></i>
                            </if>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="{{u('post',['cid'=>$d['cid']])}}" class="btn btn-default">编辑</a>
                                <a href="javascript:;" onclick="remove({{$d['cid']}})" class="btn btn-default">删除</a>
                                <a href="c{{$d['cid']}}.html" target="_blank" class="btn btn-default">预览</a>
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
</block>