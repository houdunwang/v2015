$(function () {
	$('.nav-lv1-li').hover(function () {
		$(this).find('.top-cate').addClass('cur').next().fadeIn(200);
	}, function () {
		$(this).find('.top-cate').removeClass('cur').next().fadeOut(200);
	});
});