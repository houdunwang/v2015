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


/**
 * 自动完成
 * Class Auto
 *
 * @package houdunwang\model\build
 */
trait Auto
{
    //自动完成
    protected $auto = [];

    /**
     * 自动完成处理
     *
     * @return void/mixed
     */
    final protected function autoOperation()
    {
        //不存在自动完成规则
        if (empty($this->auto)) {
            return;
        }
        $data =& $this->original;
        foreach ($this->auto as $name => $auto) {
            //处理类型
            $auto[2] = isset($auto[2]) ? $auto[2] : 'string';
            //验证条件
            $auto[3] = isset($auto[3]) ? $auto[3] : self::EXIST_AUTO;
            //验证时间
            $auto[4] = isset($auto[4]) ? $auto[4] : self::MODEL_BOTH;

            if ($auto[3] == self::EXIST_AUTO && ! isset($data[$auto[0]])) {
                //有这个字段处理
                continue;
            } else if ($auto[3] == self::NOT_EMPTY_AUTO
                       && empty($data[$auto[0]])
            ) {
                //不为空时处理
                continue;
            } else if ($auto[3] == self::EMPTY_AUTO
                       && ! empty($data[$auto[0]])
            ) {
                //值为空时处理
                continue;
            } else if ($auto[3] == self::NOT_EXIST_AUTO
                       && isset($data[$auto[0]])
            ) {
                //值不存在时处理
                continue;
            } else if ($auto[3] == self::MUST_AUTO) {
                //必须处理
            }
            if ($auto[4] == $this->action()
                || $auto[4] == self::MODEL_BOTH
            ) {
                //为字段设置默认值
                if (empty($data[$auto[0]])) {
                    $data[$auto[0]] = '';
                }
                if ($auto[2] == 'method') {
                    $data[$auto[0]] =call_user_func_array([$this,$auto[1]],[$data[$auto[0]],$data]);
                } else if ($auto[2] == 'function') {
                    $data[$auto[0]] = $auto[1]($data[$auto[0]]);
                } else if ($auto[2] == 'string') {
                    $data[$auto[0]] = $auto[1];
                }
            }
        }

        return true;
    }
}