<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=“X-UA-Compatible” content=“chrome=1″ />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="renderer" content="webkit" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>品牌与产品</title>
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/reset.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/common.css">
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/common.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>statics/houdunwang/js/scrollTop.js"></script>
</head>
<body>
<!-- 固定定位，返回顶部按钮 -->
<?php include template('content','header'); ?>
<div class="clear"></div>
<!-- 头部结束 -->
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/houdunwang/css/chanpin.css">

<!-- 产品开始 -->
<div class="main">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d5af71f969d2b774c8167efe438cdb2b&action=lists&catid=%24catid\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$catid,'limit'=>'20',));}?>
    <?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
    <div class="chanpin">
        <img src="<?php echo WEB_PATH;?>statics/houdunwang/images/chanpinTitle1.png" alt="" class="biaoti">
        <p class="xinghao"><?php echo $v['title'];?></p>
        <a href="<?php echo $v['url'];?>" class="more">查看详情</a>
        <img src="<?php echo $v['thumb'];?>" alt="" class="productpic">
    </div>
    <?php $n++;}unset($n); ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
</div>





<!-- 产品结束 -->
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
</script></body>
</html>