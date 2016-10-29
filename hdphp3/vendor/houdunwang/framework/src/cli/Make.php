<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cli;
class Make extends Cli {
	//创建控制器
	public function controller( $arg, $type = 'controller' ) {
		$info       = explode( '.', $arg );
		$MODULE     = $info[0];
		$CONTROLLER = ucfirst( $info[1] );
		$file       = ROOT_PATH . '/app/' . $MODULE . '/controller/' . ucfirst( $CONTROLLER ) . '.php';
		//判断目录
		if ( ! is_dir( ROOT_PATH . '/app/' . $MODULE . '/controller' ) ) {
			$this->error( "Directory does not exist\n" );
		}
		//创建模型文件
		if ( is_file( $file ) ) {
			$this->error( 'Controller file already exists' );
		} else {
			$data = file_get_contents( __DIR__ . '/view/' . ucfirst( $type ) . '.tpl' );
			$data = str_replace( [ '{{APP}}', '{{MODULE}}', '{{CONTROLLER}}' ], [ $this->config['app']['path'], $MODULE, $CONTROLLER ], $data );
			file_put_contents( $file, $data );
		}
	}

	//创建模型
	public function model( $arg ) {
		$info  = explode( '.', $arg );
		$MODEL = ucfirst( $info[0] );
		$TABLE = strtolower( $info[0] );
		$file  = 'system/model/' . ucfirst( $MODEL ) . '.php';
		//创建模型文件
		if ( is_file( $file ) ) {
			$this->error( "Model file already exists" );
		} else {
			$data = file_get_contents( __DIR__ . '/view/model.tpl' );
			$data = str_replace( [ '{{MODEL}}', '{{TABLE}}' ], [ $MODEL, $TABLE ], $data );
			file_put_contents( $file, $data );
		}
	}

	//创建数据迁移
	public function migration( $name, $arg ) {
		$info = explode( '=', $arg );
		//检测文件是否存在,也检测类名
		foreach ( glob( ROOT_PATH . '/system/database/migrations/*.php' ) as $f ) {
			if ( substr( basename( $f ), 18, - 4 ) == $name ) {
				$this->error( "File already exists\n" );
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

	//创建数据迁移
	public function seed( $name ) {
		//检测文件是否存在,也检测类名
		foreach ( glob( ROOT_PATH . '/system/database/seeds/*.php' ) as $f ) {
			if ( substr( basename( $f ), 18, - 4 ) == $name ) {
				$this->error( "File already exists\n" );
			}
		}
		$file = ROOT_PATH . '/system/database/seeds/' . date( 'Y_m_d' ) . '_' . substr( time(), - 6 ) . '_' . $name . '.php';
		//创建文件
		$data = file_get_contents( __DIR__ . '/view/seeder.tpl' );
		$data = str_replace( [ '{{className}}' ], [ $name ], $data );
		file_put_contents( $file, $data );
	}

	//创建标签
	public function tag( $name ) {
		$file = ROOT_PATH . '/system/tag/' . ucfirst( $name ) . '.php';
		if ( is_file( $file ) ) {
			$this->error( 'File already exists\n' );
		}
		//创建文件
		$data = file_get_contents( __DIR__ . '/view/tag.tpl' );
		$data = str_replace( [ '{{NAME}}' ], [ ucfirst( $name ) ], $data );
		file_put_contents( $file, $data );
	}
}