let path = require('path');

//会从最后参数开始,往前组合,直到能组合出来一个完整的绝对路径
//let result = path.resolve('d:/www','a','b/index.html');
//let result = path.resolve('d:/www','c:/a','b/index.html');
//let result = path.resolve('d:/www','c:/a','e:/b/index.html');
//如果直到第一个参数都组合不出来绝对路径,那么,会自动连接上当前脚本所在绝对路径,组合成一个完整的绝对路径
let result = path.resolve('www','a','b/index.html');

console.log(result);


