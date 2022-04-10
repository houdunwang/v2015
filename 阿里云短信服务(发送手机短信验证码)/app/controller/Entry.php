<?php

namespace app\controller;
use tools\SignatureHelper;

class Entry
{
	/**
	 * 加载模板页面
	 */
	public function index ()
	{
		include './view/index.html';
	}

	public function post(){
		if($_SESSION['code'] == $_POST['code']){
			echo json_encode (['status'=>1,'msg'=>'验证码输入正确']);
		}else{
			echo json_encode (['status'=>0,'msg'=>'验证码输入有误']);
		}
	}

	/**
	 * 发送短信验证码
	 */
	public function sendSms(){
		//接受前台发送的手机号码
		$phone = $_POST['phone'];

		$params = array ();

		// *** 需用户填写部分 ***

		// fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
		$accessKeyId = "LTAIuJJJbJP15gDW";
		$accessKeySecret = "Fm6ms9zdhOg2Jmlf8fvIwaG920Oifl";

		// fixme 必填: 短信接收号码
		$params["PhoneNumbers"] = $phone;

		// fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
		$params["SignName"] = "后盾人";

		// fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
		$params["TemplateCode"] = "SMS_130740347";

		// fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
		$code = $this->getCode();
		//将验证码存入session
		$_SESSION['code'] = $code;
		$params['TemplateParam'] = Array (
			"code" => $code,
		);

		// fixme 可选: 设置发送短信流水号
		//$params['OutId'] = "12345";

		// fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
		//$params['SmsUpExtendCode'] = "1234567";


		// *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
		if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
			$params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
		}

		// 初始化SignatureHelper实例用于设置参数，签名以及发送请求
		$helper = new SignatureHelper();

		// 此处可能会抛出异常，注意catch
		$content = $helper->request(
			$accessKeyId,
			$accessKeySecret,
			"dysmsapi.aliyuncs.com",
			array_merge($params, array(
				"RegionId" => "cn-hangzhou",
				"Action" => "SendSms",
				"Version" => "2017-05-25",
			))
		// fixme 选填: 启用https
		// ,true
		);
		//stdClass Object
		//(
		//	[Message] => OK
		//	[RequestId] => 38F352CF-E8D2-49D9-A382-624F7AFFB5DE
		//	[BizId] => 456609323263493888^0
		//	[Code] => OK
		//)
		//echo '<pre>';
		//print_r ($content->Code);
		if($content->Code=='OK' && $content->Message='OK'){
			echo json_encode (['status'=>1,'msg'=>'验证码发送成功']);exit;
		}else{
			echo json_encode (['status'=>0,'msg'=>'请求超时']);exit;
		}
	}

	/**
	 * 随机生成指位数的验证码
	 * @param int $len
	 *
	 * @return string
	 */
	private function getCode($len = 6){
		//1000000-->999999
		return str_pad (mt_rand (1,pow (10,$len)-1),$len,'0',STR_PAD_LEFT);
	}
}