<extend file="resource/view/system"/>
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">已经安装模块</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation"><a href="?s=system/manage/menu">系统管理</a>
		<li role="presentation" class="active"><a href="{!! u('shop.lists') !!}">模块商城</a>
	</ul>
	<div class="alert alert-success">
		<h4>正在下载请稍后 ...</h4>
	</div>
</block>

<script>
	require(['angular', 'hdjs', 'underscore', 'jquery', 'angular.sanitize'], function (angular, hdjs, _, $) {
		$.post("{!! u('upgrade',['name'=>$_GET['name']]) !!}", function (json) {
			if(json.valid==0){
				hdjs.message(json.message,"{!! u('shop.upgradeLists') !!}",'warning',8);
			}else{
				hdjs.message(json.message,json.url,'success',3);
			}
		}, 'json');
	})
</script>
