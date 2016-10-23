<?php namespace hdphp\db;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use Exception;
use hdphp\model\Model;
use hdphp\traits\HdArrayAccess;

class Query implements \ArrayAccess, \Iterator {
	use HdArrayAccess;
	//数据
	protected $data = [ ];
	//模型类
	protected $model;
	//表名
	protected $table;
	//字段列表
	protected $fields;
	//表主键
	protected $primaryKey;
	//数据库连接
	protected $connection;
	//sql分析实例
	protected $build;

	public function __construct() {
		$this->connection();
	}

	public function connection() {
		$class            = '\hdphp\db\connection\\' . ucfirst( c( 'database.driver' ) );
		$this->connection = new $class;
	}

	/**
	 * 设置操作驱动
	 * @return mixed
	 */
	public function build() {
		if ( ! $this->build ) {
			$driver      = 'hdphp\db\build\\' . ucfirst( c( 'database.driver' ) );
			$this->build = new $driver( $this->getTable() );
		}

		return $this->build;
	}

	//获取表前缀
	protected function getPrefix() {
		return c( 'database.prefix' );
	}

	/**
	 * 设置表
	 *
	 * @param $table
	 *
	 * @return $this
	 */
	public function table( $table ) {
		//模型实例时不允许改表名
		$this->table = $this->table ?: c( 'database.prefix' ) . $table;
		//缓存表字段
		$this->fields = \Schema::getFields( $table );
		//获取表主键
		$this->primaryKey = \Schema::getPrimaryKey( $table );

		return $this;
	}

	/**
	 * 获取表
	 * @return mixed
	 */
	public function getTable() {
		return $this->table;
	}

	/**
	 * 获取表字段
	 * @return array|bool
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * 获取表主键
	 * @return mixed
	 */
	public function getPrimaryKey() {
		return $this->primaryKey;
	}

	/**
	 * 移除表中不存在的字段
	 *
	 * @param $data
	 *
	 * @return array
	 */
	public function filterTableField( array $data ) {
		$new = [ ];
		if ( is_array( $data ) ) {
			foreach ( $data as $name => $value ) {
				if ( key_exists( $name, $this->fields ) ) {
					$new[ $name ] = $value;
				}
			}
		}

		return $new;
	}

	/**
	 * 设置模型
	 *
	 * @param \hdphp\model\Model $model
	 *
	 * @return \hdphp\db\Query
	 */
	public function model( Model $model ) {
		$this->model = $model;

		return $this->table( $this->model->getTableName() );
	}

	/**
	 * 获取模型
	 * @return mixed
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * 结果压入data属性
	 *
	 * @param $data
	 *
	 * @return $this
	 */
	public function data( $data ) {
		$this->data = $data;

		return $this;
	}

	public function toArray() {
		return $this->data;
	}

	/**
	 * 插入并获取自增主键
	 *
	 * @param $data
	 * @param string $action
	 *
	 * @return bool|mixed
	 */
	public function insertGetId( $data, $action = 'insert' ) {
		if ( $result = $this->insert( $data, $action ) ) {
			return $this->connection->getInsertId();
		} else {
			return FALSE;
		}
	}

	/**
	 * 分页查询
	 *
	 * @param $row 每页显示数量
	 * @param int $pageNum
	 *
	 * @return \hdphp\db\Collection
	 */
	public function paginate( $row, $pageNum = 8 ) {
		$obj = unserialize( serialize( $this ) );
		\Page::row( $row )->pageNum( $pageNum )->make( $obj->count() );

		$res     = $this->limit( \Page::limit() )->get();
		$collect = Collection::make( [ ] );
		if ( $res ) {
			//模型数据要转换为数组形式
			$collect->make( $this->getModel() ? $res->toArray() : $res );
		}

		return $collect;
	}

	public function __clone() {
		$this->build = clone $this->build;
	}

	/**
	 * 前台显示页码样式
	 * @return mixed
	 */
	public function links() {
		return \Page::show();
	}

	/**
	 * 无结果集的操作
	 *
	 * @param $sql
	 * @param $params
	 *
	 * @return mixed
	 */
	public function execute( $sql, array $params = [ ] ) {
		$result = $this->connection->execute( $sql, $params );
		$this->build()->reset();

		return $result;
	}

	/**
	 * 有结果集的操作
	 *
	 * @param $sql
	 * @param $params
	 *
	 * @return mixed
	 */
	public function query( $sql, array $params = [ ] ) {
		$data = $this->connection->query( $sql, $params );
		$this->build()->reset();

		return $data;
	}

