<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">编辑用户</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('lists') !!}">用户列表</a></li>
        <li role="presentation"><a href="{!! u('add') !!}">添加用户</a></li>
        <li role="presentation" class="active"><a href="{{__URL__}}">编辑用户</a></li>
        <li role="presentation"><a href="{!! u('permission',array('uid'=>$_GET['uid'])) !!}">查看用户权限</a></li>
    </ul>
    <form class="form-horizontal" method="post" onsubmit="post(event)">
        <input type="hidden" name="uid" value="{{$user['uid']}}">
        <h5 class="page-header">编辑用户帐号信息</h5>
        <div class="form-group">
            <label class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input class="form-control" value="{{$user['username']}}" disabled="disabled">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">密码</label>

            <div class="col-sm-10">
                <input type="password" class="form-control" name="password">
                <span class="help-block">请填写密码，最小长度为 6 个字符</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password2">
                <span class="help-block">重复输入密码，确认正确输入</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">真实姓名</label>
            <div class="col-sm-10">
                <input class="form-control" value="{{$user['realname']}}" name="realname">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">服务时间</label>

            <div class="col-sm-10">
                <p class="form-control-static">
                    <strong class="text-danger">开始时间：{{date('Y-m-d',$user['starttime'])}}~~
                        到期时间：{{date('Y-m-d',$user['endtime'])}}</strong>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">设置到期时间</label>

            <div class="col-sm-10">
                <input name="endtime" value="{{date('Y-m-j',$user['endtime'])}}" id="datetimepicker"
                       class="form-control">
                <span class="help-block">设置到期时间，留空为不限制. <a href="javascript:;" class="text-primary"
                                                           onclick="$(this).parent().prev().val('')">清空</a></span>

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">所属用户组</label>
            <div class="col-sm-10">
                <select class="js-example-basic-single form-control" name="groupid">
                    <foreach from="$groups" value="$g">
                        <if value="$g['id']==$user['groupid']">
                            <option value="{{$g['id']}}" selected="selected">{{$g['name']}}</option>
                            <else/>
                            <option value="{{$g['id']}}">{{$g['name']}}</option>
                        </if>
                    </foreach>
                </select>
                <span class="help-block">分配用户所属用户组后，该用户会自动拥有此用户组内的模块操作权限</span>
                <span class="help-block">
                    <strong class="text-danger">设置用户组后，系统会根据对应用户组的服务期限对用户的服务开始时间和结束时间进行初始化</strong>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">备注</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="remark">{{$user['remark']}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">上次登录时间</label>
            <div class="col-sm-10">
                <span class="form-control">{{date('Y-m-d H:i',$user['lasttime'])}}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">上次登录IP</label>
            <div class="col-sm-10">
                <span class="form-control">{{$user['lastip']}}</span>
            </div>
        </div>
        <h5 class="page-header">编辑用户基本资料</h5>
        <div class="form-group">
            <label class="col-sm-2 control-label">QQ号</label>
            <div class="col-sm-10">
                <input class="form-control" name="qq" value="{{$user['qq']}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">手机</label>
            <div class="col-sm-10">
                <input class="form-control" name="mobile" value="{{$user['mobile']}}">
            </div>
        </div>
        <button class="btn btn-primary col-sm-offset-2">提交保存</button>
    </form>
</block>

<script>
    require(['hdjs'], function (hdjs) {
        hdjs.datetimepicker('#datetimepicker',{
            format: 'Y-m-d',
            timepicker: false
        });
    })

    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit();
        })
    }
</script>
