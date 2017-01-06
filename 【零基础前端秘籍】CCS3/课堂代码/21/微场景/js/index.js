//大总管变量
var c = 0;
//获得屏幕高度
var win_height = $(window).height();


$("body").swipeUp(function(){
	c++;
//	计算应该到达的top值
	var t = c * -win_height;

//	将应该到达的top值赋值过去
	$("#container").css('margin-top',t);
	
})
4

$("body").swipeDown(function(){
	c--;
//	计算应该到达的top值
	var t = c * -win_height;

//	将应该到达的top值赋值过去
	$("#container").css('margin-top',t);
})