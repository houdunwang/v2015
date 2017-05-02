<extend file='master'/>
<block name="content">
	<ul class="nav nav-pills" role="tablist">
		<li class="active"><a href="#tab1">栏目列表</a></li>
		<li><a href="{{u('post')}}">新增菜品分类</a></li>
	</ul>
	<br>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">分类列表</h3>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
				<tr>
					<th>编号</th>
					<th>栏目名称</th>
					<th width="150">操作</th>
				</tr>
				</thead>
				<tbody>
				<foreach from="$data" value="$d">
					<tr>
						<td>{{$d['cid']}}</td>
						<td>{{$d['catname']}}</td>
						<td>
							<div class="btn-group">
								<a href="{{u('post',['cid'=>$d['cid']])}}" class="btn btn-default">编辑</a>
								<a href="{{u('del',['cid'=>$d['cid']])}}" class="btn btn-default">删除</a>
							</div>
						</td>
					</tr>
				</foreach>
				</tbody>
			</table>
		</div>
	</div>
</block>