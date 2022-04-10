<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>后盾人登录</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/css/login.css">
</head>
<body>
<body>
<div class="container">
    <h1 class="big-title">会员登录</h1>
    <form class="form-horizontal" role="form">
        <input type="hidden" name="csrf_token" value="7e429e500d7eebfc56c7a11363eda004">
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" class="form-control input-lg" name="username" placeholder="手机号或邮箱" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="input-group input-group-lg">
                    <input type="password" class="form-control" name="password" placeholder="请输入密码" required="required">
                    <span class="input-group-btn">
                            <a class="btn btn-default" href="http://www.houdunren.com?m=ucenter&amp;action=controller/entry/forgetpwd&amp;siteid=18">忘记密码？</a>
                        </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <button class="btn btn-success btn-lg btn-block">登录</button>
            </div>
        </div>
    </form>
    <div class="other">
        <div class="regline"></div>
        <div class="regzi">其他方式登录</div>
    </div>
    <div class="regqq">
        <div class="regbian">
            <a href="php/login.php">
                <img src="./static/images/github.png" alt="">
            </a>
        </div>
    </div>
    <p class="remind">还没有帐号？ <a href="http://www.houdunren.com?m=ucenter&amp;action=controller/entry/register&amp;siteid=18">注册新帐号</a></p>
    <p class="remind" style="margin-bottom: 50px;">
        <a href="http://www.houdunren.com">返回首页</a>
    </p>
</div>
</body>
</body>
</html>