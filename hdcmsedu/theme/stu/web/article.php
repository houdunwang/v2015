<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<tag action="article.breadcrumb" separator=" / "></tag>
<h1>内容页</h1>
<tag action="article.relation" row="1" titlelen="3">
    <a href="{{$field['url']}}">{{$field['title']}}</a>
</tag>
</body>
</html>