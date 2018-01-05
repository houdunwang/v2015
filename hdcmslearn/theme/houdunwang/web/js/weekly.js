var conf = {
	colwidth: 290,//列宽
	cols: 0,//列数
	rule: 0,//列间距
	lr: 25,//左右预留空白
	mb: 20,//上下间距
}

//计算列数
conf.cols = parseInt($("#contentarea .right").width()/conf.colwidth);
//计算列间距
conf.rule = parseInt(($("#contentarea .right").width()%conf.colwidth-conf.lr*2)/(conf.cols-1));

var n1=0,n2=0,n3=0;

$(".weekly li:nth-child(3n+1)").each(function(){
	$(this).css({top:n1,left:conf.lr,width:conf.colwidth});
	n1 += $(this).outerHeight()+conf.mb;
})

$(".weekly li:nth-child(3n+2)").each(function(){
	$(this).css({top:n2,left:conf.colwidth+conf.rule+conf.lr,width:conf.colwidth});
	n2 += $(this).outerHeight()+conf.mb;
})

$(".weekly li:nth-child(3n+3)").each(function(){
	$(this).css({top:n3,left:conf.colwidth*2+conf.rule*2+conf.lr,width:conf.colwidth});
	n3 += $(this).outerHeight()+conf.mb;
})


//计算总高度
var totalheight = 0;
for (var i=1;i<=conf.cols;i++) {
	var h=0;
	$(".weekly li:nth-child("+conf.cols+"n+"+i+")").each(function(){
		h += $(this).outerHeight()+10;
	})
	totalheight = h>totalheight?h:totalheight;
}
$(".weekly").height(totalheight+30);



//滚动条
$(window).scroll(function(){
	
	var t = $(document).scrollTop();
	var dheight = $(document).height();
	document.title = dheight;
	if (dheight-t<200) {
		
	}
})