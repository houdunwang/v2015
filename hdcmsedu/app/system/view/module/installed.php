<extend file="resource/view/system"/>
<block name="content">
    <div ng-controller="ctrl">
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i></li>
            <li><a href="?s=system/manage/menu">系统</a></li>
            <li class="active">已经安装模块</li>
        </ol>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="{!! u('module.installed') !!}">已经安装模块</a></li>
            <li role="presentation"><a href="?s=system/module/prepared">安装模块</a></li>
            <li role="presentation"><a href="?s=system/module/design">设计新模块</a></li>
            <li role="presentation"><a href="{!! u('shop.lists',['type'=>'module']) !!}">模块商城</a></li>
            <li role="presentation"><a href="{!! u('shop.upgradeLists') !!}">模块更新</a></li>
            <li role="presentation"><a href="{!! u('shop.buy',['type'=>'module']) !!}">已购模块</a></li>
        </ul>
        <h5 class="page-header">菜单列表</h5>
        <nav role="navigation" class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">模块类型</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{__URL__}}">全部</a></li>
                        <li><a href="#" data-type="business">主要业务</a></li>
                        <li><a href="#" data-type="customer">客户关系</a></li>
                        <li><a href="#" data-type="marketing">营销与活动</a></li>
                        <li><a href="#" data-type="tools">常用服务与工具</a></li>
                        <li><a href="#" data-type="industry">行业解决方案</a></li>
                        <li><a href="#" data-type="other">其他</a></li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="搜索模块" id="search">
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <foreach from="$modules" value="$m">
            <div class="media" type="{{$m['industry']}}">
                <div class="pull-right">
                    <div style="margin-right: 10px;">
                        <if value="$m['is_system']==0">
                            <if value="$m['locality']==1">
                                <div class="btn-group" role="group" aria-label="...">
                                    <a href="{!! u('createZip',['name'=>$m['name']]) !!}" class="btn btn-default btn-sm">打包下载</a>
                                    <a href="{!! u('update',['module'=>$m['name']]) !!}" class="btn btn-default btn-sm">更新模块</a>
                                    <a href="javascript:;" onclick="uninstall('{{$m['name']}}','{{$m['title']}}')" class="btn btn-sm btn-default">卸载模块</a>
                                    <a class="btn btn-default btn-sm" href="{!! u('resetDesign',array('module'=>$m['name'])) !!}">重新设计</a>
                                    <a class="btn btn-default btn-sm" href="{!! u('database.table',['name'=>$m['name']]) !!}">模块数据</a>
                                </div>
                                <else/>
                                <div class="btn-group" role="group" aria-label="...">
                                    <a href="javascript:;" onclick="uninstall('{{$m['name']}}','{{$m['title']}}')" class="btn btn-sm btn-default">卸载</a>
                                </div>
                            </if>
                        </if>
                    </div>
                </div>
                <div class="media-left">
                    <a href="javascript:;">
                        <img class="media-object" src="{{pic($m['thumb'])}}" style="width: 50px;height: 50px;"/>
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{$m['title']}}
                        <small>（标识：{{$m['name']}} 版本：{{$m['version']}} 作者：{{$m['author']}}）</small>
                        <if value="$m['is_system']==1">
                            <span class="label label-success">系统内置</span>
                            <elseif value="$m['locality']==1"/>
                            <span class="label label-info">本地开发</span>
                            <else/>
                            <span class="label label-danger">应用商店</span>
                        </if>
                    </h4>
                    <a href="javascript:;" class="detail">详细介绍</a>
                </div>
                <div class="alert alert-info" role="alert" style="display: none"><strong>功能介绍</strong>： {{$m['detail']}}
                </div>
            </div>
        </foreach>
    </div>
    <style>
        .media {
            border-bottom: solid 1px #dcdcdc;
            padding-bottom: 6px;
        }

        .media h4.media-heading {
            font-size: 16px;
        }

        .media .media-left a img {
            border-radius: 10px;
        }

        .media h4.media-heading small {
            font-size: 65%;
        }

        .media .media-body a {
            display: inline-block;
            font-size: 14px;
            padding-top: 6px;
        }

        .media .alert {
            margin-top: 6px;
            display: none;
        }
    </style>
    <script>
        /**
         * 删除模块
         * @param name 模块标识
         */
        function uninstall(name,title) {
            require(['hdjs'], function (hdjs) {
                hdjs.confirm('确定删除【'+title+'】模块吗?', function () {
                    hdjs.submit({url: "{!! u('uninstall') !!}&name=" + name, successUrl: "refresh"});
                });
            })
        }

        require(['hdjs'], function (hdjs) {
            //模块介绍
            $('.detail').click(function () {
                //隐藏所有详细介绍内容
                $('.detail').not(this).parent().next().hide();
                //显示介绍
                $(this).parent().next().toggle();
            });
            //点击模块类型显示列表
            $(".navbar-nav [data-type]").click(function () {
                //类型
                var dataType = $(this).attr('data-type');
                $(".media").show().not('[type=' + dataType + ']').hide();
                $('.navbar-nav').find('li').removeClass('active');
                $(this).parent().addClass('active');
            });
            $("#search").keyup(function () {
                var word = $(this).val();
                if (word == '') {
                    //搜索词为空
                    $(".media").show();
                } else {
                    $(".media").each(function (i) {
                        if ($(this).find('h4').text().indexOf(word) >= 0) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    })
                }
            })
        })
    </script>
</block>
