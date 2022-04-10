let fs = require('fs');
let path = require('path');


//redel 是用来删除非空文件夹的函数
let redel = (dirpath)=>{
//	清空文件夹
//	获得目录中所有子目录和文件
	let filelist = fs.readdirSync(dirpath);
//	遍历文件列表,判断是文件还是文件夹
	filelist.forEach(x=>{
//		组合路径
		let p = path.resolve(dirpath,x);
//		获得当前文件的信息
		let pinfo = fs.statSync(p);
		if (pinfo.isFile()) {
//			删除文件
			fs.unlinkSync(p);
		}else if (pinfo.isDirectory()) {
//			删除子文件夹
			redel(p);
		}
	})
//	删除文件夹
	fs.rmdirSync(dirpath);
}

redel(path.resolve(__dirname,'hd'));
//console.log(path.resolve(__dirname,'hd'))




//删除hd (){
//	删除a(){
//		删除b(){
//			删除b里的文件
//			删除空的b
//		}
//		删除文件
//		删除空的a
//	}
//	删除文件
//	删除空的hd
//}
