<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace hdphp\db;

use hdphp\db\Connection;
use Exception;

class Query {
	//数据库连接
	protected $connection;
	//sql分析实例
	protected $build;

	public function __construct( Connection $connection ) {
		$this->connection = $connection;
	}

	public function build() {
		if ( ! $this->build ) {
			$driver      = 'hdphp\db\build\\' . ucfirst( Config::get( 'database.driver' ) );
			$this->build = new $driver( $this->connection );
		}

		return $this->build;
	}

	//获取表前缀
	protected function getPrefix() {
		return \Config::get( 'database.prefix' );
	}

	public function replaceGetId( $data ) {
		$pri = $this->connection->getPrimaryKey();
		//主键为空或0时删除主键
		if ( isset( $data[ $pri ] ) && empty( $data[ $pri ] ) ) {
			unset( $data[ $pri ] );
		}

		return $this->insertGetId( $data, 'replace' );
	}

	public function insertGetId( $data, $action = 'insert' ) {
		if ( $result = $this->insert( $data, $action ) ) {
			return $this->connection->getInsertId();
		} else {
			return FALSE;
		}
	}

	public function increment( $field, $dec = 1 ) {
		$where = $this->build()->parseWhere();
		if ( empty( $where ) ) {
			throw new Exception( '缺少更新条件' );
		}
		$sql = "UPDATE " . $this->connection->getTable() . " SET {$field}={$field}+$dec " . $where;

		return $this->connection->execute( $sql, $this->build()->getUpdateParams() );
	}

	public function decrement( $field, $dec = 1 ) {
		$where = $this->build()->parseWhere();
		if ( empty( $where ) ) {
			throw new Exception( '缺少更新条件' );
		}

		$sql = "UPDATE " . $this->connection->getTable() . " SET {$field}={$field}-$dec " . $where;

		return $this->connection->execute( $sql, $this->build()->getUpdateParams() );
	}

	public function update( $data ) {
		//移除表中不存在字段
		$data = $this->connection->filterTableField( $data );
		foreach ( $data as $k => $v ) {
			$this->build()->bindExpression( 'set', $k );
			$this->build()->bindParams( 'values', $v );
		}
		if ( ! $this->build()->getBindExpression( 'where' ) ) {
			//有主键时使用主键做条件
			$pri = $this->connection->getPrimaryKey();
			if ( isset( $data[ $pri ] ) ) {
				$this->where( $pri, '=', $data[ $pri ] );
			}
		}

		return $this->connection->execute( $this->build()->update(), $this->build()->getUpdateParams() );
	}

	/**
	 * 删除记录
	 *
	 * @param string $id
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function delete( $id = '' ) {
		if ( ! empty( $id ) ) {
			$this->whereIn( $this->connection->getPrimaryKey(), is_array( $id ) ? $id : explode( ',', $id ) );
		}

		return $this->connection->execute( $this->build()->delete(), $this->build()->getDeleteParams() );
	}

	//记录不存在时创建
	function firstOrCreate( $param, $data ) {
		if ( ! $this->where( key( $param ), current( $param ) )->first() ) {
			return $this->insert( $data );
		} else {
			return FALSE;
		}
	}

	public function insert( $data, $action = 'insert' ) {
		//移除非法字段
		$data = $this->connection->filterTableField( $data );
		if ( empty( $data ) ) {
			throw new Exception( '没有数据用于插入,请检查字段名' );
		}

		foreach ( $data as $k => $v ) {
			$this->build()->bindExpression( 'field', "`$k`" );
			$this->build()->bindExpression( 'values', '?' );
			$this->build()->bindParams( 'values', $v );
		}

		return $this->connection->execute( $this->build()->$action(), $this->build()->getInsertParams() );
	}

	public function replace( $data ) {
		return $this->insert( $data, 'replace' );
	}

	/**
	 * 根据主键查找一条记录
	 *
	 * @param $id
	 *
	 * @return array|null
	 */
	public function find( $id ) {
		$pri = $this->connection->getPrimaryKey();
		if ( $pri && $id ) {
			$data = $this->where( $pri, '=', $id )->first();

			return $data;
		}
	}

	public function first( $id = NULL ) {
		if ( $id ) {
			$this->where( $this->connection->getPrimaryKey(), $id );
		}
		$data = $this->get();

		return $data ? $data[0] : [ ];
	}

