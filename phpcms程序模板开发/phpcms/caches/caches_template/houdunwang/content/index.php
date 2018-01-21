<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=“X-UA-Compatible” content=“chrome=1″ />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="renderer" content="webkit" />
    <meta name="keywords" content="<?php echo $SEO['keyword'];?>" />
    <meta name="description" content="<?php echo $SEO['description'];?>" />
    <title><?php echo $SEO['site_title'];?></title>
    <!--phpcms.cn@foxmail.com-->
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/reset.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/common.css">
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/common.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/scrollTop.js"></script>
</head>
<body>
<?php include template('content','header'); ?>

<div class="clear"></div>
<!-- 头部结束 -->
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/index.css">
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=849628ca3f0fd087fa3558737aa03109"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
<!--swiper-->
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/swiper.min.css">
<script src="<?php echo WEB_PATH;?>statics/houdunwang/js/swiper.min.js"></script>
<!--swiper-->
<style>
    html, body {
        position: relative;
        height: 100%;
    }
    .BMapLib_bubble_content{
        height: 125px !important;
    }
    /*=======*/
    .swiper-container {
        width: 100%;
        height: 100%;
        margin-top:80px;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    /*========*/
</style>

<script>
    $(function(){
        var height = $(window).height();
        // $(".slider").css('height',height - 80);
        // $(".slider .sliderimgs").css('height',height - 80);
        $(".sjslider").css('height',height - 60);
    })
</script>

<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/slider1.jpg" alt=""></div>
        <div class="swiper-slide"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/slider2.jpg" alt=""></div>
        <div class="swiper-slide"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/slider3.jpg" alt=""></div>
        <div class="swiper-slide"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/slider4.jpg" alt=""></div>
        <div class="swiper-slide"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/slider5.jpg" alt=""></div>
        <div class="swiper-slide"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/slider6.jpg" alt=""></div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<script>
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
<pre>
    <!--<?php echo print_r($SEO);?>-->
</pre>
<!-- 轮播图结束 -->
<!-- 资讯开始 -->
<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=45c5e65c9b20d90731b3602dea5e4788&action=category&num=2\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('limit'=>'2',));}?>
<?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
<div class="zixun">
    <div class="top">
        <h2 style="font-size: 32px;"><?php echo $v['catname'];?></h2>
    </div>
    <div class="news">
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=7d8ed95016c7347d2a286a0666021631&action=lists&catid=%24v%5B%27catid%27%5D&num=3\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$v['catid'],'limit'=>'3',));}?>
        <?php $n=1;if(is_array($data)) foreach($data AS $vv) { ?>
        <div class="yimao_news">
            <a href="<?php echo $vv['url'];?>" class="yimaonewspic">
                <img src="<?php echo $vv['thumb'];?>" alt="">
            </a>
            <a href="<?php echo $vv['url'];?>" class="title"><?php echo $vv['title'];?></a>
            <p class="newstime">2017-11-01 来自<span class="laiyuan"><?php echo $CATEGORYS[$vv['catid']]['catname'];?></span></p>
            <a href="<?php echo $vv['url'];?>" class="more">了解详情</a>
        </div>
        <?php $n++;}unset($n); ?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </div>
    <a href="<?php echo $v['url'];?>" class="gengduo">更多<?php echo $v['catname'];?> +</a>
</div>
<?php $n++;}unset($n); ?>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
<!-- 资讯结束 -->

