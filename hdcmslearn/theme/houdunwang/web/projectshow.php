<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
        <include file="resource/view/member"/>
		<link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/common.css?version={{HDCMS_VERSION}}" />
		<link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/production_list.css?version={{HDCMS_VERSION}}" />
		<title>{{$hdcms['catname']}}-{{$module['site']['title']}}</title>
	</head>
 
	<body>

		<!--头部-->
		<include file='ARTICLE_PATH/header' />
		<!--头部结束-->
		<div id="content">
			
			<div class="contentarea">
				<div class="left">
					<!--顶部导航开始-->
						<div class="TopNavigation">
							<div class="TopMenu">
								<div class="allList">
									<a href="/article11-48-1.html" class="all">全部项目</a>
									<tag action="article.category" pid="48">
									   	<a href="{{$field['url']}}" class="{{$field['current_category']}}">{{$field['catname']}}</a>
									</tag>
								</div>
							</div>
						</div>
						<!--顶部导航结束-->
					<!--项目展示开始-->
					<div class="GoodContent PublicContent">
						<ul class="List">
							<tag action="article.pagelist" sub_category='1' row='6' cid="$hdcms['cid']" >
								<li>
									<div class="ListContent">
										<a href="{{$field['url']}}">
											<img src="{{$field['thumb']}}" alt="{{$field['title']}}" />
											<div class="SmallTitle">
												<span>开发周期：{{$field['days']}}天</span>
											</div>
										</a>
										<div class="ListBottom">
											<h3><a href="javascript:;">{{$field['title']}}</a></h3>
											<div class="row">
												<span>学员：{{$field['name']}}</span>
												<a href="javascript:;">班级：{{$field['class']}}期</a>
											</div>
										</div>
									</div>
								</li>
							</tag>
						</ul>
					</div>
					<!--项目展示结束-->
					<!--分页开始-->
					<tag action="article.pagination"></tag>
		<!--<div class="paging">
				<tag action="article.pagination">
				<li>
					<a href="">上一页</a>
				</li>
				<li class="active">
					<a href="">1</a>
				</li>
				<li>
					<a href="">2</a>
				</li>
				<li>
					<a href="">3</a>
				</li>
				<li>
					<a href="">4</a>
				</li>
				<li>
					<a href="">5</a>
				</li>
				<li>
					<a href="">6</a>
				</li>
				<li>
					<a href="">下一页</a>
				</li>
				<li>
					<a href="">全部</a>
				</li>
				</tag>
		</div>-->
		<!--分页结束-->
					
				</div>
				
				
				
				
				<div class="right">
					<div class="lession">
						<h2>开班信息</h2>
						<tag action="course.lists" order="id desc" row="9">
							<p>
								<span>【{{$field['city']}}】</span>
								<b>{{$field['name']}}</b>
								<i>{{$field['times']}}</i>
							</p>
						</tag>
					</div>
					<!--最新视频区域-->
					<div class="newvideo">
						<div class="headarea">
							<h3>最新视频教程</h3>
							<!--<a href="lesson.html">更多</a>-->
						</div>
						<div class="conarea">
							<ul>
								<tag action="article.lists" cid="94">
								    <li class="active"><i>免费</i>
										<a target="_blank" href="{{$field['url']}}">{{$field['title']}}</a>
									</li>
								</tag>
								
							</ul>
						</div>
					</div>
					<!--最新视频区域结束-->
				</div>
			</div>
		</div>

		<!--底部-->
		<include file='ARTICLE_PATH/footer' />
		<!--底部结束-->

	</body>

</html>