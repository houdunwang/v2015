<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cli\make;
//创建控制器
class Controller {
	public function run( $arg, $type = 'controller' ) {
		$info       = explode( '.', $arg );
		$MODULE     = $info[0];
		$CONTROLLER = ucfirst( $info[1] );
		$file       = ROOT_PATH . '/app/' . $MODULE . '/controller/' . ucfirst( $CONTROLLER ) . '.php';
		//判断目录
		if ( ! is_dir( ROOT_PATH . '/app/' . $MODULE . '/controller' ) ) {
			die( "Directory does not exist\n" );
		}
		//创建模型文件
		if ( is_file( $file ) ) {
			\hdphp\cli\Cli::error( 'Controller file already exists' );
		} else {
			$data = file_get_contents( __DIR__ . '/view/' . ucfirst( $type ) . '.tpl' );
			$data = str_replace( [ '{{APP}}', '{{MODULE}}', '{{CONTROLLER}}' ], [ c( 'app.path' ), $MODULE, $CONTROLLER ], $data );
			file_put_contents( $file, $data );
		}
	}
}