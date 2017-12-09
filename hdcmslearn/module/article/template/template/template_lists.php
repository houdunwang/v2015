<extend file="resource/view/site"/>
<link rel="stylesheet" href="{{MODULE_TEMPLATE_URL}}/css/template.css">
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">模板管理</a></li>
    </ul>
    <div class="panel panel-default template">
        <div class="panel-heading">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">模板风格</a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="{{empty($_GET['type'])?'active':''}}">
                                <a href="{!! url('template.lists') !!}">全部</a>
                            </li>
                            <li class="{{'hotel'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=hotel">酒店</a>
                            </li>
                            <li class="{{'car'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=car">汽车</a>
                            </li>
                            <li class="{{'tour'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=tour">旅游</a>
                            </li>
                            <li class="{{'real'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=real">房地产</a>
                            </li>
                            <li class="{{'medical'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=medical">医疗</a>
                            </li>
                            <li class="{{'edu'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=edu">教育</a>
                            </li>
                            <li class="{{'beauty'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=beauty">美容健身</a>
                            </li>
                            <li class="{{'photography'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=photography">婚纱摄影</a>
                            </li>
                            <li class="{{'other'==$_GET['type']?'active':''}}">
                                <a href="{!! url('template.lists') !!}&type=other">其他行业</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="panel-body">
            <div class="row">
                <foreach from="$data" value="$d">
                    <div class="thumbnail action">
                        <h5>{{$d['title']}}</h5>
                        <img src="theme/{{$d['name']}}/{{$d['thumb']}}">
                        <div class="caption">
                            <button type="button" class="btn btn-default btn-xs btn-block">使用</button>
                        </div>
                    </div>
                </foreach>
            </div>
        </div>
    </div>
</block>