<!-- 品牌与产品 -->
<!--<div class="chanpin">-->
    <!--<div class="top">-->
        <!--<h2 style="font-size: 32px;">校园活动</h2>-->
    <!--</div>-->
    <!--<div class="products">-->
        <!--<div class="product">-->
            <!--<a href="http://www.yimaokeji.com/content-25-1-1.html" class="cpimg"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/xiaoyuan.JPG"></a>-->
            <!--<a href="http://www.yimaokeji.com/content-25-1-1.html" class="title">后盾网2017迎中秋佘山游（上海校区）</a>-->
        <!--</div>-->
        <!--<div class="product">-->
            <!--<a href="http://www.yimaokeji.com/content-25-1-1.html" class="cpimg"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/xiaoyuan.JPG"></a>-->
            <!--<a href="http://www.yimaokeji.com/content-25-1-1.html" class="title">后盾网2017迎中秋佘山游（上海校区）</a>-->
        <!--</div>-->
        <!--<div class="product">-->
            <!--<a href="" class="cpimg"><img src="<?php echo WEB_PATH;?>statics/houdunwang/images/xiaoyuan.JPG"></a>-->
            <!--<a href="" class="title">后盾网2017迎中秋佘山游（上海校区）</a>-->
        <!--</div>-->
    <!--</div>-->
    <!--<a href="#" class="gengduo">更多</a>-->
<!--</div>-->
<!--&lt;!&ndash; 品牌与产品 &ndash;&gt;-->

<!--&lt;!&ndash; 主题活动 &ndash;&gt;-->
<!--<div class="huodong">-->
    <!--<div class="top">-->
        <!--<img src="http://www.yimaokeji.com/statics/ymkj/images/huodongTitle.jpg">-->
    <!--</div>-->
    <!--<div class="bottom">-->
        <!--<div class="active">-->
             <!--<img src="<?php echo WEB_PATH;?>statics/houdunwang/images/xiaoyuan.JPG">-->
            <!--<div class="back"></div>-->
            <!--<a href="http://www.yimaokeji.com/content-5-13-1.html" class="title">后盾网2017迎中秋佘山游（上海校区）</a>-->
            <!--<p class="newstime">2017-07-17</p>-->
        <!--</div>-->
        <!--<div class="active">-->
            <!--<img src="<?php echo WEB_PATH;?>statics/houdunwang/images/xiaoyuan.JPG">-->
            <!--<div class="back"></div>-->
            <!--<a href="http://www.yimaokeji.com/content-5-13-1.html" class="title">后盾网2017迎中秋佘山游（上海校区）</a>-->
            <!--<p class="newstime">2017-07-17</p>-->
        <!--</div>-->
        <!--<div class="active">-->
            <!--<img src="<?php echo WEB_PATH;?>statics/houdunwang/images/xiaoyuan.JPG">-->
            <!--<div class="back"></div>-->
            <!--<a href="http://www.yimaokeji.com/content-5-13-1.html" class="title">后盾网2017迎中秋佘山游（上海校区）</a>-->
            <!--<p class="newstime">2017-07-17</p>-->
        <!--</div>-->
        <!--<div class="active">-->
            <!--<img src="<?php echo WEB_PATH;?>statics/houdunwang/images/xiaoyuan.JPG">-->
            <!--<div class="back"></div>-->
            <!--<a href="http://www.yimaokeji.com/content-5-13-1.html" class="title">后盾网2017迎中秋佘山游（上海校区）</a>-->
            <!--<p class="newstime">2017-07-17</p>-->
        <!--</div>-->
    <!--</div>-->
    <!--<a href="" class="gengduo">更多活动 +</a>-->
<!--</div>-->
<!-- 主题活动 -->
<!-- 关于我们 -->
<div class="max_about">
    <div class="about">
        <div class="left">
            <p class="title">ABOUT US & 关于后盾网<br />BRAND STORY<br />品牌影响力</p>
            <p class="aboutus">后盾网隶属于北京后盾计算机技术培训有限责任公司，是专注于培养中国互联网顶尖PHP程序语言专业人才的专业型培训机构，拥有七年培训行业经验。后盾网拥有国内最顶尖的讲师和技术团队，团队成员项目经验均在8年以上，团队曾多次为国内外上市集团、政府机关的大型项目提供技术支持，其中包括新浪、搜狐、腾讯、宝洁公司、联想、丰田、工商银行、中国一汽等众多大众所熟知的知名企业。</p>
            <a href="#" class="more">了解详情 +</a>
        </div>

        <div class="right">
            <img src="<?php echo WEB_PATH;?>statics/houdunwang/images/about.jpg" class="aboutimg">
        </div>
    </div>
