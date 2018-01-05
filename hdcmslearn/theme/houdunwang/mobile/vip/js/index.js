$(function(){
	$('#main .box').each(function(i){
		$(this).hover(function(){
			var box = $(this);
			var boxW = box[0].offsetWidth;
			var boxH = box[0].offsetHeight;
			var projectName = $(this).find('.projectName').attr('projectName');
			var keepNodeStr = '<div id="keep">\
				 					<div class="keep_box">\
				 						<div class="keep_color"></div>\
										<a class="keep_link"  href="javascript:void(0);">\
											<span class="keep_ico">\
								 				<img src="/theme/houdunwang/web/vip/images/hover.png" />\
								 				<span>试听课程</span>\
											</span>\
										</a>\
				 					</div>\
								</div>';
			box.append(keepNodeStr);
			$('#keep').css({width:boxW,height:boxH});
			var keepIcoObj = $('#keep .keep_ico');
			var iLeft = Math.floor((boxW-parseInt(keepIcoObj.css('width')))/2);
			var iTop = Math.floor((boxH-parseInt(keepIcoObj.css('height')))/2);
			keepIcoObj.css({position:'absolute',left:iLeft,top:iTop});
			$('#keep .keep_color').animate({
				opacity:0.7
			},300,'',function(){
				$('#keep .keep_link').css({display:'block'});
				$('#keep .keep_link').die().live('click',function(){
					showZoom(i);
				})
				
			});
			},function(){
				$('#keep').remove();
			})
			//显示内容弹出框
			
	})
	
	$('.show').each(function(i){
		$(this).die().click(function(){
			showZoom(i);
		})
	})
	/***设置list浮动样式***/
	$('.list').each(function(i){
		if(i%2){
			$(this).css({float:'right'})
		}else{
			$(this).css({float:'left'})
		}
	})
	/*****
	 * 显示内容弹出框
	 * @param {Object} index
	 */
	var scrollTop = 0;
	var left = Math.floor((document.documentElement.clientWidth-$('.zoom')[0].offsetWidth)/2);	//存储关闭按钮left值		
	var colosLeft = left+$('.zoom')[0].offsetWidth+15;
	$('.zoom').css({display:'none'});
	/*************广告动画**************/
	var iH = $('#top_ad')[0].offsetHeight;
	$('#top_ad').css({height:0})
	$('#top_ad').stop().animate({
		height:iH
	},2000);
	/**
	 * 显示对应详细列表块
	 * @param {Object} index
	 */
	function showZoom(index){
		scrollTop = $(document).scrollTop();
		/****布局转换,转换为固定定位*****/
		var mLeft = $('#main')[0].offsetLeft;
		var mTop = $('#main')[0].offsetTop;
		if(mTop < (iH + $('#header')[0].offsetHeight)){		//在广告还没有伸展完成时点击不执行函数
			return ;
		}
		$('#main').css({left:mLeft,top:mTop,position:'fixed'});
		var adLeft = $('#top_ad')[0].offsetLeft;
		var adTop = $('#top_ad')[0].offsetTop;
		$('#main').css({left:mLeft,top:mTop,position:'fixed'});
		$('#top_ad').css({left:adLeft,top:adTop,position:'fixed'});
		appendKeep();
		$('.zoom').eq(index).css({left:left,display:'block'});
		$('#colse').css({left:colosLeft})
		$('#colse').attr('index',index);
		$('body').css({height:$('.zoom')[0].offsetHeight+100})
		window.scrollTo(0,0);
	}
	/****删除内容弹出框***/
	$('#colse').click(function(){
		$('#main').css({position:'absolute'});
		$('#top_ad').css({position:'absolute'});
		var index = $(this).attr('index');
		//视频播发状态下，关闭以后停止播发
		
		var tempHtml = [];
		var video = $('.zoom').eq(index).find('.video');
		video.each(function(){
			tempHtml.push($(this).html());
			$(this).html('');
		});
		video.each(function(m){
			$(this).html(tempHtml[m]);
		});
		
		$('.zoom').css({display:'none'});
		$('#shelter').remove();
		$('body').css({height:'auto'})
		window.scrollTo(0,scrollTop);
		$(this).css({left:-10000})
	})
	/****
	 * 创建遮罩
	 */
	function appendKeep(){
        var iW = document.documentElement.clientWidth;
		var iH = document.documentElement.chientHeight || 10000;
		$('body').append('<div id="shelter" style=" width:'+iW+'px;height:'+iH+'px;"></div>');
	}
	/***设置每一块的高度***/
	var compare = [];
	$('.list').each(function(){
		compare.push($(this)[0].offsetHeight);
	})
	var tempArr = [];
	for(var i=0;i<compare.length;i+=2){
		for(var n=i;n<i+2;n++){
			tempArr.push(compare[n]);
		}
		var maxH = Math.max.apply({},tempArr);
		$('.list').eq(i).css({height:maxH});
		$('.list').eq(i+1).css({height:maxH});
		tempArr = [];
	}
	
	/******导航滑动效果*******/
	var aNavLi = document.getElementById('navigation').getElementsByTagName('li');
	function navTime(){
		var iNow=0;
		var timer = setInterval(function(){
			for (var n = 0; n < aNavLi.length; n++) {
				aNavLi[n].style.backgroundColor = '';
			}
			aNavLi[iNow].style.backgroundColor = '#FFF';
			iNow++;
			if (iNow >= aNavLi.length) {
				clearInterval(timer);
				aNavLi[iNow - 1].style.backgroundColor = '';
			}
		}, 60)
	}
	var timer1 = setInterval(function(){
		navTime();
	},10000)
	document.getElementById('navigation').onmouseover=function(){
		clearInterval(timer1);
	}
})


