//引入http模块
let http = require('http');

//初始化server服务
let server = http.createServer();


//监听端口
server.listen(3000,()=>{
	console.log('-----serve服务启动成功，端口:3000-----');
})


//监听用户请求
//req:客户端请求的相关信息和方法
//res:服务端响应的一些方法
server.on('request', (req,res)=>{
	console.log('有人来啦！');
//	简单输出信息,可以使用多次
//	res.write('欢迎光临！');
//	res.write('后盾人 人人做后盾！');
//	end方法表示结束响应,可以将信息反馈给用户了.
	res.end('我是end返回的信息8888');
})
