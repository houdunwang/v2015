<?php namespace app\site\controller;

use houdunwang\request\Request;
use houdunwang\view\View;
use system\model\Message;
use system\model\SiteSetting;
use system\model\Site;
use system\model\SiteWeChat;
use houdunwang\config\Config;
use houdunwang\mail\Mail;

/**
 * 网站配置管理
 * Class Setting
 *
 * @package app\site\controller
 */
class Setting extends Admin
{
    //模型
    protected $db;

    //主键
    protected $id;

    /**
     * Setting constructor.
     */
    public function __construct()
    {
        parent::__construct();
        auth();
        $this->id = SiteSetting::where('siteid', SITEID)->pluck('id');
        $this->db = $this->id ? SiteSetting::find($this->id) : new SiteSetting();
    }

    /**
     * 站点全局配置项
     *
     * @param \system\model\Site $SiteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function config(Site $SiteModel)
    {
        if (IS_POST) {
            $this->db['config'] = Request::post('config');
            $this->db->save();
            $SiteModel->updateCache();

            return message('站点设置更新成功');
        }
        $field = v('site.setting.config');

        return view('', compact('field'));
    }

    /**
     * 积分设置
     *
     * @param \system\model\Site $SiteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function credit(Site $SiteModel)
    {
        if (IS_POST) {
            //积分/余额必须开启
            $_POST['creditnames']['credit1']['status'] = 1;
            $_POST['creditnames']['credit2']['status'] = 1;
            foreach ($_POST['creditnames'] as $credit => $d) {
                $_POST['creditnames'][$credit]['status'] = isset($d['status']) ? intval($d['status']) : 0;
            }
            $this->db['creditnames'] = json_encode($_POST['creditnames'], JSON_UNESCAPED_UNICODE);
            $this->db->save();
            $SiteModel->updateCache();

            return message('积分设置成功');
        }
        View::with('creditnames', v('site.setting.creditnames'));

        return view();
    }

    /**
     * 积分策略
     *
     * @param \system\model\Site $siteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function tactics(Site $siteModel)
    {
        if (IS_POST) {
            $this->db['creditbehaviors'] = json_encode(Request::post('creditbehaviors'), JSON_UNESCAPED_UNICODE);
            $this->db->save();
            $siteModel->updateCache();

            return message('积分策略更新成功');
        }

        return view();
    }

    /**
     * 注册设置
     *
     * @param \system\model\Site $siteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function register(Site $siteModel)
    {
        if (IS_POST) {
            $this->db['register'] = Request::post('register');
            $this->db['login']    = Request::post('login');
            $this->db->save();
            $siteModel->updateCache();

            return message('修改会员注册设置成功');
        }
        $register = v('site.setting.register');
        $login    = v('site.setting.login');

        return view('', compact('register', 'login'));
    }

    /**
     * 邮件通知设置
     * @param \system\model\Site $siteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function mail(Site $siteModel)
    {
        if (IS_POST) {
            $config           = Request::post('smtp');
            $this->db['smtp'] = json_encode($config, JSON_UNESCAPED_UNICODE);
            $this->db->save();
            $siteModel->updateCache();
            Config::set('mail', $config);
            //发送测试邮件
            if ($config['testing']) {
                $d = Mail::send($config['testusername'], $config['testusername'], "邮箱配置测试成功", function () {
                    return View::instance()->with(['title' => '测试邮件发送成功', 'content' => '恭喜！站点邮箱配置正确'])->fetch('resource/view/email');
                });
                if ($d) {
                    return message("测试邮件发送成功", 'refresh', 'success', 3);
                } else {
                    return message("测试邮件发送失败", 'refresh', 'error', 3);
                }
            }

            return message('邮箱配置保存成功', 'refresh');
        }

        return view();
    }

    /**
     * 短信通知设置
     *
     * @param \system\model\Site $siteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function mobile(Site $siteModel)
    {
        if (IS_POST) {
            $this->db['sms'] = Request::post('data');
            $this->db->save();
            $siteModel->updateCache();

            return message('配置保存成功', 'refresh');
        }
        $sms = json_encode(v('site.setting.sms'));

        return view()->with('sms', $sms);
    }

    /**
     * 发送阿里云测试验证码
     *
     * @return mixed
     */
    public function aliyunCodeTest()
    {
        $post    = json_decode(Request::post('data'), true);
        $message = new Message();
        $config  = [
            'sign'     => $post['aliyun']['code']['sign'],
            'template' => $post['aliyun']['code']['template'],
            'user'     => $post['aliyun']['code']['test_mobile'],
        ];

        return $message->sendCode($config, 60);
    }

    /**
     * 微信支付
     *
     * @param \system\model\Site       $SiteModel
     * @param \system\model\SiteWeChat $WeChatModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function wepay(Site $SiteModel, SiteWeChat $WeChatModel)
    {
        if (IS_POST) {
            $this->db['id']  = $this->id;
            $this->db['pay'] = Request::post('data');
            $this->db->save();
            $SiteModel->updateCache();

            return message('修改会员支付参数成功', 'back');
        }
        $wechat      = SiteWeChat::where('siteid', siteid())->first();
        $weChatLevel = $WeChatModel->chatNameBylevel($wechat['level']);
        $data        = v('site.setting.pay');

        return view()->with(compact('wechat', 'weChatLevel', 'data'));
    }

    /**
     * 支付宝支付
     *
     * @param \system\model\Site $SiteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function alipay(Site $SiteModel)
    {
        if (IS_POST) {
            $this->db['id']  = $this->id;
            $this->db['pay'] = Request::post('data');
            $this->db->save();
            $SiteModel->updateCache();

            return message('修改支付宝参数成功', 'back');
        }
        $data = v('site.setting.pay');

        return view()->with(compact('data'));
    }

    /**
     * 阿里云配置
     *
     * @param \system\model\Site $SiteModel
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function aliyun(Site $SiteModel)
    {
        if (IS_POST) {
            $this->db['id']     = $this->id;
            $this->db['aliyun'] = Request::post('config');
            $this->db->save();
            $SiteModel->updateCache();

            return message('修改会员支付参数成功', 'back');
        }

        return view();
    }
}