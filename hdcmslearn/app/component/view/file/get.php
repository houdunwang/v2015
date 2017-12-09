<if value="$dir=='.'">
    <button class="btn btn-default btn-sm" disabled>返回上级</button>
    <else/>
    <button class="btn btn-default btn-sm" onclick="getDirFiles('{{dirname($dir)}}')">返回</button>
</if>
<table class="table table-hover">
    <thead>
    <tr>
        <th width="50">类型</th>
        <th>名称</th>
        <th width="120">名称</th>
    </tr>
    </thead>
    <tbody>
    <foreach from="$data" value="$d">
        <tr>
            <td>
                {!! is_dir($d)?'<i class="fa fa-folder-open-o"></i>':'<i class="fa fa-file-text-o"></i>' !!}
            </td>
            <td>{{$d}}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default" onclick="selectFileCompase('{{$d}}')">选择</button>
                    <if value="is_dir($d)">
                        <button type="button" onclick="getDirFiles('{{$d}}')" class="btn btn-default">进入</button>
                    </if>
                </div>
            </td>
        </tr>
    </foreach>
    </tbody>
</table>