<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">微信菜单管理</a></li>
        <li><a href="{!! url('site/post') !!}">添加菜单</a></li>
    </ul>
    <div class="alert alert-success">
        推送菜单后一般不会立刻看到效果，需要等待一段时间。<br/>你也可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="80">编号</th>
                    <th>标题</th>
                    <th>创建时间</th>
                    <th>是否生效</th>
                    <th width="220">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>{{$d['id']}}</td>
                        <td>
                            {{$d['title']}}
                        </td>
                        <td>{{date("Y-m-d H:i",$d['createtime'])}}</td>
                        <td>
                            <if value="$d['status']">
                                <span class="label label-success">已在微信端生效</span>
                                <else/>
                                <span class="label label-default">未在微信生效</span>
                            </if>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                                <a class="btn btn-default btn-sm" href="javascript:;"
                                   onclick="push({{$d['id']}})">推送到微信端</a>
                                <a class="btn btn-default btn-sm"
                                   href="{!! url('site.post',['id'=>$d['id']]) !!}">编辑</a>
                                <a class="btn btn-default btn-sm"
                                   href="javascript:del({{$d['id']}})">删除</a>
                            </div>
                        </td>
                    </tr>
                </foreach>
                </tbody>
            </table>
        </div>
    </div>
</block>
<style>
    table {
        table-layout: fixed;
    }
</style>
<script>
    /**
     * 删除菜单
     * @param id 菜单编号
     */
    function del(id) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确定删除这个菜单吗?', function () {
                $.get("{!! url('site.remove') !!}", {id: id}, function (res) {
                    if (res.valid) {
                        hdjs.message('菜单删除成功', 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'error');
                    }
                }, 'json');
            })
        })
    }

    //推送微信菜单
    function push(id) {
        require(['hdjs'], function (hdjs) {
            var url = "{!! url('site.pushWechat') !!}";
            var Modal = hdjs.loading();
            hdjs.post({
                url: url,
                data: {id: id},
                callback: function (json) {
                    Modal.modal('hide');
                    hdjs.message(json.message,'refresh');
                }
            });
        })
    }
</script>