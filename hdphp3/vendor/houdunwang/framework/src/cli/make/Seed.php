<?php namespace hdphp\cli\make;

/**
 * 创建数据迁移
 * Class Seeder
 * @package hdphp\cli\make
 * @author 向军
 */
class Seed {
	public function __construct() { }

	public function run( $name ) {
		//检测文件是否存在,也检测类名
		foreach ( glob( ROOT_PATH . '/system/database/migrations/*.php' ) as $f ) {
			if ( substr( basename( $f ), 18, - 4 ) == $name ) {
				\hdphp\cli\Cli::error( "File already exists\n" );
			}
		}
		$file = ROOT_PATH . '/system/database/seeds/' . date( 'Y_m_d' ) . '_' . substr( time(), - 6 ) . '_' . $name . '.php';
		//创建文件
		$data = file_get_contents( __DIR__ . '/view/seeder.tpl' );
		$data = str_replace( [ '{{className}}' ], [ $name ], $data );
		file_put_contents( $file, $data );
	}
}