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
use houdunwang\database\Schema;
use houdunwang\db\Db;

/**
 * 表结构生成器
 * Class Blueprint
 *
 * @package hdphp\database
 */
class Blueprint
{
    //字段结构语句
    protected $instruction = [];

    //不加前缀的表
    protected $noPreTable;

    //数据表
    protected $table;

    //添加或修改的字段
    protected $field;

    //表注释
    protected $tableComment = '';

    public function __construct($table, $comment = '')
    {
        $this->noPreTable   = $table;
        $this->table        = Config::get('database.prefix').$table;
        $this->tableComment = $comment;
    }

    /**
     * 添加索引
     *
     * @param $field 字段
     */
    public function index($field)
    {
        $sql = "ALTER TABLE `{$this->table}` ADD INDEX {$field} ( `{$field}` )";
        Db::execute($sql);
    }

    /**
     * 添加唯一索引
     *
     * @param $field 字段
     */
    public function unique($field)
    {
        $sql = "ALTER TABLE `{$this->table}` ADD UNIQUE ( `{$field}` )";
        Db::execute($sql);
    }

    //新建表
    public function create()
    {
        $sql         = "CREATE TABLE ".$this->table.'(';
        $instruction = [];
        foreach ($this->instruction as $n) {
            if (isset($n['unsigned'])) {
                $n['sql'] .= " unsigned ";
            }
            if ( ! isset($n['null'])) {
                $n['sql'] .= ' NOT NULL';
            }
            if (isset($n['default'])) {
                $n['sql'] .= " DEFAULT ".$n['default'];
            }
            if (isset($n['comment'])) {
                $n['sql'] .= " COMMENT '{$n['comment']}'";
            }
            $instruction[] = $n['sql'];
        }
        $sql .= implode(',', $instruction)
            .") CHARSET UTF8  COMMENT='{$this->tableComment}'";

        return Db::execute($sql);
    }

    //修改字段
    public function change()
    {
        $sql = 'ALTER TABLE '.$this->table." MODIFY ";
        foreach ($this->instruction as $n) {
            if (isset($n['unsigned'])) {
                $n['sql'] .= " unsigned ";
            }
            if ( ! isset($n['null'])) {
                $n['sql'] .= ' NOT NULL';
            }
            if (isset($n['default'])) {
                $n['sql'] .= " DEFAULT ".$n['default'];
            }
            if (isset($n['comment'])) {
                $n['sql'] .= " COMMENT '{$n['comment']}'";
            }
            $s = $sql.$n['sql'];

            return Db::execute($s);
        }
    }

    //添加字段
    public function add()
    {
        $sql = 'ALTER TABLE '.$this->table." ADD ";
        foreach ($this->instruction as $n) {
            if ( ! Schema::fieldExists($n['field'], $this->noPreTable)) {
                if (isset($n['unsigned'])) {
                    $n['sql'] .= " unsigned ";
                }
                if ( ! isset($n['null'])) {
                    $n['sql'] .= ' NOT NULL';
                }
                if (isset($n['default'])) {
                    $n['sql'] .= " DEFAULT ".$n['default'];
                }
                if (isset($n['comment'])) {
                    $n['sql'] .= " COMMENT '{$n['comment']}'";
                }
                $s = $sql.$n['sql'];

                return Db::execute($s);
            }
        }
    }

    public function increments($field)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." INT PRIMARY KEY AUTO_INCREMENT ",
        ];

        return $this;
    }

    public function timestamps()
    {
        $this->instruction[] = [
            'field' => 'created_at',
            'sql'   => " created_at datetime COMMENT '创建时间' ",
        ];
        $this->instruction[] = [
            'field' => 'updated_at',
            'sql'   => " updated_at datetime COMMENT '更新时间'",
        ];
    }

    public function tinyInteger($field)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." TINYINT ",
        ];

        return $this;
    }

    public function enum($field, $data)
    {
        $this->field                = $field;
        $this->instruction[]['sql'] = $field." enum('".implode("','", $data)
            ."') ";

        return $this;
    }

    public function integer($field)
    {
        $this->field                = $field;
        $this->instruction[]['sql'] = $field." INT ";

        return $this;
    }

    public function datetime($field)
    {
        $this->field                = $field;
        $this->instruction[]['sql'] = $field." DATETIME ";

        return $this;
    }

    public function date($field)
    {
        $this->field                = $field;
        $this->instruction[]['sql'] = $field." DATE ";

        return $this;
    }

    public function smallint($field)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." SMALLINT ",
        ];

        return $this;
    }

    public function mediumint($field)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." MEDIUMINT ",
        ];

        return $this;
    }

    public function decimal($field, $len, $de)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." decimal($len,$de) ",
        ];

        return $this;
    }

    public function float($field, $len, $de)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." float($len,$de) ",
        ];

        return $this;
    }

    public function double($field, $len, $de)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." double($len,$de) ",
        ];

        return $this;
    }

    public function char($field, $len = 255)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." char($len) ",
        ];

        return $this;
    }

    public function string($field, $len = 255)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." VARCHAR($len) ",
        ];

        return $this;
    }

    public function text($field)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." TEXT ",
        ];

        return $this;
    }

    public function mediumtext($field)
    {
        $this->field         = $field;
        $this->instruction[] = [
            'field' => $field,
            'sql'   => $field." MEDIUMTEXT ",
        ];

        return $this;
    }

    public function nullAble()
    {
        $this->instruction[count($this->instruction) - 1]['null'] = true;

        return $this;
    }

    public function defaults($value)
    {
        $this->instruction[count($this->instruction) - 1]['default']
            = is_string($value) ? "'$value'" : $value;

        return $this;
    }

    public function comment($value)
    {
        $this->instruction[count($this->instruction) - 1]['comment'] = $value;

        return $this;
    }

    public function unsigned()
    {
        $this->instruction[count($this->instruction) - 1]['unsigned'] = true;

        return $this;
    }

    /**
     * 删除字段
     *
     * @param $field
     */
    public function dropField($field)
    {
        if (Schema::fieldExists($field, $this->noPreTable)) {
            $sql = "ALTER TABLE ".$this->table." DROP ".$field;
            Db::execute($sql);
        }
    }
}