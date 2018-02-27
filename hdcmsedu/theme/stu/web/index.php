<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PC 站点</title>
    <include file='resource/view/member'/>
</head>
<body>
<tag action="article.category">
    <h3>{{$field['catname']}}</h3>
    <tag action="article.lists" row="10" cid="$field['cid']">
        <a href="{{$field['url']}}">{{$field['title']}}</a>
    </tag>
</tag>
</body>
</html>