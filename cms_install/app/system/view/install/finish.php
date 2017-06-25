<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link href="{{__ROOT__}}/node_modules/hdjs/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{__ROOT__}}/node_modules/hdjs/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="#">HDCMS 1.0</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#">后盾人 人人做后盾</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="row">
        <div class="col-sm-3">
            <ul class="list-group">
                <li class="list-group-item ">版权信息</li>
                <li class="list-group-item">环境检测</li>
                <li class="list-group-item">初始数据</li>
                <li class="list-group-item active">安装完成</li>
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="alert alert-success">
                <h1>恭喜系统安装完成</h1>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">初始后台帐号</h3>
                </div>
                <div class="panel-body">
                    <form action="" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">帐号</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="readonly" class="form-control" value="hdcms">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="readonly" class="form-control" value="admin888">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <a href="{{web_url()}}/login" class="btn btn-success">登录后台</a>
            <a href="{{web_url()}}" class="btn btn-primary">访问主页</a>
        </div>
    </div>
    <div class="text-center" style="margin-top: 50px;">
        copyright houdunren.com
    </div>
</div>
</body>
</html>