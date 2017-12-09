<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">用户列表</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="{!! u('lists') !!}">用户列表</a></li>
        <li role="presentation"><a href="{!! u('add') !!}">添加用户</a></li>
    </ul>
    <form action="{!! u('remove') !!}" class="form-horizontal" method="post">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">可使用的公众服务套餐</h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="100">用户名</th>
                        <th>真实姓名</th>
                        <th>身份</th>
                        <th>状态</th>
                        <th>注册时间</th>
                        <th>服务开始时间 ~~ 结束时间</th>
                        <th width="50">操作</th>
                        <th width="100"></th>
                        <th width="75"></th>
                        <th width="75"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$users" value="$u">
                        <tr>
                            <td>{{$u['username']}}</td>
                            <td>{{$u['realname']}}</td>
                            <td>
                                <if value="$u['groupid']==-1">
                                    <span class="label label-success">管理员</span>
                                    <elseif value="$u['groupid']==0">
                                        <span class="label label-info">体验用户组</span>
                                        <else/>
                                        <span class="label label-info">{{$u['name']}}</span>
                                </if>
                            </td>
                            <td>
                                <if value="$u['status']">
                                    <span class="label label-success">正常状态</span>
                                    <else/>
                                    <span class="label label-danger">被禁止</span>
                                </if>
                            </td>
                            <td>{{date('Y-m-d',$u['regtime'])}}</td>
                            <td>
                                {{date('Y-m-d',$u['starttime'])}} ~~
                                <if value="$u['endtime']">
                                    {{date('Y-m-d',$u['endtime'])}}
                                    <else/>
                                    永久有效
                                </if>
                            </td>
                            <td>
                                <a href="{!! u('edit',array('uid'=>$u['uid'])) !!}">编辑</a>
                            </td>
                            <if value="$u['groupid']==-1">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <else/>
                                <td>
                                    <a href="{!! u('permission',array('uid'=>$u['uid'])) !!}">查看操作权限</a>
                                </td>
                                <td>
                                    <if value="$u['status']">
                                        <a href="javascript:;" onclick="updateStatus({{$u['uid']}},0)">禁止用户</a>
                                        <else/>
                                        <a href="javascript:;" onclick="updateStatus({{$u['uid']}},1)"
                                           class="text-danger">启用用户</a>
                                    </if>
                                </td>
                                <td>
                                    <a href="javascript:;"
                                       onclick="removeUser('{{$u['username']}}',{{$u['uid']}})">删除用户</a>
                                </td>
                            </if>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    {!! $users->links() !!}
</block>

<script>
    /**
     * 锁定或解锁用户
     * @param uid
     * @param status
     */
    function updateStatus(uid, status) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确认要禁用/解禁此用户吗? ', function () {
                url = "{!! u('updateStatus') !!}&uid=" + uid + "&status=" + status;
                $.get(url, function (res) {
                    if (res.valid == 1) {
                        hdjs.message(res.message, 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'warning');
                    }
                }, 'json')
            });
        });
    }

    //删除用户
    function removeUser(username, uid) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确定删除 [' + username + '] 用户吗? ', function () {
                $.post("{!! u('remove') !!}", {uid: uid}, function (res) {
                    if (res.valid == 1) {
                        hdjs.message('删除用户成功', 'refresh');
                    } else {
                        hdjs.message('删除失败', '');
                    }
                }, 'json')
            });
        });
    }
</script>
