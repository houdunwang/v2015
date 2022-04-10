//引入http模块
let http = require('http');
let fs = require('fs');

//初始化server服务
let server = http.createServer();


//监听端口
server.listen(3000,()=>{
	console.log('-----serve服务启动成功，端口:3000-----');
})


//监听用户请求
server.on('request', (req,res)=>{
	
//	获得用户入口
	if (req.url=='/') {
		fs.readFile('./views/index.html',(err,data)=>{
			if (err) {
				console.log(err);
			}else{
				res.end(data);
			}
		})
	}else if (req.url=='/list') {
		fs.readFile('./views/list.html',(err,data)=>{
			if (err) {
				console.log(err);
			}else{
				res.end(data);
			}
		})
	}else if (req.url=='/page') {
		fs.readFile('./views/page.html',(err,data)=>{
			if (err) {
				console.log(err);
			}else{
				res.end(data);
			}
		})
	}else{
		fs.readFile('./views/404.html',(err,data)=>{
			if (err) {
				console.log(err);
			}else{
				res.end(data);
			}
		})
	}

})
