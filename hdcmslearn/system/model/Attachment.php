<?php namespace system\model;

use houdunwang\model\Model;

/**
 * 上传资源管理
 * Class Attachment
 *
 * @package system\model
 */
class Attachment extends Model
{
    //数据表
    protected $table = "attachment";

    //允许填充字段
    protected $allowFill = ['*'];

    //自动验证
    protected $validate
        = [
            //['字段名','验证方法','提示信息',验证条件,验证时间]
        ];

    //自动完成
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['createtime', 'time', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;

    /**
     * 删除开发者插件与模板
     *
     * @return mixed
     */
    public static function delUserModuleTemplate()
    {
        return self::where('uid', v('member.info.uid'))
                   ->where('module', 'store')
                   ->whereIn('data', ['__USER_MODULE__', '__USER_TEMPALTE__'])->delete();
    }
}