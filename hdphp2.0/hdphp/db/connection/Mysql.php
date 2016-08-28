<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace hdphp\db\connection;

use hdphp\db\Connection;

class Mysql extends Connection {
	public function getDns() {
		return $dns = 'mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['database'];
	}

	public function getTableField() {
		//不是全表名是添加表前缀
		if ( ! empty( $this->fields ) ) {
			return $this->fields;
		}
		$name = Config::get( 'database.database' ) . '.' . $this->table;
		//字段缓存
		if ( ! DEBUG && F( $name, '[get]', 'storage/cache/field' ) ) {
			$data = F( $name, '[get]', 'storage/cache/field' );
		} else {
			$sql = "show columns from " . $this->table;
			if ( ! $result = $this->query( $sql ) ) {
				return FALSE;
			}
			$data = [ ];
			foreach ( $result as $res ) {
				$f ['field']             = $res ['Field'];
				$f ['type']              = $res ['Type'];
				$f ['null']              = $res ['Null'];
				$f ['field']             = $res ['Field'];
				$f ['key']               = ( $res ['Key'] == "PRI" && $res['Extra'] ) || $res ['Key'] == "PRI";
				$f ['default']           = $res ['Default'];
				$f ['extra']             = $res ['Extra'];
				$data [ $res ['Field'] ] = $f;
			}
			DEBUG || F( $name, $data, 'storage/cache/field' );
		}

		return $this->fields = $data;
	}

	public function getPrimaryKey() {
		$fields = $this->getTableField();
		foreach ( $fields as $v ) {
			if ( $v['key'] == 1 ) {
				return $v['field'];
			}
		}
	}

	/**
	 * 获取表字段列表
	 *
	 * @param string $table 表名
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getTableFieldLists( $table ) {
		return $this->query( "DESC " . $this->getPrefix() . $table );
	}

	public function fieldExists( $field, $table ) {
		$fieldLists = $this->query( "DESC " . $this->getPrefix() . $table );
		p( $field );
		foreach ( $fieldLists as $f ) {
			if ( strtolower( $f['Field'] ) == strtolower( $field ) ) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function tableExists( $tableName ) {
		$tables = $this->query( "SHOW TABLES" );

		foreach ( $tables as $k => $table ) {
			$key = 'Tables_in_' . $this->config['database'];
			if ( strtolower( $table[ $key ] ) == strtolower( $this->getPrefix() . $tableName ) ) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function getAllTableInfo() {
		$info = $this->query( "SHOW TABLE STATUS FROM " . $this->config['database'] );
		$arr  = [ ];
		foreach ( $info as $k => $t ) {
			$arr['table'][ $t['Name'] ]['tablename'] = $t['Name'];
			$arr['table'][ $t['Name'] ]['engine']    = $t['Engine'];
			$arr['table'][ $t['Name'] ]['rows']      = $t['Rows'];
			$arr['table'][ $t['Name'] ]['collation'] = $t['Collation'];
			$charset                                 = $arr['table'][ $t['Name'] ]['collation'] = $t['Collation'];
			$charset                                 = explode( "_", $charset );
			$arr['table'][ $t['Name'] ]['charset']   = $charset[0];
			$arr['table'][ $t['Name'] ]['dataFree']  = $t['Data_free'];//碎片大小
			$arr['table'][ $t['Name'] ]['indexSize'] = $t['Index_length'];//索引大小
			$arr['table'][ $t['Name'] ]['dataSize']  = $t['Data_length'];//数据大小
			$arr['table'][ $t['Name'] ]['totalSize'] = $t['Data_free'] + $t['Data_length'] + $t['Index_length'];
		}

		return $arr;
	}

	public function getTableSize( $table ) {
		$table = $this->getPrefix() . $table;
		$sql   = "show table status from " . $this->config['database'];
		$data  = $this->query( $sql );
		foreach ( $data as $v ) {
			if ( $v['Name'] == $table ) {
				return $v['Data_length'] + $v['Index_length'];
			}
		}

		return 0;
	}

	public function repair( $table ) {
		return $this->execute( "REPAIR TABLE `" . $this->getPrefix() . $table . "`" );
	}

	public function optimize( $table ) {
		return $this->execute( "OPTIMIZE TABLE `" . $this->getPrefix() . $table . "`" );
	}

	public function getDataBaseSize() {
		$sql  = "show table status from " . $this->config['database'];
		$data = $this->query( $sql );
		$size = 0;
		foreach ( $data as $v ) {
			$size += $v['Data_length'] + $v['Data_length'] + $v['Index_length'];
		}

		return $size;
	}

	//锁表
	public function lock( $tables ) {
		$lock = '';
		foreach ( explode( ',', $tables ) as $tab ) {
			$lock .= tablename( trim( $tab ) ) . " WRITE,";
		}

		return $this->execute( "LOCK TABLES " . substr( $lock, 0, - 1 ) );
	}

	//解锁表
	public function unlock() {
		return $this->execute( "UNLOCK TABLES" );
	}

	public function truncate() {
		return $this->execute( "truncate " . $this->table );
	}
}