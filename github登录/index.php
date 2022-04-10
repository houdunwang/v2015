<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>后盾人|专注PHP、H5、JavaScript、Linux、DivCss、Python、Mysql、Vue.js、Angular开发</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-default" role="navigation">
            	<!-- Brand and toggle get grouped for better mobile display -->
            	<div class="navbar-header">
            		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            			<span class="sr-only">Toggle navigation</span>
            			<span class="icon-bar"></span>
            			<span class="icon-bar"></span>
            			<span class="icon-bar"></span>
            		</button>
            		<a class="navbar-brand" href="http://www.houdunren.com">后盾人</a>
            	</div>
            
            	<!-- Collect the nav links, forms, and other content for toggling -->
            	<div class="collapse navbar-collapse navbar-ex1-collapse">
            		<ul class="nav navbar-nav">
            			<li><a href="http://www.houdunren.com/houdunren18_videos">课程</a></li>
            			<li><a href="http://www.houdunren.com/houdunren18_newest">最新</a></li>
            			<li><a href="http://www.houdunren.com/?m=houdunren&action=controller/ask/home&siteid=18">讨论</a></li>
            			<li><a href="http://www.houdunren.com/?m=houdunren&action=controller/article/home&siteid=18">文章</a></li>
            			<li><a href="http://www.houdunren.com/?m=houdunren&action=controller/entry/vlogs&siteid=18">大叔</a></li>
            		</ul>
            		<ul class="nav navbar-nav navbar-right">
                        <?php
                            session_start ();
                            if(isset($_SESSION['login'])) {
						?>
                                <li><a href="">
                                        <img width="20px" src="<?php echo $_SESSION['avatar_url']?>" alt="">
                                    </a></li>
                                <li><a>houdunren</a></li>
                                <li><a href="php/out.php">退出</a></li>
						<?php
							}else{
                        ?>
                            <li><a href="login.php">登录</a></li>
                            <li><a href="#">注册</a></li>
                        <?php
                            }
                        ?>

            		</ul>
            	</div><!-- /.navbar-collapse -->
            </nav>
            <div>
                <img src="static/images/index.png" width="100%" alt="">
            </div>
        </div>
    </div>
</body>
</html>
