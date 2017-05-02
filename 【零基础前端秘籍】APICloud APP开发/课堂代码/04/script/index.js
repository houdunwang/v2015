window.onload = function (){
	var circle = document.getElementById('circle');
	var span = document.getElementById('time').getElementsByTagName('span')[0];
	var remind = document.getElementById('remind');
	// 给圆加手指按下事件
	circle.ontouchstart = function(){
		// 记录下按下的时候的时间
		start_time = new Date();
	}
	// 给圆加手指抬起事件
	circle.ontouchend = function(){
		// 记录下抬起的时候的事件
		end_time = new Date();
		// 计算按下和抬起之间的时间差
		var diff_time = end_time.getTime() - start_time.getTime();
		span.innerHTML = diff_time/1000;
		if(diff_time<800){
			remind.innerHTML = '亲，别激动，慢慢来！';
		}else if(diff_time<1200){
			remind.innerHTML = '已经很接近了！';
		}else{
			remind.innerHTML = '亲，睡着了吧？！';
		}
	}
}