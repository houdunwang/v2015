<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HDCMS免费的微信/移动/桌面开发工具</title>
    <include file="resource/view/member"/>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?53d98c6e216535ca7ca8f75ec35a5967";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <include file="ARTICLE_PATH/block/menu"/>
        <div class="col-sm-12 text-center body">
            <h1>HDPHP 3.0</h1>
            <p>可能是国内最好用的PHP开源框架</p>
            <img src="http://www.hdcms.com/theme/hdphp/web/images/hdphp.jpg">
            <div class="row" style="margin-top: 30px;">
                    <p>
                        <code><strong>安装框架:</strong> composer create-project houdunwang/hdphp blog  --prefer-dist</code>
                    </p>
                <a href="http://www.houdunren.com/houdunren18_50_0.html" class="btn btn-success" target="_blank">观看视频教程</a>
            </div>
            <p class="qq">
                交流QQ群:248767393(满) 517903509(开放)
            </p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            最新文章
                            <a href="http://www.hdphp.com/article13-145-1.html" class="pull-right">更多</a>
                        </h3>
                    </div>
                    <ul class="list-group">
                        <tag action="article.lists" row="10">
                            <li class="list-group-item">
                                <span class="label label-info">{{$field['category']['catname']}}</span>
                                <a href="{{$field['url']}}" target="_blank">{{$field['title']}}</a>
                                <span class="pull-right text-muted"> {{date("Y年m月d日",$field['createtime'])}}</span>
                            </li>
                        </tag>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            推荐文章
                        </h3>
                    </div>
                    <ul class="list-group">
                        <tag action="article.lists" row="10" iscommend="1">
                            <li class="list-group-item">
                                <span class="label label-success">{{$field['category']['catname']}}</span>
                                <a href="{{$field['url']}}" target="_blank">{{$field['title']}}</a>
                                <span class="pull-right text-muted"> {{date("Y年m月d日",$field['createtime'])}}</span>
                            </li>
                        </tag>
                    </ul>
                </div>
            </div>
        </div>

        <div class="copyright text-center text-muted">
            我们的使命：帮助中小企业快速实现互联网价值,增长企业效益!<br/>
            Copyright © 2010-2016 hdcms.com All Rights Reserved 京ICP备京ICP备12048441号-7
        </div>
    </div>
</div>
<script>
    require(['bootstrap']);
</script>
</body>
</html>