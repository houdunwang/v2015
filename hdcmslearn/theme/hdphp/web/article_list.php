<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$hdcms['catname']}}</title>
    <include file="resource/view/member"/>
</head>
<body>
<div class="container">
    <div class="row">
        <include file="ARTICLE_PATH/block/menu"/>
        <div class="col-sm-8" style="padding-left:0px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$hdcms['catname']}}</h3>
                </div>
                <ul class="list-group">
                    <tag action="article.pagelist" row="10" sub_category="1">
                        <li class="list-group-item">
                            <a href="{{$field['url']}}">
                                {{mb_substr($field['title'],0,20,'utf8')}}
                            </a>
                            <span class="pull-right">
                                    {{date("Y年m月d日",$field['createtime'])}}
                            </span>
                        </li>
                    </tag>
                </ul>
            </div>
            <tag action="article.pagination"></tag>
        </div>
        <div class="col-sm-4" style="padding-right: 0px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">栏目列表</h3>
                </div>
                <ul class="list-group">
                    <tag action="article.category" pid="0">
                        <li class="list-group-item">
                            <a href="{{$field['url']}}">{{$field['catname']}}</a>
                        </li>
                    </tag>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    require(['bootstrap']);
</script>
</body>
</html>