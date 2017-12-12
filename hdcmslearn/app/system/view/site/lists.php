<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="#">首页</a></li>
        <li>网站列表</li>
    </ol>
    <if value="v('user.info.groupid') gte 1">
        <div class="alert alert-warning">
            温馨提示：
            <i class="fa fa-info-circle"></i>
            Hi，<span class="text-strong">{{v('user.info.username')}}</span>，
            您所在的会员组: <span class="text-strong">{{v('user.group.name')}}</span>，
            账号有效期限：
            <span class="text-strong">
                {!! date('Y-m-d',v('user.info.starttime')) !!} ~~ {{v('user.info.endtime')?date('Y-m-d',v('user.info.endtime')):'无限制'}}
            </span>，
            可添加 <span class="text-strong">{{v('user.group.maxsite')}} </span>个站点，
            已添加<span class="text-strong"> {{$user::siteNums()}} </span>个。
        </div>
        <else/>
        <div class="alert alert-success">
            温馨提示：
            <i class="fa fa-info-circle"></i>
            Hi，<span class="text-strong">{{v('user.info.username')}}</span> 您是系统超级管理员不受任何功能限制。
        </div>
    </if>
    <div class="clearfix">
        <div class="input-group">
            <a href="?s=system/site/addSite" class="btn btn-primary"><i class="fa fa-plus"></i> 添加网站</a>
        </div>
    </div>
    <br/>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">筛选</h3>
        </div>
        <div class="panel-body">
            <form action="?s=system/site/lists" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label">搜索</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" id="sitename" name="sitename" placeholder="请输入网站名称">
                            <input type="text" class="form-control hide" id="domain" name="domain"
                                   placeholder="请输入网站域名">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"
                                           onclick="$('#domain').addClass('hide').val('');$('#sitename').removeClass('hide')">根据网站名称搜索</a>
                                    </li>
                                    <li><a href="#"
                                           onclick="$('#sitename').addClass('hide').val('');$('#domain').removeClass('hide')">根据公众号中称搜索</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <foreach from="$sites" value="$s">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="col-xs-6" style="position: relative">
                            <span>
                                套餐:
                                <?php if (empty($s['owner'])) { ?>
                                    所有套餐
                                <?php } else { ?>
                                    {{$s['owner']['group_name']}}
                                <?php }; ?>
                            </span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <a href="?s=site/entry/home&siteid={{$s['siteid']}}" class="text-info">
                                <strong><i class="fa fa-cog"></i> 管理站点</strong>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body clearfix" style="padding:8px 15px;">
                        <div class="col-xs-4 col-md-1">
                            <if value="$s['icon'] && is_file($s['icon'])">
                                <img src="{{$s['icon']}}"
                                     style="width:50px;height:50px;border-radius: 5px;border:solid 1px #dcdcdc;">
                                <else/>
                                <i class="fa fa-rss fa-4x"></i>
                            </if>
                        </div>
                        <div class="col-xs-4 col-md-5">
                            <h4 style="line-height:35px;overflow: hidden;height:30px;">{{$s['name']}}</h4>
                        </div>
                        <div class="col-xs-4 col-md-6 text-right" style="line-height:60px;height:45px;">
                            <?php if ($s->wechat()->is_connect) { ?>
                                <a href="javascript:;" data-toggle="tooltip" data-placement="top" title="接入状态: 接入成功">
                                    <i class="fa fa-check-circle fa-2x text-success"></i>
                                </a>
                            <?php } else { ?>
                                <a href="javascript:;" data-toggle="tooltip" data-placement="top"
                                   title="公众号接入失败,请重新修改公众号配置文件并进行连接测试.">
                                    <i class="fa fa-times-circle fa-2x text-warning"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="panel-footer clearfix">
                        <div class="col-xs-6">
                            服务有效期 :
                            <?php if (empty($s['owner'])) { ?>
                                无限制
                            <?php } else if ($s['owner']['endtime'] == 0) { ?>
                                无限制
                            <?php } else if ($s['owner']['endtime'] < time()) { ?>
                                <span class="label label-danger">已到期</span>
                            <?php } else { ?>
                                {!! date("Y-m-d", $s['owner']['starttime']) !!} ~
                                {!!$s['owner']['endtime']==0?'无限制':date("Y-m-d", $s['owner']['endtime']) !!}
                            <?php } ?>
                            <if value="$s['owner']">
                                &nbsp;&nbsp;&nbsp;站长 : {{$s['owner']['username']}} ({{$s['user_group']['name']}})
                            </if>
                        </div>
                        <div class="col-xs-6 text-right">
                            <?php if ($user->isSuperUser(v('user.info.uid'), 'return')) { ?>
                                <a href="?s=system/site/access_setting&siteid={{$s['siteid']}}">
                                    <i class="fa fa-key"></i> 设置权限
                                </a>&nbsp;&nbsp;&nbsp;
                            <?php } ?>
                            <?php if ($user->isManage($s['siteid'], v('user.info.uid'))) { ?>
                                <a href="?s=system/site/wechat&step=wechat&siteid={{$s['siteid']}}">
                                    <i class="fa fa-comment-o"></i> 微信公众号
                                </a>&nbsp;&nbsp;&nbsp;
                            <?php } ?>
                            <?php if ($user->isManage($s['siteid'], v('user.info.uid'))) { ?>
                                <a href="?s=system/permission/users&siteid={{$s['siteid']}}">
                                    <i class="fa fa-user"></i>操作员管理
                                </a>&nbsp;&nbsp;&nbsp;
                            <?php } ?>
                            <?php if ($user->isOwner($s['siteid'], v('user.info.uid'))) { ?>
                                <a href="javascript:;" onclick="delSite({{$s['siteid']}},'{{$s['name']}}')">
                                    <i class="fa fa-trash"></i> 删除
                                </a>&nbsp;&nbsp;&nbsp;
                            <?php } ?>
                            <?php if ($user->isManage($s['siteid'], v('user.info.uid'))) { ?>
                                <a href="?s=system/site/edit&siteid={{$s['siteid']}}">
                                    <i class="fa fa-pencil-square-o"></i> 编辑
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </foreach>
        </div>
    </div>
    <script>
        //公众号接入状态提示
        require(['hdjs'], function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        })

        //删除站点
        function delSite(siteid, name) {
            require(['hdjs'], function (hdjs) {
                hdjs.confirm('确定删除 [' + name + '] 站点吗? 将删除站点的所有数据!', function () {
                    var Modal = hdjs.loading()
                    $.get('?s=system/site/remove&siteid=' + siteid, function (res) {
                        Modal.modal('hide')
                        if (res.valid) {
                            hdjs.message(res.message, 'refresh', 'success');
                        } else {
                            hdjs.message(res.message, '', 'error');
                        }
                    }, 'json');
                })
            })
        }
    </script>
</block>