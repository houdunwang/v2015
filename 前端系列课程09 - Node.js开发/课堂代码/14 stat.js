let fs = require('fs');

fs.stat('./hd.txt',(err,info)=>{
		
//		获得当前文件是不是一个文件
		console.log(info.isFile());
		console.log(info.isDirectory());
})


//fs.stat('./houdun',(err,info)=>{
//		
////		获得当前文件是不是一个文件
//		console.log(info.isFile());
////		获得当前是不是一个目录(文件夹)
//		console.log(info.isDirectory());
//	
//})