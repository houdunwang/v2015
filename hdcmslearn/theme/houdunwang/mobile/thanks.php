<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="{{ARTICLE_URL}}/css/style.css" />
		<title>{{$hdcms['title']}}-{{$hdcms['category']['catname']}}-{{$module['site']['title']}}</title>
	</head>
	<body>
		<!--头部-->
		<include file='ARTICLE_PATH/header' />
		<!--头部结束-->
		<!--主体-->
		<div id="contentarea">
			<!--左侧菜单-->
			<include file='ARTICLE_PATH/herosleft' />
			<!--左侧菜单结束-->
			<!--右侧-->
			<div class="right">
				<!--班级列表-->
				<div class="classes">
					<tag action="article.lists" cid="$hdcms['cid']" row='100'>
						<a href="{{$field['url']}}" class='{{$field['current_article']}}'>{{$field['class']}}期</a>
					</tag>
				</div>
				<!--班级列表结束-->
				<h1>{{$hdcms['title']}}</h1>
				<p class="description">{{$hdcms['description']}}</p>
				<!--视频-->
				<embed src="{{$hdcms['videourl']}}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="480" height="400" id="video"></embed>
				<script type="text/javascript">
                    //如果没有视频链接,就删掉embed标签
					var video = document.getElementById("video");
					if (!video.getAttribute('src')) {
						video.parentNode.removeChild(video);
					}
				</script>
				<!--视频结束-->
				{{$hdcms['content']}}
			</div>
			<!--右侧结束-->
		</div>
		<!--主体结束-->
		<img src="{{ARTICLE_URL}}/images/xiangshan.jpg" class="xiangshan" />
		<!--底部-->
		<include file='ARTICLE_PATH/footer' />
		<!--底部结束-->
	</body>
</html>