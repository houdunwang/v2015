<?php

/*Language Format:
Add a new file(.lang.php) with your module name at /phpcms/languages/
translation save at the array:$LANG
*/
$LANG['trade_sn'] = 'Transaction number';
$LANG['addtime'] = 'Order time';
$LANG['to'] = 'To';
$LANG['confirm_pay'] = 'Confirm to pay';
$LANG['usernote'] = ' Note';
$LANG['adminnote'] = 'Administrative person operation';
$LANG['user_balance'] = 'Balance';
$LANG['yuan'] = '&nbsp;Yuan';
$LANG['dian'] = '&nbsp;Point';
$LANG['trade_succ'] = 'Success';
$LANG['checking'] = 'Verifying...';
$LANG['user_not_exist'] = 'The user does not exist';

$LANG['input_price_to_change'] = 'Input values (money or points)';
$LANG['number'] = 'Amount';
$LANG['must_be_price'] = 'Must be valid value, at most round them to two decimal places';
$LANG['reason_of_modify'] = 'Modification reason';

//modify_deposit.php
$LANG['recharge_type'] = 'Type';
$LANG['capital'] = 'Money';
$LANG['point'] = 'Point';
$LANG['recharge_quota'] = 'Recharge limit';
$LANG['increase'] = 'Increase';
$LANG['reduce'] = 'Reduce';
$LANG['trading'] = 'Transaction';

//payment.php
$LANG['basic_config'] = 'Basic settings';
$LANG['contact_email'] = 'Email ';
$LANG['contact_phone'] = 'Tel';
$LANG['order_info'] = 'Order info';
$LANG['order_sn'] = 'Transaction number';
$LANG['order_name'] = 'Title';
$LANG['order_price'] = 'Price';
$LANG['order_discount'] = 'Increased fees';
$LANG['order_addtime'] = 'Timestamp';
$LANG['order_ip'] = 'Client IP address';
$LANG['payment_type'] = 'Payment type';
$LANG['order'] = 'Order';
$LANG['disount_notice'] = 'If you want to reduce your price please input “-10”';

$LANG['discount'] = 'Change order price';
$LANG['recharge'] = 'Recharge online';
$LANG['offline'] = 'Offline payment';
$LANG['online'] = 'Online payment';
$LANG['selfincome'] = 'Automatically procured ';

$LANG['order_time'] = 'Payment time';
$LANG['business_mode'] = 'Business approach';
$LANG['payment_mode'] = 'Payment method ';
$LANG['deposit_amount'] = 'Amount';
$LANG['pay_status'] = 'Payment status';
$LANG['pay_btn'] = 'Pay';

$LANG['name'] = 'Name';
$LANG['desc'] = 'Description';
$LANG['pay_factorage'] = 'Pay transfer fee';
$LANG['pay_method_rate'] = 'Proportional charges';
$LANG['pay_method_fix'] = 'Fixed costs';
$LANG['pay_rate'] = 'Pay rate';
$LANG['pay_fix'] = 'Amount';
$LANG['pay_method_rate_desc'] = 'Note: the total amount of orders × pay rate = transfer fee';
$LANG['pay_method_fix_desc'] = 'Note: transfer fee per order';

$LANG['parameter_config'] = 'Parameter settings';
$LANG['plus_version'] = 'Plugin version';
$LANG['plus_author'] = 'Author';
$LANG['plus_site'] = 'Plugin site';

$LANG['plus_install'] = 'Install';
$LANG['plus_uninstall'] = 'Uninstall';

$LANG['check_confirm'] = 'Are you sure you want to pass the order{sn} reviewing?';
$LANG['check_passed'] = 'Approval';

$LANG['change_price'] = 'Change price';
$LANG['check'] = 'Reviewing';
$LANG['closed'] = 'Close';

$LANG['thispage'] = 'Display';
$LANG['finance'] = 'Finance';
$LANG['totalize'] = ' ';
$LANG['amount'] = 'Price';
$LANG['total'] = 'Total ';
$LANG['bi'] = 'orders';
$LANG['trade_succ'] = ' Success';
$LANG['transactions'] = 'Transactions';
$LANG['trade'] = ' ';
$LANG['trade_record_del'] = 'Are you sure you want to remove this record?';

/******************error & notice********************/

$LANG['illegal_sign'] = 'Signature was invalid';
$LANG['illegal_notice'] = 'Notification error';
$LANG['illegal_return'] = 'Return messages on error';
$LANG['illegal_pay_method'] = 'Payment method error';
$LANG['illegal_creat_sn'] = 'Failed to generate order number';


$LANG['pay_success'] = 'Congratulations, your online payment goes successfully.';
$LANG['pay_failed'] = 'A failure happens to your online payment, please contact admin';
$LANG['payment_failed'] = 'Payment method error';
$LANG['order_closed_or_finish'] = 'Order has been completed or closed';
$LANG['state_change_succ'] = 'Changed successfully';

