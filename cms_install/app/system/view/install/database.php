<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link href="{{__ROOT__}}/node_modules/hdjs/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{__ROOT__}}/node_modules/hdjs/css/font-awesome.min.css" rel="stylesheet">
    <script>
        //模块配置项
        var hdjs = {
            //框架目录
            'base': 'node_modules/hdjs',
            //上传文件后台地址
            'uploader': '?s=component/upload/uploader',
            //获取文件列表的后台地址
            'filesLists': '?s=component/upload/filesLists',
        };
    </script>
    <script src="{{__ROOT__}}/node_modules/hdjs/app/util.js"></script>
    <script src="{{__ROOT__}}/node_modules/hdjs/require.js"></script>
    <script src="{{__ROOT__}}/node_modules/hdjs/config.js"></script>
    <link href="{{__ROOT__}}/resource/css/hdcms.css" rel="stylesheet">
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
                <li class="list-group-item">版权信息</li>
                <li class="list-group-item">环境检测</li>
                <li class="list-group-item active">初始数据</li>
                <li class="list-group-item">安装完成</li>
            </ul>
        </div>
        <form action="" class="form-horizontal" onsubmit="post(event)">
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">数据库连接配置</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">主机</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="host" value="127.0.0.1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">帐号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user" value="cms_install_hdp">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" value="RRjpAKZ2rQ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">数据库</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="database" value="cms_install_hdp">
                            </div>
                        </div>

                    </div>
                </div>
                <div>
                    <a href="{{u('environment')}}" class="btn btn-default">上一步</a>
                    <button class="btn btn-success">下一步</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function post(event) {
            event.preventDefault();
            require(['jquery', 'util'], function ($, util) {
                $.post('{{__URL__}}', $('form').serialize(), function (response) {
                    console.log(response);
                    if (response.valid == 1) {
                        util.message(response.message, '{{u("tables")}}', 'success');
                    } else {
                        util.message(response.message);
                    }
                }, 'json');
            })
        }
    </script>
    <div class="text-center" style="margin-top: 50px;">
        copyright houdunren.com
    </div>
</div>
</body>
</html>