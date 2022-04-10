let fs = require('fs');


//创建目录
//fs.mkdir('houdun',(err)=>{
//	console.log('文件夹创建成功');
//});

//不能创建已存在的文件夹
//fs.mkdirSync('hd');


//删除目录
//fs.rmdir('./hd',err=>{
//	if (err) {
//		console.log(err);
//	}else{
//		console.log('删除成功！');
//	}
//});


fs.rmdirSync('./hd');

