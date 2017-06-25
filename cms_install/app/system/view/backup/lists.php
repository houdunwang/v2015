<extend file='resource/admin/system.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#">备份列表</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>目录</th>
                    <th>大小</th>
                    <th>创建时间</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$dirs" value="$d">
                    <tr>
                        <td>{{$d['path']}}</td>
                        <td>{{Tool::getSize($d['size'])}}</td>
                        <td>{{date('Y-m-d h:i',$d['filemtime'])}}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="javascript:;" onclick="recovery('{{$d['filename']}}')"
                                   class="btn btn-default">还原</a>
                                <a href="javascript:;" onclick="remove('{{$d['filename']}}')"
                                   class="btn btn-default">删除</a>
                            </div>
                        </td>
                    </tr>
                </foreach>
                </tbody>
            </table>
            <script>
                function remove(dir) {
                    if (confirm('确定要删除备份吗?')) {
                        location.href = "{{u('remove')}}&dir=" + dir;
                    }
                }

                function recovery(dir) {
                    if (confirm('确定要执行数据还原吗?')) {
                        location.href = "{{u('recovery')}}&dir=" + dir;
                    }
                }
            </script>
        </div>
    </div>
</block>