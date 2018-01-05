<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <include file="resource/view/member"/>
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
    <div class="right">
        <div class="heying36">
            <img src="{{ARTICLE_URL}}/images/topbanner.jpg" class="topbanner"/>
            <h3 class="toptitle">只有在后盾网可以获得如此深厚的师生情</h3>
        </div>

        <!--就业数据-->
        <table cellpadding="0" cellspacing="0" class="jiuyeshuju">
            <tr>
                <td>姓名</td>
                <td>公司</td>
                <td>毕业薪资</td>
                <td>目前薪资</td>
                <td>工作地点</td>
            </tr>
            <tag action="salary.lists" order="id desc">
                <tr>
                    <td>{{$field['name']}}</td>
                    <td>{{$field['company']}}</td>
                    <td>{{$field['wage']}}</td>
                    <td>{{$field['present']}}</td>
                    <td>{{$field['address']}}</td>
                </tr>
            </tag>

        </table>
        <h3 class="jq">唯一毕业学员送锦旗的机构 这是发自内心的感谢！胜过一切广告，只有后盾网能做到!</h3>
        <img src="{{ARTICLE_URL}}/images/jinqi/1.jpg" style="display: block;width: 100%;"/>
        <img src="{{ARTICLE_URL}}/images/jinqi/2.jpg" style="display: block;width: 100%;"/>
        <img src="{{ARTICLE_URL}}/images/jinqi/3.jpg" style="display: block;width: 100%;"/>
        <!--就业数据结束-->

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