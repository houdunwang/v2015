<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<?php include "./layout/head.php" ?>

	<div class="container">
	<div class="row">
		<?php include "./layout/left.php" ?>

		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" >
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">学生管理</h3>
				</div>
				<div class="panel-body">
					<!-- TAB NAVIGATION -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="?s=admin/student/lists">列表</a></li>
						<li><a href="?s=admin/student/add" >添加/编辑</a></li>
					</ul>


					<table class="table table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>姓名</th>
							<th>性别</th>
							<th>班级</th>
							<th>操作</th>
						</tr>
						</thead>
						<tbody>
                        <?php foreach($data as $v): ?>
						<tr>
							<td><?php echo $v['sid'] ?></td>
							<td><?php echo $v['sname'] ?></td>
							<td><?php echo $v['sex'] ?></td>
							<td><?php echo $v['gname'] ?></td>
							<td>
                                <div class="btn-group">
                                    <a href="?s=admin/student/edit&sid=<?php echo $v['sid'] ?>" class="btn btn-primary btn-sm">编辑</a>
                                    <a onclick="del(<?php echo $v['sid'] ?>)" class="btn btn-danger btn-sm">删除</a>
                                </div>
                            </td>
						</tr>
                        <?php endforeach ?>
						</tbody>
					</table>
                    <script>
                        function del(sid) {
                            if(confirm('确定删除吗？')){
                                location.href='?s=admin/student/delete&sid=' + sid;
                            }
                        }
                    </script>
				</div>
			</div>
		</div>
	</div>
</div>















</body>
</html>