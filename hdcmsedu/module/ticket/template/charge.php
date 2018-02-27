<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">{{$ticket_name}}核销</a></li>
    </ul>
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-4 col-lg-2 control-label">{{$ticket_name}}标题</label>
                    <div class="col-sm-6">
                        <select name="tid" class="form-control">
                            <option value="">不限</option>
                            <foreach from="$ticket" value="$t">
                                <option value="{{$t['tid']}}">{{$t['title']}}</option>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 col-lg-2 control-label">用户编号</label>
                    <div class="col-sm-6">
                        <input name="uid" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 col-lg-2 control-label">{{$ticket_name}}状态</label>
                    <div class="col-sm-6">
                        <select name="status" class="form-control">
                            <option value="">不限</option>
                            <option value="1">未使用</option>
                            <option value="2">已使用</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>用户ID</th>
                    <th>标题</th>
                    <th>图标</th>
                    <th>
                        <if value="$_GET['type']==1">折扣
                            <else/>
                            面额
                        </if>
                    </th>
                    <th>兑换时间</th>
                    <th>{{$ticket_name}}状态</th>
                    <th>核销人</th>
                    <th>使用时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <foreach from="$data" value="$t">
                    <tr>
                        <td>{{$t['uid']}}</td>
                        <td>{{$t['title']}}</td>
                        <td>
                            <img src="{{$t['thumb']}}"
                                 style="width:50px;height:50px;border-radius: 8px;">
                        </td>
                        <td>{{$t['discount']}}</td>
                        <td>{{$t['createtime']?date('Y-m-d h:i',$t['createtime']):''}}</td>
                        <td>
                            <if value="$t['status']==2">
                                <span class="label label-success">已使用</span>
                                <else/>
                                <span class="label label-danger">未使用</span>
                            </if>
                        </td>
                        <td>{{$t['username']}}</td>
                        <td>{{$t['usetime']?date('Y-m-d h:i',$t['usetime']):''}}</td>
                        <td>
                            <if value="$t['status']==1">
                                <a href="javascript:;" onclick="verification({{$t['id']}})">核销</a>
                                - <a href="javascript:;" onclick="removeTicket({{$t['id']}})">删除</a>
                            </if>
                        </td>
                    </tr>
                </foreach>
                </tbody>
            </table>
            {{$page}}
        </div>
    </div>
</block>
<script>
    /**
     * 卡卷核销
     * @param id
     */
    function verification(id) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确定核销吗', function () {
                $.get('{!! url("site.verification") !!}', {id: id}, function (res) {
                    if (res.valid == 1) {
                        hdjs.message(res.message, 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'error');
                    }
                }, 'json');
            });
        });
    }

    /**
     * 删除卡卷
     * @param id
     */
    function removeTicket(id) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('删除后无法恢复', function () {
                $.get('{!! url("site.remove") !!}', {id: id}, function (res) {
                    if (res.valid == 1) {
                        hdjs.message(res.message, 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'error');
                    }
                }, 'json');
            });
        })
    }
</script>