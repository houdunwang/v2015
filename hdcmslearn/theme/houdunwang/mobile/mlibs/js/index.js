$(function() {
	
//	导航条展开
	var menu2_sta = 1;
	$("#zhankai").click(function(){
		if (menu2_sta==1) {
		
			$("#menu2").animate({'height':50},300);
			menu2_sta = 2;
		}else{
			$("#menu2").animate({'height':0},300);
			menu2_sta = 1;
		}
	})
	
	
	$("#xinzi li:even").addClass('cur');
	//	薪资轮播

	setInterval(function() {

		$("#xinzi li").eq(1).animate({

			'height': 0

		}, 600, function() {

			$("#xinzi").append($("#xinzi li").eq(1).height(40));

		});

	}, 1500)

})