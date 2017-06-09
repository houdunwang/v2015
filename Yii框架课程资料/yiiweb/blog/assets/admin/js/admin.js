	
	$(function(){
		//导航栏点击获得当前位置内容
		$('#top_box a').click(function(){
			var tmp = $(this).find('span').html();
			$(".now_time span").html(tmp);
		})
		//左侧点击获得当前位置内容
		$('#left_box a').click(function(){
			var tmp = $(this).html();
			$(".now_time span").html(tmp);
		})
		

		// 左侧栏收缩展开效果
			$(".menu_box h2").click(function(){
				$(".text").slideUp('slow');
				$(this).next(".text").slideToggle("slow");
				

			})

		//导航栏翻转效果
			$("#top_box #top ul#menu2 li a").wrapInner( '<span class="out"></span>' );
				
			$("#top_box #top ul#menu2 li a").each(function() {
				$( '<span class="over">' +  $(this).text() + '</span>' ).appendTo( this );
			});

			$("#top_box #top ul#menu2 li a").hover(function() {
				$(".out",	this).stop().animate({'top':	'40px'},	100); // move down - hide
				$(".over",	this).stop().animate({'top':	'0px'},		100); // move down - show
			}, function() {
				$(".out",	this).stop().animate({'top':	'0px'},		300); // move up - show
				$(".over",	this).stop().animate({'top':	'-40px'},	300); // move up - hide
			});
		//左侧二级菜单效果
			$(".con").prepend('<div class="nav_ub"></div><div class="nav_db"></div>')
			$(".con").hover(function(){
				$(this).children(".nav_ub").stop().animate({top:-26},300);
				$(this).find(".pos").stop().animate({left:20},250);
				$(this).children(".nav_db").stop().animate({bottom:-14},300);
				$(this).find(".pos").stop().animate({left:20},250);
			},function(){
				$(this).children(".nav_ub").stop().animate({top:0},300);
				$(this).find(".pos").stop().animate({left:0},250);
				$(this).children(".nav_db").stop().animate({bottom:0},300);
				$(this).find(".pos").stop().animate({left:0},250);
			});
			//调用调整函数
			resize_win();
			//自适应窗口拖拽
			$(window).resize(function(){
				resize_win();
			})


	});
			//自动调整left区域和right区域宽高				
			function resize_win(){
				var top_box_H = $('#top_box').height();
				var top_bar_H = $('.top_bar').height();
				var foot_box_H = $('#foot_box').height();
				var DH = $(window).height();
				//左右高度
				$('#left_box').css({'height' : DH - (top_box_H + top_bar_H + foot_box_H) - 10});
				$('#right').css({'height' : DH - (top_box_H + top_bar_H + foot_box_H) - 10});
				//右边宽度
				var left_box_W = $('#left_box').width();
				var DW = $(window).width();
				$('#right').css({'width' : DW - left_box_W - 40});
			}
			
			
			

