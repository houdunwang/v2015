<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$hdcms['catname']}}</title>
    <extend file='resource/view/member'/>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/article_index.css"/>
    <script src="{{ARTICLE_URL}}/js/list.js" type="text/javascript" charset="utf-8"></script>
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
<img src="{{ARTICLE_URL}}/images/20160722165047_65119.jpg" style="display: block;margin: 0 auto;"/>
<!--大区域-->
<div class="main">
    <!--左侧-->
    <div class="left">
        <!--面包屑导航-->
        <!--<p class="position">
            <span>当前位置：</span>
            <a href="">首页</a> » <a href="">产品中心</a>
        </p>-->
        <!--推荐信息-->
        <!--这个轮播图非常聪明，只需要向ul里遍历li数据即可。其他的事情js帮你搞定-->
        <div id="factory">
            <div class="line"></div>
            <img src="{{ARTICLE_URL}}/images/tuijian.jpg" class="title"/>
            <img src="{{ARTICLE_URL}}/images/ico_l01.jpg" class="icon1"/>
            <img src="{{ARTICLE_URL}}/images/ico_r01.jpg" class="icon2"/>
            <div class="center">
                <ul>
                    <tag action="article.lists" iscommend="1" cid="$hdcms['cid']">
                        <li>
                            <img src="{{$field['thumb']}}" alt="{{$field['title']}}"/>
                            <a href="">{{$field['title']}}</a>
                        </li>
                    </tag>
                    <!--<li>
                        <img src="images/20131106172412_91601.jpg" />
                        <a href="">晋中新大宇不锈钢制品有限公司</a>
                    </li>-->

                </ul>
            </div>
        </div>
        <img src="{{ARTICLE_URL}}/images/ge02.jpg" id="shadow"/>
        <!--推荐信息结束-->
        <tag action="article.category">
            <div class="box">
                <h2><a href="{{$field['url']}}">{{$field['catname']}}</a></h2>
                <ul>
                    <tag action="article.lists" cid="$field['cid']">
                        <li>
                            <a href="{{$field['url']}}">{{$field['title']}}</a>
                            <span class="time">{{date('Y-m-d',$field['createtime'])}}</span>
                        </li>
                    </tag>
                </ul>
            </div>
        </tag>
        <!--<div class="box">
            <h2>第一子栏目</h2>
            <ul>
                <li>
                    <a href="">当不锈钢制管机具备了互联网思维</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">佛山不锈钢机械|焊管设备推荐</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">远兴鸿做的焊管模具有多牛？</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">优质的焊管机选购</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">优质的焊管机选购</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">制管机如何应对“定制化”时代来临</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">当不锈钢制管机具备了互联网思维</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">不锈钢焊管机械，为什么要这么执着</a>
                    <span class="time">2016-01-09</span>
                </li>
                <li>
                    <a href="">当不锈钢制管机具备了互联网思维</a>
                    <span class="time">2016-01-09</span>
                </li>
            </ul>
        </div>-->

    </div>
    <!--左侧结束-->
    <!--右侧-->
    <div class="right">
        <h3>全站资讯导航</h3>
        <tag action="article.category" cid="7,8,9">
            <dl>
                <dt>
                    <a href="{{$field['url']}}">{{$field['catname']}}</a>
                <dt>
                    <tag action="article.category_level">
                <dd><a href="{{$field['url']}}">{{$field['catname']}}</a></dd>
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
