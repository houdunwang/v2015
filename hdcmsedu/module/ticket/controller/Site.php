<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\ticket\controller;

use houdunwang\request\Request;
use module\HdController;
use system\model\MemberGroup;
use system\model\Ticket;
use system\model\TicketGroups;
use system\model\TicketModule;
use system\model\TicketRecord;
use Db;
use View;

/**
 * 卡券管理
 * Class site
 *
 * @package module\ticket\controller
 */
class site extends HdController
{
    /**
     * 构造函数
     * site constructor.
     *
     * @param \system\model\Ticket $Ticket
     */
    public function __construct(Ticket $Ticket)
    {
        parent::__construct();
        auth('member_coupons');
        View::with('ticket_name', $Ticket->title(Request::get("type")));
    }

    /**
     * 折扣券列表
     *
     * @return mixed
     */
    public function lists()
    {
        $sql  = "SELECT t.*, count(r.id) as usertotal FROM ".tablename('ticket')." t ";
        $sql  .= "LEFT JOIN ".tablename('ticket_record')." r ";
        $sql  .= "ON t.tid=r.tid WHERE t.type=".q('get.type')." GROUP BY t.tid ORDER BY t.tid DESC";
        $data = Db::query($sql);

        return view($this->template.'/lists.html')->with(compact('data'));
    }

    /**
     * 添加折扣券
     *
     * @param \system\model\Ticket $Ticket
     *
     * @return mixed|string
     */
    public function post(Ticket $Ticket)
    {
        $tid   = Request::get('tid', 0, 'intval');
        $model = $tid ? Ticket::find($tid) : $Ticket;
        if (IS_POST) {
            //表单验证
            switch (Request::get('type')) {
                case 1:
                    //折扣券
                    Validate::make([
                        ['condition', 'regexp:/^[1-9]\d*\.?\d*$/', '"满多少钱可使用"只能为数字'],
                        ['discount', 'regexp:/^0\.\d+$/', '"折扣"只能为0-1的小数'],
                    ]);
                    break;
                case 2:
                    Validate::make([
                        ['condition', 'regexp:/^[1-9]\d*$/', '"使用条件"只能为数字'],
                        ['discount', 'regexp:/^[1-9]\d*\.?\d*$/', '"代金券面额"只能为数字'],
                    ]);
                    if ($_POST['condition'] < $_POST['discount']) {
                        return message('代金券面额必须少于使用条件的金额。', 'back', 'error');
                    }
            }
            $model->save(Request::post());
            //模块设置
            Db::table('ticket_module')->where('tid', $model['tid'])->delete();
            foreach (Request::post('module', []) as $module) {
                $ticketModule           = new TicketModule();
                $ticketModule['tid']    = $model['tid'];
                $ticketModule['module'] = $module;
                $ticketModule->save();
            }

            //会员组
            TicketGroups::where('siteid', siteid())->where('tid', $tid)->delete();
            foreach (Request::post('groups', []) as $group_id) {
                $ticketGroups             = new TicketGroups();
                $ticketGroups['tid']      = $model['tid'];
                $ticketGroups['group_id'] = $group_id;
                $ticketGroups->save();
            }

            return message('卡券数据更新成功', url('site.lists', ['type' => q('type')]));
        }
        //文字描述
        if (Request::get('type') == 1) {
            $msg = [
                'module'      => ['title' => '折扣券'],
                'title'       => ['title' => '折扣券名称', 'help' => ''],
                'condition'   => ['title' => '满多少钱可打折', 'help' => '请填写整数。默认订单金额大于0元就可以使用'],
                'discount'    => ['title' => '折扣', 'help' => '请填写0-1的小数比如: 0.5'],
                'description' => ['title' => '折扣券说明', 'help' => ''],
                'amount'      => ['title' => '折扣券总数量', 'help' => '此设置项设置折扣券的总发行数量。'],
                'limit'       => ['title' => '每人可使用数量', 'help' => '此设置项设置每个用户可领取此折扣券数量。'],
            ];
        } else {
            $msg = [
                'module'      => ['title' => '代金券'],
                'title'       => ['title' => '代金券名称', 'help' => ''],
                'condition'   => ['title' => '使用条件', 'help' => '订单满多少钱可用。'],
                'discount'    => ['title' => '代金券面额', 'help' => '代金券面额必须少于使用条件的金额。'],
                'description' => ['title' => '代金券说明', 'help' => ''],
                'amount'      => ['title' => '代金券总数量', 'help' => '此设置项设置代金券的总发行数量。'],
                'limit'       => ['title' => '每人可使用数量', 'help' => '此设置项设置每个用户可领取此代金券数量。'],
            ];
        }
        //所有会员组
        $groups = MemberGroup::getSiteAllMemberGroup();
        //卡券已经使用的模块
        $modules = Ticket::getTicketModules($tid);
        //卡券可使用的会员组
        $groupsIds = Ticket::getTicketGroupIds($tid);
        View::with([
            'msg'       => $msg,
            'field'     => $model,
            'groups'    => $groups,
            'modules'   => $modules,
            'groupsIds' => $groupsIds,
        ]);

        return view($this->template.'/post.html');
    }

    /**
     * 删除卡券
     *
     * @return mixed|string
     */
    public function del()
    {
        $tid = Request::get('tid');
        $res = Db::table('ticket_record')->where('siteid', siteid())->where('tid', $tid)->get();
        if ($res) {
            return message('卡券已经使用,不能删除', 'back', 'error');
        }
        Db::table('ticket')->where('siteid', siteid())->where('tid', $tid)->delete();

        return message('卡券删除成功');
    }

    /**
     * 卡券核销列表
     *
     * @return mixed
     */
    public function charge()
    {
        //查询数据
        $db = Db::table('member');
        $db->field("ticket_record.id,member.uid,ticket.title,ticket.thumb,ticket.condition,ticket.discount,user.username,ticket_record.createtime,ticket_record.usetime,ticket_record.status");
        $db->join('ticket_record', 'member.uid', '=', 'ticket_record.uid');
        $db->join('ticket', 'ticket.tid', '=', 'ticket_record.tid');
        $db->leftJoin('user', 'user.uid', '=', 'ticket_record.manage');
        $db->where('ticket.type', q('get.type'))->where('member.siteid', SITEID);

        //有搜索条件
        if ($tid = Request::post('tid')) {
            $db->where('ticket.tid', $tid);
        }
        if ($status = Request::post('status')) {
            $db->where('ticket_record.status', $status);
        }
        if ($uid = Request::post('uid')) {
            $db->where('ticket_record.uid', $uid);
        }
        $data = $db->limit(20)->get();

        //卡券数据
        $ticket = Db::table('ticket')->where('siteid', SITEID)->where('type', Request::get('type'))->groupBy('tid')->get();

        return view($this->template.'/charge.html', compact('ticket', 'data', 'page'));
    }

    /**
     * 核销卡券
     *
     * @return mixed|string
     */
    public function verification()
    {
        $model            = TicketRecord::find(Request::get('id'));
        $model['status']  = 2;
        $model['manage']  = v('user.info.uid');
        $model['usetime'] = time();
        $model->save();

        return message('卡券核销成功');
    }

    /**
     * 删除会员卡券兑换记录
     *
     * @return mixed|string
     */
    public function remove()
    {
        $model = TicketRecord::find(Request::get('id'));
        $model->destory();

        return message('卡券删除成功');
    }
}











