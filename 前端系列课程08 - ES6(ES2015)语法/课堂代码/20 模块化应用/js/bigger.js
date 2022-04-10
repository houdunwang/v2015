let bigger = (obj,step=2,speed=200)=>{
	
	setInterval(()=>{
//		获得当前宽度
		let old_width = obj.offsetWidth;
//		计算新的宽度
		let new_width = old_width+step;
//		将新宽度赋值回去
		obj.style.width = new_width+'px';
	},speed)
	
}


export {bigger};
