
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


//搜索框效果
$("#search .form > input").focus(function(){
	$("#search .form").addClass('f');
}).blur(function(){
	$("#search .form").removeClass('f');
})


//轮播图效果
var c = 0;
var timer = setInterval(flashrun,6000);

function flashrun(){
	c++;
	c = c==5?0:c;
//	让c号图片显示,兄弟图片隐藏
	$("#flashbox .flash a.pic").eq(c).fadeIn(300).siblings('.pic').fadeOut(300);
//	让c号li变样式,兄弟li恢复原样
	$("#flashbox .flash ul li").eq(c).addClass('cur').siblings('li').removeClass('cur');
}

//给轮播图区域加移入移出效果
$("#flashbox").hover(function(){
//	清理定时器
	clearInterval(timer);
},function(){
	timer = setInterval(flashrun,6000);
})


//给圆点加点击效果
$("#flashbox .flash ul li").click(function(){
	//	获得当前点击的li的序号
	c = $(this).index();
	//	让c号图片显示,兄弟图片隐藏
	$("#flashbox .flash a.pic").eq(c).fadeIn(300).siblings('.pic').fadeOut(300);
	//	让c号li变样式,兄弟li恢复原样
	$("#flashbox .flash ul li").eq(c).addClass('cur').siblings('li').removeClass('cur');
})

//左按钮的单击事件
$("#flashbox .flash .lbtn").click(function(){
	c--;
	c = c==-1?4:c;
	//	让c号图片显示,兄弟图片隐藏
	$("#flashbox .flash a.pic").eq(c).fadeIn(300).siblings('.pic').fadeOut(300);
	//	让c号li变样式,兄弟li恢复原样
	$("#flashbox .flash ul li").eq(c).addClass('cur').siblings('li').removeClass('cur');
})

$("#flashbox .flash .rbtn").click(function(){
	c++;
	c = c==5?0:c;
	//	让c号图片显示,兄弟图片隐藏
	$("#flashbox .flash a.pic").eq(c).fadeIn(300).siblings('.pic').fadeOut(300);
	//	让c号li变样式,兄弟li恢复原样
	$("#flashbox .flash ul li").eq(c).addClass('cur').siblings('li').removeClass('cur');
})
















