<?php namespace hdphp\model;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use ArrayAccess;
use hdphp\traits\HdArrayAccess;
use Iterator;

class Model implements ArrayAccess, Iterator {
	use HdArrayAccess, Relation;

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
	//允许填充字段
	protected $allowFill = [ ];
	//禁止填充字段
	protected $denyFill = [ ];
	//模型数据
	protected $data = [ ];
	//模型记录
	protected static $links;
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
	protected $error = [ ];
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
	//数据库驱动
	protected $db;

	public function __construct() {
		$this->class = get_class( $this );
		$this->model = basename( str_replace( '/', '\\', $this->class ) );
		$this->setTable();
		//数据驱动
		$this->db = \Db::connect()->model( $this );
		if ( empty( $this->pk ) ) {
			$this->pk = $this->db->getPrimaryKey();
		}
	}

	/**
	 * 设置模型表
	 * @return string
	 */
	final protected function setTable() {
		if ( empty( $this->table ) ) {
			return $this->table = strtolower( preg_replace( '/.([A-Z])/', '_\1', $this->model ) );
		}
	}

	/**
	 * 获取表名
	 * @return mixed
	 */
	final public function getTableName() {
		return $this->table;
	}

	/**
	 * 获取表主键
	 */
	final public function getPrimaryKey() {
		return $this->pk;
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
	final public function data( array $data ) {
		$this->data = $data;

		return $this;
	}

	/**
	 * 对象数据转为数组
	 * @return array
	 */
	final public function toArray() {
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
	final private function unique( $field, $value, $param, $data ) {
		//表主键
		$db = \Db::table( $this->table );
		if ( isset( $data[ $this->pk ] ) ) {
			$db->where( $this->pk, '<>', $data[ $this->pk ] );
		}
		if ( empty( $value ) || ! $db->where( $field, $value )->pluck( $field ) ) {
			return TRUE;
		}
	}

	/**
	 * 自动验证
	 *
	 * @param array $data 数据
	 * @param int $type 类型 1添加 2更新
	 *
	 * @return bool
	 */
	final private function autoValidate( $data, $type ) {
		//验证库
		$VaAction = new \hdphp\validate\VaAction;
		if ( empty( $this->validate ) ) {
			return TRUE;
		}
		foreach ( $this->validate as $validate ) {
			//验证条件
			$validate[3] = isset( $validate[3] ) ? $validate[3] : self::EXIST_VALIDATE;
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
						$this->error[] = $error;
					}
				} else if ( method_exists( $VaAction, $method ) ) {
					if ( $VaAction->$method( $field, $value, $params, $data ) !== TRUE ) {
						$this->error[] = $error;
					}
				} else if ( function_exists( $method ) ) {
					if ( $method( $value ) != TRUE ) {
						$this->error[] = $error;
					}
				} else if ( substr( $method, 0, 1 ) == '/' ) {
					//正则表达式
					if ( ! preg_match( $method, $value ) ) {
						$this->error[] = $error;
					}
				}
			}
		}
		\Validate::respond( $this->error );

		return TRUE;
	}

	/**
	 * 自动完成处理
	 *
	 * @param $data 数据
	 * @param int $type 时机
	 *
	 * @return mixed
	 */
	final private function autoOperation( $data, $type ) {
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

			if ( $auto[3] == self::EXIST_AUTO && ! isset( $data[ $auto[0] ] ) ) {
				//有这个字段处理
				continue;
			} else if ( $auto[3] == self::NOT_EMPTY_AUTO && empty( $data[ $auto[0] ] ) ) {
				//不为空时处理
				continue;
			} else if ( $auto[3] == self::EMPTY_AUTO && ! empty( $data[ $auto[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $auto[3] == self::NOT_EXIST_AUTO && isset( $data[ $auto[0] ] ) ) {
				//值不存在时处理
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
	final private function autoFilter( $data, $type ) {
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
	 * 创建数据对象
	 *
	 * @param array $data 生成对象数据
	 *
	 * @return array|bool
	 */
	final private function create( array $data = [ ] ) {
		if ( $data ) {
			//允许填充的数据
			if ( ! $this->allowFill ) {
				$data = [ ];
			} else if ( $this->allowFill[0] != '*' ) {
				$data = Arr::filter_by_keys( $data, $this->allowFill, 0 );
			}
			//禁止填充的数据
			if ( $this->denyFill ) {
				if ( $this->denyFill[0] == '*' ) {
					$data = [ ];
				} else {
					$data = Arr::filter_by_keys( $data, $this->denyFill, 1 );
				}
			}
		}

		$data = $data ?: $this->data;
		//主键为空时删除
		if ( isset( $data[ $this->pk ] ) ) {
			if ( empty( $data[ $this->pk ] ) || ! Db::table( $this->table )->find( intval( $data[ $this->pk ] ) ) ) {
				unset( $data[ $this->pk ] );
			}
		}
		//动作类型  1 插入 2 更新
		$type = empty( $data[ $this->pk ] ) ? self::MODEL_INSERT : self::MODEL_UPDATE;

		//修改更新时间
		if ( $this->timestamps === TRUE ) {
			$data['updated_at'] = NOW;
			if ( $type == self::MODEL_INSERT ) {
				//更新时间
				$data['created_at'] = NOW;
			}
		}
		//字段映射
		$data = $this->parseFieldsMap( $data, $type );
		//自动完成
		$data = $this->autoOperation( $data, $type );
		//自动过滤
		$data = $this->autoFilter( $data, $type );
		//自动验证
		if ( ! $this->autoValidate( $data, $type ) ) {
			return FALSE;
		}

		return $data ?: [ ];
	}

	/**
	 * 更新或添加数据
	 *
	 * @param array $data 批量添加的数据
	 *
	 * @return bool
	 * @throws \Exception
	 */
	final public function save( array $data = [ ] ) {
		if ( ! $data = $this->create( $data ) ) {
			throw new \Exception( '没有操作的数据' );
		}
		//更新条件检测
		$action = empty( $data[ $this->pk ] ) ? 'insertGetId' : 'update';

		return $this->db->$action( $data );
	}

	/**
	 * 删除数据
	 *
	 * @param null $id 编号
	 *
	 * @return bool
	 */
	final public function destory() {
		//没有查询参数如果模型数据中存在主键值,以主键值做删除条件
		if ( empty( $this->data[ $this->pk ] ) ) {
			return FALSE;
		}

		if ( $this->db->delete( $this->data[ $this->pk ] ) ) {
			$this->data( [ ] );

			return TRUE;
		}

		return FALSE;
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
	 * 获取模型值
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function __get( $name ) {
		if ( isset( $this->data[ $name ] ) ) {
			return $this->data[ $name ];
		}
	}

	/**
	 * 设置模型数据值
	 *
	 * @param $name
	 * @param $value
	 */
	public function __set( $name, $value ) {
		$this->data[ $name ] = $value;
	}

	/**
	 * 魔术方法
	 *
	 * @param $method
	 * @param $params
	 *
	 * @return mixed
	 */
	public function __call( $method, $params ) {
		return call_user_func_array( [ $this->db, $method ], $params );
	}

	/**
	 * 调用数据驱动方法
	 *
	 * @param $method
	 * @param $params
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $params ) {
		$model = get_called_class();
		if ( ! isset( self::$links[ $model ] ) ) {
			self::$links[ $model ] = ( new static() );
		}
		$query = self::$links[ $model ];

		return call_user_func_array( [ $query, $method ], $params );
	}
}