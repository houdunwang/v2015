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
	public $tpl;
	//编译文件
	public $compile;

	/**
	 * 解析模板
	 *
	 * @param string $tpl 模板
	 * @param int $expire 过期时间
	 * @param bool|true $show 显示或返回
	 *
	 * @return bool|string
	 * @throws Exception
	 */
	public function make( $tpl = '', $expire = 0, $show = TRUE ) {
		//模板文件
		if ( ! $this->tpl = $this->getTemplateFile( $tpl ) ) {
			return FALSE;
		}
		//缓存标识
		$cacheName = md5( $_SERVER['REQUEST_URI'] . $this->tpl );
		//缓存有效
		if ( $expire > 0 && $content = Cache::dir( ROOT_PATH . '/storage/view/cache' )->get( $cacheName ) ) {
			if ( $show ) {
				die( $content );
			} else {
				return $content;
			}
		}

		//编译文件
		$this->compile = 'storage/view/' . preg_replace( '/[^\w]/', '_', $this->tpl ) . '_' . substr( md5( $this->tpl ), 0, 5 ) . '.php';
		//编译文件
		$this->compileFile();
		//释放变量到全局
		if ( ! empty( self::$vars ) ) {
			extract( self::$vars );
		}
		//获取解析结果
		ob_start();
		require( $this->compile );
		$content = ob_get_clean();

		if ( $expire > 0 ) {
			//缓存
			if ( ! Cache::dir( 'storage/view/cache' )->set( $cacheName, $content, $expire ) ) {
				throw new Exception( "创建缓存失效" );
			}
		}
		if ( $show ) {
			echo $content;
			exit;
		} else {
			return $content;
		}
	}

	//获取显示内容
	public function fetch( $tpl = '' ) {
		return $this->make( $tpl, 0, FALSE );
	}

	/**
	 * 获取模板文件
	 *
	 * @param string $file 模板文件
	 *
	 * @return bool|string
	 * @throws Exception
	 */
	public function getTemplateFile( $file ) {
		//添加后缀
		if ( ! empty( $file ) ) {
			$file = preg_match( '/\.[a-z]+$/i', $file ) ? $file : $file . C( 'view.prefix' );
		}
		if ( is_file( $file ) ) {
			return $file;
		} else if ( ! is_file( $file ) ) {
			if ( defined( 'MODULE' ) ) {
				//模块视图文件夹
				$f = strtolower( MODULE_PATH . '/view/' . CONTROLLER ) . '/' . ( $file ?: ACTION . C( 'view.prefix' ) );

				if ( is_file( $f ) ) {
					return $f;
				}

				$f = MODULE_PATH . '/view/' . $file;
				if ( is_file( $f ) ) {
					return $f;
				}
			} else {
				//路由中使用回调函数执行View::make()时，因为没有MODULE
				$f = C( 'view.path' ) . '/' . $file . C( 'view.prefix' );
				if ( is_file( $f ) ) {
					return $f;
				}
			}
		}
		if ( DEBUG ) {
			throw new Exception( "模板不存在:$f" );
		} else {
			return FALSE;
		}
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
	private function compileFile() {
		$status = DEBUG || ! file_exists( $this->compile )
		          || ! is_file( $this->compile )
		          || ( filemtime( $this->tpl ) > filemtime( $this->compile ) );
		if ( $status ) {
			//创建编译目录
			$dir = dirname( $this->compile );
			if ( ! is_dir( $dir ) ) {
				mkdir( $dir, 0755, TRUE );
			}
			//执行文件编译
			$compile = new Compile( $this );
			$content = $compile->run();
			file_put_contents( $this->compile, $content );
		}
	}

	/**
	 * 分配变量
	 *
	 * @param $name 变量名
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
}