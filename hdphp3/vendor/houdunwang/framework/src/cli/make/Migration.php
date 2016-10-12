<?php namespace hdphp\cli\make;

/**
 * 创建数据迁移
 * Class Migration
 * @package hdphp\cli\make
 * @author 向军
 */
class Migration {
	public function __construct() { }

	public function run( $name, $arg ) {
		$info = explode( '=', $arg );
		//检测文件是否存在,也检测类名
		foreach ( glob( ROOT_PATH . '/system/database/migrations/*.php' ) as $f ) {
			if ( substr( basename( $f ), 18, - 4 ) == $name ) {
				\hdphp\cli\Cli::error( "File already exists\n" );
			}
		}
		$file = ROOT_PATH . '/system/database/migrations/' . date( 'Y_m_d' ) . '_' . substr( time(), - 6 ) . '_' . $name . '.php';
		if ( $info[0] == '--create' ) {
			//创建模型文件
			$data = file_get_contents( __DIR__ . '/view/migration.create.tpl' );
			$data = str_replace( [ '{{TABLE}}', '{{className}}' ], [ $info[1], $name ], $data );
			file_put_contents( $file, $data );
		}
		if ( $info[0] == '--table' ) {
			//创建模型文件
			$data = file_get_contents( __DIR__ . '/view/migration.table.tpl' );
			$data = str_replace( [ '{{TABLE}}', '{{className}}' ], [ $info[1], $name ], $data );
			file_put_contents( $file, $data );
		}
	}
}