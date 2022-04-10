let fs = require('fs');


//let info = fs.statSync('./hd.txt');
let info = fs.statSync('./houdun');
if (info.isFile()) {
	console.log('是一个文件');
}else if(info.isDirectory()){
	console.log('是一个文件夹');
}


