<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <div class="container">
            <h1>Hello, 访问者!</h1>
            <p>欢迎使用lumiya框架...</p>
            <p><?php p( $houdun ); ?></p>
            <p><?php p( $houdunren ); ?></p>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
				<?php foreach ( $data as $v ): ?>
                    <tr>
                        <td><?php echo $v['id'] ?></td>
                        <td><?php echo $v['name'] ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="?s=home/entry/edit&id=<?php echo $v['id'] ?>" class="btn btn-success btn-xs">编辑</a>
                                <a href="javascript:if(confirm('确定删除')) location.href='?s=home/entry/delete&id=<?php echo $v['id'] ?>'" class="btn btn-danger btn-xs">删除</a>
                            </div>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>
            <p>
                <a href="http://www.houdunren.com" class="btn btn-primary btn-lg">Learn more</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>