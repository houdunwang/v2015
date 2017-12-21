<?php 
/**
 * 生成流水号
 */
function create_sn(){
	mt_srand((double )microtime() * 1000000 );
	return date("YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
}
/**
 * 返回响应地址
 */
function return_url($code, $is_api = 0){
	if($is_api){
		return APP_PATH.'index.php?m=pay&c=respond&a=respond_post&code='.$code;
	}
	else {
		return APP_PATH.'index.php?m=pay&c=respond&a=respond_get&code='.$code;
	}
}
	
function unserialize_config($cfg){
        if (is_string($cfg) ) {
            $arr = string2array($cfg);
		$config = array();
		foreach ($arr AS $key => $val) {
			$config[$key] = $val['value'];
		}
		return $config;
	} else {
		return false;
	}
}
/**
 * 返回订单状态
 */
function return_status($status) {
	$trade_status = array('0'=>'succ', '1'=>'failed', '2'=>'timeout', '3'=>'progress', '4'=>'unpay', '5'=>'cancel','6'=>'error');
	return $trade_status[$status];
}
/**
 * 返回订单手续费
 * @param  $amount 订单价格
 * @param  $fee 手续费比率
 * @param  $method 手续费方式
 */
function pay_fee($amount, $fee=0, $method=0) {
    $pay_fee = 0;
    if($method == 0) {
    	$val = floatval($fee) / 100;
    	$pay_fee = $val > 0 ? $amount * $val : 0;
    } elseif($method == 1) {
        $pay_fee = $fee;
    }
    return round($pay_fee, 2);
}

/**
 * 生成支付按钮
 * @param $data 按钮数据
 * @param $attr 按钮属性 如样式等
 * @param $ishow 是否显示描述
 */
function mk_pay_btn($data,$attr='class="payment-show"',$ishow='1') {
	$pay_type = '';
	if(is_array($data)){
		foreach ($data as $v) {
			$pay_type .= '<label '.$attr.'>';
			$pay_type .='<input name="pay_type" type="radio" value="'.$v['pay_id'].'"> <em>'.$v['name'].'</em>';
			$pay_type .=$ishow ? '<span class="payment-desc">'.$v['pay_desc'].'</span>' :'';
			$pay_type .= '</label>';
		}
	}
	return $pay_type;
}
?>