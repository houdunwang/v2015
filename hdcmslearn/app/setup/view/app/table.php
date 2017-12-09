<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HDCMS 数据库配置</title>
    <include file="resource/view/hdjs"/>
</head>
<body style="background: url(/resource/images/system_bg.jpg);background-size: 100% 100%;height: 100vh;">
<div style="width:1100px;margin: 0px auto 50px;padding-top: 50px;">
    <div style="background: url(/resource/images/logo.png) no-repeat;background-size:contain;height:80px;"></div>
    <br/>
    <div class="panel panel-default">
        <nav class="navbar navbar-default" style="border-radius: 0px;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><strong>HDCMS 百分百开源免费,可用于任意商业项目!</strong>
                        <small class="text-info">使用高效的HDPHP框架构建</small>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://www.houdunwang.com" target="_blank">培训</a></li>
                        <li><a href="http://www.hdcms.com" target="_blank">官网</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="panel-body">
            <div class="col-xs-3">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-danger active" style="width: 80%;">
                        80%
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item"><strong>安装步骤</strong></li>
                    <li class="list-group-item"><i class="fa fa-copyright"></i> 安装协议</li>
                    <li class="list-group-item"><i class="fa fa-pencil-square-o"></i> 环境检测</li>
                    <li class="list-group-item"><i class="fa fa-database"></i> 数据库配置</li>
                    <li class="list-group-item" style="background: #dff0d8"><i class="fa fa-bars"></i> 安装数据表</li>
                    <li class="list-group-item"><i class="fa fa-check-circle"></i> 完成</li>
                </ul>
            </div>
            <form class="form-horizontal" method="post" onsubmit="post(event);">
                <div class="col-xs-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4> 正在初始化数据表 ...</h4>
                        </div>
                        <div class="panel-body" style="padding: 10px;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">45% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="text-center" style="color:#ffffff;"> ©2010 - 2019 hdcms.com Inc.</div>
</div>
</body>
</html>
<script>
    require(['hdjs'], function (hdjs) {
        $.post('{{__URL__}}', $('form').serialize(), function (res) {
            if (res.valid == 1) {
                location.href = "{!! u('finish') !!}";
            } else {
                hdjs.message(res.message, '', 'info');
            }
        }, 'json');
    });
</script>