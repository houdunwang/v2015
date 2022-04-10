
$("#search .menu .hide")
.width($('body').width())
.css('left',-$("#search .menu").offset().left);


//给menu区域加移入事件
$("#search .menu").hover(function(){
	$(this).find('.hide').stop().animate({height:229},300).addClass('h');
},function(){
	$(this).find('.hide').stop().animate({height:0},300,function(){
		$(this).removeClass('h');
	});
})


//切换效果
$("#search .menu .top a").mouseenter(function(){
//	获得当前移入的元素的序号
	var c = $(this).index();
//	让对应序号的li显示,兄弟li隐藏
	$("#search .menu .hide ul li").eq(c).show().siblings('li').hide();
})

















