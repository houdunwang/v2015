$(function(){ 
				var hd = $('#hd');
//				给div加鼠标按下事件
				hd.mousedown(function(e){
//					获得鼠标当前的位置
					var mouse_old_left = e.pageX;
					var mouse_old_top = e.pageY;
//					获得div的位置
					var hd_old_left = hd.position().left;
					var hd_old_top = hd.position().top;
//					给document加鼠标移动事件
					$(document).mousemove(function(e){
//						获得鼠标最新的 位置
						var mouse_new_left = e.pageX;
						var mouse_new_top = e.pageY;
//						计算鼠标移动的距离
						var diff_left = mouse_new_left - mouse_old_left;
						var diff_top = mouse_new_top - mouse_old_top;
//						计算div的新位置
						var hd_new_left = hd_old_left+diff_left;
						var hd_new_top = hd_old_top+diff_top;
//						将新位置赋值回去

						hd.css({'left':hd_new_left+'px','top':hd_new_top+'px'});
					})
					
				})
				 
//				鼠标抬起事件
				hd.mouseup(function(){
//					解除掉document身上的事件
					$(document).off('mousemove');
				}) 
   
 
				hd.mousedown(function() {
					$(this).css('background', 'yellow');
				
				}); 
				hd.mouseup(function() {
					$(this).css('background', 'purple');
				}); 
			})   