<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\route;

use Closure;

class Compile extends Setting {
	//路由参数
	protected $args = [ ];

	//匹配路由
	protected function isMatch( $key ) {
		if ( preg_match( $this->route[ $key ]['regexp'], $this->requestUri ) ) {
			//获取参数
			$this->route[ $key ]['get'] = $this->getArgs( $key );
			//验证参数
			if ( ! $this->checkArgs( $key ) ) {
				return false;
			}
			//设置GET参数
			$this->args = $_GET = array_merge( $this->route[ $key ]['get'], $_GET );

			return $this->found = true;
		}
	}

	//获取请求参数
	protected function getArgs( $key ) {
		$args = [ ];
		if ( preg_match_all( $this->route[ $key ]['regexp'], $this->requestUri, $matched, PREG_SET_ORDER ) ) {
			//参数列表
			foreach ( $this->route[ $key ]['args'] as $n => $value ) {
				if ( isset( $matched[0][ $n + 1 ] ) ) {
					$args[ $value[1] ] = $matched[0][ $n + 1 ];
				}
			}
		}

		return $args;
	}

	//验证路由参数
	protected function checkArgs( $key ) {
		$route = $this->route[ $key ];
		if ( ! empty( $route['where'] ) ) {
			foreach ( $route['where'] as $name => $regexp ) {
				if ( isset( $route['get'][ $name ] ) && ! preg_match( $regexp, $route['get'][ $name ] ) ) {
					return false;
				}
			}
		}

		return true;
	}

	//执行路由事件
	public function exec( $key ) {
		//匿名函数
		if ( $this->route[ $key ]['callback'] instanceof Closure ) {
			//反射分析闭包
			$reflectionFunction = new \ReflectionFunction( $this->route[ $key ]['callback'] );
			$gets               = $this->route[ $key ]['get'];
			$args               = [ ];
			foreach ( $reflectionFunction->getParameters() as $k => $p ) {
				if ( isset( $gets[ $p->name ] ) ) {
					//如果GET变量中存在则将GET变量值赋予,也就是说GET优先级高
					$args[ $p->name ] = $gets[ $p->name ];
				} else {
					//如果类型为类时分析类
					if ( $dependency = $p->getClass() ) {
						$args[ $p->name ] = App::build( $dependency->name );
					} else {
						//普通参数时获取默认值
						$args[ $p->name ] = App::resolveNonClass( $p );
					}
				}
			}
			echo $reflectionFunction->invokeArgs( $args );
		} else {
			//设置控制器与方法
			$_GET[ c( 'http.url_var' ) ] = $this->route[ $key ]['callback'];
			Controller::run( $this->route[ $key ]['get'] );
		}
	}

	//GET事件处理
	protected function _get( $key ) {
		return IS_GET && $this->isMatch( $key ) && $this->exec( $key );
	}

	//POST事件处理
	protected function _post( $key ) {
		return IS_POST && $this->isMatch( $key ) && $this->exec( $key );
	}

	//PUT事件处理
	protected function _put( $key ) {
		if ( empty( $_POST ) ) {
			parse_str( file_get_contents( 'php://input' ), $_POST );
		}

		return IS_PUT && $this->isMatch( $key ) && $this->exec( $key );
	}

	//DELETE事件
	protected function _delete( $key ) {
		if ( empty( $_POST ) ) {
			parse_str( file_get_contents( 'php://input' ), $_POST );
		}

		return IS_DELETE && $this->isMatch( $key ) && $this->exec( $key );
	}

	//任意提交模式
	protected function _any( $key ) {
		return $this->isMatch( $key ) && $this->exec( $key );
	}

	//控制器路由
	protected function _controller( $key ) {
		if ( $this->route[ $key ]['method'] == 'controller' && $this->isMatch( $key ) ) {
			//控制器方法
			$method = $this->getRequestAction() . ucfirst( $this->route[ $key ]['get']['method'] );
			//从容器提取控制器对象
			$info = explode( '/', $this->route[ $key ]['callback'] );
			define( 'MODULE', array_shift( $info ) );
			define( 'CONTROLLER', array_shift( $info ) );
			define( 'ACTION', $method );
			Controller::run();
		}
	}

	//获取请求方法
	public function getRequestAction() {
		switch ( true ) {
			case IS_GET:
				return 'get';
			case IS_POST:
				return 'post';
			case IS_PUT:
				return 'put';
			case IS_DELETE:
				return 'delete';
		}
	}

	//获取解析后的参数
	public function getArg() {
		return $this->args;
	}
}