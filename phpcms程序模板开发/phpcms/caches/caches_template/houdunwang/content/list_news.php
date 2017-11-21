<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=“X-UA-Compatible” content=“chrome=1″ />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="renderer" content="webkit" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>新闻列表模板</title>
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/reset.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/common.css">
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/common.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/scrollTop.js"></script>
</head>
<body>
<!-- 固定定位，返回顶部按钮 -->
<div id='rtt'><p></p>返回顶部</div>
<!-- 固定定位，返回顶部按钮 -->

<!-- 手机头部开始 -->
<!-- 头部开始 -->
<div class="headtop">
    <div class="header">
        <div class="left">
            <a href=""></a>
        </div>
        <div class="right">
            <ul class="menu">
                <li><a href="" class="current" class="topa">首页</a></li>
                <li>
                    <a href=""   class="topa">新闻资讯</a>
                    <ul>
                        <li><a href="">公司新闻</a>
                        <li><a href="">健康资讯</a>
                        <li><a href="">行业动态</a>
                    </ul>
                </li>
                <li>
                    <a href=""   class="topa">校园活动</a>
                </li>
                <li><a href=""  class="topa">联系我们</a></li>
                <li>
                    <a href=""  class="topa">关于我们</a>
                    <ul>
                        <li><a href="">五大创始人</a></li>
                        <li><a href="">品牌影响力</a></li>
                        <li><a href="">我们的优势</a></li>
                        <li><a href="">加入我们</a></li>
                        <li><a href="">联系我们</a></li>
                    </ul>
                </li>
                <li><a href="http://www.houdunwang.com" target="_blank" class="topa">实战培训</a></li>
                <li><a href="http://www.houdunren.com" target="_blank" class="topa">在线视频</a></li>
                <li><a href="http://bbs.houdunwang.com/portal.php" target="_blank" class="topa">论坛讨论</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="clear"></div>
<!-- 头部结束 -->

<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/news_list.css">
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/swiper.min.css">
<script src="<?php echo WEB_PATH;?>statics/houdunwang/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/news.js"></script>
<script type="text/javascript">
    function getmore (){
        var page = Number($('.more').attr('page'));
        var catid = 8;
        $.ajax({
            type: "get",
            url: 'index.php?m=content&c=index&a=getMore&catid='+catid+'&page='+page+'&pagesize=9',
            data: '',
            dataType: 'json',
            success: function(data) {
                if(data==0){
                    // $('.more').css('display','none');
                    $('.more').html("没有更多了");
                    $('.more').css({'href':'javascript:void(0);',"border":"solid 1px #999","color":"#999"});
                }else{
                    var html ='';
                    $.each(data,function(key,value){
                        if (value.thumb) {
                            var images = value.thumb;
                        }else{
                            var images = "<?php echo WEB_PATH;?>statics/houdunwang/images/about1.png";
                        }
                        html += '<div class="news"><div class="newsimg"><a href="'+value.url+'"><img src="'+ images +'" alt=""></a></div><a href="'+value.url+'" class="title">'+value.title+'</a><p class="newstime">'+value.inputtime+'</p><p class="laizi">来自<span>'+value.catname+'</span></p><a href="'+value.url+'" class="liaojie">了解详情</a><span class="xian"></span></div>';
                    });
                    page = page+1;
                    $(".list").append(html);
                    $('.more').attr('page',page);
                }
            }
        });
    }

    $(function(){
        var width = $(window).width();
        $(".sjslider .tjnews").css('height',width *9 / 16);
    })

