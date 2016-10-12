<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace hdphp\database;
/**
 * 表结构生成器
 * Class Blueprint
 * @package hdphp\database
 */
class Blueprint {
	//字段结构语句
	protected $instruction = [ ];

	//数据表
	protected $table;

	public function __construct( $table ) {
		$this->table = c( 'database.prefix' ) . $table;
	}

	//新建表
	public function create() {
		$sql         = "CREATE TABLE " . $this->table . '(';
		$instruction = [ ];
		foreach ( $this->instruction as $n ) {
			if ( isset( $n['unsigned'] ) ) {
				$n['sql'] .= " unsigned ";
			}
			if ( ! isset( $n['null'] ) ) {
				$n['sql'] .= ' NOT NULL';
			}
			if ( isset( $n['default'] ) ) {
				$n['sql'] .= " DEFAULT " . $n['default'];
			}
			if ( isset( $n['comment'] ) ) {
				$n['sql'] .= " COMMENT '{$n['comment']}'";
			}
			$instruction[] = $n['sql'];
		}
		$sql .= implode( ',', $instruction ) . ')CHARSET UTF8';
		Db::execute( $sql );
	}

	//修改字段
	public function change() {
		$sql = 'ALTER TABLE ' . $this->table . " MODIFY ";
		foreach ( $this->instruction as $n ) {
			if ( isset( $n['unsigned'] ) ) {
				$n['sql'] .= " unsigned ";
			}
			if ( ! isset( $n['null'] ) ) {
				$n['sql'] .= ' NOT NULL';
			}
			if ( isset( $n['default'] ) ) {
				$n['sql'] .= " DEFAULT " . $n['default'];
			}
			if ( isset( $n['comment'] ) ) {
				$n['sql'] .= " COMMENT '{$n['comment']}'";
			}
			$s = $sql . $n['sql'];
			Db::execute( $s );
		}

	}

	public function increments( $field ) {
		$this->instruction[]['sql'] = $field . " INT PRIMARY KEY AUTO_INCREMENT ";

		return $this;
	}

	public function timestamps() {
		$this->instruction[]['sql'] = "created_at INT(10) ";
		$this->instruction[]['sql'] = "updated_at INT(10) ";
	}

	public function tinyInteger( $field ) {
		$this->instruction[]['sql'] = $field . " tinyint ";

		return $this;
	}

	public function enum( $field, $data ) {
		$this->instruction[]['sql'] = $field . " enum('" . implode( "','", $data ) . "') ";

		return $this;
	}

	public function integer( $field ) {
		$this->instruction[]['sql'] = $field . " int ";

		return $this;
	}

	public function decimal( $field, $len, $de ) {
		$this->instruction[]['sql'] = $field . " decimal($len,$de) ";

		return $this;
	}

	public function float( $field, $len, $de ) {
		$this->instruction[]['sql'] = $field . " float($len,$de) ";

		return $this;
	}

	public function double( $field, $len, $de ) {
		$this->instruction[]['sql'] = $field . " double($len,$de) ";

		return $this;
	}

	public function char( $field, $len = 255 ) {
		$this->instruction[]['sql'] = $field . " char($len) ";

		return $this;
	}

	public function string( $field, $len = 255 ) {
		$this->instruction[]['sql'] = $field . " VARCHAR($len) ";

		return $this;
	}

	public function text( $field ) {
		$this->instruction[]['sql'] = $field . " TEXT ";

		return $this;
	}

	public function nullable() {
		$this->instruction[ count( $this->instruction ) - 1 ]['null'] = TRUE;

		return $this;
	}

	public function defaults( $value ) {
		$this->instruction[ count( $this->instruction ) - 1 ]['default'] = is_string( $value ) ? "'$value'" : $value;

		return $this;
	}

	public function comment( $value ) {
		$this->instruction[ count( $this->instruction ) - 1 ]['comment'] = $value;

		return $this;
	}

	public function unsigned() {
		$this->instruction[ count( $this->instruction ) - 1 ]['unsigned'] = TRUE;

		return $this;
	}
}