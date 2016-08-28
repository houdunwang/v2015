<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://localhost/video/hdphp2.0/resource/hdjs/js/jquery.min.js"></script>
</head>
<body>
<a href="<?php echo u('message')?>">页面响应</a>
<hr>
<a href="<?php echo u('confirm')?>">确认框</a>
<hr>
<a href="javascript:;" onclick="ajax();">发异步</a>
<script>
	function ajax() {
		$.get('<?php echo u("ajax")?>', function (res) {
			console.log(res);
			alert(res.message);
		}, 'json');
	}
</script>
</body>
</html>