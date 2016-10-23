<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
<form action="" method="post">
	帐号: <input type="text" disabled="disabled" value="<?php echo $field['username']?>"><br/>
	密码: <input type="text" name="password"><br/>
	邮箱: <input type="text" name="email" value="<?php echo $field['email']?>"><br/>
	<input type="submit">
<input type='hidden' name='__TOKEN__' value='31cd2a5659e5999f01faf7bebf6a5944'/></form>
</body>
</html>