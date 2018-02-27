<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\model;
use Db;
/**
 * 卡券管理
 * Class Ticket
 *
 * @package system\model
 * @author  向军
 */
class Ticket extends Common
{
    protected $table = 'ticket';
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['title', 'required', '名称不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['title', 'unique', '名称已经被使用', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['type', 'num:1,3', '卡券类型不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['thumb', 'required', '封面图片不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['credit', 'regexp:/^[0-9\.]+$/', '兑换方式的"积分数量"只能为数字', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['limit', 'regexp:/^\d+$/', '每人可使用的数量不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['amount', 'regexp:/^[0-9\.]+$/', '卡券兑换的"券总数量"不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['limit', 'regexp:/^\d+$/', '"每人可使用数量"只能为数字', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['limit', 'validateLimit', '"每人可使用数量" 不能大于 "卡券总数量"', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['amount', 'regexp:/^\d+$/', '"折扣券总数量"只能为数字', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['starttime', 'required', '开始时间不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['endtime', 'required', '结束时间不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['credittype', 'required', '积分类型不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['description', 'required', '卡券说明 不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];

    protected function validateLimit($field, $value, $params, $data)
    {
        return $data['amount'] > $data['limit'] ? true : false;
    }

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['sn', 'autoSn', 'method', self::MUST_AUTO, self::MODEL_INSERT],
            ['starttime', 'autoStarttime', 'method', self::MUST_AUTO, self::MODEL_BOTH],
            ['endtime', 'autoEndtime', 'method', self::MUST_AUTO, self::MODEL_BOTH],
        ];

    protected function autoStarttime()
    {
        $time = preg_split('/\s+至\s+/', $_POST['times']);

        return strtotime(trim($time[0]));
    }

    protected function autoEndtime()
    {
        $time = preg_split('/\s+至\s+/', $_POST['times']);

        return strtotime(trim($time[1]));
    }

    protected function autoSn()
    {
        while (true) {
            $sn = 'HD'.strtoupper(substr(md5(time()), 0, 15));
            if ( ! Db::table('ticket')->where('sn', $sn)->get()) {
                return $sn;
            }
        }
    }

    /**
     * 获取卡券标题
     *
     * @param int $type 卡券类型
     *
     * @return string
     */
    public function title($type)
    {
        $names = [1 => '折扣券', 2 => '代金券'];

        return $names[$type];
    }

    /**
     * 获取指定类型的卡券列表
     *
     * @param int $type   卡券类型
     * @param int $siteId 站点编号
     *
     * @return array
     */
    public function getTicketListsByType($type, $siteId = 0)
    {
        $siteId = $siteId ?: SITEID;

        return Db::table('ticket')->where('siteid', $siteId)->where('type', intval($type))->get();
    }

    /**
     * 卡券兑换
     *
     * @param int $tid 卡券编号
     *
     * @return bool
     */
    public function convert($tid)
    {
        Db::beginTransaction();
        //会员已经兑换的数量
        $count = $this->getNumByTid($tid, v('member.info.uid'));
        //卡券信息
        $ticket      = self::where('tid', $tid)->where('siteid', SITEID)->first();
        $ticketTitle = $this->title($ticket['type']);
        if ($count >= $ticket['limit']) {
            return '只能兑换'.$ticket['limit'].'个'.$ticketTitle.',你已经全部兑换完毕';
        }
        //减掉会员积分
        $data               = [];
        $data['uid']        = v('member.info.uid');
        $data['credittype'] = $ticket['credittype'];
        $data['num']        = -1 * $ticket['credit'];
        $data['module']     = v('module.name');
        $data['remark']     = '兑换'.$ticketTitle.':'.$ticket['title'].',消耗'.$ticket['credit'].CreditsRecord::title($ticket['credittype']);
        //使用用积分兑换卡券
        CreditsRecord::change($data);
        self::where('tid', $tid)->decrement('amount', 1);
        //记录卡券兑换日志
        $data               = [];
        $data['uid']        = v('member.info.uid');
        $data['createtime'] = time();
        $data['usetime']    = 0;//使用时间
        $data['status']     = 1;
        $data['siteid']     = SITEID;
        $data['tid']        = $tid;
        $data['manage']     = 0;//核销员编号
        $data['module']     = v('module.name');
        $data['remark']     = '兑换'.$ticketTitle.':'.$ticket['title'].',消耗'.$ticket['credit'].CreditsRecord::title($ticket['credittype']);//核销员编号
        $model              = new TicketRecord();
        $model->save($data);
        DB::commit();

        return true;
    }

    /**
     * 获取指定卡券允许使用的用户组编号
     *
     * @param int $tid 卡券编号
     *
     * @return array
     */
    public static function getTicketGroupIds($tid)
    {
        if (empty($tid)) {
            return [];
        }

        return Db::table('ticket_groups')->where('siteid', SITEID)->where('tid', $tid)->lists('group_id');
    }

    /**
     * 获取指定卡券允许使用的模块
     *
     * @param int $tid 卡券编号
     *
     * @return array
     */
    public static function getTicketModules($tid)
    {
        if (empty($tid)) {
            return [];
        }
        $module = Db::table('ticket_module')->where('siteid', SITEID)->where('tid', $tid)->lists('module');

        return $module ? Db::table('modules')->whereIn('name', $module)->get() : [];
    }

    /**
     * 获取会员卡券兑换数量
     *
     * @param int $tid 卡券编号
     * @param int $uid 会员编号
     *
     * @return mixed
     */
    public function getNumByTid($tid, $uid)
    {
        return Db::table('ticket_record')->where('tid', $tid)->where('uid', $uid)->count();
    }
}