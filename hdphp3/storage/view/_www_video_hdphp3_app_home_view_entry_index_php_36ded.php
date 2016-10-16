<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>欢迎使用HDPHP</title>
	<link rel="stylesheet" href="<?php echo __ROOT__?>/resource/hdjs/css/bootstrap.min.css">
</head>
<body style="background: #f3f3f3;">
<a href="<?php echo u('admin/user/add',['id'=>9,'cid'=>89])?>">添加用户</a>
<hr>
<a href="<?php echo u('entry/assign')?>">测试响应</a>
<hr>
<dl>
	<dt>数据库</dt>
	<dd><a href="<?php echo u('database/connect')?>">数据库连接</a></dd>
	<dd><a href="<?php echo u('database/core')?>">核心操作</a></dd>
	<dd><a href="<?php echo u('database/query')?>">查询构造器</a></dd>
	<dd><a href="<?php echo u('database/schema')?>">数据库操作</a></dd>
</dl>
</body>
</html>