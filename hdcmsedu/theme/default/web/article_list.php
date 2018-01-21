<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>栏目页列表</title>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/article_list.css"/>
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
        <tag action="article.breadcrumb"></tag>
        <!--<p class="position">
            <span>当前位置：</span>
            <a href="">首页</a>
            »
            <a href="">产品中心</a>
        </p>-->
        <ul>
            <tag action="article.pagelist" row="3">
                <!--{{p($field)}}-->
                <li class="list-group-item">
                    <a href="{{$field['url']}}" class="title">{{$field['title']}}</a>
                    <span class="time">[ {{date('Y-m-d h:i:s',$field['createtime'])}} ]</span>
                    <p class="desc">{{$field['description']}}</p>
                </li>
            </tag>
            <!--<li>
                <a href="" class="title">不锈钢装饰焊管机，向着更高的目标健步迈进</a>
                <span class="time">[ 02-13 10:00 ]</span>
                <p class="desc">13415478816随着2017年璀璨阳光的到来，我们告别了充满挑战、奋发有为的2016年，迎来了充满希望、奋发进取的2017年。在此，远兴鸿工业焊管设备表示衷心的感谢和祝福，并致以最诚挚的新春问候及深深的敬意。</p>
            </li>-->
        </ul>
        <!--分页-->
        <tag action="article.pagination"></tag>
        <!--<div class="pagelist">
            <a href="">首页</a>
            <a href="">1</a>
            <strong>2</strong>
            <a href="">3</a>
            <span>...</span>
            <a href="">14</a>
            <a href="">15</a>
            <a href="">16</a>
            <a href="">末页</a>
        </div>-->
        <!--分页结束-->
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
