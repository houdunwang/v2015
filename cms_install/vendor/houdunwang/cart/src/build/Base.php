<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cart\build;

use houdunwang\session\Session;

/**
 * 购物车
 * Class Base
 *
 * @package houdunwang\cart\build
 */
class Base
{
    /**
     * 购物车标识
     *
     * @var string
     */
    protected $cartName = 'cart';

    /**
     * 商品资料
     *
     * @var
     */
    protected $goods;

    public function __construct()
    {
        $data = Session::get($this->cartName);
        $this->setGoods(
            is_array($data) && isset($data['goods']) ? $data['goods'] : []
        );
    }

    /**
     * 获得商品数据
     *
     * @return mixed
     */
    public function getGoods()
    {
        return $this->goods;
    }

    /**
     * @param mixed $goods
     */
    public function setGoods($goods)
    {
        $this->goods = $goods;
    }

    /**
     * 添加购物车
     *
     * @access  public
     *
     * @param array $data
     *      $data为数组包含以下几个值
     *      $Data= [
     *      "id"=>1,                        //商品ID
     *      "name"=>"后盾网2周年西服",         //商品名称
     *      "num"=>2,                       //商品数量
     *      "price"=>188.88,                //商品价格
     *      "options"=>array(               //其他参数，如价格、颜色可以是数组或字符串|可以不添加
     *      "color"=>"red",
     *      "size"=>"L"
     *      ]
     *
     * @throws \Exception
     * @return void
     */
    public function add($data)
    {
        if ( ! is_array($data) || ! isset($data['id']) || ! isset($data['name'])
            || ! isset($data['num'])
            || ! isset($data['price'])
        ) {
            throw new \Exception('购物车ADD方法参数设置错误');
        }
        //添加商品支持多商品添加
        $options = isset($data['options']) ? $data['options'] : '';
        $sid     = md5($data['id'].serialize($options));
        //生成维一ID用于处理相同商品有不同属性时
        if (isset($this->goods[$sid])) {
            //如果数量为0删除商品
            if ($data['num'] == 0) {
                unset($this->goods[$sid]);
            } else {
                //已经存在相同商品时增加商品数量
                $this->goods[$sid]['num']   = $this->goods[$sid]['num']
                    + $data['num'];
                $this->goods[$sid]['total'] = $this->goods[$sid]['num']
                    * $this->goods[$sid]['price'];
            }
        } else {
            if ($data['num'] != 0) {
                $this->goods[$sid]          = $data;
                $this->goods[$sid]['total'] = $data['num'] * $data['price'];
            }
        }

        return $this->store();
    }

    /**
     * 保存到SESSION
     *
     * @return mixed
     */
    private function store()
    {
        $cart = [
            'goods'       => $this->goods,
            'total_rows'  => $this->getTotalNums(),
            'total_price' => $this->getTotalPrice(),
        ];

        return Session::set($this->cartName, $cart);
    }

    /**
     * 更新购物车数量
     *
     * @param $data
     *  $data=[
     *  "sid"=>'',//商品的唯一SID，不是商品的ID
     *  "num"=>2,//商品数量
     *  ]
     *
     * @return bool
     * @throws \Exception
     */
    public function update($data)
    {
        if ( ! isset($data['sid']) || ! isset($data['num'])) {
            throw new \Exception('购物车update方法参数错误，缺少sid或num值');
        }
        $sid = $data['sid'];
        if (isset($this->goods[$sid])) {
            if ($data['num'] == 0) {
                unset($this->goods[$sid]);
            } else {
                $this->goods[$sid]['num'] = $data['num'];
            }

            return $this->store();
        }

        return false;
    }

    /**
     * 统计购物车中商品数量
     */
    public function getTotalNums()
    {
        $rows = 0;
        foreach ($this->goods as $v) {
            $rows += $v['num'];
        }

        return $rows;
    }

    /**
     * 获得商品汇总价格
     */
    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->goods as $v) {
            $total += $v['price'] * $v['num'];
        }

        return $total;
    }

    /**
     * 删除购物车
     *
     * @param $sid 商品SID编号
     *
     * @return bool
     * @throws \Exception
     */
    public function del($sid)
    {
        if (isset($this->goods[$sid])) {
            unset($this->goods[$sid]);
            $this->store();

            return true;
        }

        return false;
    }


    /**
     * 删除所有商品
     *
     * @return bool
     */
    public function flush()
    {
        $this->setGoods([]);
        $this->store();

        return true;
    }

    /**
     * 获得购物车中的所有数据
     * 包括商品数据、总数量、总价格
     *
     * @return mixed
     */
    public function getAllData()
    {
        return Session::get($this->cartName);
    }

    /**
     * 获得定单号
     *
     * @return string
     */
    public function getOrderId()
    {
        return date('Ymd').date('md').substr(time(), -5).substr(
                microtime(),
                2,
                5
            ).str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
    }
}