<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">已经安装模块</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('lists') !!}">用户组列表</a></li>
        <if value="q('get.id')">
            <li role="presentation"><a href="{!! u('post') !!}">添加用户组</a></li>
            <li role="presentation" class="active"><a href="#">编辑用户组</a></li>
            <else/>
            <li role="presentation" class="active"><a href="{!! u('post') !!}">添加用户组</a></li>
        </if>
    </ul>
    <h5 class="page-header">用户组管理</h5>

    <form class="form-horizontal" method="post" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">基本信息</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{$group['name']}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">站点数量</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="maxsite" value="{{$group['maxsite']?:3}}" required>
                        <span class="help-block">限制站点的数量，为0则不允许添加。</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">中间件数量</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="middleware_num"
                               value="{{$group['middleware_num']?:100}}" required>
                        <span class="help-block">限制站点的数量，为0则不允许添加。</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">路由数量</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="router_num"
                               value="{{$group['router_num']?:100}}" required>
                        <span class="help-block">限制站点的数量，为0则不允许添加。</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">有效期限</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="number" class="form-control" name="daylimit" value="{{$group['daylimit']?:30}}" required>
                            <span class="input-group-addon">天</span>
                        </div>
                        <span class="help-block">设置用户组的有效期限, 到期后该用户组的所有公众号只能使用 "基础服务"。</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">可使用的公众服务套餐</h3>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th>公众服务套餐</th>
                        <th>模块权限</th>
                        <th>模板权限</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$packages" value="$p">
                        <tr>
                            <td>
                                <if value="$p['id']==0">
                                    <input type="checkbox" disabled="disabled" checked="checked">
                                    <elseif value="$group && in_array($p['id'],$group['package'])">
                                        <input type="checkbox" name="package[]" value="{{$p['id']}}" checked="checked">
                                        <else/>
                                        <input type="checkbox" name="package[]" value="{{$p['id']}}">
                                </if>
                            </td>
                            <td>{{$p['name']}}</td>
                            <td>
                                <span class="label label-success">系统模块</span>
                                <foreach from="$p['modules']" value="$v">
                                    <span class="label label-info">{{$v['title']}}</span>
                                </foreach>
                            </td>
                            <td>
                                <span class="label label-success">系统模板</span>
                                <foreach from="$p['template']" value="$v">
                                    <span class="label label-info">{{$v['title']}}</span>
                                </foreach>
                            </td>
                        </tr>
                    </foreach>

                    </tbody>
                </table>
            </div>
        </div>
        <button class="btn btn-primary">提交</button>
    </form>
    <script>
        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit();
            });
        }
    </script>
</block>
