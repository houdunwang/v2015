<?php namespace hdphp\cli\seed;
/**
 * 迁移重置
 * Class Reset
 * @package hdphp\cli\seed
 * @author 向军
 */
class Reset {

	public function run() {
		$files = Db::table( 'seeds' )->lists( 'seed' );
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