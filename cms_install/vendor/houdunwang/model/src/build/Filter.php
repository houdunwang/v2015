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
 * 自动过滤
 * Class Filter
 *
 * @package houdunwang\model\build
 */
trait Filter
{
    //自动过滤
    protected $filter = [];

    /**
     * 自动过滤掉满足条件的字段
     *
     * @return void
     */
    final protected function autoFilter()
    {
        //不存在自动完成规则
        if (empty($this->filter)) {
            return;
        }
        $data = &$this->original;
        foreach ($this->filter as $filter) {
            //验证条件
            $filter[1] = isset($filter[1]) ? $filter[1] : self::EXIST_AUTO;
            //验证时间
            $filter[2] = isset($filter[2]) ? $filter[2] : self::MODEL_BOTH;
            //有这个字段处理
            if ($filter[1] == self::EXIST_FILTER
                && ! isset($data[$filter[0]])
            ) {
                continue;
            } else if ($filter[1] == self::NOT_EMPTY_FILTER
                && empty($data[$filter[0]])
            ) {
                //不为空时处理
                continue;
            } else if ($filter[1] == self::EMPTY_FILTER
                && ! empty($data[$filter[0]])
            ) {
                //值为空时处理
                continue;
            } else if ($filter[1] == self::NOT_EXIST_FILTER
                && isset($data[$filter[0]])
            ) {
                //值为空时处理
                continue;
            } else if ($filter[1] == self::MUST_FILTER) {
                //必须处理
            }
            if ($filter[2] == $this->action()
                || $filter[2] == self::MODEL_BOTH
            ) {
                unset($data[$filter[0]]);
            }
        }

        return true;
    }

}