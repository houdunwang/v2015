<?php
require_once 'config.php';
require_once 'saetv2.ex.class.php';

$isLogin = $_COOKIE['access_token'];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/swiper.min.css">
    <script src="./js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./js/index.js"></script>
    <link rel="stylesheet" href="./css/index.css">

</head>
<body>
<div class="container">
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">后盾人 人人做后盾</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if (!isset($isLogin)) { ?>
                    <li><a href="javascript:;" data-toggle="modal" data-target="#exampleModal">login</a></li>
                <?php } else { ?>
                    <li><a href="javascript:;">admin</a></li>
                    <li><a href="./loginout.php">loginout</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <!--登录框-->
    <div>
        <?php if (isset($isLogin)){
        $client = new SaeTClientV2(WB_APP,WB_SECRET,$isLogin);
        $info = $client->public_timeline();
        echo '<pre>';
        print_r($info);
         } ?>


    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">user login</h4>
                </div>
                <div class="modal-body" style="overflow: hidden;">
                    <form>
                        <div class="form-group">
                            <label class="control-label">username:</label>
                            <input type="text" class="form-control" placeholder="username...">
                        </div>
                        <div class="form-group">
                            <label class="control-label">password:</label>
                            <input type="text" class="form-control" placeholder="password...">
                        </div>
                    </form>
                    <div class="other" style="width: 80px;margin: 0 auto;">
                        <div class="weibo" style="text-align: center;float:left;margin-right:20px">
                            <a href="./wblogin.php" style="display: block;margin-bottom:10px"><img
                                        src="./images/weibo.png" style="width: 40px;"></a>
                            <span>微博登录</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">login</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
    <!--登录框-->
    <!--轮播图-->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="./images/1.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="./images/2.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="./images/3.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="./images/4.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="./images/5.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="./images/6.jpg" alt="">
            </div>
        </div>
        <!-- Add Pagination -->
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <!--关于我们-->
    <div class="about">
        <h3>关于后盾网</h3>
        <p>
            后盾网隶属于北京后盾计算机技术培训有限责任公司，是专注于培养中国互联网顶尖PHP程序语言专业人才的专业型培训机构，拥有七年培训行业经验。后盾网拥有国内最顶尖的讲师和技术团队，团队成员项目经验均在8年以上，团队曾多次为国内外上市集团、政府机关的大型项目提供技术支持，其中包括新浪、搜狐、腾讯、宝洁公司、联想、丰田、工商银行、中国一汽等众多大众所熟知的知名企业。</p>
        <p>
            后盾网自2010年创立至今，免费发布了数千课高质量视频教程，为同行业之最，视频在优酷、土豆、酷六等视频网站播放量高达数千万，百度网盘下载量数百万次，无数技术爱好者受益其中。除了免费视频外，后盾网还为大家提供了面授班、远程班、公益公开课、VIP系列课程等众多形式的学习途径。后盾网有一群认真执着的老师，他们一心为同学着想，将真正的知识传授给大家是后盾网永远不变追求。</p>
        <p>
            后盾网专注于PHP培训，坚持实战式教学，将学员定位于企业员工，学习即是实习，学习即是工作，为学员提供最优质的学习体验。目前后盾网学员遍布世界各地，受到了各用人单位的一致好评。后盾网独一无二的高效率学习模式培养出了众多的PHP顶尖人才，98.9%的高薪就业率更是全年领先其他培训机构。零基础、跨行业、低学历在后盾网教学模式面前都不在是问题，一个又一个的高薪就业案例胜于一切言表。</p>
    </div>
    <!--关于我们-->
</div>

<!-- Swiper JS -->
<script src="./js/swiper.min.js"></script>
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
<!--轮播图-->
</body>
</html>