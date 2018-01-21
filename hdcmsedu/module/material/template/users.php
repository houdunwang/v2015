<table class="table table-hover">
    <thead>
    <tr>
        <th width="80">编号</th>
        <th>昵称</th>
        <th width="120">操作</th>
    </tr>
    </thead>
    <tbody>
    <foreach from="$user" value="$v">
        <tr>
            <td>{{$v['uid']}}</td>
            <td>{{$v['nickname']}}</td>
            <td>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="user btn btn-default btn-sm" uid="{{$v['uid']}}">选择</button>
                </div>
            </td>
        </tr>
    </foreach>
    </tbody>
</table>