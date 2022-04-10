let fs = require('fs');
let path = require('path');

//遍历输出文件夹中所有文件的函数
//参数d表示目录层级
let reread = (dirpath,d=0)=>{
	let h = '';
	for (let i=0;i<d;i++) {
		h += '----';
	}
	console.log(h+dirpath);
	let filelist = fs.readdirSync(dirpath);
//	console.log(filelist);
//	循环所有文件
	filelist.forEach(x=>{
//		组合路径
		let p = path.resolve(dirpath,x);
//		获得文件信息
		let pinfo = fs.statSync(p);
		let h = '';
		for (let i=0;i<d+1;i++) {
			h += '----';
		}
		!pinfo.isFile() || console.log(h+p);
		!pinfo.isDirectory() || reread(p,d+1);
	})
}

reread(path.resolve(__dirname,'hd'));

