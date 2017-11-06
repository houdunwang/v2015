<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 19/10/2017
 * Time: 17:45
 * Email: 410004417@qq.com
 */
namespace houdunwang\view;
class View {
	public static function __callStatic( $name, $arguments ) {
		// TODO: Implement __callStatic() method.
		return call_user_func_array([new Base(),$name],$arguments);
	}


	public function __call( $name, $arguments ) {
		// TODO: Implement __call() method.
		return call_user_func_array([new Base(),$name],$arguments);

	}
}