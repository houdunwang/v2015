<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\session;

class MysqlHandler implements AbSession {

	private $link; //Mysql数据库连接
	private $table; //SESSION表
	private $expire; //过期时间

	/**
	 * 构造函数
	 */
	public function __construct() {
	}

	//初始
	public function make() {
		$options  = Config::get( 'session.mysql' );
		//数据表
		$this->table = Config::get( 'database.prefix' ) . $options['table'];
		//过期时间
		$expire       = Config::get( 'session.expire' );
		$this->expire = $expire ? $expire : 864000;

		//连接Mysql
		//		$this->link = mysql_connect( $database['host'], $database['user'], $database['password'] );
		$this->link = Db::table( Config::get( 'session.mysql.table' ) );
		session_set_save_handler( [ &$this, "open" ], [ &$this, "close" ], [ &$this, "read" ], [ &$this, "write" ], [ &$this, "destroy" ], [
			&$this,
			"gc"
		] );
	}

	/**
	 * session_start()时执行
	 * @return bool
	 */
	public function open() {
		return TRUE;
	}

	/**
	 * 读取SESSION 数据
	 *
	 * @param string $id
	 *
	 * @return string
	 */
	public function read( $id ) {
		$data = $this->link->where( 'sessid', $id )->where( 'atime', '>', time() - $this->expire )->pluck( 'data' );

		return $data ?: '';
	}

	/**
	 * 写入SESSION
	 *
	 * @param key $id key名称
	 * @param mixed $data 数据
	 *
	 * @return bool
	 */
	public function write( $id, $data ) {
		$sql = "REPLACE INTO " . $this->table . "(sessid,data,atime) ";
		$sql .= "VALUES('$id','$data'," . time() . ')';

		return $this->link->execute( $sql );
	}

	/**
	 * 卸载SESSION
	 *
	 * @param type $id
	 *
	 * @return type
	 */
	public function destroy( $id ) {
		$sql = "DELETE FROM " . $this->table . " WHERE sessid='$id'";

		return $this->link->execute( $sql );
	}

	/**
	 * SESSION垃圾处理
	 * @return boolean
	 */
	public function gc() {

		$sql = "DELETE FROM " . $this->table . " WHERE atime<" . ( time() - $this->expire ) . " AND sessid<>'" . session_id() . "'";

		return $this->link->execute( $sql );
	}


	//关闭SESSION
	public function close() {
		if ( mt_rand( 1, 10 ) == 1 ) {
			$this->gc();
		}

	}

	public function __destruct() {
	}
}
