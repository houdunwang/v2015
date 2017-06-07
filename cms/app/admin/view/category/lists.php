<extend file='resource/admin/article.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#" role="tab" data-toggle="tab">栏目列表</a></li>
        <li><a href="{{u('post')}}" role="tab" data-toggle="tab">添加栏目</a></li>
    </ul>
    <table class="table table-striped">
        <thead>
        <tr>
            <th width="80">编号</th>
            <th>栏目名称</th>
            <th width="150">操作</th>
        </tr>
        </thead>
        <tbody>
        <foreach from="$data" value="$d">
            <tr>
                <td>{{$d['cid']}}</td>
                <td>{{$d['_catname']}}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <a href="{{u('post',['cid'=>$d['cid']])}}" class="btn btn-default">编辑</a>
                        <a class="btn btn-default">删除</a>
                    </div>
                </td>
            </tr>
        </foreach>
        </tbody>
    </table>
</block>