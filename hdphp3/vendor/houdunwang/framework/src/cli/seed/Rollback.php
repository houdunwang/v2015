<?php namespace hdphp\cli\seed;
/**
 * 回滚到上次迁移
 * Class Migrate
 * @package hdphp\cli\seed
 * @author 向军
 */
class Rollback {

	public function run() {
		$batch = Db::table( 'seeds' )->max( 'batch' );
		$files = Db::table( 'seeds' )->where( 'batch', $batch )->lists( 'seed' );
		foreach ( (array) $files as $f ) {
			$file = ROOT_PATH . '/system/database/seeds/' . $f . '.php';
			if ( is_file( $file ) ) {
				require $file;
				$class = substr( basename( $file ), 18, - 4 );
				( new $class )->down();
				Db::table( 'seeds' )->where( 'seed', $f )->delete();
			}
		}
	}
}