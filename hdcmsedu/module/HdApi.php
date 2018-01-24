<?php namespace module;

use houdunwang\config\Config;
use houdunwang\request\Request;
use houdunwang\route\Controller;
use houdunwang\tool\Tool;
use system\model\Member;
use system\model\MemberToken;
use system\model\Message;
use system\model\Modules;
use houdunwang\code\Code;
use system\model\Site;

/**
 * 接口基础类
 * Class HdApi
 *
 * @package module
 */
abstract class HdApi extends Controller
{
    /**
     * 站点编号
     *
     * @var string
     */
    protected $siteid;

    /**
     * 配置项
     *
     * @var array
     */
    protected $config;

    /**
     * 登录帐号资料
     *
     * @var string
     */
    protected $user;

    /**
     * 构造函数
     * HdApi constructor.
     */
    public function __construct()
    {
        $this->siteid = siteid();
        $module       = new Modules();
        $this->config = $module->getModuleConfig();
        if ($uid = v('member.info.uid')) {
            $this->user = Member::find($uid);
        }
        if ($token = Request::post('token')) {
            $this->user = MemberToken::where('token', $token)->first();
        }
        //验证直接返回，不进行页面响应
        Config::set('validate.dispose', 'default');
    }

    /**
     * 更新站点缓存
     *
     * @param int $siteid
     *
     * @return bool
     * @throws \Exception
     */
    public function updateSiteCache($siteid = 0)
    {
        return Site::updateCache($siteid);
    }

    /**
     * 验证登录状态
     *
     * @param bool $dispose
     * true:验证失败时直接响应给客户端JSON（默认） false:返回验证状态
     *
     * @return bool
     */
    public function auth($dispose = true)
    {
        $stat = $this->user ? true : false;
        if ($stat === false && $dispose) {
            die(json_encode($this->error('请登录后操作')));
        }

        return $stat;
    }

    public function success($message, $data = [])
    {
        return ['valid' => 1, 'message' => $message, 'data' => $data];
    }

    public function error($message, $data = [])
    {
        return ['valid' => 0, 'message' => $message, 'data' => $data];
    }

    /**
     * 会员注册
     *
     * @return array
     * @throws \Exception
     */
    public function register()
    {
        $res = Member::register(Request::post());
        if ($res['valid'] == 1) {
            $token = MemberToken::where('uid', $res['uid'])->first();
            if (empty($token)) {
                $model                = new MemberToken();
                $model['uid']         = $res['uid'];
                $model['token']       = md5($res['uid'], time());
                $model['expire_time'] = '2020-2-22 3:22:12';
                $model->save();

                return $this->success('注册成功');
            }
        }

        return $this->error($res['message'] ?: '登录失败');
    }

    /**
     * 会员登录
     *
     * @return array
     * @throws \Exception
     */
    public function login()
    {
        $res = Member::login(Request::post());
        if ($res['valid'] == 0) {
            return $res;
        }
        $model                = MemberToken::where('uid', $res['uid'])->first()
            ?: new MemberToken();
        $model['uid']         = $res['uid'];
        $model['token']       = md5($res['uid'] . time());
        $model['expire_time'] = '2030-2-22 3:22:12';
        $model->save();

        return $this->success('登录成功', ['token' => $model['token']]);
    }

    /**
     * 退出登录
     *
     * @return array
     */
    public function out()
    {
        if ($this->token) {
            $this->token->destory();

            return $this->success('退出成功');
        }

        return $this->error('退出失败');
    }

    /**
     * 发送手机短信
     *
     * @param string $mobile 手机号
     * @param string $code   验证码
     *
     * @return array
     */
    public function mobileMessage($mobile = '', $code = '')
    {
        $mobile = $mobile ?: Request::post('username');
        $code   = $code ?: Tool::rand(4);
        $data   = [
            //短信签名
            'sign'     => '后盾网',
            //短信模板
            'template' => 'SMS_12840367',
            //手机号
            'mobile'   => $mobile,
            //模板变量
            'vars'     => ["code" => $code, "product" => v('site.info.name')],
        ];
        if (Message::sendMobileMessage($data) === true) {
            return $this->success('发送成功');
        } else {
            return $this->error('发送失败');
        }
    }
}