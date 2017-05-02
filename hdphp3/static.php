<?php

class News {
	public function save() {
		echo 'save';
	}

	public static function __callStatic( $name, $arguments ) {
		//houdunren.com
		//		echo $name;
		//		print_r($arguments);
		static $cache = NULL;
		if ( is_null( $cache ) ) {
			$cache = new Db;
		}
		return call_user_func_array([$cache,$name],$arguments);
	}
}

class Db {
	public function find( $id ) {
		echo 'id:' . $id;
	}
}

//
//$obj = new Db;
//$d = $obj->find(2);
//print_r($d);

//$instance=  new News;
//$instance->save();
News::find( 3);