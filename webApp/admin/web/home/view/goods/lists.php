<extend file='master'/>
<block name="content">
	<ul class="nav nav-pills" role="tablist">
		<li class="active"><a href="#tab1">菜品列表</a></li>
		<li><a href="{{u('post')}}">新增菜品</a></li>
	</ul>
	<br>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">菜品列表</h3>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
				<tr>
					<th>编号</th>
					<th>菜品名称</th>
					<th>图片</th>
					<th>售价</th>
					<th width="150">操作</th>
				</tr>
				</thead>
				<tbody>
				<foreach from="$data" value="$d">
					<tr>
						<td>{{$d['id']}}</td>
						<td>{{$d['title']}}</td>
						<td>
							<img src="{{$d['thumb']}}" style="width:80px;¬">
						</td>
						<td>{{$d['price']}}元</td>
						<td>
							<div class="btn-group">
								<a href="{{u('post',['id'=>$d['id']])}}" class="btn btn-default">编辑</a>
								<a href="{{u('del',['id'=>$d['id']])}}" class="btn btn-default">删除</a>
							</div>
						</td>
					</tr>
				</foreach>
				</tbody>
			</table>
		</div>
	</div>
</block>