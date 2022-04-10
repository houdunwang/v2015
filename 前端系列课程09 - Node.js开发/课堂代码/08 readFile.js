let fs = require('fs');

//错误优先机制
fs.readFile('./hd.txt',(err,data)=>{
	if (err) {
		console.log('报错啦',err);
	}else{
//		获得的是文件内容的buffer(二进制)数据
//		toString()可以将二进制数据转成字符串
		console.log(data.toString());
	}
})

