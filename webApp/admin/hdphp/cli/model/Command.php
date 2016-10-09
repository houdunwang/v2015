<?php namespace Hdphp\Cli\Model;

class Command {
	/**
	 * 创建模型或控制器
	 * @param $arg [0=>'模型名']
	 */
	public function make( $arg ) {
		$info  = explode( '.', $arg );
		$MODEL = ucfirst( $info[0] );
		$TABLE = strtolower( $info[0] );
		$file  = 'system/model/' . ucfirst( $MODEL ) . '.php';
		//创建模型文件
		if ( is_file( $file ) ) {
			\hdphp\cli\Cli::error( "Model file already exists" );
		} else {
			$data = file_get_contents( __DIR__ . '/Model.tpl' );
			$data = str_replace( [ '{{MODEL}}', '{{TABLE}}' ], [ $MODEL, $TABLE ], $data );
			file_put_contents( $file, $data );
		}
	}
}