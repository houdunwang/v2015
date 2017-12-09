<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">会员列表</a></li>
        <li><a href="{!! url('site/MemberPost') !!}">添加会员</a></li>
    </ul>
    <form class="form-horizontal" method="post">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">搜索</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">用户类型</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="user_type" checked value="email"> 用户名
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="user_type" value="mobile"> 手机号
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form class="form-horizontal" onsubmit="return false;">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="50">删除</th>
                        <th width="100">会员编号</th>
                        <th>昵称/真实姓名</th>
                        <th>会员组</th>
                        <th>手机</th>
                        <th>邮箱</th>
                        <th>余额/积分</th>
                        <th>注册时间</th>
                        <th class="text-right">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$data" value="$d">
                        <tr>
                            <td>
                                <input type="checkbox" name="uid[]" value="{!! $d['uid'] !!}">
                            </td>
                            <td>{!! $d['uid'] !!}</td>
                            <td>{!! $d['nickname'] !!}<br/>{!! $d['realname'] !!}</td>
                            <td>{!! $d['title'] !!}</td>
                            <td>{!! $d['mobile'] !!}</td>
                            <td>{!! $d['email'] !!}</td>
                            <td>
                                <span class="label label-info" style="line-height: 1.8">积分:{!! $d['credit1'] !!}</span>
                                <br/>
                                <span class="label label-warning">余额:{!! $d['credit2'] !!}</span>
                            </td>
                            <td>
                                {!! date('Y-m-d',$d['createtime']) !!}
                            </td>
                            <td>
                                <div class="btn-group pull-right" role="group" aria-label="...">
                                    <a href="javascript:;" data-type="credit1" data-uid="{!! $d['uid'] !!}"
                                       onclick="trade(this)" class="btn btn-default">积分</a>
                                    <a href="javascript:;" data-type="credit2" data-uid="{!! $d['uid'] !!}"
                                       onclick="trade(this)" class="btn btn-default">余额</a>
                                    <a href="{!! url('site/MemberEdit') !!}&uid={!! $d['uid'] !!}"
                                       class="btn btn-default">编辑</a>
                                </div>
                            </td>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-primary" onclick="del()"> 删除选中用户</button>
        </div>
        <div class="pull-right">
            {!! $data->links() !!}
        </div>
    </form>
    <script>
        //修改会员积分/余额
        function trade(obj) {
            require(['hdjs'], function (hdjs) {
                //会员编号
                var uid = $(obj).data('uid');
                //积分类型 credit1积分  credit2余额
                var type = $(obj).data('type');
                hdjs.modal({
                    //加载的远程地址
                    content: ['{!! url("site/trade") !!}&uid=' + uid + "&type=" + type],
                    title: '会员积分操作',
                    width: 800,
                    show: true
                });
            })
        }

        function del() {
            require(['hdjs'], function (hdjs) {
                if ($("[name*='uid']:checked").length == 0) {
                    hdjs.message('你还没有选择要删除的用户', '', 'warning');
                    return;
                }
                hdjs.confirm('确定删除用户吗?', function () {
                    $.post("{!! url('site.delete') !!}", $("form").serialize(), function (res) {
                        if (res.valid == 1) {
                            hdjs.message(res.message, 'refresh', 'success');
                        } else {
                            hdjs.message(res.message, '', 'error');
                        }
                    }, 'json');
                });
            });
        }
    </script>
</block>