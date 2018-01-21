<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">已经安装模块</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="?s=system/package/lists">服务套餐列表</a></li>
        <if value="isset($_GET['id'])">
            <li role="presentation"><a href="?s=system/package/post">添加套餐</a></li>
            <li role="presentation" class="active"><a href="#">编辑套餐</a></li>
            <else/>
            <li role="presentation" class="active"><a href="?s=system/package/post">添加套餐</a></li>
        </if>
    </ul>
    <div class="clearfix">
        <div class="form-group">
            <form class="form-horizontal" action="" method="post" id="vue" @submit.prevent="submit" id="vue">
                <input type="hidden" name="id" value="{{$package['id']}}">
                <h5 class="page-header">服务套餐管理</h5>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">服务套餐名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" value="{{$package['name']}}"
                               required="required">
                    </div>
                </div>
                <h5 class="page-header">设置当前用户允许使用的模块</h5>
                <div class="panel panel-default">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="150">
                                    <input type="checkbox" @click="selectAll"> (全选)选择
                                </th>
                                <th>模块名称</th>
                                <th>模块标识</th>
                                <th>功能简介</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <foreach from="$modules" value="$p">
                                <tr>
                                    <td>
                                        <if value="$p['is_system']">
                                            <input type="checkbox" checked="checked" disabled="disabled">
                                            <else/>
                                            <if value="$package && in_array($p['name'], $package['modules'])">
                                                <input type="checkbox" name="modules[]" value="{{$p['name']}}"
                                                       checked="checked">
                                                <else/>
                                                <input type="checkbox" name="modules[]" value="{{$p['name']}}">
                                            </if>
                                        </if>
                                    </td>
                                    <td>{{$p['title']}}</td>
                                    <td>{{$p['name']}}</td>
                                    <td>{{$p['resume']}}</td>
                                    <td>
                                        <if value="$p['is_system']">
                                            <span class="label label-success">系统模块</span>
                                        </if>
                                    </td>
                                </tr>
                            </foreach>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5 class="page-header">设置当前用户允许使用的模板</h5>

                <div class="panel panel-default">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="150">
                                    <input type="checkbox" class="selectAll"> (全选)选择
                                </th>
                                <th>模板名称</th>
                                <th>模板标识</th>
                                <th>模板描述</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <foreach from="$templates" value="$t">
                                <tr>
                                    <td>
                                        <if value="$t['is_system']">
                                            <input type="checkbox" checked="checked" disabled="disabled">
                                            <elseif value="$package && in_array($t['name'], $package['template'])">
                                                <input type="checkbox" name="template[]" value="{{$t['name']}}"
                                                       checked="checked">
                                                <else/>
                                                <input type="checkbox" name="template[]" value="{{$t['name']}}">
                                        </if>
                                    </td>
                                    <td>{{$t['title']}}</td>
                                    <td>{{$t['name']}}</td>
                                    <td>{{$t['description']}}</td>
                                    <td>
                                        <if value="$t['is_system']">
                                            <span class="label label-success">系统模板</span>
                                        </if>
                                    </td>
                                </tr>
                            </foreach>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">确认</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</block>
<script>
    require(['hdjs', 'vue'], function (hdjs, Vue) {
        new Vue({
            el: '#vue',
            data: {},
            methods: {
                selectAll: function (e) {
                    $(e.target).parents('table').eq(0).find("[type='checkbox']").not(":disabled").prop('checked', $(e.target).prop('checked'));
                },
                submit: function () {
                    hdjs.submit();
                }
            }
        })
    });
</script>