<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="./jquery.min.js"></script>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="./bt3/css/bootstrap.min.css">
    <script src="./bt3/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse" role="navigation" style="border-radius: 0;">
    <div class="container">


        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">后盾人 houdunren.com</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a data-toggle="modal" href="#modal-id">注册</a>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">快来注册吧 ^_^</h4>
            </div>
            <div class="modal-body" style="padding: 40px;">
                <form action="?a=reg" method="post" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="email" name="email" id="inputID" class="form-control" value="" title=""
                                   required="required" placeholder="邮箱：一会儿这个邮箱要收验证码">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" name="password" id="inputID" class="form-control" value="" title=""
                                   required="required" placeholder="请输入密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" name="password_confirmation" id="inputID" class="form-control"
                                   value="" title="" required="required" placeholder="请确认密码">
                        </div>
                    </div>
                    <div class="input-group" style="margin-top: 20px;">
                        <input class="form-control" placeholder="请输入验证码" name="captcha" required="required">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="sendCaptcha">发送验证码</button>
                        </span>
                    </div>
                    <input style="margin-top: 20px;" type="submit" class="btn btn-info btn-block" value="注册">


                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(function () {
        $('#sendCaptcha').click(function () {
            var email = $.trim($('[name=email]').val());
            if (email == '') {
                alert('邮箱不能为空');
                return;
            }
            //410004417@qq.com
            var reg = /^[0-9a-zA-Z-_]+@[0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2,3})?$/g;
            if (!reg.test(email)) {
                alert('邮箱格式不正确');
                return;
            }
            //发送异步发邮件



            //倒计时开始
            var button = $('#sendCaptcha');
            //按钮禁用
            button.attr('disabled', true);
            //倒计时
            var countdownNum = 10;
            //第一次先写入一次
            button.html(countdownNum + '秒之后再发送');
            //启动定时器60秒
            var timer = setInterval(function () {
                countdownNum--;
                //如果时间为0
                if (countdownNum <= 0) {
                    //清除定时
                    clearInterval(timer);
                    button.html('发送验证码');
                    //解除disabled属性
                    button.attr('disabled', false);
                }else{
                    button.html(countdownNum + '秒之后再发送');
                }

            }, 1000);
        })
    })
</script>
</body>
</html>