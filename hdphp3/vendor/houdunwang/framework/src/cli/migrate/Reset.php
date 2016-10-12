<?php namespace hdphp\cli\migrate;
/**
 * 迁移重置
 * Class Reset
 * @package hdphp\cli\migrate
 * @author 向军
 */
class Reset {

	public function run() {
		$files = Db::table( 'migrations' )->lists( 'migration' );
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