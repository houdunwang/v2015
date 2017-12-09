<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li><a href="{!! url('site/MemberLists') !!}">会员列表</a></li>
        <li class="active"><a href="javascript:;">添加会员</a></li>
    </ul>
    <form method="post" role="form" class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">添加会员</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">会员真实姓名</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="realname" required
                               value="{{old('realname')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">手机号</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="mobile" required
                               value="{{old('mobile')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">登陆密码</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">确认密码</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password2" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">邮箱</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="email" required value="{{old('email')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{v('site.setting.creditnames.credit1.title')}}
                    </label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="credit1" value="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{v('site.setting.creditnames.credit2.title')}}
                    </label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="credit2" value="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员组</label>
                    <div class="col-sm-8">
                        <select name="group_id" class="form-control">
                            <foreach from="$group" value="$g">
                                <option value="{{$g['id']}}">{{$g['title']}}</option>
                            </foreach>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存</button>
    </form>
    <script>
        function post(e) {
            e.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit();
            })
        }
    </script>
</block>