<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">设置站点权限</li>
    </ol>
    <form method="post" role="form" class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">站点【{{$site['name']}}】权限设置</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站站长</label>
                    <div class="col-sm-10">
						<span class="label label-success" id="username">
							<if value="$user['username']">
								<i class="fa fa-times-circle" style="cursor: pointer"
                                   onclick="delOwner({{SITEID}})"></i>
							</if>
							{{$user['username']}}
						</span>
                        <input type="hidden" name="uid" value="{{$user['uid']}}">
                        <a href="javascript:;" onclick="selectUser()">选择用户</a> -
                        如果是新用户请先<a href="javascript:;" onclick="addUser()">添加</a>
                        <span class="help-block">
							一个公众号只可拥有一个主管理员，管理员有管理公众号和添加操作员的权限
							未指定主管理员时将默认属于创始人，则公众号具有所有模块及模板权限
						</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">公众号可使用的权限（以下选中套餐）</h4>
            </div>
            <div class="panel-body">
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
                    <foreach from="$systemAllPackages" value="$p">
                        <tr>
                            <td>
                                <if value="$p['id']==0">
                                    <input type="checkbox" checked="checked" disabled="disabled">
                                    <elseif value="in_array($p['id'],$defaultPackage)">
                                        <input type="checkbox" name="package_id[]" value="{{$p['id']}}"
                                               checked="checked" disabled="disabled">
                                        <elseif value="in_array($p['id'],$extPackage)">
                                            <input type="checkbox" name="package_id[]" value="{{$p['id']}}"
                                                   checked="checked">
                                            <else/>
                                            <input type="checkbox" name="package_id[]" value="{{$p['id']}}">
                                </if>
                            </td>
                            <td>{{$p['name']}}</td>
                            <td>
                                <if value="$p['id']==-1">
                                    <span class="label label-danger">所有模块</span>
                                    <else/>
                                    <span class="label label-success">系统模块</span>
                                    <foreach from="$p['modules']" value="$m">
                                        <span class="label label-info">{{$m['title']}}</span>
                                    </foreach>
                                </if>
                            </td>
                            <td>
                                <if value="$p['id']==-1">
                                    <span class="label label-danger">所有模板</span>
                                    <else/>
                                    <span class="label label-success">系统模板</span>
                                    <foreach from="$p['template']" value="$t">
                                        <span class="label label-info">{{$t['title']}}</span>
                                    </foreach>
                                </if>
                            </td>
                        </tr>
                    </foreach>
                    <tr>
                        <td></td>
                        <td>专属附加权限</td>
                        <td id="extModule">
                            <foreach from="$extModule" value="$v">
                                <span class="label label-success">{{$v['title']}}</span>
                                <input name="modules[]" value="{{$v['name']}}" type="hidden"/>
                            </foreach>
                        </td>
                        <td id="extTemplate">
                            <foreach from="$extTemplate" value="$t">
                                <span class="label label-success">{{$t['title']}}</span>
                                <input name="templates[]" value="{{$t['name']}}" type="hidden"/>
                            </foreach>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-default" onclick="extModules()">附加权限</button>
                        </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</block>

<script>
    //提交表单
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit();
        })
    }

    /**
     * 选择管理员
     */
    function selectUser() {
        require(['hdjs'], function (hdjs) {
            //user 选中用户id 数组类型
            hdjs.modal({
                title: '选择用户',
                width: 700,
                id: 'getSingleUser',
                content: ["?s=component/user/select&single=1&siteid={{siteid()}}"],
                events: {
                    'hidden.bs.modal': function () {
                        var bt = $("#getSingleUser").find("button[class*='primary']");
                        var username = bt.attr('username');
                        var uid = bt.attr('uid');
                        $("#username").text(username);
                        $("[name='uid']").val(uid);
                        $("#getSingleUser").remove();
                    }
                }
            })
        })
    }

    /**
     * 添加用户
     */
    function addUser() {
        require(['hdjs'], function (hdjs) {
            hdjs.modal({
                content: ['?s=system/user/add'],
                title: '会员注册',
                width: 800
            });
        })
    }

    /**
     * 删除站长
     * @param siteid 站点编号
     */
    function delOwner(siteid) {
        require(['hdjs'], function (hdjs) {
            $.get('{!! u("delOwner") !!}', {siteid: siteid}, function () {
                hdjs.message('站长删除成功', 'refresh', 'success');
            })
        })
    }

    /**
     * 专属附加权限
     */
    function extModules() {
        require(['resource/js/hdcms.js', 'hdjs'], function (hdcms) {
            var options = {
                module: [],
                template: []
            }
            //已经选中的模板与模板
            $("#extModule input").each(function () {
                options.module.push($(this).val());
            });
            $("#extTemplate input").each(function () {
                options.template.push($(this).val());
            });
            hdcms.getModuleTemplate(function (json) {
                var mHtml = ''
                var tHtml = '';
                $(json.module).each(function (i) {
                    mHtml += '<span class="label label-success">' + json.module[i]['title'] + '</span> ' +
                        '<input name="modules[]" value="' + json.module[i]['name'] + '" type="hidden"/>';
                })
                $(json.template).each(function (i) {
                    tHtml += '<span class="label label-success">' + json.template[i]['title'] + '</span> ' +
                        '<input name="templates[]" value="' + json.template[i]['name'] + '" type="hidden"/>';
                })
                $("#extModule").html(mHtml);
                $("#extTemplate").html(tHtml);
            }, options);
        })
    }
</script>
<style>
    .nav li.normal {
        background: #eee;
    }

    .nav li.normal a, .nav li.normal a:active, .nav li.normal a:focus {
        border: none;
    }
</style>
