<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">模型管理</a></li>
        <li><a href="{!! url('model.post') !!}">添加模型</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="80">编号</th>
                    <th>模型名称</th>
                    <th>模型标识</th>
                    <th>系统模型</th>
                    <th width="200">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>{{$d['mid']}}</td>
                        <td>{{$d['model_title']}}</td>
                        <td>{{$d['model_name']}}</td>
                        <td>
                            <if value="$d['is_system']==1">是
                                <else/>
                                否
                            </if>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="{!! url('field.lists',['mid'=>$d['mid']]) !!}" class="btn btn-default btn-sm">字段管理</a>
                                <a href="{!! url('model.post',['mid'=>$d['mid']]) !!}" class="btn btn-default btn-sm">编辑</a>
                                <button onclick="del({{$d['mid']}})" type="button" class="btn btn-default btn-sm">删除
                                </button>
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
    function del(mid) {
        hdjs.confirm('确定删除这个模型吗?', function () {
            $.get('{!! url("model.del") !!}&mid=' + mid, function (res) {
                if (res.valid) {
                    location.reload(true);
                } else {
                    hdjs.message(res.message, '', 'error');
                }
            }, 'json');
        })
    }
</script>