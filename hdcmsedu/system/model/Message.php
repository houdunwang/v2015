<?php namespace system\model;

use houdunwang\model\Model;
use houdunwang\aliyunsms\Sms;
use Request;
use Tool;
use Session;
use View;

/**
 * Class Message
 *
 * @package system\model
 */
class Message extends Model
{
    //数据表
    protected $table = "message";

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
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;


    /**
     * 获取上次发送的验证码时间
     *
     * @return int
     */
    public static function getLastSendTime()
    {
        return $sendTime = self::where('ip', Request::ip())->orderBy('id', 'DESC')->pluck('sendtime') ?: 0;
    }

    /**
     * 检测发送时间差
     *
     * @param int $step 间隔时间
     *
     * @return int
     */
    public static function sendDiffTime($step = 60)
    {
        return self::getLastSendTime() + $step - time();
    }

    /**
     * 发送手机短信
     *
     * @param $data
     *
     * @return bool|string
     */
    public static function sendMobileMessage($data)
    {
        $res = Sms::send($data);
        if ($res['errcode'] == 0) {
            $data['ip']       = Request::ip();
            $data['sendtime'] = time();
            $data['data']     = serialize($data);

            return boolval(call_user_func_array([new static(), 'save'], [$data]));
        } else {
            return false;
        }
    }

    /**
     * 发送邮件信息
     *
     * @param $data
     *
     * @return bool|string
     */
    public static function sendMailMessage($data)
    {
        $res = Mail::send($data['mail'], $data['mail'], $data['title'], function () use ($data) {
            return View::instance()->with(['title' => $data['title'], 'content' => $data['data']])->fetch('resource/view/email');
        });
        if ($res['errcode'] == 0) {
            $data['ip']       = Request::ip();
            $data['sendtime'] = time();
            $data['data']     = serialize($data);

            return boolval(call_user_func_array([new static(), 'save'], [$data]));
        } else {
            return false;
        }
    }

    /**
     * 发送验证码
     *
     * @param array $config
     *                    $config=[
     *                    'user'=>'手机号或邮箱系统会自动识别',
     *                    'sign'=>'签名',
     *                    'template'=>'短信模板'
     *                    ]
     * @param int   $step 间隔时间
     *
     * @return array
     */
    public function sendCode(array $config, $step = 60)
    {
        //测试上次发送时间
        if (($times = Message::sendDiffTime($step)) > 0) {
            return ['valid' => 0, 'message' => '请'.$times.'秒后发送'];
        }
        $code     = Tool::rand(4);
        $status   = false;
        $userType = '';
        if (preg_match('/^\d{11}$/', $config['user'])) {
            $config   = array_merge(v('site.setting.sms.aliyun.code'), $config);
            $userType = 'mobile';
            $data     = [
                //短信签名
                'sign'     => $config['sign'],
                //短信模板
                'template' => $config['template'],
                //手机号
                'mobile'   => $config['user'],
                //模板变量
                'vars'     => ["code" => $code, "product" => v('site.info.name')],
            ];
            $status   = $this->sendMobileMessage($data);
        }
        if (preg_match('/\w+@\w+/', $config['user'])) {
            $userType = 'email';
            $siteName = v('site.info.name');
            $content  = "验证码{$code}，您正在进行 {$siteName} 身份验证，千万不要告诉别人哦！";
            $data     = [
                'mail'  => $config['user'],
                'title' => "«{$siteName}» 验证码",
                'data'  => $content,
            ];
            $status   = $this->sendMailMessage($data);
        }
        if ($status) {
            Session::set('MessageValidCode', ['code' => $code, 'user' => $config['user'], 'type' => $userType]);
            switch ($userType) {
                case 'mobile':
                    $message = '验证码已经发送到 '.$config['user'];
                    break;
                case 'email':
                    $message = '验证码已经发送到 '.$config['user'].'<br/>有些邮件会发送到垃圾箱中，请注意查看';
                    break;
            }

            return ['valid' => 1, 'message' => $message,];
        } else {
            return ['valid' => 0, 'message' => '验证码发送失败，发送地址或网站配置错误',];
        }
    }

    /**
     * 测试验证码
     *
     * @param array $data ['code'=>'验证码','user'=>'帐号']
     *
     * @return bool
     */
    public function checkCode(array $data)
    {
        return Session::get('MessageValidCode.code') == $data['code'] && Session::get('MessageValidCode.user') == $data['user'];
    }
}