<?php

/*Language Format:
Add a new file(.lang.php) with your module name at /phpcms/languages/
translation save at the array:$LANG
*/
$LANG['trade_sn'] = '支付单号';
$LANG['addtime'] = '订单时间';
$LANG['to'] = '至';
$LANG['confirm_pay'] = '确认并支付';
$LANG['usernote'] = '备注';
$LANG['adminnote'] = '管理员操作';
$LANG['user_balance'] = '用户余额：';
$LANG['yuan'] = '&nbsp;元';
$LANG['dian'] = '&nbsp;点';
$LANG['trade_succ'] = '成功';
$LANG['checking'] = '验证中..';
$LANG['user_not_exist'] = '该用户不存在';

$LANG['input_price_to_change'] = '输入修改数量（资金或者点数）';
$LANG['number'] = '数量 ';
$LANG['must_be_price'] = '必须为金额，最多保留两位小数';
$LANG['reason_of_modify'] = '要修改的理由';

//modify_deposit.php
$LANG['recharge_type'] = '充值类型';
$LANG['capital'] = '资金';
$LANG['point'] = '点数';
$LANG['recharge_quota'] = '充值额度';
$LANG['increase'] = '增加';
$LANG['reduce'] = '减少';
$LANG['trading'] = '交易';
$LANG['op_notice'] = '提醒操作';
$LANG['op_sendsms'] = '发送短消息通知会员';
$LANG['op_sendemail'] = '发送e-mail通知会员';
$LANG['send_account_changes_notice'] = '账户变更通知';
$LANG['background_operation'] = '后台操作';
$LANG['account_changes_notice_tips'] = '尊敬的{username},您好！<br/>您的账户于{time}发生变动,操作：{op},理由:{note},当前余额：{amount}元，{point}积分。';

//payment.php
$LANG['basic_config'] = '基本设置';
$LANG['contact_email'] = '联系邮箱';
$LANG['contact_phone'] = '联系电话';
$LANG['order_info'] = '订单信息';
$LANG['order_sn'] = '支付单号';
$LANG['order_name'] = '名称';
$LANG['order_price'] = '订单价格';
$LANG['order_discount'] = '交易加价/涨价';
$LANG['order_addtime'] = '订单生成时间';
$LANG['order_ip'] = '订单生成IP';
$LANG['payment_type'] = '支付类型';
$LANG['order'] = '订单';
$LANG['disount_notice'] = '要给顾客便宜10元,降价请输入“-10”';

$LANG['discount'] = '订单改价';
$LANG['recharge'] = '在线充值';
$LANG['offline'] = '线下支付';
$LANG['online'] = '在线支付';
$LANG['selfincome'] = '自助获取';

$LANG['order_time'] = '支付时间';
$LANG['business_mode'] = '业务方式';
$LANG['payment_mode'] = '支付方式';
$LANG['deposit_amount'] = '存入金额';
$LANG['pay_status'] = '付款状态';
$LANG['pay_btn'] = '付款';

$LANG['name'] = '名称';
$LANG['desc'] = '描述';
$LANG['pay_factorage'] = '支付手续费';
$LANG['pay_method_rate'] = '按比例收费';
$LANG['pay_method_fix'] = '固定费用';
$LANG['pay_rate'] = '费率';
$LANG['pay_fix'] = '金额';
$LANG['pay_method_rate_desc'] = '说明：顾客将支付订单总金额乘以此费率作为手续费；';
$LANG['pay_method_fix_desc'] = '说明：顾客每笔订单需要支付的手续费；';

$LANG['parameter_config'] = '参数设置';
$LANG['plus_version'] = '插件版本';
$LANG['plus_author'] = '插件作者';
$LANG['plus_site'] = '插件网址';

$LANG['plus_install'] = '安装';
$LANG['plus_uninstall'] = '卸载';

$LANG['check_confirm'] = '确认要通过订单  {sn} 审核？';
$LANG['check_passed'] = '审核通过';

$LANG['change_price'] = '改价';
$LANG['check'] = '审核';
$LANG['closed'] = '关闭';

$LANG['thispage'] = '本页';
$LANG['finance'] = '财务';
$LANG['totalize'] = '总计';
$LANG['amount'] = '金额';
$LANG['total'] = '总';
$LANG['bi'] = '笔';
$LANG['trade_succ'] = '成功';
$LANG['transactions'] = '交易量';
$LANG['trade'] = '交易';
$LANG['trade_record_del'] = '确认删除该记录？';

/******************error & notice********************/

$LANG['illegal_sign'] = '签名错误';
$LANG['illegal_notice'] = '通知错误';
$LANG['illegal_return'] = '信息返回错误';
$LANG['illegal_pay_method'] = '支付方式错误';
$LANG['illegal_creat_sn'] = '订单号生成错误';


