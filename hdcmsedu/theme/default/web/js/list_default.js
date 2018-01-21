$(function(){
	
	//获得轮播图片的数量
var fc = 0;
var flen = $("#factory .center ul li").length;
var fmax = Math.ceil(flen/4);

function frun(){
	fc++;
	fc = fc==fmax?0:fc;
	var left = -654*fc;
	$("#factory .center ul").animate({left:left},300);
}
var timerf = setInterval(frun,2000); 

//左按钮点击
$("#factory .icon1").click(function(){
	clearInterval(timerf);
	fc++;
	fc = fc==fmax?0:fc;
	var left = -654*fc;
	$("#factory .center ul").animate({left:left},300);
	timerf = setInterval(frun,2000); 
})

//右按钮点击
$("#factory .icon2").click(function(){
	clearInterval(timerf);
	fc--;
	fc = fc == -1?fmax-1:fc;
	var left = -654*fc;
	$("#factory .center ul").animate({left:left},300);
	timerf = setInterval(frun,2000); 
})

	
})
