$(function(){
//全局a标签清空地址
$('a').attr('href','JavaScript:void(0)')
//录播图效果	
var c=0
//轮播函数
function flash(){
	c++;
	if(c==9){
		$('ul.lbt').css('left','0');
		c=1;
	}
	$('ul.lbt').animate({'left':c*-10+'rem'},300);
	if(c==8){
		$('#flash div.dot span').removeClass('point').eq(0).addClass('point')
	}else{
		$('#flash div.dot span').removeClass('point').eq(c).addClass('point')
	}
	
}
//定时器启动执行flash函数
var timer = setInterval(flash,1000);
//鼠标按下暂停轮播2秒
$('#flash .lbt li').mousedown(function(){
	clearInterval(timer)
	setTimeout(function(){
		clearInterval(timer)
		timer = setInterval(flash,1000)
	},2000)
})

//轮播图结束	

//热点轮播图
function hot(){
	$('#hot ul li').first().animate({'height':'0'},300,function(){
		$('#hot ul').append($('#hot ul li').first());
		$('#hot ul li').last().height('0.7333rem');
	})
}
var timer2 = setInterval(hot,4000);
//热点轮播图结束
//倒数器
var timer3 = setInterval(count,1000);
function count(){
	var now = new Date;
	var dl = new Date(2017,07,03)
	var dif = dl.getTime() - now.getTime();
	var hour = parseInt(dif/3600000);
	var minu = parseInt((dif%3600000)/60000);
	var sec = parseInt(((dif%3600000)%60000)/1000);
	hour=(hour<10)?'0'+hour:hour;
	minu=(minu<10)?'0'+minu:minu;
	sec=(sec<10)?'0'+sec:sec;
	$('#qianggou .one span').eq(0).html(hour);
	$('#qianggou .one span').eq(2).html(minu);
	$('#qianggou .one span').eq(4).html(sec);
}
//倒数器结束
















})
