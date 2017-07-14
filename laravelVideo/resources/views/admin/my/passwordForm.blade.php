@extends('admin.layout.master')
@section('content')
    <form action="" method="post" class="form-horizontal" role="form">
        {{csrf_field()}}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">修改密码</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">原密码</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="original_password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="password_confirmation">
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存修改</button>
    </form>
@endsection