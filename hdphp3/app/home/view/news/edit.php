<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1>
	<a href="{{__ROOT__}}/index.php/news">列表</a>
</h1>
<form action="{{__ROOT__}}/index.php/news/{{$field['id']}}" method="post">
	{{csrf_field()}}
	{{ method_field('PUT') }}
	标题: <input type="text" name="title" value="{{$field['title']}}"><br/>
	<input type="submit" value="保存">
</form>

</body>
</html>