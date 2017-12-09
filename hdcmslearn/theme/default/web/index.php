<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$module['site']['title']}}</title>
    <include file="resource/view/member.php"/>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/index.css"/>
    <script src="{{ARTICLE_URL}}/js/index.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<!--头部-->
<include file='ARTICLE_PATH/header'/>
<!--头部结束-->
<!--导航条-->
<div id="menu">
    <div class="center">
        <a href="/" class="current_category">首页</a>
        <tag action="article.category_top">
            <a href="{{$field['url']}}">{{$field['catname']}}</a>
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

<!--轮播图-->
<!--注意：直接向下面的div中遍历输出a标签即可，小圆点会根据a标签的数量自动创建，边界条件会自动判断。-->
<div id="flash" style="overflow: hidden;">
    <tag action="article.slide">
</tag>
</div>
<!--轮播图结束-->

<!--大区域-->
<div class="main">
    <div class="left">

        <h3>全站资讯导航</h3>
        <tag action="article.category">
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

    <!--右侧-->
    <div class="right">
        <!--标题-->
        <div class="title">
            <p>
                <span>最新产品</span>
                <img src="{{ARTICLE_URL}}/images/sd02.jpg"/>
            </p>
            <a href=""><img src="{{ARTICLE_URL}}/images/more01.gif"/></a>
        </div>
        <!--标题结束-->
        <!--产品列表-->
        <ul class="product_list">
            <tag action="article.lists" row="11">
                <li>
                    <a href="{{$field['url']}}" class="pic"><img src="{{$field['thumb']}}"/></a>
                    <a href="{{$field['url']}}" class="product_title">{{$field['title']}}</a>
                    <p>{{$field['description']}}</p>
                </li>
            </tag>
        </ul>
        <!--产品列表结束-->

    </div>
    <!--右侧结束-->
</div>
<!--大区域结束-->
<!--车间-->
<!--这个轮播图非常聪明，只需要向ul里遍历li数据即可。其他的事情js帮你搞定-->
<div id="factory">
    <div class="line"></div>
    <img src="{{ARTICLE_URL}}/images/sltil.gif" class="title"/>
    <img src="{{ARTICLE_URL}}/images/ico_l01.jpg" class="icon1"/>
    <img src="{{ARTICLE_URL}}/images/ico_r01.jpg" class="icon2"/>
    <div class="center">
        <ul>
            <tag action="article.lists" row="10" iscommend='1'>
                <li>
                    <img src="{{$field['thumb']}}"/>
                    <a href="{{$field['url']}}">{{$field['title']}}</a>
                </li>
            </tag>
        </ul>
    </div>
</div>
<!--车间结束-->
<img src="{{ARTICLE_URL}}/images/ge02.jpg" id="shadow"/>
<!--底部-->
<include file='ARTICLE_PATH/footer'/>
<!--底部结束-->
</body>
</html>