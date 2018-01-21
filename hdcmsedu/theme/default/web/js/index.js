require(['hdjs'], function () {
    $(function () {
        //////////////////////轮播图
        var c = 0;
        var circle = $("#flash a").length;
        //	循环创建小圆点
        for (var i = 0; i < circle; i++) {

            if (i == 0) {
                $("#flash ul").append('<li class="cur"></li>');
                continue;
            }
            $("#flash ul").append('<li></li>');
        }
        function flashrun() {
            c++;
            c = c % circle;
            $("#flash a").eq(c).fadeIn(300).siblings('a').fadeOut(300);
            $("#flash ul li").eq(c).addClass('cur').siblings().removeClass('cur');
        }
        var timer = setInterval(flashrun, 5000);
        //移入移出
        $("#flash ul li").hover(function () {
            clearInterval(timer);
            c = $(this).index();
            $("#flash a").eq(c).fadeIn(300).siblings('a').fadeOut(300);
            $("#flash ul li").eq(c).addClass('cur').siblings().removeClass('cur');
        }, function () {
            timer = setInterval(flashrun, 5000);
        })
        ////////////////车间左右轮播
        //获得轮播图片的数量
        var fc = 0;
        var flen = $("#factory .center ul li").length;
        var fmax = Math.ceil(flen / 4);
        function frun() {
            fc++;
            fc = fc == fmax ? 0 : fc;
            var left = -872 * fc;
            $("#factory .center ul").animate({left: left}, 300);
        }
        var timerf = setInterval(frun, 2000);
        //左按钮点击
        $("#factory .icon1").click(function () {
            clearInterval(timerf);
            fc++;
            fc = fc == fmax ? 0 : fc;
            var left = -872 * fc;
            $("#factory .center ul").animate({left: left}, 300);
            timerf = setInterval(frun, 5000);
        })

        //右按钮点击
        $("#factory .icon2").click(function () {
            clearInterval(timerf);
            fc--;
            fc = fc == -1 ? fmax - 1 : fc;
            var left = -872 * fc;
            $("#factory .center ul").animate({left: left}, 300);
            timerf = setInterval(frun, 5000);
        })
    })
})
