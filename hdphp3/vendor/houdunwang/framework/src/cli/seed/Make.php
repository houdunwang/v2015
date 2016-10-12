<?php namespace hdphp\cli\seed;

/**
 * 数据迁移指令
 * Class Migrate
 * @package hdphp\cli\seed
 * @author 向军
 */
class make {
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

	public function run() {
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
}