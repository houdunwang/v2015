<?php namespace system\model;

use houdunwang\model\Model;

class Module extends Model
{
    //数据表
    protected $table = "module";

    //允许填充字段
    protected $allowFill = ['*'];

    //禁止填充字段
    protected $denyFill = [];

    //自动验证
    protected $validate
        = [
            //['字段名','验证方法','提示信息',验证条件,验证时间]
            ['name', 'required', '模块标识不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['title', 'required', '模块名称不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];

    //自动完成
    protected $auto
        = [
            //['字段名','处理方法','方法类型',验证条件,验证时机]
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;
}