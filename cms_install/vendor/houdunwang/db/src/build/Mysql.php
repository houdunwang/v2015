<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\db\build;

/**
 * 查询语句组件
 * Class Mysql
 * @package hdphp\db\build
 * @author 向军
 */
class Mysql extends Build {
	public function select() {
		return str_replace( [
			'%field%',
			'%table%',
			'%join%',
			'%where%',
			'%groupBy%',
			'%having%',
			'%orderBy%',
			'%limit%',
			'%lock%'
		], [
			$this->parseField(),
			$this->parseTable(),
			$this->parseJoin(),
			$this->parseWhere(),
			$this->parseGroupBy(),
			$this->parseHaving(),
			$this->parseOrderBy(),
			$this->parseLimit(),
			$this->parseLock()
		], 'SELECT %field% FROM %table% %join% %where% %groupBy% %having% %orderBy% %limit% %lock%' );
	}

	public function insert() {
		return str_replace( [
			'%table%',
			'%field%',
			'%values%'
		], [
			$this->parseTable(),
			$this->parseField(),
			$this->parseValues(),
		], "INSERT INTO %table% (%field%) VALUES(%values%)" );
	}

	public function replace() {
		return str_replace( [
			'%table%',
			'%field%',
			'%values%'
		], [
			$this->parseTable(),
			$this->parseField(),
			$this->parseValues(),
		], "REPLACE INTO %table% (%field%) VALUES(%values%)" );
	}

	public function update() {
		return str_replace( [
			'%table%',
			'%set%',
			'%where%'
		], [
			$this->parseTable(),
			$this->parseSet(),
			$this->parseWhere()
		], "UPDATE %table% %set% %where%" );
	}

	public function delete() {
		return str_replace( [
			'%table%',
			'%using%',
			'%where%'
		], [
			$this->parseTable(),
			$this->parseUsing(),
			$this->parseWhere(),
		], "DELETE FROM %table% %using% %where%" );
	}
}