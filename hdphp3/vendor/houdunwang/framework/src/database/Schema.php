<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\database;

/**
 * 数据库操作
 * Class Schema
 * @package hdphp\schema
 */
use Closure;

class Schema {
	//操作表
	protected $table;

	//执行动作
	protected $exe;

	//连接
	protected $driver;

	public function __construct() {
		$class = '\hdphp\database\build\\' . ucfirst( c( 'database.driver' ) );

		$this->driver = new $class();
	}

	/**
	 * 创建表结构
	 *
	 * @param string $table 表名
	 * @param \Closure $callback
	 */
	public function create( $table, Closure $callback ) {
		$Blueprint = new Blueprint( $table );
		$callback( $Blueprint );
		$Blueprint->create();
	}

	public function table( $table, Closure $callback ) {
		$Blueprint = new Blueprint( $table );
		$callback( $Blueprint );
	}

	public function __call( $name, $arguments ) {
		return call_user_func_array( [ $this->driver, $name ], $arguments );
	}
}