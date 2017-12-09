<?php namespace module\article\model;

use Request;
use houdunwang\model\Model;

/**
 * 官网栏目管理
 * Class WebCategory
 *
 * @package system\model
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class WebCategory extends Model
{
    protected $table = 'web_category';

    protected $allowFill = ['*'];

    protected $validate
        = [
            ['catname', 'required', '栏目标题不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['orderby', 'num:0,255', '排序数字为0~255之间的字符', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['mid', 'required', '请选择模型类型', self::EXIST_VALIDATE, self::MODEL_INSERT],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['pid', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['orderby', 'intval', 'function', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
            ['description', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['linkurl', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['ishomepage', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['status', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['index_tpl', 'article_index.html', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['category_tpl', 'article_list.html', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['content_tpl', 'article.html', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['html_category', 'article{siteid}-{cid}-{page}.html', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['html_content', 'article{siteid}-{aid}-{cid}-{mid}.html', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],

        ];
    protected $filter
        = [
            ['mid', self::MUST_FILTER, self::MODEL_UPDATE],
        ];

    /**
     * 文章模块栏目伪静态
     *
     * @param int $field 栏目字段数据
     *
     * @return mixed|string
     */
    public static function url($field)
    {
        $field['page'] = Request::get('page', 1);
        $url           = web_url().'/article{siteid}-{cid}-{page}.html';
        foreach ($field as $k => $v) {
            $url = str_replace('{'.$k.'}', $v, $url);
        }

        return $url;
    }

    /**
     * 获取树状栏目
     * 指定cid时过滤掉cid及其子栏目
     *
     * @param int $cid 栏目编号
     * @param int $mid 模型编号
     *
     * @return mixed
     */
    public static function getLevelCategory($cid = 0, $mid = 0)
    {
        $category = Db::table('web_category')->where('siteid', SITEID)->orderBy('orderby', 'desc')->get();
        if ($category) {
            $category = Arr::tree($category, 'catname', 'cid', 'pid');
            foreach ($category as $k => $v) {
                //获取批定模型时只显示模块的栏目
                if ($mid && $v['mid'] != $mid) {
                    unset($category[$k]);
                }
                //编辑时在栏目选择中不显示自身与子级栏目
                if ($cid && ($v['cid'] == $cid || Arr::isChild($category, $v['cid'], $cid))) {
                    unset($category[$k]);
                }
            }
        }

        return $category;
    }

    /**
     * 删除栏目
     *
     * @return bool
     */
    public function delCategory()
    {
        $table = (new WebModel())->getModelTable($this['mid']);
        //删除文章
        Db::table($table)->where('cid', $this['cid'])->delete();

        return $this->destory();
    }

    /**
     * 根据栏目编号获取数据
     *
     * @param $cid 栏目编号
     *
     * @return mixed
     */
    public function getByCid($cid)
    {
        static $cache = [];
        if ( ! isset($cache[$cid])) {
            $cache[$cid] = Db::table('web_category')->find($cid);
        }

        return $cache[$cid];
    }
}