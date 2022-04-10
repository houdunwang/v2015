let fs = require('fs');

//rmdir只能删除空文件夹
fs.rmdir('./hd',err=>{
	if (err) {
		console.log(err);
	}else{
		console.log('删除成功');
	}
})
