<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后盾网_PHP培训_PHP视频教程_北京PHP培训_后盾网有实力做后盾!全国PHP实战培训,全程实战,抵制肤浅内容-</title>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/common.css?version={{HDCMS_VERSION}}"/>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/index.css?version={{HDCMS_VERSION}}"/>
    <meta name="keywords" content="北京php培训,php视频教程,php培训,php基础视频,php实例视频,lamp视频教程"/>
    <meta name="description" content="后盾网顶尖PHP培训，最专业的网站开发php培训，小班化授课，全程实战！业内顶级北京php培训讲师亲自授课，千余课时php独家视频教程免费下载，数百G原创视频资源，实力不容造假！抢座热线：400-682-3231"/>
    <!--swiper-->
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/2.7.6/idangerous.swiper.min.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/Swiper/2.7.6/idangerous.swiper.min.js"></script>
    <!--swiper end-->
</head>
<body>
<!--头部-->
<include file='ARTICLE_PATH/header'/>
<!--头部结束-->
<!--轮播图区域-->
<div id="slideArea">
    <div class="NewsBox">
        <div class="NewS" style="">
            <h2>最新新闻</h2>
            <ul>
                <tag action="article.lists" row="9" cid="139">
                    <li><a href="{{$field['url']}}"> {{$field['title']}}</a></li>
                </tag>
            </ul>
        </div>
        <!--轮播图开始-->
        <div class="swiper-container banner" style="overflow: hidden;">
            <div class="swiper-wrapper">
                <tag action="article.slide_lists">
                <div class="swiper-slide">
                    <a href="{{$field['url']}}" target="_blank" title="{{$field['title']}}">
                    <img src="{{$field['thumb']}}">
                    </a>
                </div>
                </tag>
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
            <!-- 如果需要导航按钮 -->
            <!--<div class="swiper-button-prev"></div>-->
            <!--<div class="swiper-button-next"></div>-->
        </div>
        <style>
            .swiper-container {
                width: 700px;
                height: 300px;
            }
            .swiper-pagination-bullet{
            	border-radius: 0;
            	width: 20px;
            	height: 5px;
            }
        </style>
        <script>
//          require(['hdjs'], function (hdjs) {
//
//              var mySwiper = new Swiper('.swiper-container', {
//                  loop: true,
//                  // 如果需要分页器
//                  pagination: '.swiper-pagination',
//                  //点击分页器可以切换图片
//                  paginationClickable :true,
//                  // 如果需要前进后退按钮
////                  nextButton: '.swiper-button-next',
////                  prevButton: '.swiper-button-prev',
//              })
//          })



			var mySwiper = new Swiper ('.swiper-container', {
			    loop: true,
			    // 如果需要分页器
			    pagination: '.swiper-pagination',
			    //点击分页器可以切换图片
                paginationClickable :true,
			})        	
        </script>
        <!--轮播图结束-->
    </div>
    <!--轮播图区域结束-->
    <!--开班信息-->
    <div class="lession">
        <h2>开班信息</h2>
        <tag action="course.lists" order="orderby desc" row="9">
            <p>
                <span>【{{$field['city']}}】</span>
                <b>{{$field['name']}}</b>
                <i>{{$field['times']}}</i>
            </p>
        </tag>

    </div>
    <!--开班信息结束-->
</div>
<!--学员风采区域-->
<div id="stuStyle">
    <!--风采展示区域-->
    <div class="styleArea">
        <div class="styleHead">
            <h2>学员故事</h2>
            <a href="/article11-55-1.html">更多</a>
        </div>
        <ul class="list">
            <tag action="article.lists" row="12" cid="55">
                <li>
                    <a href="{{$field['url']}}" target="_blank"><img src="{{$field['thumb']}}"/></a>
                    <!--<span class="play"></span>-->
                    <p class="title">
                        <a href="{{$field['url']}}" target="_blank">{{$field['title']}}</a>
                    </p>
                    <!--<p class="cate">{{$field['title']}}</p>-->
                </li>
            </tag>

        </ul>
    </div>
    <!--风采展示区域结束-->
    <!--就业信息区域-->
    <div class="eduinfo">
        <h2><a target="_blank" href="http://www.houdunwang.com/article11-34-1.html">就业信息</a></h2>
        <div class="bodyarea">
            <ul>
                <li class='first'>
                    <img src="{{ARTICLE_URL}}/images/3.jpg"/>
                    <p><b>PHP特种兵的摇篮</b></p>
                </li>

                <tag action="salary.lists" order="id desc" row='10'>
                    <li>
                        <p>
                            <span class="class"></span>
                            <span class="name">{{$field['name']}}</span>
                            <span class="company">{{$field['company']}}</span>
                            <span class="salary">{{$field['wage']}}元</span>
                        </p>
                    </li>
                    <!--<tr>
                        <td>{{$field['name']}}</td>
                        <td>{{$field['company']}}</td>
                        <td>{{$field['graduation']}}</td>
                        <td>{{$field['wage']}}</td>
                        <td>{{$field['present']}}</td>
                        <td>{{$field['address']}}</td>
                    </tr>-->
                </tag>
            </ul>
        </div>
    </div>
    <!--就业信息区域结束-->
