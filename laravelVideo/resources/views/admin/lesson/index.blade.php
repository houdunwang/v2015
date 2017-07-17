@extends('admin.layout.master')
@section('content')
    <ul class="nav nav-tabs">
        <li class="active"><a href="">课程列表</a></li>
        <li><a href="/admin/lesson/create">新增课程</a></li>
    </ul>
    <form action="" method="post" class="form-horizontal" role="form">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">视频课程列表</h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="100">编号</th>
                        <th>课程名称</th>
                        <th>视频数量</th>
                        <th width="120">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                        <tr>
                            <td>{{$d['id']}}</td>
                            <td>{{$d['title']}}</td>
                            <td>{{$d->videos()->count()}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="/admin/lesson/{{$d['id']}}/edit" class="btn btn-default">编辑</a>
                                    <a href="javascript:;" onclick="del({{$d['id']}})"
                                       class="btn btn-default">删除</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <script>
        function del(id) {
            require(['util'], function (util) {
                util.confirm('确定删除吗?', function () {
                    $.ajax({
                        url: '/admin/lesson/' + id,
                        method: 'DELETE',
                        success: function (response) {
                            util.message(response.message, 'refresh');
                        }
                    })
                })
            })
        }
    </script>
@endsection