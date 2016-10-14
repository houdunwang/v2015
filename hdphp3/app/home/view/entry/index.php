<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>欢迎使用HDPHP</title>
	<link rel="stylesheet" href="{{__ROOT__}}/resource/hdjs/css/bootstrap.min.css">
</head>
<body style="background: #f3f3f3;">
<a href="{{u('admin/user/add',['id'=>9,'cid'=>89])}}">添加用户</a>
<hr>
<a href="{{u('entry/assign')}}">测试响应</a>
<hr>
<a href="{{u('db/connect')}}">数据库连接</a>
</body>
</html>