<?php namespace system\model;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use houdunwang\config\Config as C;
use houdunwang\db\Db;
use houdunwang\arr\Arr;
use houdunwang\request\Request;

/**
 * 站点模型
 * Class Site
 *
 * @package system\model
 */
class Site extends Common
{
    protected $allowFill = ['*'];

    protected $table = 'site';

    protected $validate
        = [
            ['name', 'required', '站点名称不能为空', self::MUST_VALIDATE, self::MODEL_INSERT,],
            ['name', 'unique', '站点名称已经存在', self::MUST_VALIDATE, self::MODEL_INSERT,],
            ['description', 'required', '网站描述不能为空', self::MUST_VALIDATE, self::MODEL_INSERT,],
        ];

    protected $auto
        = [
            ['weid', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['createtime', 'time', 'function', self::MUST_AUTO, self::MODEL_INSERT,],
            ['allfilesize', 200, 'string', self::MUST_AUTO, self::MODEL_INSERT],
            ['description', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['ucenter_template', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT,],
        ];

    /**
     * site_wechat多表关联
     *
     * @return mixed
     */
    public function wechat()
    {
        return $this->hasOne(SiteWeChat::class, 'siteid', 'siteid');
    }

    /**
     * 根据条件获取站点列表
     *
     * @param array $where 查找条件
     *
     * @return mixed
     */
    public static function getSiteByCondition(array $where = [])
    {
        //超级管理员获取所有站点
        if (User::isSuperUser()) {
            $sites = self::where($where)->where($where)->get();
        } else {
            //普通站长获取站点列表
            $where[] = ['uid', v('user.info.uid')];
            $sites   = self::join('site_user', 'site.siteid', '=', 'site_user.siteid')
                           ->groupBy('site.siteid')->where($where)->get();
        }
        if ($sites) {
            //获取站点套餐与所有者数据
            $Package = new Package();
            $User    = new User();
            foreach ($sites as $k => $v) {
                $v['owner'] = $User->getSiteOwner($v['siteid']);
                if ( ! empty($v['owner'])) {
                    //有站长时获取用户组名称
                    $v['user_group'] = UserGroup::where('id', $v['owner']['groupid'])->first();
                }
            }
        }

        return $sites;
    }

    /**
     * 检测站点是否关闭
     *
     * @return bool
     */
    public function isClose()
    {
        $owner = (new User())->getSiteOwner($this['siteid']);

        return empty($owner) || $owner['endtime'] == 0 || $owner['endtime'] > time();
    }

    /**
     * 站点用户
     *
     * @return mixed
     */
    public function siteUser()
    {
        return $this->hasMany(SiteUser::class, 'siteid');
    }

    /**
     * 系统启动时执行的站点信息初始化
     *
     * @return bool|void
     */
    public static function siteInitialize()
    {
        if (SITEID) {
            if (Db::table('site')->find(SITEID)) {
                return self::loadSite(SITEID);
            }

            return false;
        }

        return true;
    }

    /**
     * 加载当前请求的站点缓存
     *
     * @param int $siteId 站点编号
     *
     * @return bool|void
     */
    public static function loadSite($siteId)
    {
        //缓存存在时不获取
        if (v('site') || empty($siteId)) {
            return;
        };
        //站点信息
        v('site.info', cache("site", '[get]', 0, [], $siteId));
        //站点设置
        v('site.setting', cache("setting", '[get]', 0, [], $siteId));
        //微信帐号
        v('site.wechat', cache("wechat", '[get]', 0, [], $siteId));
        //加载模块
        v('site.modules', cache("modules", '[get]', 0, [], $siteId));
        //设置微信配置
        $config = [
            "token"          => v('site.wechat.token'),
            "encodingaeskey" => v('site.wechat.encodingaeskey'),
            "appid"          => v('site.wechat.appid'),
            "appsecret"      => v('site.wechat.appsecret'),
            "mch_id"         => v('site.setting.pay.wechat.mch_id'),
            "key"            => v('site.setting.pay.wechat.key'),
            "apiclient_cert" => v('site.setting.pay.wechat.apiclient_cert'),
            "apiclient_key"  => v('site.setting.pay.wechat.apiclient_key'),
            "rootca"         => v('site.setting.pay.wechat.rootca'),
            "back_url"       => '',
        ];
        //设置微信通信数据配置
        C::set('wechat', array_merge(C::get('wechat'), $config));
        //设置邮箱配置
        C::set('mail', v('site.setting.smtp'));
        //支付宝配置
        C::set('alipay', v('site.setting.pay.alipay'));
        //阿里云配置
        if (SITEID && v('site.setting.aliyun.aliyun.use_site_aliyun')) {
            C::set('aliyun', v('site.setting.aliyun.aliyun'));
        }

        return true;
    }

    /**
     * 删除站点
     *
     * @param int $siteId 站点编号
     *
     * @return bool
     */
    public function remove($siteId)
    {
        /**
         * 删除所有包含siteid的表
         * 因为siteid在系统中是站点编号
         */
        $tables = \Schema::getAllTableInfo();
        foreach ($tables['table'] as $name => $info) {
            $table = str_replace(\Config::get('database.prefix'), '', $name);
            //表中存在siteid字段时操作这个表
            if (\Schema::fieldExists('siteid', $table)) {
                Db::table($table)->where('siteid', $siteId)->delete();
            }
        }
        //删除缓存
        $keys = ['access', 'setting', 'wechat', 'site', 'modules', 'module_binding'];
        foreach ($keys as $key) {
            cache("$key", '[del]');
        }

        return true;
    }

    /**
     * 站点是否存在
     *
     * @param $siteId
     *
     * @return bool
     */
    public function has($siteId)
    {
        return $this->where('siteid', $siteId)->get() ? true : false;
    }

    /**
     * 新建站点时初始化站点的默认数据
     *
     * @param int $siteId 站点编号
     *
     * @return bool
     * @throws \Exception
     */
    public function InitializationSiteTableData($siteId)
    {
        /*
        |--------------------------------------------------------------------------
        | 站点设置
        |--------------------------------------------------------------------------
        */
        $SiteSetting                = new SiteSetting();
        $SiteSetting['siteid']      = $siteId;
        $SiteSetting['quickmenu']   = 1;
        $SiteSetting['creditnames'] = json_encode([
            'credit1' => ['title' => '积分', 'status' => 1, 'unit' => '个'],
            'credit2' => ['title' => '余额', 'status' => 1, 'unit' => '元'],
            'credit3' => ['title' => '', 'status' => 0, 'unit' => '个'],
            'credit4' => ['title' => '', 'status' => 0, 'unit' => '个'],
            'credit5' => ['title' => '', 'status' => 0, 'unit' => '个'],
        ], JSON_UNESCAPED_UNICODE);
        //注册设置
        $SiteSetting['register'] = [
            //注册方式
            'type' => 2,
            //注册邮箱或手机号需要验证
            'auth' => 0,
        ];
        //登录设置
        $SiteSetting['login'] = [
            //登录方式
            'type'          => 2,
            //微信桌面端登录
            'pc_wechat'     => 0,
            //微信客户端设置
            'mobile_wechat' => 1,
        ];
        //全局配置
        $SiteSetting['config'] = json_encode([
            'must_set_nickname' => 0,
            'must_set_icon'     => 0,
        ], JSON_UNESCAPED_UNICODE);
        //积分策略
        $SiteSetting['creditbehaviors'] = json_encode([
            'activity' => 'credit1',
            'currency' => 'credit2',
        ], JSON_UNESCAPED_UNICODE);
        $SiteSetting->save();

        /*
        |--------------------------------------------------------------------------
        | 站点会员组设置
        |--------------------------------------------------------------------------
        */
        $MemberGroup              = new MemberGroup();
        $MemberGroup['siteid']    = $siteId;
        $MemberGroup['title']     = '会员';
        $MemberGroup['credit']    = 0;
        $MemberGroup['isdefault'] = 1;
        $MemberGroup['is_system'] = 1;
        $MemberGroup->save();

        /*
        |--------------------------------------------------------------------------
        | 创建用户字段表数据
        |--------------------------------------------------------------------------
        */
        $memberField = new MemberFields();
        $memberField->where('siteid', $siteId)->delete();
        $profile_fields = Db::table('profile_fields')->get();
        foreach ($profile_fields as $f) {
            $d['siteid']  = $siteId;
            $d['field']   = $f['field'];
            $d['title']   = $f['title'];
            $d['orderby'] = $f['orderby'];
            $d['status']  = $f['status'];
            $memberField->insert($d);
        }
        /*
        |--------------------------------------------------------------------------
        | 初始化微信公众号
        |--------------------------------------------------------------------------
        */
        (new SiteWeChat())->save(['siteid' => $siteId]);
        /*
        |--------------------------------------------------------------------------
        | 初始快捷菜单
        |--------------------------------------------------------------------------
        */
        $data['siteid'] = $siteId;
        $data['data']   = '{"status":1,"system":[],"module":[]}';
        $data['uid']    = v('user.info.uid');
        Db::table('site_quickmenu')->insert($data);

        /*
        |--------------------------------------------------------------------------
        | 初始文章系统表
        |--------------------------------------------------------------------------
        */
        service('article.Init.make', $siteId);

        return true;
    }

    /**
     * 添加站点
     *
     * @param array $data 站点数据
     *
     * @return bool
     * @throws \Exception
     */
    public function addSite(array $data = [])
    {
        if ( ! User::hasAddSite(v('user.info.uid'))) {
            die(message('您可创建的站点数量已经用完,请联系管理员进行升级'));
        }
        //添加站点信息
        $site                     = new self();
        $site['name']             = Request::post('name');
        $site['description']      = Request::post('description');
        $site['domain']           = Request::post('domain');
        $site['module']           = Request::post('module');
        $site['ucenter_template'] = 'default';
        $site                     = $site->save($data);
        //添加站长数据,系统管理员不添加数据
        $uid = v('user.info.uid');
        if ( ! User::isSuperUser($uid)) {
            SiteUser::setSiteOwner($site['siteid'], $uid);
        }
        //创建用户字段表等数据
        $this->InitializationSiteTableData($site['siteid']);

        //更新站点缓存
        return $this->updateCache($site['siteid']);
    }

    /**
     * 获取用户管理的所有站点信息
     *
     * @param int $uid 用户编号
     *
     * @return array 站点列表
     */
    public function getUserAllSite($uid)
    {
        return $this->join('site_user', 'site.siteid', '=', 'site_user.siteid')
                    ->where('site_user.uid', $uid)->get();
    }

    /**
     * 更新站点数据缓存
     *
     * @param int $siteId 网站编号
     *
     * @return bool
     * @throws \Exception
     */
    public static function updateCache($siteId = 0)
    {
        $siteId = $siteId ?: siteid();
        //站点微信信息缓存
        $wechat         = Db::table('site_wechat')->where('siteid', $siteId)->first();
        $data['wechat'] = $wechat ?: [];
        //站点信息缓存
        $site         = Db::table('site')->where('siteid', $siteId)->first();
        $data['site'] = $site ?: [];
        //站点设置缓存
        $data['setting'] = self::formatSiteConfig($siteId);
        //站点模块
        $data['modules'] = (new Modules())->getSiteAllModules($siteId, false);
        foreach ($data as $key => $value) {
            cache($key, $value, 0, ['siteid' => $siteId, 'module' => '', 'type' => 'system'],
                $siteId);
        }

        return true;
    }

    /**
     * 初始站点配置项用于缓存
     *
     * @param int $siteId 站点编号
     *
     * @return array
     */
    protected static function formatSiteConfig($siteId)
    {
        $setting               = Db::table('site_setting')->where('siteid', $siteId)->first();
        $setting               = $setting ?: [];
        $setting ['smtp']      = Arr::merge([
            'host'         => 'smtpdm.aliyun.com',
            'port'         => '25',
            'ssl'          => '0',
            'username'     => 'edu@vip.houdunren.com',
            'password'     => 'HOUdunwang2010',
            'fromname'     => '后盾人在线IT教学网站',
            'frommail'     => 'edu@vip.houdunren.com',
            'testing'      => '1',
            'testusername' => '2300071698@qq.com',
        ], json_decode($setting['smtp'], true));
        $setting ['quickmenu'] = $setting['quickmenu'];
        //短信设置
        $setting ['sms'] = Arr::merge([
            'provider' => 'aliyun',
            'aliyun'   => [
                'endPoint' => 'https://297600.mns.cn-hangzhou.aliyuncs.com/',
                'sign'     => '',
                'template' => '',
                'topic'    => 'sms.topic-cn-hangzhou',
                'code'     => [
                    'sign'        => '',
                    'template'    => '',
                    //测试手机号
                    'test_mobile' => '',
                ],
            ],
        ], json_decode($setting['sms'], true));
        //支付设置
        $setting ['pay'] = Arr::merge([
            'wechat' => [
                'open'           => 1,
                'version'        => 1,
                'mch_id'         => '',
                'key'            => '',
                'partnerid'      => '',
                'partnerkey'     => '',
                'paysignkey'     => '',
                'apiclient_cert' => '',
                'apiclient_key'  => '',
                'rootca'         => '',
            ],
            'alipay' => [
                'open'                 => 1,
                'app_id'               => '',
                'merchant_private_key' => '',
                'notify_url'           => '',
                'return_url'           => '',
                'charset'              => 'UTF-8',
                'sign_type'            => 'RSA2',
                'gatewayUrl'           => 'https://openapi.alipay.com/gateway.do',
                'alipay_public_key'    => '',
            ],
        ], json_decode($setting['pay'], true));

        //积分名称
        $setting ['creditnames'] = Arr::merge([
            'credit1' => ['title' => '积分', 'status' => 1],
            'credit2' => ['title' => '余额', 'status' => 1],
            'credit3' => ['title' => '', 'status' => 0],
            'credit4' => ['title' => '', 'status' => 0],
            'credit5' => ['title' => '', 'status' => 0],
        ], json_decode($setting['creditnames'], true));

        //积分策略
        $setting ['creditbehaviors'] = Arr::merge([
            'activity' => 'credit1',
            'currency' => 'credit2',
        ], json_decode($setting['creditbehaviors'], true));

        //注册配置
        $setting ['register'] = Arr::merge([
            //注册方式
            'type' => 2,
            //注册邮箱或手机号需要验证
            'auth' => 0,
        ], json_decode($setting['register'], true));

        //登录配置
        $setting ['login'] = Arr::merge([
            //登录方式
            'type'          => 2,
            //微信桌面端登录
            'pc_wechat'     => 0,
            //微信客户端设置
            'mobile_wechat' => 1,
        ], json_decode($setting['login'], true));

        //站点全局配置
        $setting ['config'] = Arr::merge([
            //会员必须设置昵称
            'must_set_nickname' => 0,
            //会员必须设置头像
            'must_set_icon'     => 0,
            //模板目录独立
            'template_dir_diff' => 1,
        ], json_decode($setting['config'], true));
        //阿里云
        $setting ['aliyun'] = Arr::merge([
            'aliyun' => [
                'use_site_aliyun' => 0,
                'regionId'        => 'cn-hangzhou',
                'accessId'        => '',
                'accessKey'       => '',
            ],
            'oss'    => [
                'bucket'        => '',
                'endpoint'      => '',
                'custom_domain' => 1,
                'use_site_oss'  => 0,
            ],
        ], json_decode($setting['aliyun'], true));

        return $setting;
    }

    /**
     * 更新所有站点缓存
     *
     * @return bool
     * @throws \Exception
     */
    public static function updateAllCache()
    {
        foreach (self::lists('siteid') as $siteid) {
            self::updateCache($siteid);
        }

        return true;
    }

    /**
     * 根据站长会员编号更新站点编号
     *
     * @param int $uid 站长编号
     *
     * @return bool
     * @throws \Exception
     */
    public static function updateSiteCacheByUid($uid = 0)
    {
        $uid   = $uid ?: v('user.info.uid');
        $sites = Db::table('site_user')->where('uid', $uid)->where('role', 'owner')->lists('siteid');
        foreach ((array)$sites as $id) {
            self::updateCache($id);
        }

        return true;
    }

    /**
     * 初始化站点时设置微信数据
     *
     * @param $siteid
     *
     * @return 微信表新增主键编号
     */
    public function initSiteWeChat($siteid)
    {
        $data = [
            'siteid'     => $siteid,
            'wename'     => '',
            'account'    => '',
            'original'   => '',
            'level'      => 1,
            'appid'      => '',
            'appsecret'  => '',
            'qrcode'     => '',
            'icon'       => '',
            'is_connect' => 0,
        ];

        return $this->insertGetId($data);
    }
}