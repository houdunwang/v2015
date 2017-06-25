<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\model\build;

use houdunwang\db\Db;
use houdunwang\validate\build\VaAction;

/**
 * 自动验证
 * Class Validate
 *
 * @package houdunwang\model\build
 */
trait Validate
{
    //自动验证
    protected $validate = [];
    //验证错误
    protected $error = [];

    /**
     * 获取操作错误信息
     *
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param array $error
     */
    public function setError(array $error)
    {
        $this->error = $error;
    }

    /**
     * 自动验证
     *
     * @return bool
     */
    final protected function autoValidate()
    {
        $this->setError([]);
        //验证库
        $VaAction = new VaAction();
        if (empty($this->validate)) {
            return true;
        }
        $data = &$this->original;
        foreach ($this->validate as $validate) {
            //验证条件
            $validate[3] = isset($validate[3]) ? $validate[3] : self::EXIST_VALIDATE;
            if ($validate[3] == self::EXIST_VALIDATE && ! isset($data[$validate[0]])) {
                continue;
            } else if ($validate[3] == self::NOT_EMPTY_VALIDATE && empty($data[$validate[0]])) {
                //不为空时处理
                continue;
            } else if ($validate[3] == self::EMPTY_VALIDATE && ! empty($data[$validate[0]])) {
                //值为空时处理
                continue;
            } else if ($validate[3] == self::NOT_EXIST_VALIDATE && isset($data[$validate[0]])) {
                //值为空时处理
                continue;
            } else if ($validate[3] == self::MUST_VALIDATE) {
                //必须处理
            }
            $validate[4] = isset($validate[4]) ? $validate[4] : self::MODEL_BOTH;
            //验证时间判断
            if ($validate[4] != $this->action() && $validate[4] != self::MODEL_BOTH) {
                continue;
            }
            //字段名
            $field = $validate[0];
            //验证规则
            $actions = explode('|', $validate[1]);
            //错误信息
            $error = $validate[2];
            //表单值
            $value = isset($data[$field]) ? $data[$field] : '';
            foreach ($actions as $action) {
                $info   = explode(':', $action);
                $method = $info[0];
                $params = isset($info[1]) ? $info[1] : '';

                if (method_exists($this, $method)) {
                    //类方法验证
                    if ($this->$method($field, $value, $params, $data) != true) {
                        $this->error[$field] = $error;
                    }
                } else if (method_exists($VaAction, $method)) {
                    if ($VaAction->$method($field, $value, $params, $data) != true) {
                        $this->error[$field] = $error;
                    }
                } else if (function_exists($method)) {
                    if ($method($value) != true) {
                        $this->error[$field] = $error;
                    }
                } else if (substr($method, 0, 1) == '/') {
                    //正则表达式
                    if ( ! preg_match($method, $value)) {
                        $this->error[$field] = $error;
                    }
                }
            }
        }
        \houdunwang\validate\Validate::respond($this->error);

        return $this->error ? false : true;
    }

    /**
     * 自动验证字段值唯一(自动验证使用)
     *
     * @param $field 字段名
     * @param $value 字段值
     * @param $param 参数
     * @param $data  提交数据
     *
     * @return bool 验证状态
     */
    final protected function unique($field, $value, $param, $data)
    {
        //表主键
        $db = Db::table($this->table)->where($field, $value);
        if ($this->action() == self::MODEL_UPDATE) {
            $db->where($this->pk, '<>', $this->data[$this->pk]);
        }
        if (empty($value) || ! $db->get()) {
            return true;
        }
    }
}