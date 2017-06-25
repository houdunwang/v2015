<extend file='resource/admin/module.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="{{u('lists')}}">模块列表</a></li>
        <li><a href="{{u('post')}}">设计模块</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>预览图</th>
                    <th>模块名称</th>
                    <th>模块标识</th>
                    <th width="70">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$d">
                    <tr>
                        <td>
                            <img src="{{$d['preview']}}" style="height:60px;">
                        </td>
                        <td>{{$d['title']}}</td>
                        <td>{{$d['name']}}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <if value="$d['isinstall']">
                                    <a href="javascript:;" onclick="remove('{{$d['name']}}')"
                                       class="btn btn-default">卸载</a>
                                    <else/>
                                    <a href="{{u('install',['name'=>$d['name']])}}" class="btn btn-default">安装</a>
                                </if>
                            </div>
                        </td>
                    </tr>
                </foreach>
                </tbody>
            </table>
            <script>
                function remove(name) {
                    if (confirm('确定要卸载这个模块吗?')) {
                        location.href = "{{u('uninstall')}}&name=" + name;
                    }
                }
            </script>
        </div>
    </div>
</block>