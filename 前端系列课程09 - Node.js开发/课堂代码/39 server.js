//引入http模块
let http = require('http');
let fs = require('fs');
let path = require('path');

//初始化server服务
let server = http.createServer();


//监听端口
server.listen(3000,()=>{
	console.log('-----serve服务启动成功，端口:3000-----');
})


//监听用户请求
server.on('request', (req,res)=>{
//	console.log(req.url);
//	console.log(path.join(__dirname,req.url))
	if (req.url=='/dog.jpg') {
//		读取dog.jpg
		fs.readFile('./dog.jpg',(err,data)=>{
			if (err) {
				console.log(err);
			}else{
//				如果没有错误,就返回读取到的图片数据
				res.end(data);
			}
		})
	}else{
		res.end('<h1>404页面没找到！o(╥﹏╥)o</h1>');
	}

})
