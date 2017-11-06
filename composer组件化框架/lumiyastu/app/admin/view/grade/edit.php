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
					<h3 class="panel-title">班级管理</h3>
				</div>
				<div class="panel-body">
					<!-- TAB NAVIGATION -->
					<ul class="nav nav-tabs" role="tablist">
						<li ><a href="?s=admin/grade/lists">列表</a></li>
						<li class="active"><a href="?s=admin/grade/add" >添加/编辑</a></li>
					</ul>
                    <br>
                    <form action="" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="inputID" class="col-sm-2 control-label">班级名称:</label>
                            <div class="col-sm-10">
                                <input type="text" name="gname" id="inputID" class="form-control" value="<?php echo $oldData['gname'] ?>" title=""
                                       required="required">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <input type="hidden" name="gid" value="<?php echo $oldData['gid'] ?>">
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>















</body>
</html>