let fs = require('fs');

//写入的时候,如果没有这个文件,会自动创建这个文件
//fs.writeFile('./abc.txt','666',(err)=>{
//	console.log('文件写入成功');
//})


//写入数据的类型必须是字符串或者buffer二进制数据
//let obj = {
//	x:1,
//	y:2
//}
//fs.writeFile('./abc.txt',JSON.stringify(obj),(err)=>{
//	console.log('文件写入成功');
//})



//回调函数中没有第二个参数
//fs.writeFile('./abc.txt','666','utf-8',(err,d)=>{
//	console.log('文件写入成功');
//	console.log(d);
//})


//同步版本
fs.writeFileSync('./abc.txt','123');

