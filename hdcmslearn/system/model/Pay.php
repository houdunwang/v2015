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

/**
 * 支付记录模型
 * Class Pay
 *
 * @package system\model
 */
class Pay extends Common
{
    protected $table = "pay";
    protected $allowFill = ['*'];
    protected $timestamps = true;
    protected $validate
        = [
            ['tid', 'required', '定单号不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['type', 'required', '支付类型不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['fee', 'required', '支付金额不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['module', 'required', '模块名称不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['goods_name', 'required', '商品名称不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['status', 'required', '支付状态不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['createtime', 'time', 'function', self::MUST_AUTO, self::MODEL_INSERT],
            ['use_card', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['card_type', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['card_id', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['card_fee', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['attach', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['body', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['type', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 根据定单号获取记录
     *
     * @param int $tid 定单号
     *
     * @return mixed
     */
    public static function getByTid($tid)
    {
        return self::where('tid', $tid)->where('siteid', SITEID)->first();
    }

    /**
     * 获取支付中文描述
     *
     * @return string
     */
    public function payTitle()
    {
        $msg = '';
        switch ($this['type']) {
            case 'wechat':
                $msg = '微信支付';
                break;
            case 'alipay':
                $msg = '支付宝';
                break;
        }

        return $msg;
    }

    /**
     * 创建系统定单记录
     *
     * @param array $param 参数
     *
     * @return string
     */
    public function make(array $param)
    {
        if ( ! v('module.name') || ! v('member.info.uid') || empty($param['goods_name']) || empty($param['fee'])
             || empty($param['body'])
             || empty($param['tid'])) {
            return '支付参数错误,请重新提交';
        }
        if ($pay = Db::table('pay')->where('tid', $param['tid'])->first()) {
            if ($pay['status'] == 1) {
                return '这笔定单已经完成支付';
            }
        }
        $data['siteid']     = SITEID;
        $data['uid']        = v('member.info.uid');
        $data['tid']        = $param['tid'];
        $data['fee']        = $param['fee'];
        $data['type']       = $param['type'];
        $data['createtime'] = time();
        $data['goods_name'] = $param['goods_name'];
        $data['attach']     = (isset($param['attach']) ? $param['attach'] : '');
        $data['body']       = $param['body'];
        $data['module']     = v('module.name');
        $data['status']     = 0;
        $data['is_usecard'] = isset($param['is_usecard']) ? $param['is_usecard'] : 0;
        $data['card_type']  = isset($param['card_type']) ? $param['card_type'] : '';
        $data['card_id']    = isset($param['is_usecard']) ? $param['card_id'] : 0;
        $data['card_fee']   = isset($param['card_fee']) ? $param['card_fee'] : 0;

        $this->save($data);

        return true;
    }
}