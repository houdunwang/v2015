<extend file="resource/view/site"/>
<block name="content">
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="#">文章系统</a></li>
	</ul>
	<div class="page-header">
		<h4><i class="fa fa-comments"></i> 文章系统</h4>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">数据统计</h3>
		</div>
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<th>类型</th>
				<th>数量</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>模型</td>
				<td>{{Db::table('web_model')->where('siteid',SITEID)->count()}}</td>
			</tr>
			<tr>
				<td>栏目</td>
				<td>{{Db::table('web_category')->where('siteid',SITEID)->count()}}</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">绑定域名</h3>
		</div>
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<th>域名</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<?php $domains=Db::table('module_domain')->where('siteid',SITEID)->where('module','article')->lists('domain');?>
				<foreach from="$domains" value="$domain">
					<td>
						<a href="{{$domain}}" target="_blank">{{$domain}}</a>
					</td>
				</foreach>

			</tr>
			</tbody>
		</table>
	</div>
</block>