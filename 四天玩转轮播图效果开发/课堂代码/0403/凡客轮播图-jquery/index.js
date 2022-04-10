//小技巧:不同的途径控制相同元素的效果,都通过大总管变量c来实现.

var c = 0;//大总管变量

//设置定时器,控制自动轮播
var timer = setInterval(run,6000);

//定时器调用的函数
function run(){
	c++;
	c = c==4?0:c;
//	让c号图片显示,兄弟图片隐藏
	$("#flash img").eq(c).fadeIn(300).siblings('img').fadeOut(300);
//	让c号li变红,其他li变灰
	$("#flash ul li").eq(c).css('background','#a10000')
	.siblings('li').css('background','#ddd');
}



$("#flash").hover(function(){
//	清理定时器
	clearInterval(timer);
},function(){
	
	timer = setInterval(run,6000);
	
})


//鼠标移入小圆点的效果
$("#flash ul li").mouseenter(function(){
//	获得当前移入的li的序号
	c = $(this).index();
	//	让c号图片显示,兄弟图片隐藏
	$("#flash img").eq(c).fadeIn(300).siblings('img').fadeOut(300);
	//	让c号li变红,其他li变灰
	$("#flash ul li").eq(c).css('background','#a10000')
	.siblings('li').css('background','#ddd');
})

$("#flash .icon-xiangzuo").click(function(){
	c--;
	c = c==-1?3:c;
	//	让c号图片显示,兄弟图片隐藏
	$("#flash img").eq(c).fadeIn(300).siblings('img').fadeOut(300);
	//	让c号li变红,其他li变灰
	$("#flash ul li").eq(c).css('background','#a10000')
	.siblings('li').css('background','#ddd');
})

$("#flash .icon-you").click(function(){
	c++;
	c = c==4?0:c;
	//	让c号图片显示,兄弟图片隐藏
	$("#flash img").eq(c).fadeIn(300).siblings('img').fadeOut(300);
	//	让c号li变红,其他li变灰
	$("#flash ul li").eq(c).css('background','#a10000')
	.siblings('li').css('background','#ddd');
})



