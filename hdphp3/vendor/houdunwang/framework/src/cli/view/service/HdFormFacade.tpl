<?php namespace system\service\{{NAME}};

/** .-------------------------------------------------------------------
* |  Software: [HDPHP framework]
* |      Site: www.hdphp.com
* |-------------------------------------------------------------------
* |    Author: 向军 <2300071698@qq.com>
* |    WeChat: aihoudun
* | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
* '-------------------------------------------------------------------*/

use hdphp\kernel\ServiceFacade;

//外观构造类
class {{NAME}}Facade extends ServiceFacade{

	public static function getFacadeAccessor(){
		return '{{NAME}}';
	}
}