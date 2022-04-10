let fs = require('fs');

console.log('1');

//readFileSync是同步版本,会产生阻塞效果
let data = fs.readFileSync('./hd.txt');
console.log(data.toString());


console.log('2');