	/**
	 * 字段值增加
	 *
	 * @param $field
	 * @param int $dec
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function increment( $field, $dec = 1 ) {
		$where = $this->build()->parseWhere();
		if ( empty( $where ) ) {
			throw new Exception( '缺少更新条件' );
		}
		$sql = "UPDATE " . $this->getTable() . " SET {$field}={$field}+$dec " . $where;

		return $this->execute( $sql, $this->build()->getUpdateParams() );
	}

	/**
	 * 字段值减少
	 *
	 * @param $field
	 * @param int $dec
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function decrement( $field, $dec = 1 ) {
		$where = $this->build()->parseWhere();
		if ( empty( $where ) ) {
			throw new Exception( '缺少更新条件' );
		}

		$sql = "UPDATE " . $this->getTable() . " SET {$field}={$field}-$dec " . $where;

		return $this->execute( $sql, $this->build()->getUpdateParams() );
	}

	/**
	 * 更新数据
	 * @param $data
	 *
	 * @return bool|mixed
	 * @throws \Exception
	 */
	public function update( $data ) {
		//移除表中不存在字段
		$data = $this->filterTableField( $data );
		if ( empty( $data ) ) {
			throw new Exception( '缺少更新数据' );
		}
		foreach ( (array) $data as $k => $v ) {
			$this->build()->bindExpression( 'set', $k );
			$this->build()->bindParams( 'values', $v );
		}
		if ( ! $this->build()->getBindExpression( 'where' ) ) {
			//有主键时使用主键做条件
			$pri = $this->getPrimaryKey();
			if ( isset( $data[ $pri ] ) ) {
				$this->where( $pri, $data[ $pri ] );
			}
		}
		//必须有条件才可以更新
		if ( $this->build()->getBindExpression( 'where' ) ) {
			return $this->execute( $this->build()->update(), $this->build()->getUpdateParams() );
		}

		return FALSE;
	}

	/**
	 * 删除记录
	 *
	 * @param mixed $id
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function delete( $id = [ ] ) {
		if ( ! empty( $id ) ) {
			$this->whereIn( $this->getPrimaryKey(), is_array( $id ) ? $id : explode( ',', $id ) );
		}
		//必须有条件才可以删除
		if ( $this->build()->getBindExpression( 'where' ) ) {
			return $this->execute( $this->build()->delete(), $this->build()->getDeleteParams() );
		}

		return FALSE;
	}

	/**
	 * 记录不存在时创建
	 *
	 * @param $param
	 * @param $data
	 *
	 * @return bool
	 */
	function firstOrCreate( $param, $data ) {
		if ( ! $this->where( key( $param ), current( $param ) )->first() ) {
			return $this->insert( $data );
		} else {
			return FALSE;
		}
	}

	/**
	 * 插入数据
	 *
	 * @param $data
	 * @param string $action
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function insert( $data, $action = 'insert' ) {
		//移除非法字段
		$data = $this->filterTableField( $data );
		if ( empty( $data ) ) {
			throw new Exception( '没有数据用于插入' );
		}

		foreach ( $data as $k => $v ) {
			$this->build()->bindExpression( 'field', "`$k`" );
			$this->build()->bindExpression( 'values', '?' );
			$this->build()->bindParams( 'values', $v );
		}

		return $this->execute( $this->build()->$action(), $this->build()->getInsertParams() );
	}

	/**
	 * 替换数据适用于表中有唯一索引的字段
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function replace( $data ) {
		return $this->insertGetId( $data, 'replace' );
	}

	/**
	 * 根据主键查找一条数据
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function find( $id ) {
		if ( $id ) {
			$this->where( $this->getPrimaryKey(), $id );
			if ( $data = $this->query( $this->build()->select(), $this->build()->getSelectParams() ) ) {
				$res = $data ? $data[0] : [ ];
				if ( $model = $this->getModel() ) {
					$instance = clone $model;

					return $instance->data( $res );
				} else {
					return $res;
				}
			}
		}
	}

	/**
	 * 查找一条数据
	 * @return \hdphp\db\Query
	 */
	public function first() {
		if ( $data = $this->query( $this->build()->select(), $this->build()->getSelectParams() ) ) {
			$res = $data ? $data[0] : [ ];
			if ( $model = $this->getModel() ) {
				$instance = clone $model;

				return $instance->data( $res );
			} else {
				return $res;
			}
		}
	}

