<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=“X-UA-Compatible” content=“chrome=1″/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="renderer" content="webkit"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <title><?php echo $title;?></title>
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
<div class="sjheader">
    <div class="left">
        <a href="http://www.yimaokeji.com/"><img src="http://www.yimaokeji.com/statics/ymkj/images/mobile/logo.png"
                                                 alt=""></a>
    </div>
    <div class="center">行业动态</div>
    <!-- <div class="right">
        <img src="http://www.yimaokeji.com/statics/ymkj/images/mobile/menu.png" alt="">
    </div> -->
    <!-- 手机菜单 -->
    <div class="menu">
        <a href="#menu" class="glyphicon glyphicon-th-list">
        </a>
    </div>
    <!-- 手机菜单 -->
</div>


<!-- 手机头部结束 -->
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/news_list.css">
<script type="text/javascript">
    $(function () {

    })

</script>

<div class="main">
    <div class="left">
        <div class="top">
            <p class="title"><?php echo $title;?></p>
            <p class="newstime">发布日期：<?php echo $inputtime;?></p>
            <div class="laiyuan">来自<span><?php echo $CATEGORYS[$catid]['catname'];?></span></div>
        </div>
        <div class="clear"></div>
        <div class="content" style="overflow:hidden;">
            <?php echo $content;?>
        </div>
    </div>
    <div class="right">
        <div class="top">
            <p class="newzx">相关新闻</p>
            <a href="http://www.yimaokeji.com/list-10-1.html" class="gengduo">更多 ></a>
        </div>
        <div class="tj_list">
            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=74e06b368a05e7f91557d1a8a1f4623b&action=lists&catid=%24CATEGORYS%5B%24CATEGORYS%5B%24catid%5D%5B%27parentid%27%5D%5D%5B%27catid%27%5D\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$CATEGORYS[$CATEGORYS[$catid]['parentid']]['catid'],'limit'=>'20',));}?>
            <?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
            <div class="news">
                <a href="<?php echo $v['url'];?>"><img src="<?php echo $v['thumb'];?>" alt=""></a>
                <p class="title"><a href="<?php echo $v['url'];?>"><?php echo $v['title'];?></a>
                </p>
                <div class="newstime"><?php echo date("Y-m-d",$v['inputtime']);?></div>
                <div class="laiyuan">来自<span><?php echo $CATEGORYS[$v['catid']]['catname'];?></span></div>
            </div>
            <?php $n++;}unset($n); ?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
</div>


<script language="JavaScript" src="http://www.yimaokeji.com/api.php?op=count&id=151&modelid=1"></script>
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
</div>
<!-- 底部区域 -->
<!-- 手机版本menu -->
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
    with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".gzweixin").hover(function () {
            var height = document.documentElement.clientHeight;
            $(".gzherweima").css('bottom', (height - 200) / 2);
            $(".gzherweima").css('display', 'block');
        }, function () {
            $(".gzherweima").css('display', 'none');
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
    with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
</script>
</body>
</html>