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
</head>
<body>
<div class="container" style="margin-top: 10%;width: 40%">
	<form action="" method="post" class="form-horizontal" role="form">
		<div class="form-group">
			<label for="inputID" class="col-sm-2 control-label">用户名:</label>
			<div class="col-sm-10">
				<input type="text" name="username" id="inputID" class="form-control" value="" title="" required="required">
			</div>
		</div>
		<div class="form-group">
			<label for="inputID" class="col-sm-2 control-label">密码:</label>
			<div class="col-sm-10">
				<input type="password" name="password" id="inputID" class="form-control" value="" title="" required="required">
			</div>
		</div>
		<div class="form-group">
			<label for="inputID" class="col-sm-2 control-label">验证码:</label>
			<div class="col-sm-10">
				<input type="text" name="captcha" id="inputID" class="form-control" value="" title="" required="required">
				<br>
				<img id="captchaImg" src="?s=admin/login/captcha" alt="">
				<a href="javascript:;" id="captchaA">看不清换一张</a>
			</div>
		</div>
        <script>
            $(function () {
                var src = $('#captchaImg').attr('src');
                $('#captchaImg,#captchaA').click(function () {
                    $('#captchaImg').attr('src',src+'&houdunren=' + Math.random());
                })
            })
        </script>

		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-primary btn-block">登陆</button>
			</div>
		</div>
	</form>
</div>
</body>
</html>