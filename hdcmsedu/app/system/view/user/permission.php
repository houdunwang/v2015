<extend file="resource/view/system"/>
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">已经安装模块</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation"><a href="{!! u('lists') !!}">用户列表</a></li>
		<li role="presentation"><a href="{!! u('add') !!}">添加用户</a></li>
		<li role="presentation"><a href="{!! u('edit',array('uid'=>$_GET['uid'])) !!}">编辑用户</a></li>
		<li role="presentation" class="active"><a href="#">查看操作权限</a></li>
	</ul>
	<div class="panel panel-default">
		<div class="panel-heading">
			用户组基本权限
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<tbody>
				<tr>
					<td width="150">用户组名</td>
					<td width="300">{{$group['name']}} <a href="?s=system/group/post&id={{$group['id']}}"><span class="fa fa-edit"></span></a></td>
					<td></td>
				</tr>
				<tr>
					<td>最多站点数量</td>
					<td>{{$group['maxsite']}}</td>
					<td></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">可使用站点</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">站点</th>
					<th width="300">角色</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<foreach from="$sites" value="$s">
					<tr>
						<td>{{$s['name']}}</td>
						<td>
							<?php $role = [ 'owner' => '所有者', 'manage' => '管理员', 'operate' => '操作员' ];
							echo $role[ $s['role'] ]; ?>
						</td>
						<td>
							<a href="?s=system/site/edit&siteid={{$s['siteid']}}">编辑站点</a>&nbsp;|&nbsp;
							<a href="?s=system/permission/users&siteid={{$s['siteid']}}&fromuid={{$_GET['uid']}}">编辑权限</a>
						</td>
					</tr>
				</foreach>
				</tbody>
			</table>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			当前用户所在用户组可使用的站点权限
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">站点</th>
					<th width="300">角色</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<foreach from="$packages" value="$p">
					<tr>
						<td>{{$p['name']}}</td>
						<td>
							<span class="label label-success">系统模块</span>
							<if value="!empty($p['modules_title'])">
								<foreach from="$p['modules_title']" value="$mt">
									<span class="label label-info">{{$mt}}</span>
								</foreach>
							</if>
						</td>
						<td>
							<span class="label label-success">微站默认模板</span>
						</td>
					</tr>
				</foreach>
				</tbody>
			</table>
		</div>
	</div>
</block>

<script>

</script>
