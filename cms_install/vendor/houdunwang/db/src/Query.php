<?php namespace houdunwang\db;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use Exception;
use houdunwang\ArrayAccess;
use houdunwang\config\Config;
use houdunwang\dir\Dir;
use houdunwang\page\Page;

class Query implements \ArrayAccess, \Iterator
{
    use ArrayAccessIterator;
    //数据
    protected $data = [];
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

    /**
     * 根据驱动创建数据库连接对象
     *
     * @return $this
     */
    public function connection()
    {
        $driver = ucfirst(Config::get('database.driver'));
        //SQL数据库连接引擎
        $class            = '\houdunwang\db\connection\\'.$driver;
        $this->connection = new $class($this);

        //SQL语句编译引擎
        $buile       = 'houdunwang\db\build\\'.$driver;
        $this->build = new $buile($this);

        return $this;
    }

    //获取表前缀
    protected function getPrefix()
    {
        return Config::get('database.prefix');
    }

    /**
     * 设置表
     *
     * @param string $table 表名
     * @param bool   $full  完整表包(含前缀)
     *
     * @return $this
     */
    public function table($table, $full = false)
    {
        //模型实例时不允许改表名
        $this->table = $this->table ?: ($full ? $table : Config::get('database.prefix').$table);
        //缓存表字段
        $this->fields = $this->getFields();
        //获取表主键
        $this->primaryKey = $this->getPrimaryKey();

        return $this;
    }

    /**
     * 获取表
     *
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * 移除表中不存在的字段
     *
     * @param $data
     *
     * @return array
     */
    public function filterTableField(array $data)
    {
        $new = [];
        if (is_array($data)) {
            foreach ($data as $name => $value) {
                if (key_exists($name, $this->fields)) {
                    $new[$name] = $value;
                }
            }
        }

        return $new;
    }

