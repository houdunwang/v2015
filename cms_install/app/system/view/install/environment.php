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
                <li class="list-group-item active">环境检测</li>
                <li class="list-group-item">初始数据</li>
                <li class="list-group-item">安装完成</li>
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">系统环境</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td>操作系统</td>
                            <td>{{$data['service_software']}}</td>
                        </tr>
                        <tr>
                            <td>PHP版本</td>
                            <td>{{$data['php_version']}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">环境检测</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <th>变量</th>
                        <th>状态</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>pdo</td>
                            <td>
                                <if value="$data['pdo']">
                                    <i class="fa fa-check-circle alert-success"></i>
                                    <else/>
                                    <i class="fa fa-times-circle hd-error"></i>
                                </if>
                            </td>

                        </tr>
                        <tr>
                            <td>curl</td>
                            <td>
                                <if value="$data['curl']">
                                    <i class="fa fa-check-circle alert-success"></i>
                                    <else/>
                                    <i class="fa fa-times-circle hd-error"></i>
                                </if>
                            </td>
                        </tr>
                        <tr>
                            <td>openssl</td>
                            <td>
                                <if value="$data['openssl']">
                                    <i class="fa fa-check-circle alert-success"></i>
                                    <else/>
                                    <i class="fa fa-times-circle hd-error"></i>
                                </if>
                            </td>
                        </tr>
                        <tr>
                            <td>gd</td>
                            <td>
                                <if value="$data['gd']">
                                    <i class="fa fa-check-circle alert-success"></i>
                                    <else/>
                                    <i class="fa fa-times-circle hd-error"></i>
                                </if>
                            </td>
                        </tr>
                        <tr>
                            <td>/</td>
                            <td>
                                <if value="$data['root_dir']">
                                    <i class="fa fa-check-circle alert-success"></i>
                                    <else/>
                                    <i class="fa fa-times-circle hd-error"></i>
                                </if>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <a href="{{u('copyright')}}" class="btn btn-default">上一步</a>
                <a href="javascript:;" onclick="nextStep()" class="btn btn-success">下一步</a>
            </div>
        </div>
    </div>
    <script>
        function nextStep() {
            require(['jquery', 'util'], function ($, util) {
                if ($('.hd-error').length > 0) {
                    util.message('安装环境不符合，无法进行安装', '', 'error');
                } else {
                    location.href = "{{u('database')}}";
                }
            })
        }
    </script>
    <div class="text-center" style="margin-top: 50px;">
        copyright houdunren.com
    </div>
</div>
</body>
</html>