<?php namespace module;

use houdunwang\config\Config;
use houdunwang\request\Request;
use houdunwang\route\Controller;
use system\model\Member;
use system\model\MemberToken;
use system\model\Modules;
use Code;
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
     * 会员令牌资料
     *
     * @var string
     */
    protected $token;

    /**
     * 构造函数
     * HdApi constructor.
     */
    public function __construct()
    {
        $this->siteid = siteid();
        $module       = new Modules();
        $this->config = $module->getModuleConfig();
        if ($token = Request::post('token')) {
            $this->token = MemberToken::where('token', $token)->first();
        }
        //验证直接返回，不进行页面响应
        Config::set('validate.dispose', 'default');
    }

    /**
     * 更新站点缓存
     *
     * @param int $siteid 站点编号
     *
     * @return bool
     */
    public function updateSiteCache($siteid = 0)
    {
        return Site::updateCache($siteid);
    }

    /**
     * 验证登录状态
     *
     * @return bool
     */
    public function auth()
    {
        return $this->token ? true : false;
    }

    public function success($message, $data = [])
    {
        return ['vaid' => 1, 'messate' => $message, 'data' => $data];
    }

    public function error($message, $data = [])
    {
        return ['vaid' => 0, 'messate' => $message, 'data' => $data];
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
        $res   = Member::login(Request::post());
        $token = MemberToken::where('uid', $res['uid'])->first();
        if (empty($token)) {
            $model                = new MemberToken();
            $model['uid']         = $res['uid'];
            $model['token']       = md5($res['uid'], time());
            $model['expire_time'] = '2020-2-22 3:22:12';
            $model->save();

            return $this->success('注册成功', ['token' => $model['token']]);
        }

        return $this->error($res['message'] ?: '登录失败');
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
}