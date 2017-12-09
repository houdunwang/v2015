<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\ucenter\controller;

use houdunwang\request\Request;
use system\model\CreditsRecord;
use system\model\Ticket as Model;

/**
 * 卡券管理
 * Class Ticket
 *
 * @package module\ucenter\controller
 */
class Ticket extends Auth
{
    /**
     * 卡券列表
     *
     * @return mixed
     */
    public function lists()
    {
        $uid = v('member.info.uid');
        //获取用户卡券
        switch ($_GET['status']) {
            case 1:
            case 2:
                $sql = "SELECT t.tid,count(t.tid) as nums,t.discount,t.condition,t.tid,t.starttime,t.endtime,t.title,t.limit,t.thumb,tr.status,tr.uid,tr.remark ";
                $sql .= "FROM ".tablename('ticket')." t JOIN ".tablename('ticket_record')." tr ON t.tid=tr.tid ";
                $sql .= "WHERE tr.uid={$uid} AND t.type={$_GET['type']} AND tr.status={$_GET['status']} GROUP BY t.tid";
                break;
            case 3:
                //过期
                $sql = "SELECT t.tid,count(t.tid) as nums,t.discount,t.condition,t.tid,t.starttime,t.endtime,t.title,t.limit,t.thumb,tr.status,tr.uid,tr.remark ";
                $sql .= "FROM ".tablename('ticket')." t JOIN ".tablename('ticket_record')." tr ON t.tid=tr.tid ";
                $sql .= "WHERE tr.uid={$uid} AND t.type={$_GET['type']} AND t.endtime<".time()." GROUP BY t.tid";
        }

        $data = Db::query($sql);
        View::with('data', $data);

        return View::make($this->template.'/ticket_lists');
    }

    /**
     * 兑换卡券
     *
     * @param \system\model\Ticket $model
     *
     * @return mixed|string
     */
    public function convert(Model $model)
    {
        if (IS_POST) {
            //兑换卡券
            $res = $model->convert(Request::post('tid'));
            if ($res !== true) {
                return message($res, 'back', 'error');
            }

            return message('兑换成功');
        }
        $sql  = "SELECT t.tid,t.credit,t.starttime,t.credittype,t.endtime,t.description,t.title,t.limit,t.thumb FROM ".tablename('ticket');
        $sql  .= " t LEFT JOIN ".tablename('ticket_record')." tr ON t.tid=tr.tid "."WHERE t.starttime<".time()." AND t.endtime>".time();
        $sql  .= " AND t.type={$_GET['type']}"." AND t.siteid=".SITEID." GROUP BY t.tid HAVING count(tr.id) < t.limit";
        $data = Db::query($sql);
        foreach ($data as $k => $v) {
            //兑换积分名称,积分或余额
            $data[$k]['credit_title'] = CreditsRecord::title($v['credittype']);
        }

        return View::make($this->template.'/ticket_convert', compact('data'));
    }

    /**
     * 使用卡券
     *
     * @return mixed
     */
    public function employ()
    {
        $tid = Request::get('tid', 0);
        //会员卡卷记录
        $ticket = Db::table('ticket')->where('tid', $tid)->first();

        return View::make($this->template.'/ticket_employ', compact('ticket'));
    }
}