<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#">字段列表</a></li>
        <li><a href="{!! url('field.post',['mid'=>$_GET['mid']]) !!}">添加字段</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>名称</th>
                    <th>标识</th>
                    <th>系统字段</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>{{$d['id']}}</td>
                        <td>{{$d['title']}}</td>
                        <td>{{$d['name']}}</td>
                        <td>
                            <if value="$d['is_system']==1">是
                                <else/>
                                否
                            </if>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="{!! url('field.post',['mid'=>$d['mid'],'id'=>$d['id']]) !!}" class="btn btn-default btn-sm">编辑</a>
                                <button onclick="del({{$d['id']}})" type="button" class="btn btn-default btn-sm">删除
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
    function del(id) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确定删除这个字段吗?删除字段后不可以恢复,请事先做好数据备份!', function () {
                $.get('{!! url("field.del") !!}&id=' + id, function (res) {
                    hdjs.message(res.message,'refresh');
                }, 'json');
            });
        })
    }
</script>