var bgblack = document.getElementById("bgblack");
var bgred = document.getElementById("bgred");

//给整个页面加滚动条事件
window.onscroll = function(){
//	获得滚动上去的距离
	var t = document.documentElement.scrollTop
	document.title = t;
	
	if (t<=100) {
		var o = 1-t/100;
		bgblack.style.opacity = o;
		bgred.style.opacity = 0;
	}else if(t>100&&t<=400){
		var o = (t-100)/300;
		bgred.style.opacity = o;
		bgblack.style.opacity = 0;
	}
}