	/**
	 * 查询一个字段
	 *
	 * @param $field
	 *
	 * @return mixed
	 */
	public function pluck( $field ) {
		$data   = $this->query( $this->build()->select(), $this->build()->getSelectParams() );
		$result = $data ? $data[0] : [ ];
		if ( ! empty( $result ) ) {
			return $result[ $field ];
		}
	}

	/**
	 * 查询集合
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	public function get( array $field = [ ] ) {
		if ( ! empty( $field ) ) {
			$this->field( $field );
		}
		if ( $results = $this->query( $this->build()->select(), $this->build()->getSelectParams() ) ) {
			if ( $model = $this->getModel() ) {
				$Collection = Collection::make( [ ] );
				foreach ( $results as $k => $v ) {
					$instance         = clone $model;
					$Collection[ $k ] = $instance->data( $v );
				}

				return $Collection;
			} else {
				return $results;
			}
		}
	}

	/**
	 * 获取字段列表
	 *
	 * @param $field
	 *
	 * @return array|mixed
	 */
	public function lists( $field ) {
		$result = $this->query( $this->build()->select(), $this->build()->getSelectParams() );
		if ( $result ) {
			$data  = [ ];
			$field = explode( ',', $field );
			switch ( count( $field ) ) {
				case 1:
					foreach ( $result as $row ) {
						$data[] = $row[ $field[0] ];
					}
					break;
				case 2:
					foreach ( $result as $v ) {
						$data[ $v[ $field[0] ] ] = $v[ $field[1] ];
					}
					break;
				default:
					foreach ( $result as $v ) {
						$data[ $v[ $field[0] ] ] = $v;
					}
					break;
			}

			return $data;
		}
	}

	/**
	 * 设置结果集字段
	 *
	 * @param $field
	 *
	 * @return \hdphp\db\connection\DbInterface
	 */
	public function field( $field ) {
		$field = is_array( $field ) ? $field : explode( ',', $field );
		foreach ( (array) $field as $k => $v ) {
			$this->build()->bindExpression( 'field', $v );
		}

		return $this;
	}

	/**
	 * 分组查询
	 * @return \hdphp\db\connection\DbInterface
	 */
	public function groupBy() {
		$this->build()->bindExpression( 'groupBy', func_get_arg( 0 ) );

		return $this;
	}

	public function having() {
		$args = func_get_args();
		$this->build()->bindExpression( 'having', $args[0] . $args[1] . ' ? ' );
		$this->build()->bindParams( 'having', $args[2] );

		return $this;
	}

	public function orderBy() {
		$args = func_get_args();
		$this->build()->bindExpression( 'orderBy', $args[0] . " " . ( empty( $args[1] ) ? ' ASC ' : " $args[1]" ) );

		return $this;
	}

	public function limit() {
		$args = func_get_args();
		$this->build()->bindExpression( 'limit', $args[0] . " " . ( empty( $args[1] ) ? '' : ",{$args[1]}" ) );

		return $this;
	}

	public function count( $field = '*' ) {
		$this->build()->bindExpression( 'field', "count($field) AS m" );
		$data = $this->first();

		return $data ? $data['m'] : '';
	}

	public function max( $field ) {
		$this->build()->bindExpression( 'field', "max({$field}) AS m" );
		$data = $this->first();

		return $data ? $data['m'] : '';
	}

	public function min( $field ) {
		$this->build()->bindExpression( 'field', "min({$field}) AS m" );
		$data = $this->first();

		return $data ? $data['m'] : '';
	}

	public function avg( $field ) {
		$this->build()->bindExpression( 'field', "avg({$field}) AS m" );
		$data = $this->first();

		return $data ? $data['m'] : '';
	}

	public function sum( $field ) {
		$this->build()->bindExpression( 'field', "sum({$field}) AS m" );
		$data = $this->first();

		return $data ? $data['m'] : '';
	}

	public function logic( $login ) {
		//如果上一次设置了and或or语句时忽略
		$expression = $this->build()->getBindExpression( 'where' );
		if ( empty( $expression ) || preg_match( '/^\s*(OR|AND)\s*$/i', array_pop( $expression ) ) ) {
			return FALSE;
		}

		$this->build()->bindExpression( 'where', trim( $login ) );

		return $this;
	}

