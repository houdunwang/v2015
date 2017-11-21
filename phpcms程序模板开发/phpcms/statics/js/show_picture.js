$(document).ready(function(){
	//获取锚点即当前图片id
	var picid = location.hash;
	picid = picid.substring(1);
	if(isNaN(picid) || picid=='' || picid==null) {
		picid = 1;
	}
	picid = parseInt(picid);

	//图集图片总数
	var totalnum = $("#pictureurls li").length;
	//如果当前图片id大于图片数，显示第一张图片
	if(picid > totalnum || picid < 1) {
		picid = 1;
		next_picid = 1;	//下一张图片id
	} else {
		next_picid = picid + 1;
	}

	url = $("#pictureurls li:nth-child("+picid+") img").attr("rel");
	$("#big-pic").html("<img src='"+url+"' onload='loadpic("+next_picid+")'>");
	$('#big-pic img').LoadImage(true, 890, 650,$("#load_pic").attr('rel'));
	$("#picnum").html("("+picid+"/"+totalnum+")");
	$("#picinfo").html($("#pictureurls li:nth-child("+picid+") img").attr("alt"));

	$("#pictureurls li").click(function(){
		i = $(this).index() + 1;
		showpic(i);
	});

	//加载时图片滚动到中间
	var _w = $('.cont li').width()*$('.cont li').length;
	if(picid>2) {
		movestep = picid - 3;
	} else {
		movestep = 0;
	}
	$(".cont ul").css({"left":-+$('.cont li').width()*movestep});

	//点击图片滚动
	$('.cont ul').width(_w);
	$(".cont li").click( function () {
	    if($(this).index()>2){
			movestep = $(this).index() - 2;
			$(".cont ul").css({"left":-+$('.cont li').width()*movestep});
		}
	});
	//当前缩略图添加样式
	$("#pictureurls li:nth-child("+picid+")").addClass("on");

});

$(document).keyup(function(e) {     
	var currKey=0,e=e||event;
	currKey=e.keyCode||e.which||e.charCode;
	switch(currKey) {     
		case 37: // left
			showpic('pre');
			break;
		case 39: // up
			showpic('next');
			break;
		case 13: // enter
			var nextpicurl = $('#nextPicsBut').attr('href');
			if(nextpicurl !== '' || nextpicurl !== 'null') {
				window.location=nextpicurl;
			}
			break;
	}   
});


function showpic(type, replay) {
	//隐藏重复播放div
	$("#endSelect").hide();

	//图集图片总数
	var totalnum = $("#pictureurls li").length;
	if(type=='next' || type=='pre') {
		//获取锚点即当前图片id
		var picid = location.hash;
		picid = picid.substring(1);
		if(isNaN(picid) || picid=='' || picid==null) {
			picid = 1;
		}
		picid = parseInt(picid);

		if(type=='next') {
			i = picid + 1;
			//如果是最后一张图片，指针指向第一张
			if(i > totalnum) {
				$("#endSelect").show();
				i=1;
				next_picid=1;
				//重新播放
				if(replay!=1) {
					return false;
				} else {
					$("#endSelect").hide();
				}
			} else {
				next_picid = parseInt(i) + 1;
			}

		} else if (type=='pre') {
			i = picid - 1;
			//如果是第一张图片，指针指向最后一张
			if(i < 1) {
				i=totalnum;
				next_picid = totalnum;
			} else {
				next_picid = parseInt(i) - 1;
			}
		}
		url = $("#pictureurls li:nth-child("+i+") img").attr("rel");
		$("#big-pic").html("<img src='"+url+"' onload='loadpic("+next_picid+")'>");
		$('#big-pic img').LoadImage(true, 890, 650,$("#load_pic").attr('rel'));
		$("#picnum").html("("+i+"/"+totalnum+")");
		$("#picinfo").html($("#pictureurls li:nth-child("+i+") img").attr("alt"));
		//更新锚点
		location.hash = i;
		type = i;

		//点击图片滚动
		var _w = $('.cont li').width()*$('.cont li').length;
		if(i>2) {
			movestep = i - 3;
		} else {
			movestep = 0;
		}
		$(".cont ul").css({"left":-+$('.cont li').width()*movestep});
	} else if(type=='big') {
		//获取锚点即当前图片id
		var picid = location.hash;
		picid = picid.substring(1);
		if(isNaN(picid) || picid=='' || picid==null) {
			picid = 1;
		}
		picid = parseInt(picid);

		url = $("#pictureurls li:nth-child("+picid+") img").attr("rel");
		window.open(url);
	} else {
		url = $("#pictureurls li:nth-child("+type+") img").attr("rel");
		$("#big-pic").html("<img src='"+url+"'>");
		$('#big-pic img').LoadImage(true, 890, 650,$("#load_pic").attr('rel'));
		$("#picnum").html("("+type+"/"+totalnum+")");
		$("#picinfo").html($("#pictureurls li:nth-child("+type+") img").attr("alt"));
		location.hash = type;
	}

	$("#pictureurls li").each(function(i){
		j = i+1;
		if(j==type) {
			$("#pictureurls li:nth-child("+j+")").addClass("on");
		} else {
			$("#pictureurls li:nth-child("+j+")").removeClass();
		}
	});
}
//预加载图片
function loadpic(id) {
	url = $("#pictureurls li:nth-child("+id+") img").attr("rel");
	$("#load_pic").html("<img src='"+url+"'>");
}