$LANG['pay_success'] = '恭喜您，支付成功';
$LANG['pay_failed'] = '支付失败，请联系管理员';
$LANG['payment_failed'] = '支付方式发生错误';
$LANG['order_closed_or_finish'] = '订单已完成或该已经关闭';
$LANG['state_change_succ'] = '状态修改完成';

$LANG['delete_succ'] = '删除成功';
$LANG['public_discount_succ'] = '操作成功';
$LANG['admin_recharge'] = '后台充值';

/******************pay status********************/
$LANG['all_status'] = '全部状态';

$LANG['unpay'] = '<font color="red" class="onError">交易未支付</font>';
$LANG['succ'] = '<font color="green" class="onCorrect">交易成功</font>';
$LANG['failed'] = '交易失败';
$LANG['error'] = '交易错误';
$LANG['progress'] = '<font color="orange" class="onTime">交易处理中</font>';
$LANG['timeout'] = '交易超时';
$LANG['cancel'] = '交易取消';
$LANG['waitting'] = '<font color="orange" class="onTime">等待付款</font>';

$LANG['select']['unpay'] = '交易未支付';
$LANG['select']['succ'] = '交易成功';
$LANG['select']['progress'] = '交易处理中';
$LANG['select']['cancel'] = '交易取消';

/*************pay plus language***************/

$LANG['alipay'] = '支付宝';
$LANG['alipay_account'] = '支付宝帐户';
$LANG['alipay_tip'] = '支付宝是国内领先的独立第三方支付平台，由阿里巴巴集团创办。致力于为中国电子商务提供“简单、安全、快速”的在线支付解决方案。';
$LANG['alipay_key'] = '交易安全校验码(key)';
$LANG['alipay_partner'] = '合作者身份(parterID)';
$LANG['service_type'] = '选择接口类型';

$LANG['tenpay_account'] = '财付通客户号';
$LANG['tenpay_privateKey'] = '财付通私钥';
$LANG['tenpay_authtype'] = '选择接口类型';

$LANG['chinabank'] = '网银在线';
$LANG['chinabank_tip'] = '网银在线与中国银行、中国工商银行、中国农业银行、中国建设银行、招商银行等国内各大银行，以及VISA、MasterCard、JCB等国际信用卡组织保持了长期、紧密、良好的合作关系。<a href="http://www.chinabank.com.cn" target="_blank"><font color="red">立即在线申请</font>';
$LANG['chinabank_account'] = '网银在线商户号';
$LANG['chinabank_key'] = '网银在线MD5私钥';

$LANG['sndapay'] = '盛付通';
$LANG['sndapay_tip'] = '盛付通是盛大网络创办的中国领先的在线支付平台，致力于为互联网用户和企业提供便捷、安全的支付服务。通过与各大银行、通信服务商等签约合作，提供具备相当实力和信誉保障的支付服务。<a href="http://www.shengpay.com/HomePage.aspx?tag=phpcms" target="_blank"><font color="red">立即在线申请</font>';
$LANG['sndapay_account'] = '盛大支付商户号';
$LANG['sndapay_key'] = '盛大支付密钥';


$LANG['service_type_range'][0] = '使用担保交易接口';
$LANG['service_type_range'][1] = '使用标准双接口';
$LANG['service_type_range'][2] = '使用即时到账交易接口';

$LANG['userid'] = '用户ID';
$LANG['op'] = '操作人';
$LANG['expenditure_patterns'] = '消费类型';
$LANG['money'] = '金钱';
$LANG['point'] = '积分';
$LANG['from'] = '从';
$LANG['content_of_consumption'] = '消费内容';
$LANG['empdisposetime'] = '消费时间';
$LANG['consumption_quantity'] = '消费数量';
$LANG['self'] = '自身';
$LANG['wrong_time_over_time_to_time_less_than'] = '错误的时间格式，结束时间小于开始时间！';

$LANG['spend_msg_1'] = '请对消费内容进行描述。';
$LANG['spend_msg_2'] = '请输入消费金额。';
$LANG['spend_msg_3'] = '用户不能为空。';
$LANG['spend_msg_6'] = '账户余额不足。';
$LANG['spend_msg_7'] = '消费类型为空。';
$LANG['spend_msg_8'] = '数据存入数据库时出错。';
$LANG['bank_transfer'] = '银行转账';
$LANG['transfer'] = '银行汇款/转账';
$LANG['dsa'] = 'DSA 签名方法待后续开发，请先使用MD5签名方式';
$LANG['alipay_error'] = '支付宝暂不支持{sign_type}类型的签名方式';
$LANG['execute_date'] = '执行日期';
$LANG['query_stat'] = '查询统计';
$LANG['total_transactions'] = '总交易数';
$LANG['transactions_success'] = '成功交易';
$LANG['pay_tip'] = '我们目前支持的汇款方式，请根据您选择的支付方式来选择银行汇款。汇款以后，请立即通知我们。';
$LANG['configure'] = '配置';
?>