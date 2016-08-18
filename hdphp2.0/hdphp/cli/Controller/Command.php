<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cli\Controller;

class Command {
	/**
	 * 创建控制器
	 *
	 * @param  string $arg 路径
	 * @param  string $type 参数 base 基本 resource 资源
	 *
	 * @return void
	 */
	public function make( $arg, $type = 'controller' ) {
		$info       = explode( '.', $arg );
		$MODULE     = $info[0];
		$CONTROLLER = ucfirst( $info[1] );
		$file       = APP_PATH . '/' . $MODULE . '/controller/' . ucfirst( $CONTROLLER ) . '.php';
		//判断目录
		if ( ! is_dir( APP_PATH . '/' . $MODULE . '/controller' ) ) {
			die( "Directory does not exist\n" );
		}
		//创建模型文件
		if ( is_file( $file ) ) {
			\hdphp\cli\Cli::error( 'Controller file already exists' );
		} else {
			$data = file_get_contents( __DIR__ . '/' . ucfirst( $type ) . '.tpl' );
			$data = str_replace( [ '{{APP}}', '{{MODULE}}', '{{CONTROLLER}}' ], [ c( 'app.path' ), $MODULE, $CONTROLLER ], $data );
			file_put_contents( $file, $data );
		}
	}
}