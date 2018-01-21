<extend file="resource/view/system"/>
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">已经安装模块</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="{!! u('lists') !!}">用户组列表</a></li>
		<li role="presentation"><a href="{!! u('post') !!}">添加用户组</a></li>
	</ul>
	<form class="form-horizontal" method="post" onsubmit="return false;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">可使用的公众服务套餐</h3>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
					<tr>
						<th width="30">删？</th>
						<th>名称</th>
						<th>公众号数量</th>
						<th>中间件数量</th>
						<th>路由数量</th>
						<th>有效期限</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					<foreach from="$groups" value="$g">
						<tr>
							<td>
								<if value="$g['id']!=v('config.register.groupid') && !$g['system_group']">
									<input type="checkbox" name="id[]" value="{{$g['id']}}">
								</if>
							</td>
							<td>
								{{$g['name']}}
								<if value="$g['id']==v('config.register.groupid')">
									<span class="label label-success">默认组</span>
								</if>
							</td>
							<td>{{$g['maxsite']}}</td>
							<td>{{$g['middleware_num']}}</td>
							<td>{{$g['router_num']}}</td>
							<td>
								<if value="$g['daylimit']">
									<span class="label label-success">{{$g['daylimit']}}天</span>
									<else/>
									<span class="label label-success">永久有效</span>
								</if>
							</td>
							<td>
								<a href="?s=system/group/post&id={{$g['id']}}">编辑</a>
							</td>
						</tr>
					</foreach>
					</tbody>
				</table>
			</div>
		</div>
		<button class="btn btn-primary" type="button" onclick="del()">删除选中用户组</button>
	</form>
</block>

<script>
	function del() {
		require(['hdjs', 'jquery'], function (hdjs, $) {
			hdjs.confirm('确定删除所选用户组吗?', function () {
				$.post('?s=system/group/remove', $('form').serialize(), function (res) {
					if (res.valid == 1) {
						hdjs.message(res.message, 'refresh');
					}
				}, 'json');
			})
		})
	}
</script>
