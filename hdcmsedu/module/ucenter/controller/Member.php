<?php namespace module\ucenter\controller;

/**
 * 会员中心
 * Class Member
 *
 * @package module\ucenter\controller
 */
use Db;

class Member extends Auth
{
    /**
     * 会员中心
     *
     * @return mixed
     */
    public function index()
    {
        //读取菜单
        $where  = [['entry', 'member'], ['siteid', SITEID]];
        $module = Db::table('navigate')->where($where)->groupBy('module')->lists('module');
        $data   = [];
        foreach ($module as $m) {
            if ($moduleData = Db::table('modules')->where('name', $m)->first()) {
                $where  = [['entry', 'member'], ['siteid', SITEID], ['module', $m]];
                $data[] = [
                    'module' => $moduleData,
                    'menus'  => Db::table('navigate')->where($where)->get(),
                ];
            }
        }
        foreach ($data as $k => $v) {
            foreach ($v['menus'] as $n => $m) {
                $data[$k]['menus'][$n]['css'] = json_decode($m['css'], true);
            }
        }

        return $this->view($this->template.'/index', compact('data'));
    }
}