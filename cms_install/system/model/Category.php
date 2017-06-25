<?php namespace system\model;

use houdunwang\model\Model;

/**
 * Class Category
 *
 * @package system\model
 */
class Category extends Model
{
    //数据表
    protected $table = "category";

    //允许填充字段
    /**
     * @var array
     */
    protected $allowFill = ['*'];

    //禁止填充字段
    protected $denyFill = [];

    //自动验证
    protected $validate
        = [
            //['字段名','验证方法','提示信息',验证条件,验证时间],
            ['catname', 'required', '栏目名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];

    //自动完成
    protected $auto
        = [
            //['字段名','处理方法','方法类型',验证条件,验证时机]
            ['orderby', 'intval', 'function', self::MUST_AUTO, self::MODEL_BOTH],
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;

    /**
     * 获取栏目数据
     *
     * @return mixed
     */
    public static function getCategory()
    {
        $data = static::get();
        return Arr::tree($data?$data->toArray():[], 'catname', 'cid', 'pid');
    }

    /**
     * 根据传递的模型添加字段
     * 用于控制不允许选择子栏目
     * 栏目的父级栏目选中等属性
     *
     * @param \system\model\Category $model
     *
     * @return mixed
     */
    public static function getCategoryByCid(Category $model)
    {
        $data = self::getCategory();
        foreach ($data as $k => $v) {
            //如果当前栏目与列表中栏目cid相同时不允许选择
            $data[$k]['_disabled'] = $v['cid'] == $model['cid'] ? ' disabled="diabled" ' : '';
            if (Arr::isChild($data, $v['cid'], $model['cid'], 'cid', 'pid')) {
                $data[$k]['_disabled'] = ' disabled="diabled" ';
            }

            $data[$k]['_selected'] = $v['cid'] == $model['pid'] ? ' selected="selected" ' : '';
        }

        return $data;
    }

    /**
     * 删除栏目
     *
     * @param int $cid 栏目编号
     *
     * @return bool
     */
    public function remove($cid)
    {
        $model    = $this->find($cid);
        $category = $this->get();
        if (Arr::hasChild($category, $cid, 'pid')) {
            $this->setError(['请先删除子栏目']);

            return false;
        }

        return $model->destory();
    }
}