</div>
<!--学员风采区域结束-->


<!--校园活动-->
<div id="stupro">
    <div class="proheader">校园活动
        <span>/
					<tag action="article.category" cid="38">
						<a href="/article11-38-1.html" target="_blank">更多</a>
					</tag>
				</span>
    </div>
    <style>
        #stupro .probody.school li {
            width: 278px;
            margin-left: 10px;
            margin-right: 10px;
        }

        #stupro .probody.school li a {
            width: 100%;
        }

        #stupro .probody.school li a img {
            max-width: 278px;
            position: absolute;
            height: auto;
        }

        #stupro .probody.school li a {
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
    <ul class="probody school">
        <tag action="article.lists" row="8" cid="38" titlelen="34">
            <li>
                <a href="{{$field['url']}}" style="position: relative;"><img src="{{$field['thumb']}}"/></a>
                <p class="title">
                    <a href="{{$field['url']}}">{{$field['title']}} </a>
                </p>
                <!--<p class="des">{{$field['description']}}</p>-->
            </li>
        </tag>

    </ul>
</div>
<!--校园活动结束-->

<!--学生作品区域-->
<div id="stupro">
    <div class="proheader">学员作品
        <span>/
					<tag action="article.category" cid="48">
						<a href="/article11-48-1.html">更多</a>
					</tag>
				</span>
    </div>
    <ul class="probody">
        <tag action="article.lists" row="8" cid="48" sub_category='1' titlelen="16" iscommend="1">
            <li>
                <!--<div class="play"></div>-->
                <a href="{{$field['url']}}" class="imglink"><img src="{{$field['thumb']}}"/></a>
                <p class="title">
                    <a href="{{$field['url']}}">{{$field['title']}} </a>
                </p>
                <p class="des">{{$field['description']}}</p>
            </li>
        </tag>

    </ul>
</div>
<!--学生作品区域结束-->


<!--视频教程区域-->
<div id="video">
    <div class="videoarea">
        <h2>视频教程</h2>
        <p class='detail'>课程库中包含了大量制作精良的课程，你可以在这里浏览到后盾网所有课程，并且根据需求，按照技术分类进行检索</p>
        <a href="http://www.houdunren.com" target="_blank" class='btn'>查看全部课程</a>
        <img src="{{ARTICLE_URL}}/images/pc.jpg"/>
    </div>
</div>
<!--视频教程区域结束-->
<!--开学典礼Start-->
<div id="notice">
    <div class="noticearea">
        <div class="kaixue">
            <h2><a href="http://www.houdunwang.com/article11-54-1.html">更多</a>开学典礼</h2>
            <div class="pics">
                <tag action="article.lists" row="1" cid="54" titlelen='13'>
<!--                    <div class="big">-->
<!--                        <a href="{{$field['url']}}" target="_blank">-->
<!--                            <img src="{{$field['thumb']}}"/>-->
<!--                            <p>{{$field['title']}}</p>-->
<!--                            <input type="hidden" value="{{$field['thumb']}}"/>-->
<!--                        </a>-->
<!--                    </div>-->
                </tag>
                <div class="smallimg">
                    <ul>
                        <tag action="article.lists" row="8" cid="54" titlelen='10'>
                            <li>
                                <a href="{{$field['url']}}" target="_blank">
                                    <img src="{{$field['thumb']}}" alt="{{$field['title']}}"/>
                                    <p>{{$field['title']}}</p>
                                </a>
                            </li>
                        </tag>

                    </ul>
                </div>
            </div>
        </div>

        <div class="ganyan" style="height: 500px;">
            <h2>学员感言</h2>
            <div class="ganyanpic">
                <ul>
                    <tag action="article.lists" row="2" cid="78" titlelen='13'>
                        <li>
                            <div>
                                <a href="{{$field['url']}}" target="_blank"><img src="{{$field['thumb']}}" alt="{{$field['title']}}"/></a>
                            </div>
                            <div class="desc">
                                <h3><a href="{{$field['url']}}" target="_blank">{{$field['title']}}</a></h3>
                                <p>{{truncate($field['description'],40)}}</p>
                            </div>
                        </li>
                    </tag>

                </ul>
            </div>

            <div class="glist">
                <ul>
                    <tag action="article.lists" row="11" start="2" cid="78" titlelen='25'>
                        <li>
                            <a href="{{$field['url']}}">· {{$field['title']}}</a>
                        </li>
                    </tag>

                </ul>
            </div>
        </div>
    </div>
