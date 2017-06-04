<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>温馨提示</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body style="background: url('resource/images/bg.jpg');background-size: cover">
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

    <h1>&nbsp;</h1>

    <div style="background: url('resource/images/logo.png') no-repeat;background-size: contain;height:60px;"></div>
    <br/>

    <div class="alert alert-info clearfix jumbotron">
        <h4>&nbsp;</h4>

        <div class="col-xs-3">
            <i class="fa fa-5x fa-w fa-warning"></i>
        </div>
        <div class="col-xs-9">
            <p>对不起, 您请求的页面不存在</p>
            <p>
                <a href="javascript:;" onclick="window.history.back()" class="alert-link">[返回上一页]</a> &nbsp;
                <a href="<?php echo __ROOT__;?>" class="alert-link">[回首页]</a> &nbsp;
            </p>
        </div>
    </div>
</div>
</body>
</html>