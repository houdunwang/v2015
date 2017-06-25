<extend file='resource/admin/system.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="javascript:;" role="tab" data-toggle="tab">修改密码</a></li>
    </ul>
    <form action="" method="post" role="form" class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">修改密码</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">帐号</label>
                    <div class="col-sm-10">
                        <input type="text" disabled="disabled" class="form-control" value="{{v('user.username')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" placeholder="请输入新密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-10">
                        <input type="password" name="password_confirm" class="form-control" placeholder="请输入确认密码">
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存修改</button>
    </form>
    <script>
        function post(event) {
            event.preventDefault();
            require(['util'], function (util) {
                util.submit({
                    url: '{{__URL__}}',
                    successUrl: 'refresh',
                });
            });
        }
    </script>
</block>