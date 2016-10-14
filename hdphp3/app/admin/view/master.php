<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<blade name="title"/>
	<script src="resource/hdjs/js/jquery.min.js"></script>
	<script>
		var i=1;
	</script>
</head>
<body>
<widget name="copyright">
	版权所有   {{webname}} houdunwang.com
</widget>
<div class="top">
	<a href="">首页</a>
</div>
<div class="container">
	<div class="menu">
		<ul>
			<li>栏目管理</li>
			<li>文章管理</li>
		</ul>
	</div>
	<div class="content">
		<blade name="content"/>
	</div>
</div>
</body>
</html>

<style>
	.top {
		height     : 80px;
		background : #999;
	}

	.container {
		position : relative;
	}

	.container .menu {
		width      : 300px;
		float      : left;
		background : #dcdcdc;
	}

	.container .content {
		float    : right;
		width    : 700px;
		position : absolute;
		left     : 300px;
		right    : 0px;
		top      : 0px;
		bottom   : 0px;
	}
</style>