//引入http模块
let http = require('http');

//初始化server服务
let server = http.createServer();


//监听端口
server.listen(3000,()=>{
	console.log('-----serve服务启动成功，端口:3000-----');
})


//监听用户请求
server.on('request', (req,res)=>{
//	console.log('有人来啦！');
//	res.end('我是end返回的信息8888');

//	获得用户入口
//	console.log(req.url);
	if (req.url=='/') {
		res.end('<h1>首页</h1>');
	}else if (req.url=='/list') {
		res.end('<h1>列表页</h1>');
	}else if (req.url=='/page') {
		res.end(`
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="UTF-8">
				<title></title>
			</head>
			<body>
				
				<h1>我是内容页</h1>
				
			</body>
		</html>
		`);
	}else{
		res.end('<h1>404页面没找到！o(╥﹏╥)o</h1>');
	}

})
