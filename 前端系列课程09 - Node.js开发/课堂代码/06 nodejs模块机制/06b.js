//nodejs中默认会导出一个叫做module.exports对象
//就算是什么都不写,也默认导出这个对象

let foo = x=>{
	return x*x;
}
module.exports.hd = '后盾人';
module.exports.foo = foo;

//exports是对module.exports的引用,相当于是module.exports的简写
//exports.hd = '后盾人';
//exports.foo = foo;

