<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <include file="resource/view/member"/>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/common.css?version={{HDCMS_VERSION}}"/>
    <link rel="stylesheet" type="text/css" href="{{ARTICLE_URL}}/css/projectdetail.css?version={{HDCMS_VERSION}}"/>
    <title>{{$hdcms['title']}}-{{$hdcms['category']['catname']}}-{{$module['site']['title']}}</title>
</head>

<body>

<!--头部-->
<include file='ARTICLE_PATH/header'/>
<!--头部结束-->

<div id="content">
    <div class="contentarea">
        <div class="left">
            <p class="title">{{$hdcms['title']}}</p>
            <dl>
                <dt>项目介绍 &nbsp;&nbsp;<span style="color:#f00;">后盾网学员全部独立开发</span></dt>
                <dd>
                    <table>
                        <tr>
                            <td width="80">开发学员：</td>
                            <td>{{$hdcms['name']}}</td>
                        </tr>
                        <tr>
                            <td>项目阶段：</td>
                            <td>{{$hdcms['category']['catname']}}</td>
                        </tr>
                        <tr>
                            <td>项目介绍：</td>
                            <td>{{$hdcms['description']}}</td>
                        </tr>
                    </table>
                </dd>

                <dt>视频展示</dt>
                <dd>
                    <!--视频-->
                    <if value='$hdcms["source"] eq "oss"'>
                        <video src="{{$hdcms['videourl']}}" width="802" controls='controls' autoplay='autoplay' style="display: block;margin: 0 auto;"></video>
                        <else/>
                        <embed src="{{$hdcms['videourl']}}" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="800" height="550"></embed>
                    </if>
                    <!--视频结束-->
                </dd>

                <dt>项目截图</dt>
                <dd>
                    <img src="{{$hdcms['thumb']}}"/>
                </dd>
            </dl>
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
            <div class="show">
                <div class="headarea">
                    <h3>学生项目</h3>
                    <!--<a href="project.html">更多</a>-->
                </div>
                <ul class="conarea">
                    <tag action="article.lists" row="5" cid="48" sub_category='1' titlelen="26" iscommend="1">
                        <li>
                            <div class="picture">
                                <a href="{{$field['url']}}"><img src="{{$field['thumb']}}"/></a>
                            </div>
                            <p>
                                <a href="{{$field['url']}}">{{$field['title']}}</a>
                            </p>
                            <p class='light'>{{$field['description']}}</p>
                        </li>
                    </tag>
                </ul>
            </div>
            <!--学员项目展示区域结束-->
        </div>
    </div>
</div>

<!--底部-->
<include file='ARTICLE_PATH/footer'/>
<!--底部结束-->

</body>

</html>