<?php namespace hdphp\db\build;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
/**
 * Class Build
 * @package hdphp\db
 * SELECT %field% FROM %table% JOIN %join% WHERE %where% GROUP BY %group% HAVING %having% ORDER BY %order% LIMIT %limit%
 * INSERT INTO %table% (%field%) VALUES(%values%)
 * REPLACE INTO %table% (%field%) VALUES(%values%)
 * UPDATE %table% SET %set% WHERE %where%
 * DELETE FROM %table% USING  %using% WHERE %where%
 */
abstract class Build {
	//表名
	protected $table;
	//查询参数
	protected $params = [ ];

	abstract public function insert();

	abstract public function replace();

	abstract public function select();

	abstract public function update();

	abstract public function delete();

	public function __construct( $table ) {
		$this->table = $table;
	}


	public function getBindExpression( $name ) {
		return isset( $this->params[ $name ]['expression'] ) ? $this->params[ $name ]['expression'] : [ ];
	}

	//绑定表达式
	public function bindExpression( $name, $expression ) {
		$this->params[ $name ]['expression'][] = $expression;
	}

	//绑定参数
	public function bindParams( $name, $param ) {
		$this->params[ $name ]['parames'][] = $param;
	}

	public function getBindParams( $name ) {
		return isset( $this->params[ $name ]['parames'] ) ? $this->params[ $name ]['parames'] : [ ];
	}

	public function reset() {
		$this->params = [ ];
	}

	public function getSelectParams() {
		$params = [ ];
		$id     = 0;
		//查询参数
		foreach ( [ 'field', 'join', 'where', 'group', 'having', 'order', 'limit' ] as $k ) {
			foreach ( $this->getBindParams( $k ) as $m ) {
				$params[ ++ $id ] = $m;
			}
		}

		return $params;
	}

	public function getInsertParams() {
		$params = [ ];
		$id     = 0;
		//查询参数
		foreach ( [ 'field', 'values' ] as $k ) {
			foreach ( $this->getBindParams( $k ) as $m ) {
				$params[ ++ $id ] = $m;
			}
		}

		return $params;
	}

	public function getUpdateParams() {
		$params = [ ];
		$id     = 0;
		//查询参数
		foreach ( [ 'set', 'values', 'where' ] as $k ) {
			foreach ( $this->getBindParams( $k ) as $m ) {
				$params[ ++ $id ] = $m;
			}
		}

		return $params;
	}

	public function getDeleteParams() {
		$params = [ ];
		$id     = 0;
		//查询参数
		foreach ( [ 'where' ] as $k ) {
			foreach ( $this->getBindParams( $k ) as $m ) {
				$params[ ++ $id ] = $m;
			}
		}

		return $params;
	}

	protected function parseTable() {
		return $this->table;
	}

	protected function parseField() {
		$expression = $this->getBindExpression( 'field' );

		return $expression ? implode( ',', $expression ) : '*';
	}

	protected function parseValues() {
		$values = [ ];
		foreach ( $this->params['values']['expression'] as $k => $v ) {
			$values[] = "?";
		}

		return implode( ',', $values );
	}

	public function parseJoin() {
		$expression = $this->getBindExpression( 'join' );
		$as         = preg_replace( "/^" . c( 'database.prefix' ) . "/", '', $this->parseTable() );

		return $expression ? $as . implode( ' ', $expression ) : '';
	}

	public function parseWhere() {
		if ( $expression = $this->getBindExpression( 'where' ) ) {
			return "WHERE " . implode( ' ', $expression );
		}
	}

	protected function parseGroupBy() {
		if ( $expression = $this->getBindExpression( 'groupBy' ) ) {
			return "GROUP BY " . implode( ',', $expression );
		}
	}

	protected function parseHaving() {
		if ( $expression = $this->getBindExpression( 'having' ) ) {
			return "HAVING " . current( $expression );
		}
	}

	protected function parseOrderBy() {
		if ( $expression = $this->getBindExpression( 'orderBy' ) ) {
			return "ORDER BY " . implode( ',', $expression );
		}
	}

	protected function parseLimit() {
		if ( $expression = $this->getBindExpression( 'limit' ) ) {
			return "LIMIT " . current( $expression );
		}
	}

	protected function parseSet() {
		if ( $expression = $this->getBindExpression( 'set' ) ) {
			$set = '';
			foreach ( $expression as $k => $v ) {
				$set .= "`{$v}`=?,";
			}

			return $set ? 'SET ' . substr( $set, 0, - 1 ) : '';
		}
	}

	protected function parseUsing() {
		if ( $expression = $this->getBindExpression( 'using' ) ) {
			return "USING " . implode( ',', $expression );
		}
	}
}