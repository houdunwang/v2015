<?php namespace hdphp\cli\migrate;
/**
 * 回滚到上次迁移
 * Class Migrate
 * @package hdphp\cli\migrate
 * @author 向军
 */
class Rollback {

	public function run() {
		$batch = Db::table( 'migrations' )->max( 'batch' );
		$files = Db::table( 'migrations' )->where( 'batch', $batch )->lists( 'migration' );
		foreach ( (array) $files as $f ) {
			$file = ROOT_PATH . '/system/database/migrations/' . $f . '.php';
			if ( is_file( $file ) ) {
				require $file;
				$class = substr( basename( $file ), 18, - 4 );
				( new $class )->down();
				Db::table( 'migrations' )->where( 'migration', $f )->delete();
			}
		}
	}
}