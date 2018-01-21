<?php namespace system\middleware;

use houdunwang\arr\Arr;
use houdunwang\middleware\build\Middleware;
use houdunwang\model\Model;
use system\core\Api;
use system\database\migrations\message;

class DatabaseExecute implements Middleware
{
    //模块标识
    protected $module;
    //查询构造器对象
    protected $query;
    //操作表
    protected $table;
    //不需要验证的表
    protected $filterTable = ['session'];
    //查询构造器模型实例
    protected $model;
    //执行的SQL语句
    protected $sql;

    //执行中间件
    public function run($next, $query)
    {
        //扩展模块处理
//        if (v('module') && v('module.is_system') == 0) {
//            $this->module = v('module.name');
//            $this->query  = $query;
//            $this->table  = $this->query->getTable();
//            $this->model  = $this->query->getModel();
//            $this->sql    = $this->query->getSql();
//            $res          = $this->parseSql();
//            //系统表 new Member()->execute('delete from member')
//            if (substr($res[3], 0, 5) == 'hd_s_') {
//                $this->error('不允许模块操作系统表');
//            }
//        }
        $next();
    }

    /**
     * 分析执行语句
     * 获取动作/表名等如下：
     * [0] => REPLACE INTO hd_session
     * [1] => REPLACE
     * [2] => INTO
     * [3] => hd_session
     *
     * @return string
     */
    protected function parseSql()
    {
        $status = preg_match('/^\s*(UPDATE|DELETE|INSERT|REPLACE)\s+(INTO|FROM)?\s*(\w+)/i', $this->sql, $match);
        if ( ! $status) {
            $this->error('系统已经拦截不允许的操作系统表动作');
        }

        return Arr::valueCase($match, 0);
    }

    protected function error($msg)
    {
        if (IS_AJAX) {
            die(ajax(['valid' => 0, 'message' => $msg]));
        } else {
            die(message($msg, '', 'info'));
        }
    }
}