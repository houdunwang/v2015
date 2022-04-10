var flash = document.getElementById("flash");
var is = flash.getElementsByTagName('img');
var ls = flash.getElementsByTagName('li');


var c = 0;

setInterval(function(){
	c++;
//	if (c==4) {
//		c=0;
//	}
	c = c==4?0:c;
	document.title = c;
	
//	让所有的图片都隐藏 所有的li都变成灰色
	for (var i=0;i<is.length;i++) {
		is[i].style.display = 'none';
		ls[i].style.background = '#DDDDDD';
	}
//	让c号图片显示
	is[c].style.display = 'block';
//	让c号li变红
	ls[c].style.background = '#A10000';
},1000)

