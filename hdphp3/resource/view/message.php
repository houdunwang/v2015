<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>温馨提示</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body style="background: url('{{__ROOT__}}/resource/images/bg.jpg');background-size: cover">
<!--导航-->
<nav class="navbar navbar-inverse" style="border-radius: 0px;">
	<div class="container-fluid">
		<div class="navbar-header">
			<ul class="nav navbar-nav">
				<li>
					<a href="http://bbs.houdunwang.com" target="_blank"><i class="fa fa-w fa-forumbee"></i> 后盾论坛</a>
				</li>
				<li>
					<a href="http://www.houdunwang.com" target="_blank"><i class="fa fa-w fa-phone-square"></i> 联系后盾</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!--导航end-->
<div class="container-fluid">
	<div style="background: url('{{__ROOT__}}/resource/images/logo.png') no-repeat;background-size: contain;height:80px;margin-top: 60px;"></div>
	<div class="alert alert-info clearfix jumbotron" style="padding:30px;margin-top: 50px;">
		<br/>
		<div class="col-xs-3">
			<i class="fa fa-5x fa-w {{$ico}}"></i>
		</div>
		<div class="col-xs-9">
			<p>{{$content}}</p>
			<if value="$redirect=='back'">
				<p>
					<a href="javascript:void(0);" onclick="{{$url}}" class="alert-link">如果你的浏览器没有跳转, 请点击此链接</a>
				</p>
				<else/>
				<p><a href="javascript:void(0);" onclick="{{$url}}" class="alert-link">如果你的浏览器没有跳转, 请点击此链接</a></p>
			</if>
		</div>
	</div>
</div>
<script>
	setTimeout(function () {<?php echo $url;?>},<?php echo $timeout;?>);
</script>
</body>
</html>