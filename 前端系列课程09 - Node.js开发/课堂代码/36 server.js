//引入http模块
let http = require('http');

//初始化server服务
let server = http.createServer();

//监听端口
server.listen(3000,()=>{
	console.log('-----serve服务启动成功，端口:3000-----');
})