</div>
<!-- <span style="display:block;width:100%;border-top:solid 0.5px #ccc;margin:0;"></span> -->
<div class="contact">
    <div class="top">
        <img src="http://www.yimaokeji.com/statics/ymkj/images/contactTitle.jpg">
    </div>
    <div class="bottom">
        <div class="xianlu">
            <img src="http://www.yimaokeji.com/statics/ymkj/images/contactImg.jpg">
            <p class="chengche">地铁15号线马泉营站，C口出右转坐988路公交车在两站后终点下车，下车后前行到马泉营北门出去右转100米即可到达后盾IT教育。</p>
        </div>
        <div class="map" id="allmap"></div>
    </div>
</div>
<!-- 联系我们 -->
<?php include template('content','footer'); ?>
<script>
    window._bd_share_config = {
        "common": {
            "bdSnsKey": {},
            "bdText": "",
            "bdMini": "2",
            "bdMiniList": false,
            "bdPic": "",
            "bdStyle": "0",
            "bdSize": "16"
        },
        "share": {},
        // "image": {
        // 	"viewList": ["sqq", "weixin", "qzone", "tieba", "tsina", "tqq"],
        // 	"viewText": "分享到：",
        // 	"viewSize": "16"
        // },
        // "selectShare": {
        // 	"bdContainerClass": null,
        // 	"bdSelectMiniList": ["sqq", "weixin", "qzone", "tieba", "tsina", "tqq"]
        // }
    };
    with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".gzweixin").hover(function(){
            var height = document.documentElement.clientHeight;
            $(".gzherweima").css('bottom',(height - 200) / 2);
            $(".gzherweima").css('display','block');
        },function(){
            $(".gzherweima").css('display','none');
        });
    });
</script>
<!-- 分享 -->
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 5000,
        autoplayDisableOnInteraction: false
    });
</script>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map('allmap');
    var poi = new BMap.Point(116.52179315359358,40.04801374641647);
    map.centerAndZoom(poi, 18);
    map.enableScrollWheelZoom();

    var content = '<div style="margin:0;line-height:20px;padding:2px;">' +
        '<img src="<?php echo WEB_PATH;?>statics/houdunwang/images/houdunwang.jpg" alt="" style="float:right;zoom:1;overflow:hidden;width:70px;height:70;margin-left:3px;background:#f22f16"/>' +
        '地址：北京市朝阳区马泉营顺白路12号比目鱼创业园A区<br/>电话：400-682-3231<br/>简介：后盾网隶属于北京后盾计算机技术培训有限责任公司，是专注于培养中国互联网顶尖PHP程序语言专业人才的专业型培训机构。' +
        '</div>';

    //创建检索信息窗口对象
    var searchInfoWindow = null;
    searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
        title  : "后盾网",      //标题
        width  : 340,             //宽度
        height : 125,              //高度
        panel  : "panel",         //检索结果面板
        enableAutoPan : true,     //自动平移
        searchTypes   :[
            BMAPLIB_TAB_SEARCH,   //周边检索
            BMAPLIB_TAB_TO_HERE,  //到这里去
            BMAPLIB_TAB_FROM_HERE //从这里出发
        ]
    });
    var marker = new BMap.Marker(poi); //创建marker对象
    searchInfoWindow.open(marker);
    marker.addEventListener("click", function(e){
        searchInfoWindow.open(marker);
    })
    map.addOverlay(marker); //在地图中添加marker
</script>

<!--http://api.map.baidu.com/geocoder/v2/?address=北京市朝阳区马泉营顺白路12号&output=json&ak=4eQQ1fZAP1iwK5YekxqTtEjKkAZstwH5&callback=showLocation-->


</body>
</html>