$LANG['delete_succ'] = 'Deleted successfully';
$LANG['public_discount_succ'] = 'The operation was successful';
$LANG['admin_recharge'] = 'Recharge on backend';

/******************pay status********************/
$LANG['all_status'] = 'Status';

$LANG['unpay'] = '<font color="red" class="onError">Not paid</font>';
$LANG['succ'] = '<font color="green" class="onCorrect">Successful</font>';
$LANG['failed'] = 'Failed to transact';
$LANG['error'] = 'Transaction error';
$LANG['progress'] = '<font color="orange" class="onTime">Processing</font>';
$LANG['timeout'] = 'Transaction is timeout';
$LANG['cancel'] = 'Cancelled';
$LANG['waitting'] = '<font color="orange" class="onTime">Pending payment</font>';

$LANG['select']['unpay'] = 'Not paid';
$LANG['select']['succ'] = 'Success';
$LANG['select']['progress'] = 'Processing';
$LANG['select']['cancel'] = 'Cancel';

/*************pay plus language***************/

$LANG['alipay'] = 'Alipay';
$LANG['alipay_account'] = 'Alipay account';
$LANG['alipay_tip'] = 'Alipay.com CO.Ltd. is China`s leading independent third-party online payment platform. Alipay is an affiliate of Alibaba Group , a leading international e-commerce service provider, Alipay is dedicated toward providing its users and merchants with a "simple, secure and speedy" online payment solution.<a href="http://www.alipay.com" target="_blank"><font color="red">Apply Now</font></a>';
$LANG['alipay_key'] = 'Transaction key';
$LANG['alipay_partner'] = 'Parter ID';
$LANG['service_type'] = 'Select interface type';

$LANG['tenpay_account'] = 'Tenpay client ID';
$LANG['tenpay_privateKey'] = 'Tenpay private key';
$LANG['tenpay_authtype'] = 'Select interface type';

$LANG['chinabank'] = 'Chinabank payment';
$LANG['chinabank_tip'] = 'Chinabank payment has always maintained good relations of cooperation with China major banks like Bank of China, Industrial and Commercial Bank of China, Agricultural Bank of China, China Construction Bank, China Merchants Bank Ltd and etc. Also, with Visa, MasterCard, JCB and other international credit card organizations.<a href="http://www.chinabank.com.cn" target="_blank"><font color="red">Apply Now</font>';
$LANG['chinabank_account'] = 'Chinabank payment business client ID';
$LANG['chinabank_key'] = 'Chinabank MD5 key';

$LANG['sndapay'] = 'Shengpay';
$LANG['sndapay_tip'] = 'Shengpay is China`s leading independent third-party online payment platform. Shengpay is a leading e-commerce service provider. By signed with major banks, Communication service providers , shengpay is dedicated toward providing its users and merchants with a "simple, secure and speedy" online payment solution.<a href="http://www.shengpay.com/HomePage.aspx?tag=phpcms" target="_blank"><font color="red">Apply Now</font>';
$LANG['sndapay_account'] = 'SNDA shengpay business client ID';
$LANG['sndapay_key'] = 'SNDA shengpay transaction key';


$LANG['service_type_range'][0] = 'Use guaranteed transaction interface';
$LANG['service_type_range'][1] = 'Use standard double interface';
$LANG['service_type_range'][2] = 'Use instantaneous payment interface';

$LANG['userid'] = 'User ID';
$LANG['op'] = 'Operator';
$LANG['expenditure_patterns'] = 'Consumption type';
$LANG['money'] = 'Money';
$LANG['point'] = 'Point';
$LANG['from'] = 'From';
$LANG['content_of_consumption'] = 'Consumption';
$LANG['empdisposetime'] = 'Time';
$LANG['consumption_quantity'] = 'Quantity';
$LANG['self'] = 'Your';
$LANG['wrong_time_over_time_to_time_less_than'] = 'Time format is invalid, Start time must be less than end time';

$LANG['spend_msg_1'] = 'Please add description for consumption';
$LANG['spend_msg_2'] = 'Please input your purchase amount';
$LANG['spend_msg_3'] = 'User is required';
$LANG['spend_msg_6'] = 'Your balance is insufficient';
$LANG['spend_msg_7'] = 'Consumption type is required';
$LANG['spend_msg_8'] = 'Failed to save data to database';
$LANG['bank_transfer'] = 'Bank transfer';
$LANG['transfer'] = 'Bank transfer';
$LANG['dsa'] = 'DSA is under further developement, please use MD5 signature';
$LANG['alipay_error'] = 'Alipay does not support {sign_type} signature';
$LANG['execute_date'] = 'Implementation date ';
$LANG['query_stat'] = 'View statistics';
$LANG['total_transactions'] = 'All transactions';
$LANG['transactions_success'] = 'Successful trading';
$LANG['pay_tip'] = 'We currently support the way of transfter. Please continue to bank transfer based on your payment type. Also, please contact us after paying your purchase';
?>