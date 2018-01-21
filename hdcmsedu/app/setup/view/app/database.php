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
                    <div class="progress-bar progress-bar-striped progress-bar-danger active" style="width: 60%;">
                        60%
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item"><strong>安装步骤</strong></li>
                    <li class="list-group-item"><i class="fa fa-copyright"></i> 安装协议</li>
                    <li class="list-group-item"><i class="fa fa-pencil-square-o"></i> 环境检测</li>
                    <li class="list-group-item" style="background: #dff0d8"><i class="fa fa-database"></i> 数据库配置</li>
                    <li class="list-group-item"><i class="fa fa-check-circle"></i> 完成</li>
                </ul>
            </div>
            <form class="form-horizontal" method="post" onsubmit="post(event);">
                <div class="col-xs-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            数据库配置
                        </div>
                        <div class="panel-body" style="padding: 10px;">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">主机</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="host" value="127.0.0.1"
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数据库</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="database" required="required"
                                           value="hdcms">
                                    <span class="help-block">请确认数据库已经存在，否则无法进行安装</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="user" required="required"
                                           value="root">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:history.back()" class="btn btn-success">返回</a>
                    <button class="btn btn-primary">继续</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center" style="color:#ffffff;"> ©2010 - 2019 hdcms.com Inc.</div>
</div>
<script>
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs, ) {
            $.post('{{__URL__}}', $('form').serialize(), function (res) {
                if (res.valid == 1) {
                    location.href = "{!! u('table') !!}";
                } else {
                    hdjs.message(res.message, '', 'info');
                }
            }, 'json');
        });
    }
</script>
</body>
</html>