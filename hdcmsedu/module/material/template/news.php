<extend file="resource/view/site"/>
<block name="content">
    <link rel="stylesheet" href="{{MODULE_TEMPLATE_PATH}}/css.css">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{!! url('site/image') !!}">图片素材列表</a></li>
        <li class="active"><a href="{!! url('site/news') !!}">图文消息列表</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="line-height: 2em;">图文列表</h3>
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a href="{!! url('site/postNews') !!}" class="btn btn-success btn-sm ">
                    <i class="fa fa-plus"></i> 新建图文消息
                </a>
                <a href="{!! url('site/syncNews') !!}" class="btn btn-default btn-sm ">
                    <i class="fa fa-cloud-download"></i>与微信服务器同步
                </a>
            </div>
        </div>
        <div class="panel-body">
            <div class="news">
                <foreach from="$data" value="$m">
                    <div class="lists">
                        <ul>
                            <foreach from="$m['data']['articles']" value="$v" key="$k">
                                <if value="$k==0">
                                    <li>
                                        <div class="pic" style="background:url({!! pic($v['pic']) !!})">
                                            <h3>{{$v['title']}}</h3>
                                        </div>
                                    </li>
                                </if>
                                <if value="$k gt 0">
                                    <!--子图文-->
                                    <li class="small clearfix">
                                        <p>{{$v['title']}}</p>
                                        <div class="pic" style="background-image:url({!! pic($v['pic']) !!})"></div>
                                    </li>
                                </if>
                                <li class="action">
                                    <a href="{!! url('site/PostNews',['id'=>$m['id']]) !!}"><i class="fa fa-trash-o"></i> 编辑</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="remove({{$m['id']}})"><i class="fa fa-pencil-square-o"></i> 删除</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="send({{$m['id']}})"><i class="fa fa-paper-plane-o"></i> 群发</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="preview({{$m['id']}})"><i class="fa fa-eye"></i> 预览</a>
                                </li>
                            </foreach>
                        </ul>
                    </div>
                </foreach>
            </div>
        </div>
        {!! $data->links() !!}
    </div>
    <script>
        /**
         * 发送微信预览消息
         * @param id
         */
        function preview(id) {
            require(['hdjs', 'resource/js/member.js'], function (hdjs, member) {
                member.wechat(function (user) {
                    $.post('{!! url("site/preview") !!}', {id: id, uid: user.uid}, function (res) {
                        if (res.valid == 1) {
                            hdjs.message(res.message, '', 'success');
                        } else {
                            hdjs.message(res.message, '', 'error');
                        }
                    }, 'json');
                })
            })
        }

        /**
         * 删除消息
         * @param id
         */
        function remove(id) {
            require(['hdjs', 'resource/js/member.js'], function (hdjs, member) {
                hdjs.confirm('确定删除图文消息吗?', function () {
                    var loading = hdjs.loading();
                    $.post('{!! url("site/delNews") !!}', {id: id}, function (res) {
                        loading.modal('hide');
                        if (res.valid == 1) {
                            hdjs.message(res.message, 'refresh', 'success');
                        } else {
                            hdjs.message(res.message, '', 'error');
                        }
                    }, 'json');
                });
            })
        }

        /**
         * 群发图文
         * @param id
         */
        function send(id) {
            require(['hdjs', 'resource/js/member.js'], function (hdjs, member) {
                hdjs.confirm('确定发送消息吗?', function () {
                    $.post('{!! url("site/sendNews") !!}', {id: id}, function (res) {
                        if (res.valid == 1) {
                            hdjs.message(res.message, '', 'success');
                        } else {
                            hdjs.message(res.message, '', 'error');
                        }
                    }, 'json');
                });
            })
        }
    </script>
</block>