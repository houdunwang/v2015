<?php namespace system\model;

use houdunwang\model\Model;

/**
 * 模块动作操作模型
 * Class ModulesBindings
 *
 * @package system\model
 */
class ModulesBindings extends Model
{
    //数据表
    protected $table = "modules_bindings";

    //允许填充字段
    protected $allowFill = ['*'];

    //自动验证
    protected $validate
        = [
            ['title', 'required', '模块名称不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['entry', 'required', '动作类型不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['do', 'required', '动作不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];

    //自动完成
    protected $auto
        = [
            ['controller', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['url', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['icon', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['params', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['orderby', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = false;

    /**
     * 获取模块桌面入口动作
     *
     * @param $module 模块
     *
     * @return array
     */
    public function getWebDo($module)
    {
        return self::where('module', $module)->where('entry', 'web')->first();
    }

    /**
     * 根据入口类型获取模块动作
     *
     * @param $module 模块标识
     * @param $entry  入口类型
     *
     * @return array
     */
    public function getDoByEntry($module, $entry)
    {
        return self::where('module', $module)->where('entry', $entry)->get();
    }
}