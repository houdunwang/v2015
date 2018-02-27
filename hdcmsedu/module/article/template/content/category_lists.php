<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">栏目管理</a></li>
        <li><a href="{!! url('category.post') !!}">添加栏目</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="80">编号</th>
                    <th>名称</th>
                    <th width="120">模型</th>
                    <th>排序</th>
                    <th>封面</th>
                    <th width="100">状态</th>
                    <th width="180">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>{{$d['cid']}}</td>
                        <td>{!! $d['_catname'] !!}</td>
                        <td>{{$d['_model']['model_title']}}</td>
                        <td>{{$d['orderby']}}</td>
                        <td>
                            <if value="$d['is_system']==1">是<else/>否</if>
                        </td>
                        <td>
                            <if value="$d['status']==1">开启<else/>关闭</if>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="{{$d['url']}}" target="_blank" class="copy btn btn-default btn-sm">预览</a>
                                <a href="{!! url('category.post',['cid'=>$d['cid']]) !!}"
                                   class="btn btn-default btn-sm">编辑</a>
                                <button onclick="del({{$d['cid']}})" type="button" class="btn btn-default btn-sm">删除
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
    function del(cid) {
        require(['hdjs'],function(hdjs){
            hdjs.confirm('删除栏目将删除栏目下的所有文章! 确定删除栏目吗? ', function () {
                $.get('{!! url("category.del") !!}&cid=' + cid, function (res) {
                    if (res.valid) {
                        hdjs.message(res.message, 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'warning');
                    }
                }, 'json');
            })
        })
    }
</script>