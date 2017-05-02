//这是jQuery官方的插件开发规范，这样写是作用是：
//1. 避免全局依赖。
//2. 避免第三方破坏。
//3. 兼容jQuery操作符’$'和’jQuery’
(function ($) {
	//这里放入插件代码
	//起插件名称叫backTop
	$.fn.backTop = function(options){
		//设置默认值
		var defaultValue = {
			'bottom': 10, //距离底部为20
			'right' : 10, //距离右侧为20
			'speed' : 700 //返回顶部的时间
		};
		//用户如果传递则走用户的，否则走默认值
		var resultOptions = $.extend(defaultValue,options);
		//比如$('.backTop').backTop(); 那么当前对象$(this)就是$('.backTop')
		var _this = $(this);
		_this.css({
			'position':'absolute',
			'bottom': resultOptions.bottom,
			'right': resultOptions.right,
			'display':'none'
		})
		//滚动条滚动
		$(document).scroll(function(){
			var top = $(window).height() - _this.height() - resultOptions.bottom + $(this).scrollTop();
			_this.css({top : top });
			//判断什么时候出现
			if($(this).scrollTop()>=10){
				_this.fadeIn(500);
			}else{
				_this.fadeOut(500);
			}
		})
		//点击返回顶部
		_this.click(function(){
			$('html,body').animate({scrollTop:0},resultOptions.speed);			
		})
		
	}
})(jQuery);

//插件使用
//$('.backTop').backTop({right:20,bottom:20,speed:900});