<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\model;

use ArrayAccess;
use hdphp\traits\HdArrayAccess;
use Iterator;

class Model implements ArrayAccess, Iterator {
	use HdArrayAccess;

	//----------自动验证----------
	//有字段时验证
	const EXIST_VALIDATE = 1;
	//值不为空时验证
	const NOT_EMPTY_VALIDATE = 2;
	//必须验证
	const MUST_VALIDATE = 3;
	//值是空时验证
	const EMPTY_VALIDATE = 4;
	//不存在字段时处理
	const NOT_EXIST_VALIDATE = 5;
	//----------自动完成----------
	//有字段时验证
	const EXIST_AUTO = 1;
	//值不为空时验证
	const NOT_EMPTY_AUTO = 2;
	//必须验证
	const MUST_AUTO = 3;
	//值是空时验证
	const EMPTY_AUTO = 4;
	//不存在字段时处理
	const NOT_EXIST_AUTO = 5;
	//----------自动过滤----------
	//有字段时验证
	const EXIST_FILTER = 1;
	//值不为空时验证
	const NOT_EMPTY_FILTER = 2;
	//必须验证
	const MUST_FILTER = 3;
	//值是空时验证
	const EMPTY_FILTER = 4;
	//不存在字段时处理
	const NOT_EXIST_FILTER = 5;
	//--------处理时机/自动完成&自动验证共用
	//插入时处理
	const MODEL_INSERT = 1;
	//更新时处理
	const MODEL_UPDATE = 2;
	//全部情况下处理
	const MODEL_BOTH = 3;
	//模型记录
	public static $links;
	//数据库连接
	protected $connect;
	//类名
	protected $class;
	//表名
	protected $table;
	//表主键
	protected $pk;
	//模型名
	protected $model;
	//验证错误
	protected $error;
	//模型数据
	public $data = [ ];
	//自动验证
	protected $validate = [ ];
	//自动完成
	protected $auto = [ ];
	//字段映射
	protected $map = [ ];
	//自动过滤
	protected $filter = [ ];
	//时间操作
	protected $timestamps = FALSE;
	//允许插入的字段
	protected $denyInsertFields = [ ];
	//允许更新的字段
	protected $denyUpdateFields = [ ];
	//数据库驱动
	protected $db;

	public function __construct() {
		$this->class = get_class( $this );
		$this->model = basename( str_replace( '/', '\\', $this->class ) );
		$this->setTable();
		//数据驱动
		$this->db = \Db::connect()->model( $this );
		$this->pk = $this->db->getPrimaryKey();
		if ( method_exists( $this, '__init' ) ) {
			$this->__init();
		}
	}

	//设置模型表
	final protected function setTable() {
		if ( empty( $this->table ) ) {
			$this->table = strtolower( preg_replace( '/.([A-Z])/', '_\1', $this->model ) );
		}
	}

	//获取表名
	final public function getTableName() {
		return $this->table;
	}

	/**
	 * 获取操作错误信息
	 * @return mixed
	 */
	final public function getError() {
		return $this->error;
	}

	/**
	 * 设置data 记录信息属性
	 *
	 * @param $data
	 *
	 * @return $this
	 */
	final public function data( $data ) {
		$this->data = $data;

		return $this;
	}

	//获取数据
	final public function getData() {
		return $this->data;
	}

	/**
	 * 自动验证字段值唯一(自动验证使用)
	 *
	 * @param $field 字段名
	 * @param $value 字段值
	 * @param $param 参数
	 * @param $data 提交数据
	 *
	 * @return bool 验证状态
	 */
	private function unique( $field, $value, $param, $data ) {
		//表主键
		$db = Db::table( $this->table );
		if ( isset( $data[ $this->pk ] ) ) {
			$db->where( $this->pk, '<>', $data[ $this->pk ] );
		}
		if ( empty( $value ) || ! $db->where( $field, $value )->get() ) {
			return TRUE;
		}
	}

