<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="#">系统</a></li>
        <li class="active">我的帐户</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="{!! u('lists') !!}">我的资料</a></li>
    </ul>
    <form class="form-horizontal" method="post" id="password" onsubmit="postPassword(event)">
        <div class="panel panel-default">
            <div class="panel-heading">修改密码</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input disabled="disabled" value="{{v('user.info.username')}}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" required/>
                        <span class="help-block">请填写密码，最小长度为 6 个字符</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password2" required/>
                        <span class="help-block">重复输入密码，确认正确输入</span>
                    </div>
                </div>
                <button class="btn btn-default col-sm-offset-2">保存修改</button>
            </div>
            <script>
                function postPassword(event) {
                    event.preventDefault();
                    require(['hdjs'], function (hdjs) {
                        hdjs.submit({url: "{!! u('password') !!}", successUrl: '',data:$("#password").serialize()});
                    })
                }
            </script>
        </div>
    </form>
    <form class="form-horizontal" method="post" id="info" onsubmit="info(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">个人资料</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">真实姓名</label>
                    <div class="col-sm-10">
                        <input name="realname" value="{{v('user.info.realname')}}" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">邮箱</label>
                    <div class="col-sm-10">
                        <input name="email" value="{{v('user.info.email')}}" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">QQ</label>
                    <div class="col-sm-10">
                        <input name="qq" value="{{v('user.info.qq')}}" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">手机号</label>
                    <div class="col-sm-10">
                        <input name="mobile" value="{{v('user.info.mobile')}}" class="form-control" required>
                    </div>
                </div>
                <button class="btn btn-default col-sm-offset-2">保存修改</button>
            </div>
        </div>
        <script>
            function info(event) {
                event.preventDefault();
                require(['hdjs'], function (hdjs) {
                    hdjs.submit({url: "{!! u('info') !!}", successUrl: '',data:$("#info").serialize()});
                })
            }
        </script>
    </form>
</block>