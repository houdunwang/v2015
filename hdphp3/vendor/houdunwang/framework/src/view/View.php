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
	protected $vars = [ ];
	//模版文件
	protected $file;
	//缓存目录
	protected $cacheDir;
	//缓存时间
	protected $expire;

	public function __construct() {
		$this->cacheDir = ROOT_PATH . '/storage/view/cache';
	}

	/**
	 * 解析模板
	 *
	 * @param string $file
	 * @param int $expire
	 *
	 * @return $this
	 */
	public function make( $file = '', $expire = null ) {
		$this->file   = $file;
		$this->expire = is_null( $expire ) ? null : intval( $expire );

		return $this;
	}

	/**
	 * 根据模板文件生成编译文件
	 *
	 * @param $file
	 *
	 * @return string
	 */
	public function compile( $file ) {
		$file        = $this->template( $file );
		$compileFile = ROOT_PATH . '/storage/view/' . preg_replace( '/[^\w]/', '_', $file ) . '_' . substr( md5( $file ), 0, 5 ) . '.php';
		$status      = c( 'app.debug' )
		               || ! is_file( $compileFile )
		               || ( filemtime( $file ) > filemtime( $compileFile ) );
		if ( $status ) {
			Dir::create( dirname( $compileFile ) );
			//执行文件编译
			$compile = new Compile( $this );
			$content = $compile->run( $file );
			file_put_contents( $compileFile, $content );
		}

		return $compileFile;
	}

	//解析编译文件,返回模板解析后的字符
	public function fetch( $file ) {
		$compileFile = $this->compile( $file );
		ob_start();
		extract( $this->vars );
		include $compileFile;

		return ob_get_clean();
	}

	//显示模板
	public function __toString() {
		if ( ! is_null( $this->expire ) && $this->isCache( $this->file ) ) {
			//缓存有效时返回缓存数据
			return Cache::dir( $this->cacheDir )->get( $this->cacheName( $this->file ) ) ?: '';
		}
		$content = $this->fetch( $this->file );
		//创建缓存文件
		if ( ! is_null( $this->expire ) ) {
			Cache::dir( $this->cacheDir )->set( $this->cacheName( $this->file ), $content, $this->expire );
		}

		return $content;
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
				$this->vars[ $k ] = $v;
			}
		} else {
			$this->vars[ $name ] = $value;
		}

		return $this;
	}

	//获取模板文件
	public function getTpl() {
		return $this->template( $this->file );
	}

	//根据文件名获取模板文件
	public function template( $file ) {
		//没有扩展名时添加上
		if ( $file && ! preg_match( '/\.[a-z]+$/i', $file ) ) {
			$file .= c( 'view.prefix' );
		}
		if ( ! is_file( $file ) ) {
			if ( defined( 'MODULE' ) ) {
				//模块视图文件夹
				$file = c( 'app.path' ) . '/' . strtolower( MODULE . '/view/' . CONTROLLER ) . '/' . ( $file ?: ACTION . c( 'view.prefix' ) );
				if ( ! is_file( $file ) ) {
					trigger_error( "模板不存在:$file", E_USER_ERROR );
				}
			} else {
				//路由访问时
				$file = c( 'view.path' ) . '/' . $file;
				if ( ! is_file( $file ) ) {
					trigger_error( "模板不存在:$file", E_USER_ERROR );
				}
			}
		}

		return $file;
	}

	//缓存标识
	protected function cacheName( $file ) {
		return md5( $_SERVER['REQUEST_URI'] . $this->template( $file ) );
	}

	//验证缓存文件
	public function isCache( $file = '' ) {
		return Cache::dir( $this->cacheDir )->get( $this->cacheName( $file ) ) ? true : false;
	}

	//删除模板缓存
	public function delCache( $file = '' ) {
		return Cache::dir( $this->cacheDir )->del( $this->cacheName( $file ) );
	}
}