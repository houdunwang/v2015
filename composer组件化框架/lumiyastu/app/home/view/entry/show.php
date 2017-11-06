<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <script src="./static/js/jquery-1.11.3.min.js"></script>
    <script src="./static/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation" style="border-radius: 0">
    <div class="container">


        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./index.php">首页</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="./index.php">学生列表</a></li>
                <li><a href="http://www.houdunren.com">关于我们</a></li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div>
</nav>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">学生 <span style="color: red;font-weight: 700">后盾人</span> 详细资料</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <tr>
                    <th>姓名：</th>
                    <td><?php echo $data['sname'] ?></td>
                </tr>
                <tr>
                    <th>性别：</th>
                    <td><?php echo $data['sex'] ?></td>

                </tr>
                <tr>
                    <th>生日：</th>
                    <td><?php echo $data['birthday'] ?></td>

                </tr>
                <tr>
                    <th>班级：</th>
                    <td><?php echo $data['gname'] ?></td>

                </tr>
                <tr>
                    <th>爱好：</th>
                    <td><?php echo $data['hobby'] ?></td>

                </tr>

            </table>
            <a href="index.php" class="btn btn-success btn-xs">返回首页</a>
        </div>
    </div>
</div>
</body>
</html>