# 购物车
##简介
为了便于商城系统的开发提供了完善的购物车处理类，使商城购物车处理更加方便快捷，程序员只需要专注业务流程而不用关注实现步骤，大大增加了开发效率。
[TOC]
##安装
使用 composer 命令进行安装或下载源代码使用。
```
composer require houdunwang/cart
```

##操作
####添加购物车
系统会根据商品数据生成唯一的SID编号，如果购物车中已经存在这个商品时将修改商品数量。如果添加时的商品数量为0时将从购物车中删除商品。
```
$data = [ 
	'id' 		=> 1, // 商品 ID 
	'name'		=>' 后盾网 PHP 视频教程光盘 ',// 商品名称 
	'num' 		=> 2, // 商品数量 
	'price' 	=> 988, // 商品价格 
	'options'   => [],// 其他参数如价格、颜色、可以为数组或字符串 
	'color' 	=> 'red', 
	'size' 	    => 'L' 
]; 
Cart::add($data);
```

####更新购物车
更新购物车需要传入商品的唯一 SID，同时传入更新的商品数量，
```
$data=array( 
	'sid'=>'商品唯一编号',// 唯一 sid，添加购物车时自动生成 
	'num'=>88 
); 
Cart::update($data); 
```

####购物车中商品数据
```
Cart::getGoods(); 
```

####购物车所有商品数据
```
Cart::getAllData(); 
```

####清空购物车

```
Cart::flush(); 
```

####获得商品总价格
```
echo Cart::getTotalPrice();
```

####统计购物车中的商品数量
```
Cart::getTotalNums(); 
```

####获得定单号\houdunwang\cart\Cart::getOrderId()
```
Cart::getOrderId();
```