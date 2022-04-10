let path = require('path');


//let result = path.isAbsolute('d:/abc/index');//true
//let result = path.isAbsolute('abc/index/views');//false
//识别为了linux下的绝对路径↓
let result = path.isAbsolute('/abc/index/views');//true
console.log(result);
