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
		<li><a href="<?php echo u('lists')?>">菜品列表</a></li>
		<li class="active"><a href="<?php echo u('post')?>">新增菜品</a></li>
	</ul>
	<br>
	<form action="" method="post" class="form-horizontal">
		<input type="hidden" name="id" value="<?php echo $field['id']?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">菜品设置</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">分类</label>
					<div class="col-sm-8">
						<select name="cid" class="form-control">
							<?php foreach ((array)$category as $v){?>
								<?php if($v['cid']==$field['cid']){?>
                
									<option value="<?php echo $v['cid']?>" selected="selected"><?php echo $v['catname']?></option>
									<?php }else{?>
									<option value="<?php echo $v['cid']?>"><?php echo $v['catname']?></option>
								
               <?php }?>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">菜品名称</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="title" value="<?php echo $field['title']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">售价</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" name="price" value="<?php echo $field['title']?>">
							<span class="input-group-addon">元</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">菜品图片</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" name="thumb" readonly="" value="<?php echo $field['thumb']?>">
							<div class="input-group-btn">
								<button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
							</div>
						</div>
						<div class="input-group" style="margin-top:5px;">
							<img src="<?php echo $field['thumb']?:'resource/images/nopic.jpg'?>" class="img-responsive img-thumbnail" width="150">
							<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
						</div>
					</div>

					<script>
						//上传图片
						function upImage(obj) {
							require(['util'], function (util) {
								options = {
									multiple: false,//是否允许多图上传
									data: '',
									hash: 1
									//hash为确定上传文件标识（可以以用户编号，标识为此用户上传的文件，系统使用这个字段值来显示文件列表），data为数据表中的data字段值，开发者根据业务需要自行添加
								};
								util.image(function (images) {             //上传成功的图片，数组类型 
									$("[name='thumb']").val(images[0]);
									$(".img-thumbnail").attr('src', images[0]);
								}, options)
							});
						}

						//移除图片 
						function removeImg(obj) {
							$(obj).prev('img').attr('src', 'resource/images/nopic.jpg');
							$(obj).parent().prev().find('input').val('');
						}
					</script>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">店铺介绍</label>
					<div class="col-sm-8">
						<textarea id="container" name="content" style="height:300px;width:100%;"><?php echo $field['content']?></textarea>
						<script>
							util.ueditor('container', {hash: 2, data: 'hd'}, function (editor) {
								//这是回调函数 editor是百度编辑器实例
							});
						</script>
					</div>
				</div>

			</div>
		</div>
		<button type="submit" class="btn btn-primary">保存</button>
	<input type='hidden' name='__TOKEN__' value='801d97a293ee6aae18944270d0b310b9'/></form>

	</div>
</div>
<script>
	require(['bootstrap'], function () {
	})
</script>
</body>
</html>
