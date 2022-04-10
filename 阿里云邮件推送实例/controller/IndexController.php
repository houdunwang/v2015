<?php
include_once './aliyun/aliyun-php-sdk-core/Config.php';
include_once './tools/Smtp.php';
use Dm\Request\V20151123 as Dm;

class IndexController
{
	/**
	 * 首页
	 */
	public function index ()
	{
		//加载模板页面
		include './view/index.html';
	}

	/**
	 * 提交数据比对验证码
	 */
	public function post(){
		//接受post提交的code数据
		$code = $_POST['code'];
		if($code == $_SESSION['code']){
			//比对成功
			echo json_encode (['status'=>1,'msg'=>'验证码输入正确']);exit;
		}else{
			//比对失败
			echo json_encode (['status'=>0,'msg'=>'验证码输入错误']);exit;
		}

	}


	public function smtpSend(){
		$mailto=$_POST[ 'email' ];
		$mailsubject="<< 后盾人 >> 验证码";

		$code = $this->getCode ();
		//将随机生成的6位验证码存入到session中
		$_SESSION['code'] = $code;
		$tpl  = $this->emailTpl ( $code );


		$mailbody = $tpl;
		$smtpserver     = "smtpdm.aliyun.com";
		$smtpserverport = 25;
		$smtpusermail   = "houdun@email.houdunphp.com";
		$smtpuser       = "houdun@email.houdunphp.com";
		$smtppass       = "HOUdun98765";
		$mailsubject    = "=?UTF-8?B?" . base64_encode($mailsubject) . "?=";
		$mailtype       = "HTML";
		$smtp           = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
		$smtp->debug    = false;
		$res = $smtp->sendmail($mailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
		if($res){
			echo json_encode (['status'=>1,'msg'=>'邮件已经成功发送']);exit;

		}else{
			echo json_encode (['status'=>0,'msg'=>'邮件发送失败，请检查邮箱再重新发送']);exit;
		}
	}

	/**
	 * 发送短信验证码
	 */
	public function send ()
	{
		$email = $_POST[ 'email' ];
		//需要设置对应的region名称，如华东1（杭州）设为cn-hangzhou，新加坡Region设为ap-southeast-1，澳洲Region设为ap-southeast-2。
		$iClientProfile = DefaultProfile::getProfile ( "cn-hangzhou" , "LTAIiv0sc7D1KAiy" , "dX2c9PY1hAnumzdk6SG3HMlFKQSQvZ" );
		$client         = new DefaultAcsClient( $iClientProfile );
		$request        = new Dm\SingleSendMailRequest();
		$request->setAccountName ( "houdun@email.houdunphp.com" );
		$request->setFromAlias ( "后盾IT教育" );
		$request->setAddressType ( 1 );
		//$request->setTagName("控制台创建的标签");
		$request->setReplyToAddress ( "true" );
		$request->setToAddress ( $email );
		$request->setSubject ( "<< 后盾人 >> 验证码" );
		$code = $this->getCode ();
		//将随机生成的6位验证码存入到session中
		$_SESSION['code'] = $code;
		$tpl  = $this->emailTpl ( $code );

		$request->setHtmlBody ( $tpl);
		try {
			$response = $client->getAcsResponse ( $request );
			//print_r ( $response );
			echo json_encode (['status'=>1,'msg'=>'邮件已经成功发送']);exit;
		} catch ( ClientException  $e ) {
			//print_r ( $e->getErrorCode () );
			//print_r ( $e->getErrorMessage () );
			echo json_encode (['status'=>0,'msg'=>'邮件发送失败，请检查邮箱再重新发送']);exit;
		} catch ( ServerException  $e ) {
			//print_r ( $e->getErrorCode () );
			//print_r ( $e->getErrorMessage () );
			echo json_encode (['status'=>0,'msg'=>'邮件发送失败，请检查邮箱再重新发送']);exit;
		}
	}

	/**
	 * 随机指定位数的验证码
	 * @param int $length
	 *
	 * @return string
	 */
	private function getCode ( $length = 6 )
	{
		return str_pad (mt_rand (0,pow (10,$length)-1),$length,'0',STR_PAD_LEFT);
	}

	/**
	 * 邮件内容模板
	 *
	 * @param $code
	 *
	 * @return string
	 */
	private function emailTpl ( $code )
	{
		$str
			= <<<str
<div id="mailContentContainer" class="qmbox qm_con_body_content qqmail_webmail_only" style="">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                       style=" border-collapse: collapse;">
                    <tbody>
                    <tr>
                        <td align="center" bgcolor="#141422"
                            style="padding: 40px 0 30px 0; color: #1B9388; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            «后盾人» 验证码
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#262633" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                <tr>
                                    <td style="color:#CFCFD1; font-family: Arial, sans-serif; font-size: 24px;font-weight: normal;">
                                        <b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 30px 0 30px 0; color:#CFCFD1; font-family: Arial, sans-serif; font-size: 16px; line-height: 2em;font-weight: normal;">
                                        验证码{$code}，您正在进行 后盾人 身份验证，千万不要告诉别人哦！
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;"
                                        width="75%">
                                        ® 后盾人 2018<br>
                                        <a style="color: #ffffff;">
                                            <font color="#ffffff">http://www.houdunren.com</font>
                                        </a>
                                    </td>
                                    <td align="right" width="25%">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;"></td>
                                                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: normal;color: #262633;">
                                                    后盾人提供技术支持
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

</div>
str;

		return $str;
	}
}