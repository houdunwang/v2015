<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <include file="resource/view/member"/>
</head>
<body>


<tag action="article.pagelist" row="1" sub_category="1">
    <li class="list-group-item">
        [<a href="{{$field['category']['url']}}">{{$field['category']['catname']}}</a>]
        <a href="{{$field['url']}}">
            {{mb_substr($field['title'],0,20,'utf8')}}
        </a>
    </li>
</tag>

<tag action="article.pagination"></tag>
</body>
</html>