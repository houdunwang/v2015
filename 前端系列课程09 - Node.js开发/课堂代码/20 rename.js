let fs = require('fs');

//重命名
//fs.rename('./hd.txt','./houdun.txt',err=>{
//	console.log('重命名成功！');
//});

//移动文件
//fs.rename('./hd.txt','./a/houdun.txt',err=>{
//	if (err) {
//		console.log('有错误！',err);
//	}else{
//		console.log('重命名成功！');
//	}
//});

//fs.renameSync('./hd.txt','./a/houdunren.txt');


//重命名文件夹,文件不为空也可以
fs.rename('./abc','./aaaaaaa',err=>{
	if (err) {
		console.log('有错误！',err);
	}else{
		console.log('重命名成功！');
	}
})



