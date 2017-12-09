<extend file="resource/view/system"/>
<link rel="stylesheet" href="{{view_url()}}/css.css">
<block name="content">
    <div ng-controller="ctrl">
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i></li>
            <li><a href="?s=system/manage/menu">系统</a></li>
            <li class="active">已经安装模板</li>
        </ol>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="javascript:;">已经安装模板</a></li>
            <li role="presentation"><a href="?s=system/template/prepared">安装模板</a></li>
            <li role="presentation"><a href="?s=system/template/design">设计新模板</a></li>
            <li role="presentation"><a href="{!! u('shop.lists',['type'=>'template']) !!}">模板商城</a>
            <li role="presentation"><a href="{!! u('shop.buy',['type'=>'template']) !!}">已购模板</a></li>
        </ul>

        <nav role="navigation" class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1"
                            aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">模板类型</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{__URL__}}">全部</a></li>
                        <li><a href="#" data-type="often">常用模板</a></li>
                        <li><a href="#" data-type="rummery">酒店</a></li>
                        <li><a href="#" data-type="car">汽车</a></li>
                        <li><a href="#" data-type="tourism">旅游</a></li>
                        <li><a href="#" data-type="drink">餐饮</a></li>
                        <li><a href="#" data-type="realty">房地产</a></li>
                        <li><a href="#" data-type="medical">医疗保健</a></li>
                        <li><a href="#" data-type="education">教育</a></li>
                        <li><a href="#" data-type="cosmetology">健身美容</a></li>
                        <li><a href="#" data-type="shoot">婚纱摄影</a></li>
                        <li><a href="#" data-type="other">其他</a></li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="搜索模板" id="search">
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <div class="template">
            <foreach from="$template" value="$m">
                <div class="thumbnail" industry="{{$m['industry']}}">
                    <h5>{{$m['title']}}</h5>
                    <img class="media-object" src="{{$m['thumb']}}"/>
                    <div class="caption">
                        <if value="$m['is_system']">
                            <a href="javascript:;" class="btn btn-default btn-xs btn-block">系统模板不允许卸载</a>
                            <else/>
                            <if value="$m['locality']==1">
                                <a href="{!! u('uninstall',['name'=>$m['name']]) !!}" class="btn btn-default btn-xs" style="width: 45%">卸载</a>
                                <a class="btn btn-default btn-xs" style="width: 45%" href="{!! u('createZip',array('name'=>$m['name'])) !!}">打包下载</a>
                                <else/>
                                <a href="{!! u('uninstall',['name'=>$m['name']]) !!}" class="btn btn-default btn-xs btn-block">卸载</a>
                            </if>
                        </if>
                    </div>
                </div>
            </foreach>
        </div>
    </div>
</block>
<script>
    require(['hdjs'], function (hdjs) {
        //点击模板类型显示列表
        $(".navbar-nav [data-type]").click(function () {
            //类型
            var dataType = $(this).attr('data-type');
            $(".thumbnail").show().not('[industry=' + dataType + ']').hide();
            $('.navbar-nav').find('li').removeClass('active');
            $(this).parent().addClass('active');
        });
        $("#search").keyup(function () {
            var word = $(this).val();
            if (word == '') {
                //搜索词为空
                $(".thumbnail").show();
            } else {
                $(".thumbnail").each(function (i) {
                    if ($(this).find('h5').text().indexOf(word) >= 0) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                })
            }
        })
    });
</script>
