<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cli;
class Seed extends Cli {
	protected static $batch;

	public function __construct() {
		//创建migration表用于记录动作
		if ( ! Schema::tableExists( 'seeds' ) ) {
			$sql = "CREATE TABLE " . c( 'database.prefix' ) . 'seeds(seed varchar(255) not null,batch int)CHARSET UTF8';
			Db::execute( $sql );
		}
		if ( empty( self::$batch ) ) {
			self::$batch = Db::table( 'seeds' )->max( 'batch' ) ?: 0;
		}
	}

	//运行数据填充
	public function make() {
		$files = glob( ROOT_PATH . '/system/database/seeds/*.php' );
		sort( $files );
		foreach ( (array) $files as $file ) {
			$name = substr( basename( $file ), 0, - 4 );
			//只执行没有执行过的migration
			if ( ! Db::table( 'seeds' )->where( 'seed', $name )->first() ) {
				require $file;
				$class = substr( basename( $file ), 18, - 4 );
				( new $class )->up();
				Db::table( 'seeds' )->insert( [ 'seed' => $name, 'batch' => ++ self::$batch ] );
			}
		}
	}

	//回滚所有的数据填充
	public function reset() {
		$files = Db::table( 'seeds' )->lists( 'seed' );
		foreach ( (array) $files as $f ) {
			$file = ROOT_PATH . '/system/database/seeds/' . $f . '.php';
			if ( is_file( $file ) ) {
				require $file;
				$class = substr( basename( $file ), 18, - 4 );
				( new $class )->down();
			}
			Db::table( 'seeds' )->where( 'seed', $f )->delete();
		}
	}

	//回滚最近一次填充
	public function rollback() {
		$batch = Db::table( 'seeds' )->max( 'batch' );
		$files = Db::table( 'seeds' )->where( 'batch', $batch )->lists( 'seed' );
		foreach ( (array) $files as $f ) {
			$file = ROOT_PATH . '/system/database/seeds/' . $f . '.php';
			if ( is_file( $file ) ) {
				require $file;
				$class = substr( basename( $file ), 18, - 4 );
				( new $class )->down();
			}
			Db::table( 'seeds' )->where( 'seed', $f )->delete();
		}
	}
}