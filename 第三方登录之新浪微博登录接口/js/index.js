$(function () {
    $('.weibo').hover(function () {
        $(this).find('img').attr('src','./images/weibo2.png');
    },function () {
        $(this).find('img').attr('src','./images/weibo.png');
    })
    $('.weixin').hover(function () {
        $(this).find('img').attr('src','./images/weixin2.png');
    },function () {
        $(this).find('img').attr('src','./images/weixin.png');
    })
    $('.qq').hover(function () {
        $(this).find('img').attr('src','./images/qq2.png');
    },function () {
        $(this).find('img').attr('src','./images/qq.png');
    })
})