	public function get( array $field = [ ] ) {
		if ( ! empty( $field ) ) {
			$this->field( $field );
		}

		return $this->connection->query( $this->build()->select(), $this->build()->getSelectParams() );
	}

	public function pluck( $field ) {
		$result = $this->first();
		if ( ! empty( $result ) ) {
			return $result[ $field ];
		}
	}

	public function lists( $field ) {
		$result = $this->field($field)->get();
		$data   = [ ];
		if ( ! empty( $result ) ) {
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

		return [ ];
	}

	public function field( $field ) {
		$field = is_array( $field ) ? $field : explode( ',', $field );
		foreach ( (array) $field as $k => $v ) {
			$this->build()->bindExpression( 'field', $v );
		}

		return $this->connection;
	}

	public function groupBy() {
		$this->build()->bindExpression( 'groupBy', func_get_arg( 0 ) );

		return $this->connection;
	}

	public function having() {
		$args = func_get_args();
		$this->build()->bindExpression( 'having', $args[0] . $args[1] . ' ? ' );
		$this->build()->bindParams( 'having', $args[2] );

		return $this->connection;
	}

	public function orderBy() {
		$args = func_get_args();
		$this->build()->bindExpression( 'orderBy', $args[0] . " " . ( empty( $args[1] ) ? ' ASC ' : " $args[1]" ) );

		return $this->connection;
	}

	public function limit() {
		$args = func_get_args();
		$this->build()->bindExpression( 'limit', $args[0] . " " . ( empty( $args[1] ) ? '' : ",{$args[1]}" ) );

		return $this->connection;
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

		return $this->connection;
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

		return $this->connection;
	}

	//预准备whereRaw
	public function whereRaw( $sql, array $params = [ ] ) {
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', $sql );
		foreach ( $params as $p ) {
			$this->build()->bindParams( 'where', $p );
		}

		return $this->connection;
	}

	public function orWhere() {
		$this->logic( 'OR' );
		call_user_func_array( [ $this, 'where' ], func_get_args() );

		return $this->connection;
	}

	public function andWhere() {
		$this->build()->bindExpression( 'where', ' AND ' );
		call_user_func_array( [ $this, 'where' ], func_get_args() );

		return $this->connection;
	}

	public function whereNull( $field ) {
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', "$field IS NULL" );

		return $this->connection;
	}

	public function whereNotNull( $field ) {
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', "$field IS NOT NULL" );

		return $this->connection;
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

		return $this->connection;
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

		return $this->connection;
	}

	public function whereBetween( $field, $params ) {
		if ( ! is_array( $params ) || empty( $params ) ) {
			throw  new Exception( 'whereIn 参数错误' );
		}
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', " $field BETWEEN  ? AND ? " );
		$this->build()->bindParams( 'where', $params[0] );
		$this->build()->bindParams( 'where', $params[1] );

		return $this->connection;
	}

	public function whereNotBetween( $field, $params ) {
		if ( ! is_array( $params ) || empty( $params ) ) {
			throw  new Exception( 'whereIn 参数错误' );
		}
		$this->logic( 'AND' );
		$this->build()->bindExpression( 'where', " $field NOT BETWEEN  ? AND ? " );
		$this->build()->bindParams( 'where', $params[0] );
		$this->build()->bindParams( 'where', $params[1] );

		return $this->connection;
	}

	public function join() {
		$args = func_get_args();
		$this->build()->bindExpression( 'join', " INNER JOIN " . $this->getPrefix() . "{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}" );

		return $this->connection;
	}

	public function leftJoin() {
		$args = func_get_args();
		$this->build()->bindExpression( 'join', " LEFT JOIN " . $this->getPrefix() . "{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}" );

		return $this->connection;
	}

	public function rightJoin() {
		$args = func_get_args();
		$this->build()->bindExpression( 'join', " RIGHT JOIN " . $this->getPrefix() . "{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}" );

		return $this->connection;
	}

	public function __call( $method, $params ) {
		if ( substr( $method, 0, 5 ) == 'getBy' ) {
			$field = preg_replace( '/.[A-Z]/', '_\1', substr( $method, 5 ) );
			$field = strtolower( $field );

			return $this->where( $field, '=', current( $params ) )->first();
		}
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

	public function sql( $sql ) {
		$result = preg_split( '/;(\r|\n)/is', $sql );
		foreach ( (array) $result as $r ) {
			if ( ! $this->connection->execute( $r ) ) {
				return FALSE;
			}
		}

		return TRUE;
	}

}