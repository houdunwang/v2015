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
<?php include template('content','header'); ?>
<div class="clear"></div>
<!-- 头部结束 -->
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
            <a href="" class="gengduo">更多 ></a>
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


<script language="JavaScript" src=""></script>
<?php include template('content','footer'); ?>
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