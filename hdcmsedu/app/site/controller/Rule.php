<?php namespace app\site\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use houdunwang\request\Request;
use system\model\Rule as Model;
use system\model\RuleKeyword;
use system\model\SiteWeChat;
use houdunwang\db\Db;
use houdunwang\view\View;

/**
 * 模块回复规则管理
 * Class Rule
 *
 * @package app\site\controller
 */
class Rule extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 显示规则回复列表
     *
     * @param \system\model\Rule $Rule
     *
     * @return mixed
     */
    public function lists(Model $Rule)
    {
        auth('system_rule');
        //回复规则
        $rules = $Rule->moduleRuleByStatus('', Request::get('status') == 'close' ? 0 : 1);
        $rules = $rules ? $rules->toArray() : [];
        //回复关键词
        $data = [];
        foreach ($rules as $k => $v) {
            $v['keywords'] = RuleKeyword::where('rid', $v['rid'])->lists('content') ?: [];
            //按关键词搜索
            if ($con = Request::post('content')) {
                if ( ! in_array($con, $v['keywords'])) {
                    continue;
                }
            }
            $data[$k] = $v;
        }

        return view()->with(['module' => v('module.name'), 'data' => $data,]);
    }

    /**
     * 添加/修改回复关键词
     *
     * @return mixed
     */
    public function post()
    {
        auth('system_rule');
        //模块关于回复关键词的处理类
        $class    = (v('module.is_system') ? '\module\\' : 'addons\\').v('module.name')
                    .'\system\Rule';
        $instance = new $class();
        if (IS_POST) {
            //添加规则数据
            $data             = json_decode(Request::post('hdcms_wechat_keyword'), true);
            $data['rid']      = Request::get('rid', 0);
            $data['keywords'] = $data['keyword'];
            $rid              = SiteWeChat::rule($data);
            if ( ! is_numeric($rid)) {
                return message($rid, '', 'error');
            }
            //调用模块的执行方法进行数据验证
            $msg = $instance->fieldsValidate($rid);
            if ($msg !== true) {
                //添加时失败将删除已经添加的规则数据
                if ( ! Request::get('rid')) {
                    SiteWeChat::removeRule($rid);
                }

                return ['valid' => 0, 'message' => $msg];
            }
            //使模块保存回复内容
            $instance->fieldsSubmit($rid);

            return message('规则保存成功', site_url('post', ['rid' => $rid]));
        }
        //获取关键词回复
        if ($rid = Request::get('rid')) {
            $data = Model::find($rid);
            if (empty($data)) {
                return message('回复规则不存在', site_url('lists'), 'error');
            }
            $data            = $data->toArray();
            $data['keyword'] = Db::table('rule_keyword')->orderBy('id', 'asc')->where('rid', $rid)
                                 ->get();
            View::with('rule', $data);
        }
        $moduleForm = $instance->fieldsDisplay($rid);

        return view('post', compact('moduleForm'));
    }

    /**
     * 删除规则
     *
     * @return mixed|string
     */
    public function remove()
    {
        auth('system_rule');
        $rid = Request::get('rid');
        SiteWeChat::removeRule($rid);
        //执行模块中的删除动作
        $class    = (v('module.is_system') ? '\module\\' : 'addons\\').v('module.name')
                    .'\system\Rule';
        $instance = new $class();
        $instance->ruleDeleted($rid);

        return message('文字回复删除成功');
    }
}