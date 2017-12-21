$(function(){
	SwapTab(".swap-tab","li",".swap-content","ul","on");//通用Tab切换
	startmarquee('announ',22,1,500,3000);//头部滚动广告
	slide("#yp-slide","cur",447,201,1);//首页焦点图
	//通用select菜单
	$(".mouseover").each(function(i){
		var type = $(this).attr('type'),height = parseInt($(this).attr('heights')),position=parseInt($(this).attr('position')),
			 navSub = $('.sub'+type+'_'+i);
		$(this).bind("mouseenter",function(){
			var offset =$(this).offset();
				if(navSub.css("display") == "none"){
					if(position==true){
						navSub.css({"position":"absolute","z-index":"100",left:offset.left,top:offset.top+height}).show();
					}else{
						navSub.show();
					}
				}
		}).bind("mouseleave",function(){
			navSub.hide();
		});
		navSub.bind({
			mouseenter:function(){
				navSub.show();
			},
			mouseleave:function(){
				navSub.hide();
			}
		})
	})
	//首页产品目录ie6支持
	if("\v"=="v") {
		if (!window.XMLHttpRequest) {
			var catitem = $(".cat-item");
			catitem.hover(function(){
				$(this).addClass("cat-item-hover");
			},function(){
				$(this).removeClass("cat-item-hover");
			})
		} 
	}
	/*筛选菜单展开收起*/
	$("#PropSingle dd.AttrBox").each(function(){
		var len = $(this).children().length;
		if(len >10){
			$(this).before("<dd class='more cu'>全部展开</dd>");
			var category = $(this).children('a:gt(9)'),moreBtn = $(this).siblings(".more");
			category.hide();
			moreBtn.click(function(){
				if(category.is(":visible")){
					category.hide();
					moreBtn.removeClass("on").text("全部展开");
				}else{
					category.show();
					moreBtn.addClass("on").text("精简显示");
				}
			})
		}
	})
	$(".input").blur(function(){$(this).removeClass('input-focus');});
	$(".input").focus(function(){$(this).addClass('input-focus')});
})