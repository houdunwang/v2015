<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <include file="resource/view/member"/>
		<link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/common.css?version={{HDCMS_VERSION}}" />
		<link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/product.css?version={{HDCMS_VERSION}}" />
		<title>{{$hdcms['title']}}-{{$module['site']['title']}}</title>
	</head>
	<body>

		<!--头部-->
		<include file='ARTICLE_PATH/header'/>
		<!--头部结束-->
		<!--主体区域-->
		<div id="content">
			<div class="contentarea">
                
                <!--左侧菜单-->
                <include file='ARTICLE_PATH/aboutusleft'/>
                <!--左侧菜单结束-->
                
				<div class="right">
					<h2>{{$hdcms['description']}}</h2>
					<div class="body">
						{!!$hdcms['content']!!}
					</div>
				</div>
			</div>
		</div>
		<!--主体区域结束-->


		<!--底部-->
		<include file='ARTICLE_PATH/footer'/>
		<!--底部结束-->
        
	</body>

</html>