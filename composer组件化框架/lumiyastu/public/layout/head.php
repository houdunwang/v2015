<link rel="stylesheet" href="./static/bootstrap-3.3.7-dist/css/bootstrap.min.css">
<script src="./static/js/jquery-1.11.3.min.js"></script>
<script src="./static/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-inverse" role="navigation" style="border-radius: 0">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">基于Lumiya学生系统</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="./index.php">前台首页</a></li>
				<li><a href="http://www.houdunren.com" target="_blank">后盾人</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user']['username'] ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="?s=admin/user/changePassword">修改密码</a></li>
						<li><a href="?s=admin/login/logout">退出登陆</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->

	</div>
</nav>