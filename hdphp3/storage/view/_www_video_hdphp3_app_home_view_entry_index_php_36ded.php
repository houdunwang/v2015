<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>欢迎使用HDPHP</title>
	<link rel="stylesheet" href="<?php echo __ROOT__?>/resource/hdjs/css/bootstrap.min.css">
</head>
<body style="background: #f3f3f3;">
<div style="padding: 50px;">
	<dl>
		<dt>基础</dt>
		<dd><a href="<?php echo u('admin/user/add',['id'=>9,'cid'=>89])?>">添加用户</a></dd>
		<dd><a href="<?php echo u('entry/assign')?>">测试响应</a></dd>
	</dl>
	<dl>
		<dt>数据库</dt>
		<dd><a href="<?php echo u('database/connect')?>">数据库连接</a></dd>
		<dd><a href="<?php echo u('database/core')?>">核心操作</a></dd>
		<dd><a href="<?php echo u('database/query')?>">查询构造器</a></dd>
		<dd><a href="<?php echo u('database/schema')?>">数据库操作</a></dd>
		<dd><a href="<?php echo u('database/transaction')?>">事务处理</a></dd>
		<dd><a href="<?php echo u('conf/base')?>">配置项</a></dd>
		<dd><a href="<?php echo u('model/base')?>">模型基本操作</dd>
		<dd><a href="<?php echo u('model/action')?>">模型动作</dd>
		<dd><a href="<?php echo u('model/validate')?>">验证服务</dd>
		<dd><a href="<?php echo u('model/auto')?>">自动完成</dd>
		<dd><a href="<?php echo u('model/filter')?>">自动过滤</dd>
		<dd><a href="<?php echo u('model/fill')?>">字段保护</dd>
	</dl>
	<dl>
		<dt>模板</dt>
		<dd><a href="<?php echo u('view/tag')?>">标签</a></dd>
		<dd><a href="<?php echo u('view/user')?>">用户定义tag</a></dd>
		<dd><a href="<?php echo u('view/cache')?>">模板缓存</a></dd>
		<dd><a href="<?php echo u('view/csrf')?>">csrf</a></dd>
	</dl>
</div>
</body>
</html>