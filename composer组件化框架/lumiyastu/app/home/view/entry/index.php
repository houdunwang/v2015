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
            <h3 class="panel-title">学生列表</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>班级（<a href="./index.php">全部</a>）</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
				<?php foreach ( $data as $v ): ?>
                    <tr>
                        <td><?php echo $v['sid'] ?></td>
                        <td><?php echo $v['sname'] ?></td>
                        <td><?php echo $v['sex'] ?></td>
                        <td>
                            <a href="?s=home/entry/index&gid=<?php echo $v['gid'] ?>"><?php echo $v['gname'] ?></a>
                        </td>
                        <td>
                            <a href="?s=home/entry/show&sid=<?php echo $v['sid'] ?>" class="btn btn-success btn-xs">查看详细资料</a>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>