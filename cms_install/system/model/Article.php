<?php namespace system\model;

use houdunwang\model\Model;

class Article extends Model
{
    //数据表
    protected $table = "article";

    //允许填充字段
    protected $allowFill = ['*'];

    //禁止填充字段
    protected $denyFill = [];

    //自动验证
    protected $validate
        = [
            //['字段名','验证方法','提示信息',验证条件,验证时间]
            ['title', 'required', '标题不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['content', 'required', '内容不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];

    //自动完成
    protected $auto
        = [
            //['字段名','处理方法','方法类型',验证条件,验证时机]
            ['iscommend', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
            ['ishot', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;

    /**
     * 栏目表关联
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_cid');
    }
}