</div>
<!--开学典礼End-->
<!--team团队区域-->
<div id="team">
    <div class="teamarea">
        <div class="header">核心管理团队</div>
        <ul class="member">
            <tag action="article.lists" row="12" cid="76">
                <!--{{p($field)}}-->
                <li>
                    <img src="{{$field['thumb']}}"/>
                    <h2>{{$field['title']}}</h2>
                    <span>{{$field['author']}}</span>
                    <p>{{$field['description']}}</p>
                </li>
            </tag>

        </ul>
    </div>
</div>

<!--合作伙伴区域-->
<div id="clients">
    <div class="clientarea">
        <h2>谁选择了我们的学生？</h2>
        <p>我们培养最负责任的行业最NB的PHP工程师！</p>
        <ul>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/ansys.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/baidu.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/renren.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/sina.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/sohu.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/taobao.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/tmail.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/tom.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/tudou.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/youku.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/zilian.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/vanvel.jpg"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/jumei.png"/></a>
            </li>
            <li>
                <a href="javascript:;"><img src="{{ARTICLE_URL}}/images/ifeng.jpg"/></a>
            </li>
        </ul>
    </div>
</div>
<!--合作伙伴区域结束-->

<!--bbs区域-->
<div id="bbs">
    <div class="bbsarea">
        <h2>BBS</h2>
        <div class="nav">
            <!--<a href="lesson.html" target="_blank">"圣经"级免费视频</a>-->
            <a href="http://bbs.houdunwang.com/thread-36838-1-1.html" target="_blank">VIP视频</a>
            <a href="http://bbs.houdunwang.com/forum-89-1.html" target="_blank">问题解答区</a>
            <!--<a href="http://bbs.houdunwang.com/forum-105-1.html" target="_blank">HDPHP框架问答</a>-->
            <a href="http://bbs.houdunwang.com/forum.php?gid=287" target="_blank">向军老师免费视频</a>
            <a href="http://bbs.houdunwang.com/forum.php?gid=307" class="last" target="_blank">最新零基础视频教程</a>
        </div>
        <div class="des">通过论坛分享心得，结交更多热爱技术的朋友</div>
        <br>
        <ul class="bbs_title">
            <li>最新问题</li>
            <li>推荐阅读</li>
            <li>原创微视频</li>
        </ul>

        <div class="bbs_list">
            <script type="text/javascript" src="http://bbs.houdunwang.com/api.php?mod=js&bid=20"></script>
            <script type="text/javascript" src="http://bbs.houdunwang.com/api.php?mod=js&bid=22"></script>
            <script type="text/javascript" src="http://bbs.houdunwang.com/api.php?mod=js&bid=24"></script>
        </div>
    </div>
</div>
<!--bbs区域结束-->

<!--底部-->
<include file='ARTICLE_PATH/footer'/>
<!--底部结束-->

<!-- 友情链接 -->
<style type="text/css">
    #youlian {
        overflow: hidden;
        background: #000000;
        padding: 30px;
    }

    #youlian .center {
        width: 1200px;
        line-height: 30px;
        margin: 0 auto;
    }

    #youlian .center a {
        color: #7D7F81;
        float: left;
        padding-right: 9px;
    }

    #youlian .center strong {
        float: left;
        color: #7D7F81;
    }
</style>
<div id="youlian">
    <div class="center">
        <strong>友情链接(换链接请Q 773642682)：</strong>

        <tag action="links.lists" order="id desc" row="50">
            <a href="{{$field['url']}}" target="_blank">{{$field['name']}}</a>
        </tag>


    </div>
</div>

<!-- 友情链接结束 -->


</body>

</html>