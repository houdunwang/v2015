<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\session;

/**
 * 文件处理
 * Class FileHandler
 * @package hdphp\session
 * @author 向军
 */
class FileHandler implements AbSession {
	use Base;
	protected $dir;
	protected $file;

	//连接
	public function connect() {
		$this->dir = ROOT_PATH . '/storage/session';
		//创建目录
		if ( ! is_dir( $this->dir ) ) {
			mkdir( $this->dir, 0755, true );
			file_put_contents( $this->dir . '/index.html', '' );
		}
		$this->file = ROOT_PATH . '/storage/session/' . $this->session_id . '.php';
	}

	//读取数据
	public function read() {
		if ( ! is_file( $this->file ) ) {
			return [ ];
		}

		return include $this->file;
	}

	//保存数据
	public function write() {
		$data = "<?php if(!defined('ROOT_PATH'))exit;\nreturn " . var_export( $this->items, true ) . ";\n?>";
		file_put_contents( $this->file, $data );
	}

	//删除所有数据
	public function flush() {
		return Dir::delFile( $this->file );
	}

	//垃圾回收
	public function gc() {
		foreach ( glob( $this->dir . '/*.php' ) as $f ) {
			if ( basename( $f ) != basename( $this->file ) && ( filemtime( $this->file ) + $this->expire ) < time() ) {
				Dir::delFile( $f );
			}
		}
	}
}