<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <include file="resource/view/member"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ARTICLE_URL}}/css/style.css?version={{HDCMS_VERSION}}"/>
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
        <ul class="show xyhf">
            <tag action="article.lists" cid="$hdcms['cid']" row="100">
                <li>
                    <img src="{{$field['thumb']}}" alt="{{$field['title']}}"/>
                    <h2>{{$field['title']}}</h2>
                    <p>{{$field['description']}}</p>
                    <a href="{{$field['url']}}" class="more" target="_blank">回访详情</a>
                </li>
            </tag>
        </ul>
    </div>
    <!--右侧结束-->
</div>
<!--主体结束-->
<img src="{{ARTICLE_URL}}/images/xiangshan.jpg" class="xiangshan"/>
<!--底部-->
<include file='ARTICLE_PATH/footer'/>
<!--底部结束-->
</body>
</html>