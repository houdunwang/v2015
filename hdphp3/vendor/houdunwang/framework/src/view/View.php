<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\view;

use Exception;

//视图处理
class View {
	//模板变量集合
	protected static $vars = [ ];
	//模版文件
	protected $tpl;
	//编译文件
	protected $compileFile;
	//缓存目录
	protected $cacheDir;

	/**
	 * 解析模板
	 *
	 * @param string $tpl
	 * @param int $expire
	 *
	 * @return $this
	 */
	public function make( $tpl = '', $expire = 0 ) {
		$this->cacheDir = ROOT_PATH . '/storage/view/cache';
		//模板文件
		$this->tpl = $this->getTemplateFile( $tpl );
		//缓存标识
		$cacheName = md5( $_SERVER['REQUEST_URI'] . $this->tpl );
		//缓存有效
		if ( $expire > 0 && $content = Cache::dir( $this->cacheDir )->get( $cacheName ) ) {
			return $this;
		}
		//编译文件
		$this->compileFile = ROOT_PATH . '/storage/view/' . preg_replace( '/[^\w]/', '_', $this->tpl ) . '_' . substr( md5( $this->tpl ), 0, 5 ) . '.php';
		//编译文件
		$this->compile();
		//创建缓存文件
		if ( $expire > 0 ) {
			Cache::dir( $this->cacheDir )->set( $cacheName, $content, $expire );
		}

		return $this;
	}

	//获取模板文件
	public function getTpl() {
		return $this->tpl;
	}

	//获取编译文件
	public function getCompileFile() {
		return $this->compileFile;
	}

	/**
	 * 返回模板解析后的字符
	 *
	 * @param string $tpl
	 * @param int $expire
	 *
	 * @return mixed
	 */
	public function fetch( $tpl = '', $expire = 0 ) {
		return $this->make( $tpl, $expire )->__toString();
	}

	/**
	 * 获取模板文件
	 *
	 * @param $file
	 *
	 * @return string
	 * @throws \Exception
	 */
	protected function getTemplateFile( $file ) {
		//没有扩展名时添加上
		if ( $file && ! preg_match( '/\.[a-z]+$/i', $file ) ) {
			$file .= c( 'view.prefix' );
		}

		if ( is_file( $file ) ) {
			return $file;
		}
		if ( defined( 'MODULE' ) ) {
			//模块视图文件夹
			$f = strtolower( MODULE_PATH . '/view/' . CONTROLLER ) . '/' . ( $file ?: ACTION . c( 'view.prefix' ) );
			if ( is_file( $f ) ) {
				return $f;
			}
		} else {
			//路由访问时
			$f = ROOT_PATH . '/' . c( 'view.path' ) . '/' . $file . c( 'view.prefix' );
			if ( is_file( $f ) ) {
				return $f;
			}
		}
		throw new Exception( "模板不存在:$f" );
	}

	/**
	 * 验证缓存文件
	 *
	 * @param string $tpl
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function isCache( $tpl = '' ) {
		//缓存标识
		$cacheName = md5( $_SERVER['REQUEST_URI'] . $this->getTemplateFile( $tpl ) );

		return Cache::dir( 'storage/view/cache' )->get( $cacheName );
	}

	//编译文件
	protected function compile() {
		$status = c( 'app.debug' )
		          || ! file_exists( $this->compileFile )
		          || ! is_file( $this->compileFile )
		          || ( filemtime( $this->tpl ) > filemtime( $this->compileFile ) );

		if ( $status ) {
			//创建编译目录
			$dir = dirname( $this->compileFile );
			if ( ! is_dir( $dir ) ) {
				mkdir( $dir, 0755, true );
			}
			//执行文件编译
			$compile = new Compile( $this );
			$content = $compile->run();
			file_put_contents( $this->compileFile, $content );
		}
	}

	/**
	 * 分配变量
	 *
	 * @param mixed $name 变量名
	 * @param string $value 值
	 *
	 * @return $this
	 */
	public function with( $name, $value = '' ) {
		if ( is_array( $name ) ) {
			foreach ( $name as $k => $v ) {
				self::$vars[ $k ] = $v;
			}
		} else {
			self::$vars[ $name ] = $value;
		}

		return $this;
	}

	//显示模板
	public function __toString() {
		extract( self::$vars );
		ob_start();
		include $this->compileFile;

		return ob_get_clean();
	}
}