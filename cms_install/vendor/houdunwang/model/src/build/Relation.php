<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\model\build;

use houdunwang\db\Db;

trait Relation
{

    /**
     * 一对一
     *
     * @param     $class      关联模型
     * @param int $foreignKey 关联表关联字段
     * @param int $localKey   本模型字段
     *
     * @return mixed
     */
    protected function hasOne($class, $foreignKey = 0, $localKey = 0)
    {
        $foreignKey = $foreignKey ?: $this->getTable().'_'.$this->getPk();
        $localKey   = $localKey ?: $this->getPk();

        return (new $class())->where($foreignKey, $this[$localKey])->first();
    }

    /**
     * 一对多
     *
     * @param        $class      关联模型
     * @param string $foreignKey 关联表关联字段
     * @param string $localKey   本模型字段
     *
     * @return mixed
     */
    protected function hasMany($class, $foreignKey = '', $localKey = '')
    {
        $foreignKey = $foreignKey ?: $this->getTable().'_'.$this->getPk();
        $localKey   = $localKey ?: $this->getPk();

        return (new $class())->where($foreignKey, $this[$localKey])->get();
    }

    /**
     * 相对的关联
     *
     * @param $class
     * @param $parentKey
     * @param $localKey
     *
     * @return mixed
     */
    protected function belongsTo($class, $localKey = null, $parentKey = null)
    {
        //父表
        $instance  = new $class();
        $parentKey = $parentKey ?: $instance->getPk();
        $localKey  = $localKey
            ?: $instance->getTable().'_'.$instance->getPk();

        return $instance->where($parentKey, $this[$localKey])->first();
    }

    /**
     * 多对多关联
     *
     * @param string $class       关联中间模型
     * @param string $middleTable 中间表
     * @param string $localKey    主表字段
     * @param string $foreignKey  关联表字段
     *
     * @return mixed
     */
    protected function belongsToMany(
        $class,
        $middleTable = '',
        $localKey = '',
        $foreignKey = ''
    ) {

        $instance    = new $class;
        $middleTable = $middleTable
            ?: $this->getTable().'_'.$instance->getTable();
        $localKey    = $localKey ?: $this->table.'_'.$this->pk;
        $foreignKey  = $foreignKey
            ?: $instance->getTable().'_'.$instance->getPrimaryKey();
        $middle      = Db::table($middleTable)->where(
            $localKey,
            $this[$this->pk]
        )->lists($foreignKey);

        return $instance->whereIn($instance->getPk(), array_values($middle))
            ->get();
    }
}