    /**
     * 获取表字段信息
     *
     * @return array|int|mixed|null|void
     * @throws \Exception
     */
    public function getFields()
    {
        static $cache = [];
        if ( ! empty($cache[$this->table])) {
            return $cache[$this->table];
        }
        $isCache = Config::get('database.cache_field');
        //缓存字段
        $data = $isCache ? $this->cache($this->table) : [];
        if (empty($data)) {
            $sql = "show columns from ".$this->table;
            if ( ! $result = $this->connection->query($sql)) {
                throw new Exception("获取{$this->table}表字段信息失败");
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
            $isCache and $this->cache($this->table, $data);
        }
        $cache[$this->table] = $data;

        return $data;
    }

    /**
     * 获取表主键
     *
     * @return mixed
     */
    public function getPrimaryKey()
    {
        static $cache = [];
        if (isset($cache[$this->table])) {
            return $cache[$this->table];
        }
        $fields = $this->getFields($this->table);
        foreach ($fields as $v) {
            if ($v['key'] == 1) {
                return $cache[$this->table] = $v['field'];
            }
        }
    }

    /**
     * 缓存表字段
     *
     * @param      $name
     * @param null $data
     *
     * @return int|null|void
     */
    public function cache($name, $data = null)
    {
        //目录检测
        $dir = Config::get('database.cache_dir');
        Dir::create($dir);
        //缓存文件
        $file = $dir.'/'.($name).'.php';
        //读取数据
        if (is_null($data)) {
            $result = [];
            if (is_file($file)) {
                $result = unserialize(file_get_contents($file));
            }

            return is_array($result) ? $result : [];
        } else {
            //写入数据
            return file_put_contents($file, serialize($data));
        }
    }

    /**
     * 结果压入data属性
     *
     * @param $data
     *
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function toArray()
    {
        return $this->data;
    }

    /**
     * 插入并获取自增主键
     *
     * @param        $data
     * @param string $action
     *
     * @return bool|mixed
     */
    public function insertGetId($data, $action = 'insert')
    {
        if ($result = $this->insert($data, $action)) {
            return $this->connection->getInsertId();
        } else {
            return false;
        }
    }

    /**
     * 分页查询
     *
     * @param int $row     每页显示数量
     * @param int $pageNum 页面数量
     * @param int $count   总数
     *
     * @return mixed
     */
    public function paginate($row, $pageNum = 8, $count = -1)
    {
        $obj = unserialize(serialize($this));
        Page::row($row)->pageNum($pageNum)->make($count == -1 ? $obj->count() : $count);
        $res = $this->limit(Page::limit())->get();
        $this->data($res ?: []);

        return $this;
    }

    /**
     * 前台显示页码样式
     *
     * @return mixed
     */
    public function links()
    {
        return Page::show();
    }

    /**
     * 无结果集的操作
     *
     * @param $sql
     * @param $params
     *
     * @return mixed
     */
    public function execute($sql, array $params = [])
    {
        $result = $this->connection->execute($sql, $params);
        $this->build->reset();

        return $result;
    }

    /**
     * 有结果集的操作
     *
     * @param string $sql
     * @param array  $params
     *
     * @return mixed
     */
    public function query($sql, array $params = [])
    {
        $data = $this->connection->query($sql, $params);
        $this->build->reset();

        return $data;
    }

    /**
     * 字段值增加
     *
     * @param     $field
     * @param int $dec
     *
     * @return mixed
     * @throws \Exception
     */
    public function increment($field, $dec = 1)
    {
        $where = $this->build->parseWhere();
        if (empty($where)) {
            throw new Exception('缺少更新条件');
        }
        $sql = "UPDATE ".$this->getTable()." SET {$field}={$field}+$dec "
               .$where;

        return $this->execute($sql, $this->build->getUpdateParams());
    }

    /**
     * 字段值减少
     *
     * @param     $field
     * @param int $dec
     *
     * @return mixed
     * @throws \Exception
     */
    public function decrement($field, $dec = 1)
    {
        $where = $this->build->parseWhere();
        if (empty($where)) {
            throw new Exception('缺少更新条件');
        }

        $sql = "UPDATE ".$this->getTable()." SET {$field}={$field}-$dec "
               .$where;

        return $this->execute($sql, $this->build->getUpdateParams());
    }

    /**
     * 更新数据
     *
     * @param $data
     *
     * @return bool|mixed
     * @throws \Exception
     */
    public function update($data)
    {
        //移除表中不存在字段
        $data = $this->filterTableField($data);
        if (empty($data)) {
            throw new Exception('缺少更新数据');
        }
        foreach ((array)$data as $k => $v) {
            $this->build->bindExpression('set', $k);
            $this->build->bindParams('values', $v);
        }
        if ( ! $this->build->getBindExpression('where')) {
            //有主键时使用主键做条件
            $pri = $this->getPrimaryKey();
            if (isset($data[$pri])) {
                $this->where($pri, $data[$pri]);
            }
        }
        if ( ! $this->build->getBindExpression('where')) {
            throw new Exception('没有更新条件不允许更新');
        }

        return $this->execute(
            $this->build->update(),
            $this->build->getUpdateParams()
        );
    }

    /**
     * 删除记录
     *
     * @param mixed $id
     *
     * @return bool
     * @throws \Exception
     */
    public function delete($id = [])
    {
        if ( ! empty($id)) {
            $this->whereIn($this->getPrimaryKey(), is_array($id) ? $id : explode(',', $id));
        }
        //必须有条件才可以删除
        if ($this->build->getBindExpression('where')) {
            return $this->execute($this->build->delete(), $this->build->getDeleteParams());
        }

        return false;
    }

    /**
     * 记录不存在时创建
     *
     * @param $param
     * @param $data
     *
     * @return bool
     */
    function firstOrCreate($param, $data)
    {
        if ( ! $this->where(key($param), current($param))->first()) {
            return $this->insert($data);
        } else {
            return false;
        }
    }

    /**
     * 插入数据
     *
     * @param        $data
     * @param string $action
     *
     * @return bool
     * @throws \Exception
     */
    public function insert($data, $action = 'insert')
    {
        //移除非法字段
        $data = $this->filterTableField($data);
        if (empty($data)) {
            throw new Exception('没有数据用于插入');
        }

        foreach ($data as $k => $v) {
            $this->build->bindExpression('field', "`$k`");
            $this->build->bindExpression('values', '?');
            $this->build->bindParams('values', $v);
        }

        return $this->execute(
            $this->build->$action(),
            $this->build->getInsertParams()
        );
    }

    /**
     * 替换数据适用于表中有唯一索引的字段
     *
     * @param $data
     *
     * @return bool
     */
    public function replace($data)
    {
        return $this->insert($data, 'replace');
    }

    /**
     * 根据主键查找一条数据
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        if ($id) {
            $this->where($this->getPrimaryKey(), $id);
            if ($data = $this->query($this->build->select(), $this->build->getSelectParams())) {
                return $data ? $data[0] : [];
            }
        }
    }

    /**
     * 查找一条数据
     *
     * @return array
     */
    public function first()
    {
        $data = $this->query($this->build->select(), $this->build->getSelectParams());

        return $data ? $data[0] : [];
    }

    /**
     * 查询一个字段
     *
     * @param $field
     *
     * @return mixed
     */
    public function pluck($field)
    {
        $data   = $this->query(
            $this->build->select(),
            $this->build->getSelectParams()
        );
        $result = $data ? $data[0] : [];
        if ( ! empty($result)) {
            return $result[$field];
        }
    }

    /**
     * 查询集合
     *
     * @param array $field
     *
     * @return array
     */
    public function get(array $field = [])
    {
        if ( ! empty($field)) {
            $this->field($field);
        }

        return $this->query(
            $this->build->select(),
            $this->build->getSelectParams()
        );
    }

    /**
     * 获取字段列表
     *
     * @param $field
     *
     * @return array|mixed
     */
    public function lists($field)
    {
        $result = $this->query(
            $this->build->select(),
            $this->build->getSelectParams()
        );
        $data   = [];
        if ($result) {
            $field = explode(',', $field);
            switch (count($field)) {
                case 1:
                    foreach ($result as $row) {
                        $data[] = $row[$field[0]];
                    }
                    break;
                case 2:
                    foreach ($result as $v) {
                        $data[$v[$field[0]]] = $v[$field[1]];
                    }
                    break;
                default:
                    foreach ($result as $v) {
                        foreach ($field as $f) {
                            $data[$v[$field[0]]][$f] = $v[$f];
                        }
                    }
                    break;
            }
        }

        return $data;
    }

    /**
     * 设置结果集字段
     *
     * @param string|array $field 字段列表
     *
     * @return $this
     */
    public function field($field)
    {
        $field = is_array($field) ? $field : explode(',', $field);
        foreach ((array)$field as $k => $v) {
            $this->build->bindExpression('field', $v);
        }

        return $this;
    }

    /**
     * 分组查询
     *
     * @return $this
     */
    public function groupBy()
    {
        $this->build->bindExpression('groupBy', func_get_arg(0));

        return $this;
    }

    public function having()
    {
        $args = func_get_args();
        $this->build->bindExpression('having', $args[0].$args[1].' ? ');
        $this->build->bindParams('having', $args[2]);

        return $this;
    }

    public function orderBy()
    {
        $args = func_get_args();
        $this->build->bindExpression(
            'orderBy',
            $args[0]." ".(empty($args[1]) ? ' ASC ' : " $args[1]")
        );

        return $this;
    }

    //排他锁，必须与事务结合使用
    public function lock()
    {
        $this->build->bindExpression('lock', ' FOR UPDATE ');

        return $this;
    }

    public function limit()
    {
        $args = func_get_args();
        $this->build->bindExpression(
            'limit',
            $args[0]." ".(empty($args[1]) ? '' : ",{$args[1]}")
        );

        return $this;
    }

    public function count($field = '*')
    {
        $this->build->bindExpression('field', "count($field) AS m");
        $data = $this->first();

        return intval($data ? $data['m'] : 0);
    }

    public function max($field)
    {
        $this->build->bindExpression('field', "max({$field}) AS m");
        $data = $this->first();

        return intval($data ? $data['m'] : 0);
    }

    public function min($field)
    {
        $this->build->bindExpression('field', "min({$field}) AS m");
        $data = $this->first();

        return intval($data ? $data['m'] : 0);
    }

    public function avg($field)
    {
        $this->build->bindExpression('field', "avg({$field}) AS m");
        $data = $this->first();

        return intval($data ? $data['m'] : 0);
    }

    public function sum($field)
    {
        $this->build->bindExpression('field', "sum({$field}) AS m");
        $data = $this->first();

        return intval($data ? $data['m'] : 0);
    }

    public function logic($login)
    {
        //如果上一次设置了and或or语句时忽略
        $expression = $this->build->getBindExpression('where');
        if (empty($expression)
            || preg_match(
                '/^\s*(OR|AND)\s*$/i',
                array_pop($expression)
            )
        ) {
            return false;
        }

        $this->build->bindExpression('where', trim($login));

        return $this;
    }

    public function where()
    {
        $this->logic('AND');
        $args = func_get_args();
        if (is_array($args[0])) {
            foreach ($args as $v) {
                call_user_func_array([$this, 'where'], $v);
            }
        } else {
            switch (count($args)) {
                case 1:
                    $this->build->bindExpression('where', $args[0]);
                    break;
                case 2:
                    $this->build->bindExpression('where', "{$args[0]} = ?");
                    $this->build->bindParams('where', $args[1]);
                    break;
                case 3:
                    $this->build->bindExpression(
                        'where',
                        "{$args[0]} {$args[1]} ?"
                    );
                    $this->build->bindParams('where', $args[2]);
                    break;
            }
        }

        return $this;
    }

    //预准备whereRaw
    public function whereRaw($sql, array $params = [])
    {
        $this->logic('AND');
        $this->build->bindExpression('where', $sql);
        foreach ($params as $p) {
            $this->build->bindParams('where', $p);
        }

        return $this;
    }

    public function orWhere()
    {
        $this->logic('OR');
        call_user_func_array([$this, 'where'], func_get_args());

        return $this;
    }

    public function andWhere()
    {
        $this->build->bindExpression('where', ' AND ');
        call_user_func_array([$this, 'where'], func_get_args());

        return $this;
    }

    public function whereNull($field)
    {
        $this->logic('AND');
        $this->build->bindExpression('where', "$field IS NULL");

        return $this;
    }

    public function whereNotNull($field)
    {
        $this->logic('AND');
        $this->build->bindExpression('where', "$field IS NOT NULL");

        return $this;
    }

    public function whereIn($field, $params)
    {
        if ( ! is_array($params) || empty($params)) {
            throw  new Exception('whereIn 参数错误');
        }
        $this->logic('AND');
        $where = '';
        foreach ($params as $value) {
            $where .= '?,';
            $this->build->bindParams('where', $value);
        }
        $this->build->bindExpression(
            'where',
            " $field IN (".substr($where, 0, -1).")"
        );

        return $this;
    }

    public function whereNotIn($field, $params)
    {
        if ( ! is_array($params) || empty($params)) {
            throw  new Exception('whereIn 参数错误');
        }
        $this->logic('AND');
        $where = '';
        foreach ($params as $value) {
            $where .= '?,';
            $this->build->bindParams('where', $value);
        }
        $this->build->bindExpression(
            'where',
            " $field NOT IN (".substr($where, 0, -1).")"
        );

        return $this;
    }

    public function whereBetween($field, $params)
    {
        if ( ! is_array($params) || empty($params)) {
            throw  new Exception('whereIn 参数错误');
        }
        $this->logic('AND');
        $this->build->bindExpression('where', " $field BETWEEN  ? AND ? ");
        $this->build->bindParams('where', $params[0]);
        $this->build->bindParams('where', $params[1]);

        return $this;
    }

    public function whereNotBetween($field, $params)
    {
        if ( ! is_array($params) || empty($params)) {
            throw  new Exception('whereIn 参数错误');
        }
        $this->logic('AND');
        $this->build->bindExpression('where', " $field NOT BETWEEN  ? AND ? ");
        $this->build->bindParams('where', $params[0]);
        $this->build->bindParams('where', $params[1]);

        return $this;
    }

    /**
     * 多表内连接
     *
     * @return $this
     */
    public function join()
    {
        $args = func_get_args();
        $this->build->bindExpression(
            'join',
            " INNER JOIN ".$this->getPrefix()
            ."{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}"
        );

        return $this;
    }

    /**
     * 多表左外连接
     *
     * @return $this
     */
    public function leftJoin()
    {
        $args = func_get_args();
        $this->build->bindExpression(
            'join',
            " LEFT JOIN ".$this->getPrefix()
            ."{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}"
        );

        return $this;
    }

    /**
     * 多表右外连接
     *
     * @return $this
     */
    public function rightJoin()
    {
        $args = func_get_args();
        $this->build->bindExpression(
            'join',
            " RIGHT JOIN ".$this->getPrefix()
            ."{$args[0]} {$args[0]} ON {$args[1]} {$args[2]} {$args[3]}"
        );

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
    public function __call($method, $params)
    {
        if (substr($method, 0, 5) == 'getBy') {
            $field = preg_replace('/.[A-Z]/', '_\1', substr($method, 5));
            $field = strtolower($field);

            return $this->where($field, current($params))->first();
        }

        return call_user_func_array([$this->connection, $method], $params);
    }

    /**
     * 获取查询参数
     *
     * @param $type where field等
     *
     * @return mixed
     */
    public function getQueryParams($type)
    {
        return $this->build->getBindExpression($type);
    }
}