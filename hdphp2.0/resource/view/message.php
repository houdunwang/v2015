<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>温馨提示</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<script src="{{__ROOT__}}/resource/hdjs/js/jquery.min.js"></script>
	<script src="{{__ROOT__}}/resource/hdjs/app/util.js"></script>
	<script src="{{__ROOT__}}/resource/hdjs/require.js"></script>
	<script src="{{__ROOT__}}/resource/hdjs/app/config.js"></script>
	<link href="{{__ROOT__}}/resource/hdjs/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{__ROOT__}}/resource/hdjs/css/font-awesome.min.css" rel="stylesheet">
</head>
<if value="isset($_GET['isajax'])">
	<body>
	<if value="$type=='success'">
		<script>
			parent.require(['bootstrap', 'util'], function ($, util) {
				var url = parent.location.href;
				var modalobj = util.message('{{$content}}', '', 'success', {id: 'ajaxModal'});
				if (url) {
					modalobj.on('hide.bs.modal', function () {
						$('.modal').each(function () {
							if ($(this).attr('id') != 'ajaxModal') {
								$(this).modal('hide');
							}
						});
						parent.location.reload(true)
					});
				}
			})
		</script>
		<else/>
		<script>
			parent.require(['bootstrap', 'util'], function (bootstrap, util) {
				var modalobj = util.message('{{$content}}', '', 'error');
			})
		</script>
	</if>
	</body>
	<else/>
	<body style="background: url('{{__ROOT__}}/resource/images/bg.jpg');background-size: cover">
	<!--导航-->
	<if value="!IS_MOBILE">
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
	</if>
	<!--导航end-->
	<div class="container-fluid">

		<h1>&nbsp;</h1>

		<div style="background: url('{{__ROOT__}}/resource/images/logo.png') no-repeat;background-size: contain;height:60px;"></div>
		<br/>

		<div class="alert alert-info clearfix jumbotron">
			<h4>&nbsp;</h4>

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
</if>
</html>