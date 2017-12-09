<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>内容页</title>
    <extend file='resource/view/member'/>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/page.css"/>
</head>
<body>
<!--头部-->
<include file='ARTICLE_PATH/header'/>
<!--头部结束-->
<!--导航条-->
<div id="menu">
    <div class="center">
        <a href="/">首页</a>
        <tag action="article.category_top">
            <a href="{{$field['url']}}" class="{{$field['current_category']}}">{{$field['catname']}}</a>
        </tag>
    </div>
</div>
<!--导航条结束-->
<!--搜索区域-->
<!--<div id="search">
    <span>热门关键词：</span>
    <a href="">不锈钢</a>
    <a href="">工业</a>
    <a href="">客户案例</a>
    <a href="">远兴鸿</a>
    <a href="">新闻</a>

    <form action="" method="post">
        <input type="text" placeholder="请输入搜索关键词" class="keyword"/>
        <input type="submit" value="" class="sub" />
    </form>
</div>-->
<!--搜索区域结束-->
<img src="{{ARTICLE_URL}}/images/20160722170646_18014.jpg" style="display: block;margin: 0 auto;"/>
<!--大区域-->
<div class="main">
    <!--左侧-->
    <div class="left">
        <!--面包屑导航-->
        <!--separator="/"这个属性可以指定面包屑导航中的分隔符-->
        <tag action="article.breadcrumb"></tag>
        <!--<p class="position">
            <span>当前位置：</span>
            <a href="">首页</a>
            »
            <a href="">产品中心</a>
        </p>-->
        <h1>{{$hdcms['title']}}</h1>
        <p class="info">作者：{{$hdcms['author']}}&nbsp;&nbsp;&nbsp;&nbsp;点击量：{{$hdcms['click']}}</p>
        <div class="content">
            {{$hdcms['content']}}
        </div>
        <!--上一篇下一篇-->
        <!--<div class="np">
            <p class="n">上一篇：<a href="">职守焊管岗位，模具轧辊使用寿命长</a></p>
            <p class="p">下一篇：<a href="">细中取精，制作精度分差小之又小</a></p>
        </div>-->
    </div>
    <!--左侧结束-->
    <!--右侧-->
    <div class="right">
        <h3>全站资讯导航</h3>
        <tag action="article.category" cid="7,8,9">
            <dl>
                <dt><a href="{{$field['url']}}">{{$field['catname']}}</a>
                <dt>
                    <tag action="article.category_level">
                <dd>
                    <a href="{{$field['url']}}">{{$field['catname']}}</a>
                </dd>
        </tag>
        </dl>
        </tag>
    </div>
    <!--右侧结束-->
</div>
<!--大区域结束-->
<!--底部-->
<include file='ARTICLE_PATH/footer'/>
<!--底部结束-->
</body>
</html>
