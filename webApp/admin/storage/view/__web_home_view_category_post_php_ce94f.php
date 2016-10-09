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
		
	<form action="" method="post" class="form-horizontal">
		<input type="hidden" name="cid" value="<?php echo $field['cid']?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">商铺设置</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">分类名称</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="catname" value="<?php echo $field['catname']?>">
					</div>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">保存</button>
	<input type='hidden' name='__TOKEN__' value='4f43d8387665b0df5141ec0636d38179'/></form>

	</div>
</div>
<script>
	require(['bootstrap'], function () {
	})
</script>
</body>
</html>
