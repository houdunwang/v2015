<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$hdcms['title']}}-HDCMS免费的微信/移动/桌面开发工具</title>
    <include file="resource/view/member"/>
</head>
<body>
<div class="container">
    <div class="row">
        <include file="ARTICLE_PATH/block/menu"/>
        <div class="col-sm-12" style="padding: 0px;">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 20px;">
                    <h3 class="panel-title">{{$hdcms['title']}}</h3>
                </div>
                <div class="panel-body">
                    <p>
                        <strong>发表时间</strong> {{date("Y年m月d日",$hdcms['createtime'])}}
                    </p>
                    {{$hdcms['content']}}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>