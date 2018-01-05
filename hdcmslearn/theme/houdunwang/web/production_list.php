<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <include file="resource/view/member"/>
		<link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/common.css?version={{HDCMS_VERSION}}" />
		<link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/production_list.css?version={{HDCMS_VERSION}}" />
		<title>{{$hdcms['title']}}-{{$hdcms['category']['catname']}}-{{$module['site']['title']}}</title>
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
								
								<div class="all">
									全部班级：
								</div>
								<div class="allList">
										{{p($hdcms)}}
									
									<tag action="article.category" pid="$hdcms['cid']">

									   	<a href="{{$field['url']}}" class="{{$field['current_category']}}">{{$field['catname']}}</a>
									</tag>
									<!--<a href="" class="active">第55期</a>
									<a href="">第56期</a>
									<a href="">第56期</a>
									<a href="">第56期</a>-->
								</div>
							</div>
						</div>
						<!--顶部导航结束-->
					
					<!--项目展示开始-->
					<div class="GoodContent PublicContent">
						<ul class="List">
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="ListContent">
									<a href="">
										<img src="./img/ce.jpg" alt="" />
										<div class="SmallTitle">
											<span>已更新完成&nbsp;共5课时</span>
										</div>
									</a>
									<div class="ListBottom">
										<h3><a href="">Photoshop人像后期处理基础课程</a></h3>
										<div class="row">
											<span>主讲人：孙老师</span>
											<a href="">后盾网特级讲师</a>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<!--项目展示结束-->
					<!--分页开始-->
		<div class="paging">
			<ul>
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
			</ul>
		</div>
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
					<!--学员项目展示区域-->
					<!--<div class="show">
						<div class="headarea">
							<h3>学生项目</h3>
							<a href="project.html">更多</a>
						</div>
						<ul class="conarea">
							<tag action="article.lists" row="5" cid="48" sub_category='1' titlelen="26" iscommend="1">
							    <li>
									<div class="picture">
										<a href="{{$field['url']}}"><img src="{{$field['thumb']}}" /></a>
									</div>
									<p>
										<a href="{{$field['url']}}">{{$field['title']}}</a>
									</p>
									<p class='light'>{{$field['description']}}</p>
								</li>
							</tag>
							
						</ul>
					</div>-->
					<!--学员项目展示区域结束-->
				</div>
			</div>
		</div>

		<!--底部-->
		<include file='ARTICLE_PATH/footer' />
		<!--底部结束-->

	</body>

</html>