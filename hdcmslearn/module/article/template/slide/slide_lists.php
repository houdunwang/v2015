<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="javascript:;">轮换图管理</a></li>
        <li><a href="{!! url('slide.post') !!}">添加图片</a></li>
    </ul>
    <form action="" method="post" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="150">排序</th>
                        <th>缩略图</th>
                        <th>标题</th>
                        <th width="120">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$data" value="$d">
                        <tr>
                            <td>
                                <input type="text" class="form-control input-sm"
                                       name="slide[{{$d['id']}}]"
                                       value="{{$d['displayorder']}}">
                            </td>
                            <td>
                                <img onclick="hdcms.preview('{{$d['thumb']}}')"
                                     src="{{pic($d['thumb'])}}"
                                     style="height:45px;border:solid 1px #dcdcdc;">
                            </td>
                            <td>{{$d['title']}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{!! url('slide.post')!!}&id={{$d['id'] !!}"
                                       class="btn btn-default btn-sm">编辑</a>
                                    <a href="javascript:del({{$d['id']}})"
                                       class="btn btn-default btn-sm">删除</a>
                                </div>

                            </td>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
        </div>
        <if value="$data">
            <button type="submit" class="btn btn-primary">确定</button>
        </if>
    </form>

    <script>
        function post(e) {
            e.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit();
            })
        }

        function del(id) {
            require(['hdjs'], function (hdjs) {
                hdjs.confirm('确定幻灯图片吗,删除后将不可以恢复?', function () {
                    url = "{!! url('slide.remove') !!}&id=" + id;
                    $.get(url, function (res) {
                        if (res.valid == 1) {
                            hdjs.message(res.message, 'refresh', 'success');
                        } else {
                            hdjs.message(res.message, '', 'error');
                        }
                    }, 'json');
                })
            })
        }
    </script>
</block>