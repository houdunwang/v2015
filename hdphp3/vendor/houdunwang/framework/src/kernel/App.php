<?php
// .-------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |      Site: www.hdphp.com
// |-------------------------------------------------------------------
// |    Author: 向军 <2300071698@qq.com>
// |    WeChat: houdunwangxj
// | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
// '-------------------------------------------------------------------
namespace hdphp\kernel;

use ReflectionClass;
use Hdphp\Kernel\ServiceProviders;

class App extends Container {
	//应用已启动
	protected $booted = false;

	//系统服务
	protected $servers = [ ];

	//外观别名
	protected $facades = [ ];

	//延迟加载服务提供者
	protected $deferProviders = [ ];

	//已加载服务提供者
	protected $serviceProviders = [ ];

	public function bootstrap() {
		$this->constant();
		//加载服务配置项
		$servers              = require __DIR__ . '/service.php';
		$config               = require ROOT_PATH . '/system/config/service.php';
		$servers['providers'] = array_merge( $config['providers'], $servers['providers'] );
		$servers['facades']   = array_merge( $config['facades'], $servers['facades'] );
		$this->servers        = $servers;
		//自动加载系统服务
		Loader::register( [ $this, 'autoload' ] );
		//绑定核心服务提供者
		$this->bindServiceProvider();
		//添加初始实例
		$this->instance( 'App', $this );
		//设置外观类APP属性
		ServiceFacade::setFacadeApplication( $this );
		//启动服务
		$this->boot();
		//定义错误/异常处理
		Error::bootstrap();
		//命令行模式
		IS_CLI and die( Cli::bootstrap() );
		//导入类库别名
		Loader::addMap( c( 'app.alias' ) );
		//自动加载文件
		Loader::autoloadFile();
		//开启会话
		Session::start();
		//执行全局中间件
		Middleware::globals();
		//解析路由
		Route::dispatch();
	}

	//定义常量
	protected function constant() {
		//版本号
		define( 'FRAMEWORK_VERSION', '3.0.19' );
		define( 'IS_CLI', PHP_SAPI == 'cli' );
		define( 'NOW', $_SERVER['REQUEST_TIME'] );
		define( '__ROOT__', IS_CLI ? '' : trim( 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['SCRIPT_NAME'] ), '/\\' ) );
		define( 'DS', DIRECTORY_SEPARATOR );
		IS_CLI or define( 'IS_GET', $_SERVER['REQUEST_METHOD'] == 'GET' );
		IS_CLI or define( 'IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST' );
		IS_CLI or define( 'IS_DELETE', $_SERVER['REQUEST_METHOD'] == 'DELETE' ? true : ( isset( $_POST['_method'] ) && $_POST['_method'] == 'DELETE' ) );
		IS_CLI or define( 'IS_PUT', $_SERVER['REQUEST_METHOD'] == 'PUT' ? true : ( isset( $_POST['_method'] ) && $_POST['_method'] == 'PUT' ) );
		IS_CLI or define( 'IS_AJAX', isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );
		IS_CLI or define( 'IS_WEIXIN', isset( $_SERVER['HTTP_USER_AGENT'] ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false );
		IS_CLI or define( '__URL__', trim( 'http://' . $_SERVER['HTTP_HOST'] . '/' . trim( $_SERVER['REQUEST_URI'], '/\\' ), '/' ) );
		IS_CLI or define( "__HISTORY__", isset( $_SERVER["HTTP_REFERER"] ) ? $_SERVER["HTTP_REFERER"] : '' );
	}

	//命令行模式
	protected function cli() {
		//命令模式
		if ( $_SERVER['SCRIPT_NAME'] == 'hd' ) {
			call_user_func_array( [ new \hdphp\cli\Cli(), 'start' ], [ ] );
			die;
		}
	}

	//外观类文件自动加载
	public function autoload( $class ) {
		//通过外观类加载系统服务
		$file   = str_replace( '\\', '/', $class );
		$facade = basename( $file );
		if ( isset( $this->servers['facades'][ $facade ] ) ) {
			//加载facade类
			return class_alias( $this->servers['facades'][ $facade ], $class );
		}
	}

	//系统启动
	protected function boot() {
		if ( $this->booted ) {
			return;
		}

		foreach ( $this->serviceProviders as $p ) {
			$this->bootProvider( $p );
		}
		$this->booted = true;
	}

	//服务加载处理
	protected function bindServiceProvider() {
		foreach ( $this->servers['providers'] as $provider ) {
			$reflectionClass = new ReflectionClass( $provider );
			$properties      = $reflectionClass->getDefaultProperties();
			//获取服务延迟属性
			if ( isset( $properties['defer'] ) && $properties['defer'] ) {
				$alias = substr( $reflectionClass->getShortName(), 0, - 8 );
				//延迟加载服务
				$this->deferProviders[ $alias ] = $provider;
			} else {
				//立即加载服务
				$this->register( new $provider( $this ) );
			}
		}
	}

	/**
	 * 获取服务对象
	 *
	 * @param 服务名 $name 服务名
	 * @param bool $force 是否单例
	 *
	 * @return Object
	 */
	public function make( $name, $force = false ) {
		if ( isset( $this->deferProviders[ $name ] ) ) {
			$this->register( new $this->deferProviders[$name]( $this ) );
			unset( $this->deferProviders[ $name ] );
		}

		return parent::make( $name, $force );
	}

	/**
	 * 注册服务
	 *
	 * @param $provider 服务名
	 *
	 * @return object
	 */
	protected function register( $provider ) {
		//服务对象已经注册过时直接返回
		if ( $registered = $this->getProvider( $provider ) ) {
			return $registered;
		}
		if ( is_string( $provider ) ) {
			$provider = new $provider( $this );
		}
		$provider->register( $this );
		//记录服务
		$this->serviceProviders[] = $provider;
		if ( $this->booted ) {
			$this->bootProvider( $provider );
		}
	}

	/**
	 * 运行服务提供者的boot方法
	 *
	 * @param $provider
	 */
	protected function bootProvider( $provider ) {
		if ( method_exists( $provider, 'boot' ) ) {
			$provider->boot( $this );
		}
	}

	/**
	 * 获取已经注册的服务
	 *
	 * @param $provider 服务名
	 *
	 * @return mixed
	 */
	protected function getProvider( $provider ) {
		$class = is_object( $provider ) ? get_class( $provider ) : $provider;
		foreach ( $this->serviceProviders as $value ) {
			if ( $value instanceof $class ) {
				return $value;
			}
		}
	}
}