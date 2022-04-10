function addwidth(obj,diff,speed){
	
	setInterval(function(){
		//	获得旧的宽度
			var old_width = obj.offsetWidth;
		//	计算新的宽度
			var new_width = old_width+diff;
		//	将新款度赋值给元素
			obj.style.width = new_width+'px';
	},speed)
	
}


export {addwidth};
