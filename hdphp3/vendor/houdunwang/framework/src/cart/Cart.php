<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cart;

/**
 * 购物车处理类
 * Class Cart
 *
 * @package Hdphp\Cart
 * @author  向军 <2300071698@qq.com>
 */
class Cart {
    private $app;

    public $cartName = 'cart';

    public function __construct( $app ) {
        $this->app = $app;
    }

    /**
     * 添加购物车
     *
     * @access  public
     *
     * @param array $data
     *      <code>
     *      $data为数组包含以下几个值
     *      $Data=array(
     *      "id"=>1,                        //商品ID
     *      "name"=>"后盾网2周年西服",         //商品名称
     *      "num"=>2,                       //商品数量
     *      "price"=>188.88,                //商品价格
     *      "options"=>array(               //其他参数，如价格、颜色可以是数组或字符串|可以不添加
     *      "color"=>"red",
     *      "size"=>"L"
     *      )
     *      </code>
     *
     * @return void
     */

    public function add( $data ) {
        if ( ! is_array( $data ) || ! isset( $data['id'] ) || ! isset( $data['name'] ) || ! isset( $data['num'] ) || ! isset( $data['price'] ) ) {
            throw_exception( '购物车ADD方法参数设置错误' );
        }
        $data  = isset( $data[0] ) ? $data : [ $data ];
        $goods = $this->getGoods(); //获得商品数据
        //添加商品增持多商品添加
        foreach ( $data as $v ) {
            $options = isset( $v['options'] ) ? $v['options'] : '';
            $sid     = substr( md5( $v['id'] . serialize( $options ) ), 0, 8 ); //生成维一ID用于处理相同商品有不同属性时
            if ( isset( $goods[ $sid ] ) ) {
                if ( $v['num'] == 0 ) { //如果数量为0删除商品
                    unset( $goods[ $sid ] );
                    continue;
                }
                //已经存在相同商品时增加商品数量
                $goods[ $sid ]['num']   = $goods[ $sid ]['num'] + $v['num'];
                $goods[ $sid ]['total'] = $goods[ $sid ]['num'] * $goods[ $sid ]['price'];
            } else {
                if ( $v['num'] == 0 ) {
                    continue;
                }
                $goods[ $sid ]          = $v;
                $goods[ $sid ]['total'] = $v['num'] * $v['price'];
            }
        }

        $this->save( $goods );
    }

    private function save( $goods ) {
        $_SESSION[ $this->cartName ]['goods']      = $goods;
        $_SESSION[ $this->cartName ]['total_rows'] = $this->getTotalNums();
        $_SESSION[ $this->cartName ]['total']      = $this->getTotalPrice();
    }

    /**
     * 更新购物车
     *
     * @param array $data
     *  $data为数组包含以下几个值
     *  $Data=array(
     *  "sid"=>1,                        //商品的唯一SID，不是商品的ID
     *  "num"=>2,                       //商品数量
     */
    public function update( $data ) {
        $goods = $this->getGoods(); //获得商品数据
        if ( ! isset( $data['sid'] ) || ! isset( $data['num'] ) ) {
            halt( '购物车update方法参数错误，缺少sid或num值' );
        }
        $data = isset( $data[0] ) ? $data : [ $data ]; //允许一次删除多个商品
        foreach ( $data as $dataOne ) {
            foreach ( $goods as $k => $v ) {
                if ( $k == $dataOne['sid'] ) {
                    if ( $dataOne['num'] == 0 ) {
                        unset( $goods[ $k ] );
                        continue;
                    }
                    $goods[ $k ]['num'] = $dataOne['num'];
                }
            }
        }
        $this->save( $goods );
    }

    /**
     * 统计购物车中商品数量
     */
    public function getTotalNums() {
        $goods = $this->getGoods(); //获得商品数据
        $rows  = 0;
        foreach ( $goods as $v ) {
            $rows += $v['num'];
        }

        return $rows;
    }

    /**
     * 获得商品汇总价格
     */
    public function getTotalPrice() {
        $goods = $this->getGoods(); //获得商品数据
        $total = 0;
        foreach ( $goods as $v ) {
            $total += $v['price'] * $v['num'];
        }

        return $total;
    }

    /**
     * 删除购物车
     * 必须传递商品的sid值
     *
     * @param $data
     *
     * @return bool
     */
    public function del( $data ) {
        $goods = $this->getGoods(); //获得商品数据
        if ( empty( $goods ) ) {
            return FALSE;
        }
        $sid = [ ]; //要删除的商品SID集合
        if ( is_string( $data ) ) {
            $sid['sid'] = $data;
        }
        if ( is_array( $data ) && ! isset( $data['sid'] ) ) {
            halt( '购物车update方法参数错误，缺少sid值' );
        }

        $sid = isset( $sid[0] ) ? $sid : [ $sid ]; //可以一次删除多个商品
        foreach ( $sid as $d ) {
            foreach ( $goods as $k => $v ) {
                if ( $k == $d['sid'] ) {
                    unset( $goods[ $k ] );
                }
            }
        }
        $this->save( $goods );
    }

    /**
     * 清空购物车中的所有商品
     */
    public function flush() {
        $data               = [ ];
        $data['goods']      = [ ];
        $data['total_rows'] = 0;
        $data['total']      = 0;
        Request::session( $this->cartName, $data );
    }

    /**
     * 获得购物车商品数据
     */
    public function getGoods() {
        $data = Request::session( $this->cartName );
        if ( $data ) {
            return isset( $data['goods'] ) ? $data['goods'] : NULL;
        }
        $data = [ "goods" => [ ], "total_rows" => 0, "total" => 0 ];
        Request::session( $this->cartName, $data );

        return NULL;
    }

    /**
     * 获得购物车中的所有数据
     * 包括商品数据、总数量、总价格
     */
    public function getAllData() {
        return Request::session( $this->cartName );
    }

    /**
     * 获得定单号
     *
     * @return string
     */
    public function getOrderId() {
        return date( 'Ymd' ) . date( 'md' ) . substr( time(), - 5 ) . substr( microtime(), 2, 5 ) . str_pad( mt_rand( 1, 99 ), 2, '0', STR_PAD_LEFT );
    }
}