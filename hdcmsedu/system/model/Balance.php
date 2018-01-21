<?php namespace system\model;

use houdunwang\cart\Cart;
use houdunwang\model\Model;

/**
 * 会员余额充值
 * Class Balance
 *
 * @package system\model
 */
class Balance extends Model
{
    //数据表
    protected $table = "balance";

    //允许填充字段
    protected $allowFill = ['*'];

    //禁止填充字段
    protected $denyFill = [];

    //自动验证
    protected $validate
        = [
            //['字段名','验证方法','提示信息',验证条件,验证时间]
        ];

    //自动完成
    protected $auto
        = [
            //['字段名','处理方法','方法类型',验证条件,验证时机]
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;

    /**
     * 设置余额充值记录
     *
     * @param int $fee 金额
     *
     * @return mixed
     */
    public function addRow($fee)
    {
        $data = [
            'tid'        => Cart::getOrderId(),//定单号
            'goods_name' => "会员余额充值 {$fee} 元",//商品名称
            'fee'        => $fee,//充值金额
            'data'       => '会员余额充值 {$fee} 元',
            'status'     => 0,
            'createtime' => time(),
            'uid'        => v('member.info.uid'),
            'attach'     => '',//附加数据
        ];

        return $this->save($data);
    }

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
}