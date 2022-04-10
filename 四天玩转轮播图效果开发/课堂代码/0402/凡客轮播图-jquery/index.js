var c = 0;

setInterval(function(){
	c++;
	c = c==4?0:c;
//	让c号图片显示,兄弟图片隐藏
	$("#flash img").eq(c).fadeIn(300).siblings('img').fadeOut(300);
//	让c号li变红,其他li变灰
	$("#flash ul li").eq(c).css('background','#a10000')
	.siblings('li').css('background','#ddd');
	
	
},1000)
