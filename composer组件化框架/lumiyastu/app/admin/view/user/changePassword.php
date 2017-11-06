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

			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">修改密码</h3>
					</div>
					<div class="panel-body">
						<form action="" method="post" role="form">

							<div class="form-group">
								<label for="">原始密码</label>
								<input type="password" class="form-control" name="password" id="" >
							</div>
							<div class="form-group">
								<label for="">新密码</label>
								<input type="password" class="form-control" name="new_password" id="" >
								<span class="help-block">新密码不得少于6位</span>
							</div>
							<div class="form-group">
								<label for="">确认密码</label>
								<input type="password" class="form-control" name="confirm_password" id="" >
							</div>

							

							<button type="submit" class="btn btn-primary">修改</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	</body>
</html>