	public function where() {
		$this->logic( 'AND' );
		$args = func_get_args();
		switch ( count( $args ) ) {
			case 1:
				$this->build()->bindExpression( 'where', $args[0] );
				break;
			case 2:
				$this->build()->bindExpression( 'where', "{$args[0]} = ?" );
				$this->build()->bindParams( 'where', $args[1] );
				break;
			case 3:
				$this->build()->bindExpression( 'where', "{$args[0]} {$args[1]} ?" );
				$this->build()->bindParams( 'where', $args[2] );
				break;
		}

		return $this;
	}

	//预准备whereRaw
	public function whereRaw( $sql, array $params = [ ] ) {
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', $sql );
		foreach ( $params as $p ) {
			$this->build()->bindParams( 'where', $p );
		}

		return $this;
	}

	public function orWhere() {
		$this->logic( 'OR' );
		call_user_func_array( [ $this, 'where' ], func_get_args() );

		return $this;
	}

	public function andWhere() {
		$this->build()->bindExpression( 'where', ' AND ' );
		call_user_func_array( [ $this, 'where' ], func_get_args() );

		return $this;
	}

	public function whereNull( $field ) {
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', "$field IS NULL" );

		return $this;
	}

	public function whereNotNull( $field ) {
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', "$field IS NOT NULL" );

		return $this;
	}

	public function whereIn( $field, $params ) {
		if ( ! is_array( $params ) || empty( $params ) ) {
			throw  new Exception( 'whereIn 参数错误' );
		}
		$this->logic( 'AND' );
		$where = '';
		foreach ( $params as $value ) {
			$where .= '?,';
			$this->build()->bindParams( 'where', $value );
		}
		$this->build()->bindExpression( 'where', " $field IN (" . substr( $where, 0, - 1 ) . ")" );

		return $this;
	}

	public function whereNotIn( $field, $params ) {
		if ( ! is_array( $params ) || empty( $params ) ) {
			throw  new Exception( 'whereIn 参数错误' );
		}
		$this->logic( 'AND' );
		$where = '';
		foreach ( $params as $value ) {
			$where .= '?,';
			$this->build()->bindParams( 'where', $value );
		}
		$this->build()->bindExpression( 'where', " $field NOT IN (" . substr( $where, 0, - 1 ) . ")" );

		return $this;
	}

	public function whereBetween( $field, $params ) {
		if ( ! is_array( $params ) || empty( $params ) ) {
			throw  new Exception( 'whereIn 参数错误' );
		}
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', " $field BETWEEN  ? AND ? " );
		$this->build()->bindParams( 'where', $params[0] );
		$this->build()->bindParams( 'where', $params[1] );

		return $this;
	}

	public function whereNotBetween( $field, $params ) {
		if ( ! is_array( $params ) || empty( $params ) ) {
			throw  new Exception( 'whereIn 参数错误' );
		}
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', " $field NOT BETWEEN  ? AND ? " );
		$this->build()->bindParams( 'where', $params[0] );
		$this->build()->bindParams( 'where', $params[1] );

		return $this;
	}

	/**
	 * 多表内连接
	 * @return \hdphp\db\connection\DbInterface
	 */
	public function join() {
		$args = func_get_args();
		$this->build()->bindExpression( 'join', " INNER JOIN " . $this->getPrefix() . "{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}" );

		return $this;
	}

	/**
	 * 多表左外连接
	 * @return \hdphp\db\connection\DbInterface
	 */
	public function leftJoin() {
		$args = func_get_args();
		$this->build()->bindExpression( 'join', " LEFT JOIN " . $this->getPrefix() . "{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}" );

		return $this;
	}

	/**
	 * 多表右外连接
	 * @return \hdphp\db\connection\DbInterface
	 */
	public function rightJoin() {
		$args = func_get_args();
		$this->build()->bindExpression( 'join', " RIGHT JOIN " . $this->getPrefix() . "{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}" );

		return $this;
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
		if ( substr( $method, 0, 5 ) == 'getBy' ) {
			$field = preg_replace( '/.[A-Z]/', '_\1', substr( $method, 5 ) );
			$field = strtolower( $field );

			return $this->where( $field, current( $params ) )->first();
		}

		return call_user_func_array( [ $this->connection, $method ], $params );
	}

	/**
	 * 获取查询参数
	 *
	 * @param $type where field等
	 *
	 * @return mixed
	 */
	public function getQueryParams( $type ) {
		return $this->build()->getBindExpression( $type );
	}

}