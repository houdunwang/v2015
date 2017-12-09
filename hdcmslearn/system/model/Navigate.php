<?php namespace system\model;

/**
 * 导航菜单管理
 * Class WebNav
 *
 * @package system\model
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
/**
 * Class Navigate
 *
 * @package system\model
 */
class Navigate extends Common
{
    protected $table = 'navigate';
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['name', 'required', '导航名称不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['url', 'required', '链接不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['orderby', 'num:0,255', '排序只能为0~255之间的数字', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['entry', 'required', '导航类型不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['webid', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['module', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['css', 'json_encode', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
            ['status', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['category_cid', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['description', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['position', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['position', 'intval', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
            ['orderby', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['icontype', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['entry', 'strtolower', 'function', self::NOT_EMPTY_AUTO, self::MODEL_BOTH],
            ['groups', 'autoGroups', 'method', self::EXIST_AUTO, self::MODEL_BOTH],
        ];

    public function autoGroups($val)
    {
        return json_encode(is_array($val) ? $val : []);
    }

    /**
     * 获取菜单类型的中文标题
     *
     * @param string $entry 类型标识
     *
     * @return mixed
     */
    public function title($entry = '')
    {
        $entry = $entry ?: Request::get('entry');
        $menu  = [
            'home'    => '网站首页导航',
            'profile' => '手机会员中心导航',
            'member'  => '桌面会员中心导航',
        ];

        return $menu[$entry];
    }

    /**
     * 根据类型获取菜单
     *
     * @param $entry home 文章系统官网首页导航  profile 手机会员中心导航 member 桌面会员中心导航
     *
     * @return mixed
     */
    public function getMenuByEntry($entry)
    {
        //菜单
        $menus = Db::table('navigate')->field('id,name,url,css')->orderBy('orderby', 'desc')
                   ->where('siteid', siteid())->where('entry', $entry)->orderBy('id', 'asc')->get();
        //将CSS样式返序列化,用于显示图标等信息
        foreach ($menus as $k => $v) {
            $menus[$k]['css'] = json_decode($v['css'], true);
        }

        return $menus;
    }
}