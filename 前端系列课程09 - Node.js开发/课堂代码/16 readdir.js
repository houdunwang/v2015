let fs = require('fs');

//读取hd文件夹中的所有文件列表
//readdir方法之读取一层
fs.readdir('./hd',(err,files)=>{
	if (err) {
		console.log('有错误',err);
	}else{
//		console.log(files);
		files.forEach(x=>{
			console.log('hd文件夹里有：',x);
		})
	}
})