</script>
<style type="text/css">
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
</style>
<!-- 轮播图开始 -->

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
<!-- 轮播图结束 -->
<div class="news_list">
    <div class="catgory">

        <!--<?php echo '<pre>' ?>-->
        <!--<?php echo print_r($CATEGORYS[$CATEGORYS[$catid]['parentid']]);?>-->
        <ul>
            <li><a href="<?php echo $CATEGORYS[$CATEGORYS[$catid]['parentid']]['url'];?>">全部 <?php echo $CATEGORYS[$CATEGORYS[$catid]['parentid']]['catname'];?></a></li>
            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=406659de1f9211367f62d9d6b130eb88&action=category&catid=%24CATEGORYS%5B%24catid%5D%5B%27parentid%27%5D\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>$CATEGORYS[$catid]['parentid'],'limit'=>'20',));}?>
            <?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
            <?php if($v['catid'] == $catid) { ?>
            <li>
                <a href="<?php echo $v['url'];?>" class="current"><?php echo $v['catname'];?></a>
            </li>
            <?php } else { ?>
            <li>
                <a href="<?php echo $v['url'];?>"><?php echo $v['catname'];?></a>
            </li>
            <?php } ?>
            <?php $n++;}unset($n); ?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            <!--<li>-->
                <!--<a href="">最新新闻</a>-->
            <!--</li>-->
            <!--<li>-->
                <!--<a href="">学习心得</a>-->
            <!--</li>-->
        </ul>
    </div>
    <div class="list">
        <span class="topxian"></span>
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d5af71f969d2b774c8167efe438cdb2b&action=lists&catid=%24catid\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$catid,'limit'=>'20',));}?>
        <?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
        <div class="news">
            <a href="<?php echo $v['url'];?>" class="newsimg"><img src="<?php echo $v['thumb'];?>" alt=""></a>
            <a href="<?php echo $v['url'];?>" class="title"><?php echo $v['title'];?></a>
            <p class="newstime"><?php echo date("Y-m-d H:i:s",$v['inputtime']);?></p>
            <p class="laizi">来自<span><?php echo $CATEGORYS[$catid]['catname'];?></span></p>
            <a href="<?php echo $v['url'];?>" class="liaojie">了解详情</a>
            <span class="xian"></span>
        </div>
        <?php $n++;}unset($n); ?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </div>
    <a href="javascript:getmore();" class="more" page="1">加载更多 +</a>
</div>
<div class="share">
    <div class="center">
        <div class="left" style="line-height: 40px;">
            <img src="<?php echo WEB_PATH;?>statics/houdunwang/images/houdunwang.png" alt="">
        </div>
        <!--<div class="right bdsharebuttonbox">-->
        <!--<span>分享至</span>-->
        <!--<a href="#" class="bds_sqq qq" data-cmd="sqq" title="分享到QQ"></a>-->
        <!--<a href="#" class="bds_weixin weixin" data-cmd="weixin" title="分享到微信"></a>-->
        <!--<a href="#" class="bds_qzone qzone" data-cmd="qzone" title="分享到QQ空间"></a>-->
        <!--<a href="#" class="bds_weixin friend" data-cmd="tieba" title="分享到百度贴吧"></a>-->
        <!--<a href="#" class="bds_tsina tsina" data-cmd="tsina" title="分享到新浪微博"></a>-->
        <!--<a href="#" class="bds_tqq tqq" data-cmd="tqq" title="分享到腾讯微博"></a>-->
        <!--</div>-->
    </div>
</div>

<!-- 底部区域 -->
<div class="foot">
    <div class="center">
        <div class="company">
            <p class="title">The Company</p>
            <ul>
                <li><a href="http://www.houdunwang.com/">实战培训</a></li>
                <li><a href="http://www.houdunren.com/">在线视频</a></li>
                <li><a href="http://bbs.houdunwang.com/portal.php">论坛讨论</a></li>
                <li><a href="#">关于我们</a></li>
            </ul>
        </div>
        <div class="lianxi">
            <p class="title">Contact</p>
            <ul>
                <li><a href="http://houdunren.com" target="_blank">houdunren.com</a></li>
                <li>400-682-3231</li>
            </ul>
        </div>
        <div class="address">
            <p class="title">Address</p>
            <ul>
                <li>北京市朝阳区马泉营</li>
                <li>顺白路12号</li>
                <li>比目鱼创业园A区</li>
            </ul>
        </div>
        <div class="follow">
            <p class="title">Follow Us</p>
            <a href="javascript:void(0);" class="tsina" title="马上就要放大招了，敬请期待~"></a>
            <a href="javascript:void(0);" class="gzweixin" title=""></a>
        </div>
        <div class="gzherweima">
            <img src="<?php echo WEB_PATH;?>statics/houdunwang/images/gongzhonghao.jpg" alt="">
            <p>扫一扫，关注后盾</p>
        </div>
    </div>
    <!--<div class="bottom">-->
    <!--<div class="copyright">-->
    <!--Copyright © 2016 Yimao Technology Development(Shanghai)Co,.Ltd.All rights reserved-->
    <!--</div>-->
    <!--</div>-->
</div>
<!-- 底部区域 -->
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
<a href="#" class="bds_sqq qq" data-cmd="sqq" title="分享到QQ"></a>
<a href="#" class="bds_weixin weixin" data-cmd="weixin" title="分享到微信"></a>
<a href="#" class="bds_qzone qzone" data-cmd="qzone" title="分享到QQ空间"></a>
<a href="#" class="bds_weixin friend" data-cmd="tieba" title="分享到百度贴吧"></a>
<a href="#" class="bds_tsina tsina" data-cmd="tsina" title="分享到新浪微博"></a>
<a href="#" class="bds_tqq tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
</div>
</div>
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

</body>
</html>