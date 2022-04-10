var swiper = new Swiper('.swiper-container', {
	direction: 'vertical',
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
	},

	on: {
		init: function() {
			swiperAnimateCache(this); //隐藏动画元素 
			swiperAnimate(this); //初始化完成开始动画
		},
		slideChangeTransitionEnd: function() {
			swiperAnimate(this); //每个slide切换结束时也运行当前slide动画
		}
	}
	
});


//音乐控制
var m = 2;

//这里不能用ontouchstart事件!
//$(document).one('touchend',function(){
//	$("#mpic").css({
//			'animation-play-state':'running',
//	})
//	$("#music")[0].play();
//	m=1;
//})

document.ontouchend = function(){
	$("#mpic").css({
			'animation-play-state':'running',
	})
	$("#music")[0].play();
	m=1;
//	解除事件
	document.ontouchend = null;
}


$('#mpic').on('touchstart',function(){
	if (m==1) {
		$("#mpic").css({
			'animation-play-state':'paused',
		})
//		暂停播放音乐
//		jquery或者zepto形式的对象后面加上[0]可以转成原生形式的对象
		$("#music")[0].pause();
		m=2;
	}else{
		$("#mpic").css({
			'animation-play-state':'running',
		})
		$("#music")[0].play();
		m=1;
	}
	
})



//音乐控制结束