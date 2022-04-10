let fs = require('fs');
let path = require('path');

//遍历输出文件夹中所有文件的函数
let  reread = (dirpath)=>{
	let filelist = fs.readdirSync(dirpath);
//	console.log(filelist);
//	循环所有文件
	filelist.forEach(x=>{
//		组合路径
		let p = path.resolve(dirpath,x);
//		获得文件信息
		let pinfo = fs.statSync(p);
		console.log(p);
		!pinfo.isDirectory() || reread(p);
	})
}

reread(path.resolve(__dirname,'hd'));

