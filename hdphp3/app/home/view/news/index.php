<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="{{__ROOT__}}/bower_components/jquery/dist/jquery.min.js"></script>
</head>
<body>
<h1>
	<a href="{{__ROOT__}}/index.php/news/create">添加</a>
</h1>
<foreach from="$data" value="$v">
	<li>
		<a href="{{__ROOT__}}/index.php/news/{{$v['id']}}">{{$v['title']}}</a>
		<a href="{{__ROOT__}}/index.php/news/{{$v['id']}}/edit">编辑</a>
		<a href="javascript:;" onclick="del('{{$v['id']}}')">删除</a>
	</li>
</foreach>

</body>
</html>
<script>
	function del(id) {
		$.ajax({
			type: 'DELETE',
			url: '{{__ROOT__}}/index.php/news/' + id,
			success: function () {
				location.reload(true);
			}
		})
	}
</script>