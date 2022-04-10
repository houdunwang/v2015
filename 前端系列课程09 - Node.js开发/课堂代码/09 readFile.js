let fs = require('fs');


console.log('1');

//readFile是异步的
fs.readFile('./hd.txt',(err,data)=>{
	if (err) {
		console.log('报错啦',err);
	}else{
		console.log(data.toString());
	}
})

console.log('2');
