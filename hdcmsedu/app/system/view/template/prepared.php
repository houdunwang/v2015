<extend file="resource/view/system"/>
<link rel="stylesheet" href="{{view_url()}}/css.css">
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">已经安装模板</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation"><a href="{!! u('installed') !!}">已经安装模板</a></li>
		<li role="presentation" class="active"><a href="?s=system/template/prepared">安装模板</a></li>
		<li role="presentation"><a href="?s=system/template/design">设计新模板</a></li>
		<li role="presentation"><a href="{!! u('shop.lists',['type'=>'template']) !!}">模板商城</a>
	</ul>
	<h5 class="page-header">未安装的本地模板</h5>
	<div class="template">
		<foreach from="$locality" value="$m">
			<div class="thumbnail action">
				<h5>{{$m['title']}}({{$m['name']}})</h5>
				<img class="media-object" src="{{$m['thumb']}}"/>
				<div class="caption">
					<a class="btn btn-default btn-xs" style="width: 45%" href="{!! u('install',array('name'=>$m['name'])) !!}">安装模板</a>
					<a class="btn btn-default btn-xs" style="width: 45%" href="{!! u('createZip',array('name'=>$m['name'])) !!}">打包下载</a>
				</div>
			</div>
		</foreach>
	</div>
</block>
