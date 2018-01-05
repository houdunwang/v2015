<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">修改密码</a></li>
    </ul>
    <div class="panel panel-default" id="app">
        <div class="panel-heading">
            修改密码
        </div>
        <div class="panel-body">
            <form class="form-horizontal" onsubmit="post(event)">
                <div class="form-group">
                    <label class="col-sm-2 control-label">原密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="rpassword">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">确认原密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="cpassword">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary">确定修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit({
                    successUrl: 'refresh'
                });
            })
        }
    </script>
</block>
