<?php namespace app\site\controller;

use houdunwang\arr\Arr;
use houdunwang\request\Request;
use houdunwang\view\View;
use system\model\MemberGroup;
use system\model\Navigate as NavigateModel;
use system\model\Page;
use system\model\Template;

/**
 * 模块导航菜单管理
 * Class Navigate
 *
 * @package app\site\controller
 */
class Navigate extends Admin
{
    public function __construct()
    {
        parent::__construct();
        if (Request::get('entry') == 'home') {
            $this->auth(['article_navigate_lists']);
        }
    }

    /**
     * 菜单列表管理
     *
     * @param \system\model\Template $TemplateModel
     * @param \system\model\Navigate $NavigateModel
     *
     * @return mixed|string
     */
    public function lists(Template $TemplateModel, NavigateModel $NavigateModel)
    {
        if (IS_POST) {
            $data = json_decode(Request::post('data'), true);
            foreach ($data as $k => $nav) {
                $model = empty($nav['id']) ? new NavigateModel() : NavigateModel::find($nav['id']);
                $model->save($nav);
            }

            return message('保存导航数据成功', 'refresh', 'success');
        }
        /**
         * 当为首页导航菜单时需要获取微站编号
         * 如果没有指定微信编号时获取默认站点
         * 如果没有默认站点不允许设置首页导航菜单
         * 没有站点编号时设置站点编号并刷新页面
         */
        if (Request::get('entry') == 'home') {
            //当前站点模板数据
            $template = $TemplateModel->getTemplateData();
            if (empty($template)) {
                return message('请先在站点设置中设置站点模板', '', 'error');
            }
            $template_position_data = $TemplateModel->getPositionData($template['tid']);
            View::with(compact('template', 'template_position_data'));
        }
        /**
         * 获取导航菜单
         * entry是导航类型:home微站首页导航/profile手机会员中心导航/member桌面会员中心导航
         */
        $nav = Db::table('navigate')->where('siteid', SITEID)->where('entry', Request::get('entry'))
                 ->where('module', v('module.name'))->get();
        /**
         * 扩展模块动作时将没有添加到数据库中的菜单添加到列表中
         * 根据模块菜单的URL进行比较
         */
        if (v('module.name') != 'article') {
            $moduleMenu = Db::table('modules_bindings')->where('module', v('module.name'))->where('entry', Request::get('entry'))->get();
            foreach ($moduleMenu as $k => $v) {
                $params                = empty($v['params']) ? '' : '&'.$v['params'];
                $moduleMenu[$k]['url'] = "?m={$v['module']}&action=system/navigate/{$v['do']}{$params}&siteid=".SITEID;
                foreach ($nav as $n) {
                    //如果模块的菜单已经添加到数据库中的将这个菜单从列表中移除
                    if ($n['url'] == $moduleMenu[$k]['url']) {
                        unset($moduleMenu[$k]);
                    }
                }
            }
            //没有添加到数据库中的菜单组合出可用于数据库的数据结构
            foreach ($moduleMenu as $v) {
                $nav[] = [
                    'module'   => v('module.name'),
                    'url'      => $v['url'],
                    'position' => 0,
                    'name'     => $v['title'],
                    'css'      => json_encode([
                        'icon'  => 'fa fa-external-link',
                        'image' => '',
                        'color' => '#333333',
                        'size'  => 35,
                    ]),
                    'orderby'  => 0,
                    'status'   => 0,
                    'icontype' => 1,
                    'entry'    => Request::get('entry'),
                    'original' => 1,
                    'groups'   => json_encode([0]),
                ];
            }
        }
        /**
         * 编辑菜单时
         * 将菜单数组转为JSON格式为前台使用
         */
        if ($nav) {
            foreach ($nav as $k => $v) {
                $nav[$k]['css']    = json_decode($v['css'], true);
                $nav[$k]['groups'] = empty($nav[$k]['groups']) ? [0] : json_decode($nav[$k]['groups']);
            }
        }
        $groups = MemberGroup::getSiteAllMemberGroup();
        array_unshift($groups, ['id' => 0, 'title' => '所有组']);

        return view('', compact('NavigateModel', 'nav', 'groups'));
    }

    /**
     * 添加&修改菜单
     * 只对微站首页菜单管理
     * 即entry类型为home的菜单
     *
     * @param \system\model\Template $TemplateModel
     *
     * @return mixed|string
     */
    public function post(Template $TemplateModel)
    {
        //对模块的会员中心菜单进行权限验证
        if (IS_POST) {
            $data                = json_decode(Request::post('data'), true);
            $data['module']      = Request::get('m');
            $model               = empty($data['id']) ? new NavigateModel() : NavigateModel::find($data['id']);
            $data['css']['size'] = min(intval($data['css']['size']), 100);
            $model->save($data);
            $url = site_url('lists', ['entry' => Request::get('entry')]);

            return message('保存导航数据成功', $url, 'success');
        }
        $id = Request::get('id');
        if ($id) {
            $field        = Db::table('navigate')->where('id', $id)->first();
            $field['css'] = empty($field['css']) ? [] : json_decode($field['css'], true);
        } else {
            /**
             * 新增数据时初始化导航数据
             * 只有通过官网添加导航链接才有效
             */
            $field['siteid']   = siteid();
            $field['position'] = 0;
            $field['icontype'] = 1;
            $field['status']   = 1;
            $field['orderby']  = 0;
            $field['entry']    = 'home';
            $field['css']      = [
                'icon'  => 'fa fa-external-link',
                'image' => pic(''),
                'color' => '#333333',
                'size'  => 35,
            ];
        }
        /**
         * 站点导航菜单时
         * 显示站点模板的菜单位置信息
         */
        if (Request::get('entry') == 'home') {
            //当前站点模板数据
            $template = $TemplateModel->getTemplateData();
            if (empty($template)) {
                return message('请先在站点设置中设置站点模板', '', 'error');
            }
            $template_position_data = $TemplateModel->getPositionData($template['tid']);
            View::with(compact('template', 'template_position_data'));
        }
        $field = Arr::stringToInt($field);

        return view('', compact('field'));
    }

    /**
     * 删除菜单
     *
     * @return mixed|string
     */
    public function del()
    {
        NavigateModel::delete(Request::get('id'));

        return $this->success('菜单删除成功');
    }

    /**
     * 移动端页面快捷导航
     *
     * @return mixed|string
     */
    public function quickmenu()
    {
        $model = Page::where('siteid', siteid())->where('type', 'quickmenu')->first();
        if (IS_POST) {
            $data  = json_decode(Request::post('data'), true);
            $model = $model ?: new Page();
            $model->save($data);

            return message('保存快捷菜单成功');
        }
        if ($model) {
            $model['params'] = json_decode($model['params'], true);
            $model           = $model->toArray();
        }
        $field = Arr::merge([
            'siteid'      => siteid(),
            'web_id'      => 0,
            'title'       => '类型:快捷导航',
            'description' => '页面底部快捷导航',
            'type'        => 'quickmenu',
            'status'      => 1,
            'html'        => '',
            'params'      =>
                [
                    'style'           => 'quickmenu_normal',
                    'menus'           =>
                        [
                        ],
                    'modules'         =>
                        [
                        ],
                    'has_home_button' => 1,
                    'has_ucenter'     => 0,
                    'has_home'        => 0,
                    'has_special'     => 0,
                    'has_article'     => 0,
                ],
        ], $model);

        return view()->with('field', json_encode($field));
    }
}