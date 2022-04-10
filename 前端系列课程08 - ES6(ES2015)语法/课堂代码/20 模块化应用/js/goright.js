let goright = (obj,step=1,speed=200)=>{
	
	setInterval(()=>{
//		获得当前位置
		let  old_left = obj.offsetLeft;
//		计算新位置
		let new_left = old_left+step;
//		将新位置赋值回去
		obj.style.left = new_left+'px';
	},speed)
	
}

export {goright};
