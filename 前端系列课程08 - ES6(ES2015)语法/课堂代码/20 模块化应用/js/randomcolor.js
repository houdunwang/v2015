let randomcolor = (obj,speed=1000)=>{
	
	setInterval(()=>{
		let r = Math.floor(Math.random()*256);
		let g = Math.floor(Math.random()*256);
		let b = Math.floor(Math.random()*256);
		obj.style.background = 'rgb('+r+','+g+','+b+')';
	},speed)
	
}


export {randomcolor};

