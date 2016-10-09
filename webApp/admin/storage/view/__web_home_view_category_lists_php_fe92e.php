<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>微外卖</title>
	<link href="resource/hdjs/css/bootstrap.min.css" rel="stylesheet">
	<link href="resource/hdjs/css/font-awesome.min.css" rel="stylesheet">
	<script src="resource/hdjs/js/jquery.min.js"></script>
	<script src="resource/hdjs/app/util.js"></script>
	<script src="resource/hdjs/require.js"></script>
	<script src="resource/hdjs/app/config.js"></script>
	<link rel="stylesheet" href="http://192.168.31.151/a/admin/./web/home/view/entry/css/index.css">
	<link rel="stylesheet" href="http://192.168.31.151/a/admin/./web/home/view/css.css">
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">小飞微外卖</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">admin <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="http://192.168.31.151/a/admin/index.php?s=home/entry/logout">退出</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
<div class="row">
	<div class="col-sm-2 menu">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">核心功能</h3>
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">
						<a href="http://192.168.31.151/a/admin/index.php?s=home/shop/post">店铺设置</a>
					</li>
					<li class="list-group-item">
						<a href="http://192.168.31.151/a/admin/index.php?s=home/category/lists">栏目管理</a>
					</li>
					<li class="list-group-item">
						<a href="http://192.168.31.151/a/admin/index.php?s=home/goods/lists">菜品管理</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-sm-10">
		
	<ul class="nav nav-pills" role="tablist">
		<li class="active"><a href="#tab1">栏目列表</a></li>
		<li><a href="<?php echo u('post')?>">新增菜品分类</a></li>
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
				<?php foreach ((array)$data as $d){?>
					<tr>
						<td><?php echo $d['cid']?></td>
						<td><?php echo $d['catname']?></td>
						<td>
							<div class="btn-group">
								<a href="<?php echo u('post',['cid'=>$d['cid']])?>" class="btn btn-default">编辑</a>
								<a href="<?php echo u('del',['cid'=>$d['cid']])?>" class="btn btn-default">删除</a>
							</div>
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>

	</div>
</div>
<script>
	require(['bootstrap'], function () {
	})
</script>
</body>
</html>
