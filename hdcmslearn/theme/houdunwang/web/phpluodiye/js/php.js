$(function(){
	var len = $('.select .selectCenter ul li').length;
	var w = 326*len;
	$('.select .selectCenter ul').css('width',w);
	var t,lock=false;
	$('.select .selectBox .LeftBtn').click(function(){
		if (lock) {
			return;
		}
		lock = !lock;
		clearInterval(timer);
		clearTimeout(t);
		t = setTimeout(function(){
			timer = setInterval(run,3000);
			lock = !lock;
		},600)
		$('.select .selectCenter ul li').first().animate({'margin-left':'0','width':'0'},500,function(){
			$('.select .selectCenter ul').append($('.select .selectCenter ul li').first().css({'margin-left':'106px','width':'220px'}));
		});
	})
	
	$('.select .selectBox .RightBtn').click(function(){
		if (lock) {
			return;
		}
		lock = !lock;
		clearInterval(timer);
		clearTimeout(t);
		t = setTimeout(function(){
			timer = setInterval(run,3000);
			lock = !lock;
		},600)
		$('.select .selectCenter ul').prepend($('.select .selectCenter ul li').last().css({'margin-left':'0','width':'0'}));
		$('.select .selectCenter ul li').first().animate({'margin-left':'106px','width':'220px'},500);
	})
	
	function run(){
		$('.select .selectCenter ul li').first().animate({'margin-left':'0','width':'0'},500,function(){
			$('.select .selectCenter ul').append($('.select .selectCenter ul li').first().css({'margin-left':'106px','width':'220px'}));
		});
	}
	var timer = setInterval(run,3000);
	
	
	
//	课程表tab切换
	$("#syllabus .title>li").mouseenter(function(){
		var c = $(this).index();
		$(this).addClass('cur').siblings().removeClass('cur');
		$(this).parent().siblings('.con').eq(c).css('display','flex').siblings('.con').hide();
	})
//	课程表tab切换结束

	$("img").not('.noclick').click(function(){
		open('http://tb.53kf.com/webCompany.php?arg=9003998&style=1');
	})


})
