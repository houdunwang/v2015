<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 24/10/2017
 * Time: 15:35
 * Email: 410004417@qq.com
 */

namespace houdunwang\model;


class Model {
	public function __call( $name, $arguments ) {
		return call_user_func_array([new Base(),$name],$arguments);
	}

	public static function __callStatic( $name, $arguments ) {
		$table = strtolower(ltrim(strrchr(get_called_class(),'\\'),'\\'));
		return call_user_func_array([new Base($table),$name],$arguments);
	}
}