	/**
	 * 自动验证
	 *
	 * @param $data 数据
	 * @param $type 类型 1添加 2更新
	 *
	 * @return bool
	 */
	final private function autoValidate( $data, $type ) {
		//验证库
		$VaAction              = new \hdphp\validate\VaAction;
		$_SESSION['_validate'] = $this->error = '';
		if ( empty( $this->validate ) ) {
			return TRUE;
		}
		foreach ( $this->validate as $validate ) {
			//验证条件
			$validate[3] = isset( $validate[3] ) ? $validate[3] : self::MUST_VALIDATE;

			if ( $validate[3] == self::EXIST_VALIDATE && ! isset( $data[ $validate[0] ] ) ) {
				continue;
			} else if ( $validate[3] == self::NOT_EMPTY_VALIDATE && empty( $data[ $validate[0] ] ) ) {
				//不为空时处理
				continue;
			} else if ( $validate[3] == self::EMPTY_VALIDATE && ! empty( $data[ $validate[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $validate[3] == self::NOT_EXIST_VALIDATE && isset( $data[ $validate[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $validate[3] == self::MUST_VALIDATE ) {
				//必须处理
			}
			$validate[4] = isset( $validate[4] ) ? $validate[4] : self::MODEL_BOTH;
			//验证时间判断
			if ( $validate[4] != $type && $validate[4] != self::MODEL_BOTH ) {
				continue;
			}
			//字段名
			$field = $validate[0];
			//验证规则
			$actions = explode( '|', $validate[1] );
			//错误信息
			$error = $validate[2];
			//表单值
			$value = isset( $data[ $field ] ) ? $data[ $field ] : '';
			foreach ( $actions as $action ) {
				$info   = explode( ':', $action );
				$method = $info[0];
				$params = isset( $info[1] ) ? $info[1] : '';
				if ( method_exists( $this, $method ) ) {
					//类方法验证
					if ( $this->$method( $field, $value, $params, $data ) !== TRUE ) {
						$_SESSION['_validate'] = $this->error = $error;

						return FALSE;
					}
				} else if ( method_exists( $VaAction, $method ) ) {
					if ( $VaAction->$method( $field, $value, $params, $data ) !== TRUE ) {
						$_SESSION['_validate'] = $this->error = $error;

						return FALSE;
					}
				} else if ( substr( $method, 0, 1 ) == '/' ) {
					//正则表达式
					if ( ! preg_match( $method, $value ) ) {
						$_SESSION['_validate'] = $this->error = $error;

						return FALSE;
					}
				}
			}
		}

		return TRUE;
	}

	/**
	 * 自动完成处理
	 *
	 * @param $data 数据
	 * @param $type 时机
	 *
	 * @return mixed
	 */
	private function autoOperation( $data, $type ) {
		//不存在自动完成规则
		if ( empty( $this->auto ) ) {
			return $data;
		}
		foreach ( $this->auto as $name => $auto ) {
			//处理类型
			$auto[2] = isset( $auto[2] ) ? $auto[2] : 'string';
			//验证条件
			$auto[3] = isset( $auto[3] ) ? $auto[3] : self::EXIST_AUTO;
			//验证时间
			$auto[4] = isset( $auto[4] ) ? $auto[4] : self::MODEL_BOTH;
			//有这个字段处理
			if ( $auto[3] == self::EXIST_AUTO && ! isset( $data[ $auto[0] ] ) ) {
				continue;
			} else if ( $auto[3] == self::NOT_EMPTY_AUTO && empty( $data[ $auto[0] ] ) ) {
				//不为空时处理
				continue;
			} else if ( $auto[3] == self::EMPTY_AUTO && ! empty( $data[ $auto[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $auto[3] == self::NOT_EXIST_AUTO && isset( $data[ $auto[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $auto[3] == self::MUST_AUTO ) {
				//必须处理
			}
			if ( $auto[4] == $type || $auto[4] == self::MODEL_BOTH ) {
				//为字段设置默认值
				if ( empty( $data[ $auto[0] ] ) ) {
					$data[ $auto[0] ] = '';
				}
				if ( $auto[2] == 'method' ) {
					$data[ $auto[0] ] = $this->$auto[1]( $data[ $auto[0] ], $data );
				} else if ( $auto[2] == 'function' ) {
					$data[ $auto[0] ] = $auto[1]( $data[ $auto[0] ] );
				} else if ( $auto[2] == 'string' ) {
					$data[ $auto[0] ] = $auto[1];
				}
			}
		}

		return $data;
	}

	/**
	 * 自动过滤掉满足条件的字段
	 *
	 * @param array $data 操作数据
	 * @param $type 1 增加 2 更新
	 *
	 * @return array 处理后的数据
	 */
	private function autoFilter( $data, $type ) {
		//不存在自动完成规则
		if ( empty( $this->filter ) ) {
			return $data;
		}
		foreach ( $this->filter as $filter ) {
			//验证条件
			$filter[1] = isset( $filter[1] ) ? $filter[1] : self::EXIST_AUTO;
			//验证时间
			$filter[2] = isset( $filter[2] ) ? $filter[2] : self::MODEL_BOTH;
			//有这个字段处理
			if ( $filter[1] == self::EXIST_FILTER && ! isset( $data[ $filter[0] ] ) ) {
				continue;
			} else if ( $filter[1] == self::NOT_EMPTY_FILTER && empty( $data[ $filter[0] ] ) ) {
				//不为空时处理
				continue;
			} else if ( $filter[1] == self::EMPTY_FILTER && ! empty( $data[ $filter[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $filter[1] == self::NOT_EXIST_FILTER && isset( $data[ $filter[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $filter[1] == self::MUST_FILTER ) {
				//必须处理
			}
			if ( $filter[2] == $type || $filter[2] == self::MODEL_BOTH ) {
				unset( $data[ $filter[0] ] );
			}
		}

		return $data;
	}

	/**
	 * 禁止更新字段检测处理
	 *
	 * @param array $data 数据
	 *
	 * @return array
	 */
	private function denyUpdateFieldDispose( array $data ) {
		$dispose = $data;
		if ( ! empty( $this->denyUpdateFields ) ) {
			foreach ( (array) $dispose as $field => $v ) {
				if ( in_array( $field, $this->denyUpdateFields ) ) {
					unset( $data[ $field ] );
				}
			}
		}

		return $data;
	}

	/**
	 * 禁止添加字段检测处理
	 *
	 * @param array $data 数据
	 *
	 * @return array
	 */
	private function denyInsertFieldDispose( array $data ) {
		$dispose = $data;
		if ( ! empty( $this->denyInsertFields ) ) {
			foreach ( (array) $dispose as $field => $v ) {
				if ( in_array( $field, $this->denyInsertFields ) ) {
					unset( $data[ $field ] );
				}
			}
		}

		return $data;
	}

	/**
	 * 验证令牌
	 *
	 * @return bool
	 */
	private function checkToken() {
		if ( C( 'app.token_on' ) ) {
			$status = FALSE;
			$name   = C( 'app.token_name' );
			$token  = Session::get( $name );
			$post   = q( 'post' . $name );
			if ( empty( $token ) || empty( $post ) || $post == $token ) {
				$status = TRUE;
			}
			//令牌重置
			if ( C( 'app.token_reset' ) ) {
				unset( $_SESSION[ $name ] );
			}

			return $status;
		}

		return TRUE;
	}

	/**
	 * 处理字段映射
	 *
	 * @param $data 数据
	 * @param int $type 时间 1 写入  2 读取
	 *
	 * @return mixed
	 */
	final private function parseFieldsMap( $data, $type = 2 ) {
		if ( ! empty( $this->map ) ) {
			foreach ( $this->map as $key => $value ) {
				if ( $type == 1 ) {
					if ( isset( $data[ $key ] ) ) {
						echo 11;
						$data[ $value ] = $data[ $key ];
						unset( $data[ $key ] );
					}
				} else {
					if ( isset( $data[ $value ] ) ) {
						$data[ $key ] = $data[ $value ];
						unset( $data[ $value ] );
					}
				}
			}
		}

		return $data;
	}

	/**
	 * 添加数据并返回实例
	 *
	 * @param array $data 添加的数据
	 *
	 * @return bool
	 */
	final public function add( array $data = [ ] ) {
		if ( ! $data = $this->create( $data, 1 ) ) {
			return FALSE;
		}
		if ( empty( $data ) ) {
			$this->error = '没有数据用于添加';

			return FALSE;
		}
		//更新时间
		if ( $this->timestamps === TRUE ) {
			$data['created_at'] = NOW;
		}
		//添加前操作
		if ( method_exists( $this, '_before_add' ) ) {
			$this->_before_add( $data );
		}
		if ( $this->db->insert( $data ) ) {
			if ( method_exists( $this, '_after_add' ) ) {
				$this->_after_add();
			}

			return $this->db->getInsertId() ?: TRUE;
		}

		return FALSE;
	}

	/**
	 * 创建数据对象
	 *
	 * @param array $data 生成对象数据
	 * @param string $type 1 插入 2 更新
	 *
	 * @return array|bool
	 */
	final public function create( array $data = [ ], $type = NULL ) {
		//如果数据不存在时使用$_POST
		if ( empty( $data ) ) {
			$data = $this->data ?: $_POST;
		} else if ( is_object( $data ) ) {
			//对象时获取对象属性
			$data = get_object_vars( $data );
		}
		//令牌验证
		if ( ! $this->checkToken( $data ) ) {
			$this->error = '表单令牌错误';

			return FALSE;
		}
		//动作类型  1 插入 2 更新
		$type = $type ?: ( empty( $data[ $this->pk ] ) ? self::MODEL_INSERT : self::MODEL_UPDATE );
		//禁止更新字段处理
		$data = $type == 2 ? $this->denyUpdateFieldDispose( $data ) : $data;
		//禁止添加字段处理
		$data = $type == 1 ? $this->denyInsertFieldDispose( $data ) : $data;
		if ( empty( $data ) ) {
			$this->error = '数据为空无法进行模型操作';

			return FALSE;
		}
		//自动完成
		$data = $this->autoOperation( $data, $type );
		//自动过滤
		$data = $this->autoFilter( $data, $type );
		//自动验证
		if ( ! $this->autoValidate( $data, $type ) ) {
			return FALSE;
		}

		//字段映射
		$data = $this->parseFieldsMap( $data, $type );

		return $this->data = $data ?: [ ];
	}

	/**
	 * 更新一条数据,更新数据中必须存在主键
	 *
	 * @param array $data 数据
	 *
	 * @return bool
	 */
	final public function save( array $data = [ ] ) {
		if ( ! $data = $this->create( $data, 2 ) ) {
			return FALSE;
		}
		if ( empty( $data ) ) {
			$this->error = '没有更新数据';

			return FALSE;
		}
		//更新时间
		if ( $this->timestamps === TRUE ) {
			$data['updated_at'] = NOW;
		}
		//更新条件检测
		if ( empty( $data[ $this->pk ] ) ) {
			$this->error = '模型的save方法的数据必须设置条件';

			return FALSE;
		} else {
			$this->db->where( $this->pk, $data[ $this->pk ] );
		}

		//更新前操作
		if ( method_exists( $this, '_before_save' ) ) {
			$this->_before_save( $data );
		}
		$result = $this->db->update( $data );
		//更新后操作
		if ( method_exists( $this, '_after_save' ) ) {
			$this->_after_save();
		}

		return $result;
	}

	/**
	 * 更新模型的时间戳
	 * @return bool
	 */
	final protected function touch() {
		$this->updated_at = time();

		return $this->save();
	}

	/**
	 * 删除数据
	 *
	 * @param null $id 编号
	 *
	 * @return bool
	 */
	final public function delete( $id = NULL ) {
		//没有查询参数如果模型数据中存在主键值,以主键值做删除条件
		if ( empty( $id ) && ! $this->getQueryParams( 'where' ) ) {
			if ( isset( $this->data[ $this->pk ] ) ) {
				$this->where( $this->pk, $this->data[ $this->pk ] );
			}
		}
		//删除前操作
		if ( method_exists( $this, '_before_delete' ) ) {
			$this->_before_delete();
		}
		if ( $status = $this->db->delete( $id ) ) {
			//删除后操作
			if ( method_exists( $this, '_after_delete' ) ) {
				$this->_after_delete();
			}
		}

		return $status;
	}

	/**
	 * 记录不存在才新增
	 *
	 * @param $param 条件
	 * @param $data 数据
	 *
	 * @return bool
	 */
	final public function firstOrCreate( $param, $data ) {
		if ( $data = $this->create( $data ) ) {
			return $this->db->firstOrCreate( $param, $data );
		}
	}

	//获取模型值
	public function __get( $name ) {
		if ( isset( $this->data[ $name ] ) ) {
			return $this->data[ $name ];
		}
	}

	//设置模型数据值
	public function __set( $name, $value ) {
		$this->data[ $name ] = $value;
	}

	//魔术方法
	public function __call( $method, $params ) {
		return call_user_func_array( [ $this->db, $method ], $params );
	}

	public static function __callStatic( $method, $params ) {
		$model = get_called_class();
		if ( ! isset( self::$links[ $model ] ) ) {
			self::$links[ $model ] = ( new static() );
		}
		$query = self::$links[ $model ];

		return call_user_func_array( [ $query, $method ], $params );
	}
}