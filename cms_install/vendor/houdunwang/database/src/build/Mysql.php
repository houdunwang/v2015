<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\database\build;

use houdunwang\config\Config;
use houdunwang\db\Db;

/**
 * 数据库管理
 * Class Mysql
 *
 * @package hdphp\database\build
 * @author  向军
 */
class Mysql
{
    /**
     * 获取表字段信息
     *
     * @param string $table
     *
     * @return array|bool|void
     */
    public function getFields($table)
    {
        $sql = "show columns from ".Config::get('database.prefix').$table;
        if ( ! $result = Db::query($sql)) {
            return [];
        }
        $data = [];
        foreach ((array)$result as $res) {
            $f ['field']           = $res ['Field'];
            $f ['type']            = $res ['Type'];
            $f ['null']            = $res ['Null'];
            $f ['field']           = $res ['Field'];
            $f ['key']             = ($res ['Key'] == "PRI" && $res['Extra'])
                || $res ['Key'] == "PRI";
            $f ['default']         = $res ['Default'];
            $f ['extra']           = $res ['Extra'];
            $data [$res ['Field']] = $f;
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
    public function getPrimaryKey($table)
    {
        $fields = $this->getFields($table);
        foreach ($fields as $v) {
            if ($v['key'] == 1) {
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
    public function drop($table)
    {
        if ($this->tableExists($table)) {
            return Db::execute(
                "DROP TABLE ".Config::get('database.prefix').$table
            );
        }

        return false;
    }

    /**
     * 删除表字段
     *
     * @param $table 表名
     * @param $field 字段名
     *
     * @return bool
     */
    public function dropField($table, $field)
    {
        if ($this->fieldExists($field, $table)) {
            return Db::execute(
                "ALTER TABLE ".Config::get('database.prefix').$table
                .' DROP COLUMN '.$field
            );
        }

        return true;
    }

    /**
     * 修复数据表
     *
     * @param $table
     *
     * @return mixed
     */
    public function repair($table)
    {
        return Db::execute(
            "REPAIR TABLE `".Config::get('database.prefix').$table."`"
        );
    }

    /**
     * 优化表
     *
     * @param $table
     *
     * @return mixed
     */
    public function optimize($table)
    {
        return Db::execute(
            "OPTIMIZE TABLE `".Config::get('database.prefix').$table."`"
        );
    }

    /**
     * 获取数据库大小
     *
     * @param $database
     *
     * @return int
     */
    public function getDataBaseSize($database = '')
    {
        $database = $database ?: Config::get('database.database');
        $sql      = "show table status from ".$database;
        $data     = Db::query($sql);
        $size     = 0;
        foreach ($data as $v) {
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
    public function getTableSize($table)
    {
        $table = Config::get('database.prefix').$table;
        $sql   = "show table status from ".Config::get('database.database');
        $data  = Db::query($sql);
        foreach ($data as $v) {
            if ($v['Name'] == $table) {
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
    public function lock($tables)
    {
        $lock = '';
        foreach (explode(',', $tables) as $tab) {
            $lock .= tablename(trim($tab))." WRITE,";
        }

        return Db::execute("LOCK TABLES ".substr($lock, 0, -1));
    }

    /**
     * 解锁表
     *
     * @return mixed
     */
    public function unlock()
    {
        return Db::execute("UNLOCK TABLES");
    }

    /**
     * 清空表
     *
     * @param $table
     *
     * @return mixed
     */
    public function truncate($table)
    {
        return Db::execute("truncate ".tablename($table));
    }

    /**
     * 获取所有表信息
     *
     * @param $database
     *
     * @return array
     */
    public function getAllTableInfo($database = '')
    {
        $database = $database ?: Config::get('database.database');
        $info     = Db::query("SHOW TABLE STATUS FROM ".$database);
        $arr      = [];
        foreach ((array)$info as $k => $t) {
            $arr['table'][$t['Name']]['tablename'] = $t['Name'];
            $arr['table'][$t['Name']]['engine']    = $t['Engine'];
            $arr['table'][$t['Name']]['rows']      = $t['Rows'];
            $arr['table'][$t['Name']]['collation'] = $t['Collation'];
            $charset
                                                   =
            $arr['table'][$t['Name']]['collation'] = $t['Collation'];
            $charset                               = explode("_", $charset);
            $arr['table'][$t['Name']]['charset']   = $charset[0];
            $arr['table'][$t['Name']]['dataFree']  = $t['Data_free'];//碎片大小
            $arr['table'][$t['Name']]['indexSize'] = $t['Index_length'];//索引大小
            $arr['table'][$t['Name']]['dataSize']  = $t['Data_length'];//数据大小
            $arr['table'][$t['Name']]['totalSize'] = $t['Data_free']
                + $t['Data_length'] + $t['Index_length'];
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
    public function tableExists($tableName)
    {
        $tables = Db::query("SHOW TABLES");

        foreach ($tables as $k => $table) {
            $key = 'Tables_in_'.Config::get('database.database');
            if (strtolower($table[$key]) == strtolower(
                    Config::get('database.prefix').$tableName
                )
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * 字段是否存在
     *
     * @param $field
     * @param $table
     *
     * @return bool
     */
    public function fieldExists($field, $table)
    {
        $fieldLists = Db::query("DESC ".Config::get('database.prefix').$table);
        foreach ((array)$fieldLists as $f) {
            if (strtolower($f['Field']) == strtolower($field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 执行sql
     *
     * @param $sql
     *
     * @return bool
     */
    public function sql($sql)
    {
        $result = preg_split('/;(\r|\n)/is', $sql);
        foreach ((array)$result as $r) {
            Db::execute($r);
        }

        return true;
    }
}