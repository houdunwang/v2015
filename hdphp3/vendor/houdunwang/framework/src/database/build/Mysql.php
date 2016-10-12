<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace hdphp\database\build;
/**
 * 数据库管理
 * Class Mysql
 * @package hdphp\database\build
 * @author 向军
 */
class Mysql {
	/**
	 * 获取表字段信息
	 *
	 * @param string $table
	 *
	 * @return array|bool|void
	 */
	public function getFields( $table ) {
		$name = c( 'database.database' ) . '.' . $table;
		//字段缓存
		if ( ! c( 'app.debug' ) && f( $name, '[get]', ROOT_PATH . '/storage/cache/field' ) ) {
			$data = f( $name, '[get]', ROOT_PATH . '/storage/cache/field' );
		} else {
			$sql = "show columns from " . c( 'database.prefix' ) . $table;
			if ( ! $result = Db::query( $sql ) ) {
				return;
			}
			$data = [ ];
			foreach ( (array) $result as $res ) {
				$f ['field']             = $res ['Field'];
				$f ['type']              = $res ['Type'];
				$f ['null']              = $res ['Null'];
				$f ['field']             = $res ['Field'];
				$f ['key']               = ( $res ['Key'] == "PRI" && $res['Extra'] ) || $res ['Key'] == "PRI";
				$f ['default']           = $res ['Default'];
				$f ['extra']             = $res ['Extra'];
				$data [ $res ['Field'] ] = $f;
			}
			f( $name, $data, ROOT_PATH . '/storage/cache/field' );
		}

		return $data;
	}

	/**
	 * 获取表主键
	 *
	 * @param $table
	 *
	 * @return mixed
	 */
	public function getPrimaryKey( $table ) {
		$fields = $this->getFields( $table );
		foreach ( $fields as $v ) {
			if ( $v['key'] == 1 ) {
				return $v['field'];
			}
		}
	}

	/**
	 * 删除表
	 *
	 * @param $table
	 *
	 * @return mixed
	 */
	public function drop( $table ) {
		return Db::execute( "DROP TABLE " . c( 'database.prefix' ) . $table );
	}

	/**
	 * 修复数据表
	 *
	 * @param $table
	 *
	 * @return mixed
	 */
	public function repair( $table ) {
		return Db::execute( "REPAIR TABLE `" . $this->getPrefix() . $table . "`" );
	}

	/**
	 * 优化表
	 *
	 * @param $table
	 *
	 * @return mixed
	 */
	public function optimize( $table ) {
		return Db::execute( "OPTIMIZE TABLE `" . $this->getPrefix() . $table . "`" );
	}

	/**
	 * 获取数据库大小
	 * @return int
	 */
	public function getDataBaseSize( $database ) {
		$sql  = "show table status from " . $database;
		$data = Db::query( $sql );
		$size = 0;
		foreach ( $data as $v ) {
			$size += $v['Data_length'] + $v['Data_length'] + $v['Index_length'];
		}

		return $size;
	}

	/**
	 * 获取表大小
	 *
	 * @param $table
	 *
	 * @return int
	 */
	public function getTableSize( $table ) {
		$table = c( 'database.prefix' ) . $table;
		$sql   = "show table status from " . c( 'database.database' );
		$data  = Db::query( $sql );
		foreach ( $data as $v ) {
			if ( $v['Name'] == $table ) {
				return $v['Data_length'] + $v['Index_length'];
			}
		}

		return 0;
	}

	/**
	 * 锁表
	 *
	 * @param $tables
	 *
	 * @return mixed
	 */
	public function lock( $tables ) {
		$lock = '';
		foreach ( explode( ',', $tables ) as $tab ) {
			$lock .= tablename( trim( $tab ) ) . " WRITE,";
		}

		return Db::execute( "LOCK TABLES " . substr( $lock, 0, - 1 ) );
	}

	/**
	 * 解锁表
	 * @return mixed
	 */
	public function unlock() {
		return Db::execute( "UNLOCK TABLES" );
	}

	/**
	 * 清空表
	 * @return mixed
	 */
	public function truncate( $table ) {
		return Db::execute( "truncate " . tablename( $table ) );
	}

	/**
	 * 获取所有表信息
	 * @return array
	 */
	public function getAllTableInfo( $database ) {
		$info = Db::query( "SHOW TABLE STATUS FROM " . $database );
		$arr  = [ ];
		foreach ( (array) $info as $k => $t ) {
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

	/**
	 * 检测表是否存在
	 *
	 * @param $tableName
	 *
	 * @return bool
	 */
	public function tableExists( $tableName ) {
		$tables = Db::query( "SHOW TABLES" );

		foreach ( $tables as $k => $table ) {
			$key = 'Tables_in_' . c( 'database.database' );
			if ( strtolower( $table[ $key ] ) == strtolower( c( 'database.prefix' ) . $tableName ) ) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * 字段是否存在
	 *
	 * @param $field
	 * @param $table
	 *
	 * @return bool
	 */
	public function fieldExists( $field, $table ) {
		$fieldLists = Db::query( "DESC " . c( 'database.prefix' ) . $table );
		foreach ( (array) $fieldLists as $f ) {
			if ( strtolower( $f['Field'] ) == strtolower( $field ) ) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * 执行sql
	 *
	 * @param $sql
	 *
	 * @return bool
	 */
	public function sql( $sql ) {
		$result = preg_split( '/;(\r|\n)/is', $sql );
		foreach ( (array) $result as $r ) {
			Db::execute( $r );
		}

		return TRUE;
	}
}