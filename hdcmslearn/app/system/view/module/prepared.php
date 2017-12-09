<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">已经安装模块</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('installed') !!}">已经安装模块</a></li>
        <li role="presentation" class="active"><a href="?s=system/module/prepared">安装模块</a></li>
        <li role="presentation"><a href="?s=system/module/design">设计新模块</a></li>
        <li role="presentation"><a href="{!! u('shop.lists',['type'=>'module']) !!}">模块商城</a></li>
        <li role="presentation"><a href="{!! u('shop.upgradeLists') !!}">模块更新</a></li>
    </ul>
    <h5 class="page-header">未安装的本地模块</h5>
    <foreach from="$locality" value="$local">
        <div class="media">
            <div class="pull-right">
                <div class="btn-group" role="group" aria-label="...">
                    <a class="btn btn-success btn-sm" href="{!! u('install',array('module'=>$local['name'])) !!}">安装模块</a>
                    <a class="btn btn-default btn-sm" href="{!! u('resetDesign',array('module'=>$local['name'])) !!}">重新设计</a>
                    <a class="btn btn-default btn-sm" href="{!! u('createZip',['name'=>$local['name']]) !!}">打包下载</a>
                    <a class="btn btn-default btn-sm" href="{!! u('database.table',['name'=>$local['name']]) !!}">模块数据</a>
                </div>
            </div>
            <div class="media-left">
                <a href="#">
                    <img class="media-object" src="addons/{{$local['name']}}/{{$local['preview']}}"
                         style="width: 50px;height: 50px;">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{$local['title']}}
                    <small>（标识：{{$local['name']}} 版本：{{$local['version']}} 作者：{{$local['author']}}）</small>
                </h4>
                <a href="javascript:;" class="detail">详细介绍</a>
            </div>
            <div class="alert alert-info" role="alert"><strong>功能介绍</strong>： {{$local['detail']}}</div>
        </div>
    </foreach>
    <style>
        .media {
            border-bottom: solid 1px #dcdcdc;
            padding-bottom: 6px;
        }

        .media h4.media-heading {
            font-size: 16px;
        }

        .media .media-left a img {
            border-radius: 5px;
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
        require(['hdjs'], function () {
            $('body').delegate('.detail', 'click', function () {
                //隐藏所有详细介绍内容
                $('.detail').not(this).parent().next().hide();
                //显示介绍
                $(this).parent().next().toggle();
            });
        })
    </script>
</block>
