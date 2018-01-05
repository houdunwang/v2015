<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{template_url()}}/css/style.css"/>
    <title>{{$hdcms['catname']}}-{{$module['site']['title']}}</title>
</head>
<body>
<!--头部-->
<include file='ARTICLE_PATH/header'/>
<!--头部结束-->
<!--主体-->
<div id="contentarea">
    <!--左侧菜单-->
    <include file='ARTICLE_PATH/herosleft'/>
    <!--左侧菜单结束-->
    <!--右侧-->
    <div class="right" style="background: none;box-shadow: none;overflow: visible;">
        <!--班级列表-->
        <div class="classes" style="background:white;margin-bottom:10px;padding-bottom: 15px;border-radius: 6px;padding: 10px 30px;">
            <tag action="article.category" pid="$hdcms['pid']">
                <a href="{{$field['url']}}" class="{{$field['current_category']}}">{{$field['catname']}}</a>
            </tag>
        </div>
        <!--班级列表结束-->
        <ul class="xiangmu">
            <tag action="article.lists" cid="$hdcms['cid']">
                <li>
                    <img src="{{$field['thumb']}}" alt="{{$field['title']}}"/>
                    <h2>{{$field['title']}}</h2>
                    <p>班级：{{$field['class']}}期</p>
                    <p>学员：{{$field['name']}}</p>
                    <p>开发周期：{{$field['days']}}天</p>
                    <p>所用技术：{{$field['technology']}}</p>
                    <a class="more" target="_blank" href="{{$field['url']}}">查看展示</a>
                </li>
            </tag>
        </ul>
    </div>
    <!--右侧结束-->
</div>
<!--主体结束-->
<img src="{{template_url()}}/images/xiangshan.jpg" class="xiangshan"/>
<!--手动让左侧导航变色-->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
    $("a:contains(学员项目展示)").parent().addClass('current_category');
</script>
<!--手动让左侧导航变色结束-->
<!--底部-->
<include file='ARTICLE_PATH/footer'/>
<!--底部结束-->
</body>
</html>