import {hd} from './b.js';

//export语句输出的接口,与其对应的值是动态绑定关系
//通过该接口可以取到模块内部的实时数据

console.log(hd);

setTimeout(()=>{
	console.log(hd);
},4000)
