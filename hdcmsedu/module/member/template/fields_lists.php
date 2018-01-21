<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="javascript:;">字段管理</a></li>
    </ul>
    <form method="post" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">字段管理</h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="100">排序</th>
                        <th>字段</th>
                        <th>标题</th>
                        <th>启用</th>
                        <th width="60">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$data" value="$d">
                        <tr>
                            <td>
                                <input type="hidden" name="member_fields[{{$d['id']}}][id]" class="form-control" value="{{$d['id']}}" >
                                <input type="text" name="member_fields[{{$d['id']}}][orderby]" class="form-control" value="{{$d['orderby']}}" required="required">
                            </td>
                            <td>{{$d['field']}}</td>
                            <td>{{$d['title']}}</td>
                            <td>
                                <input type="checkbox" name="member_fields[{{$d['id']}}][status]" value="1" {{$d['status']?'checked="checked"':''}}>
                            </td>
                            <td>
                                <a href="{!! url('site.fieldPost',['id'=>$d['id']]) !!}" class="btn btn-primary">编辑</a>
                            </td>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
    <script>
        function post(e) {
            e.preventDefault();
            require(['hdjs'],function(hdjs){
                hdjs.submit({successUrl:'refresh'});
            })
        }
    </script>
</block>