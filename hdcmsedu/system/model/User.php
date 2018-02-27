<?php namespace system\model;

use houdunwang\db\Db;
use houdunwang\arr\Arr;
use houdunwang\session\Session;
use houdunwang\request\Request;

/**
 * 管理员模型
 * Class User
 *
 * @package system\model
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class User extends Common
{
    /**
     * @var string
     */
    protected $table = 'user';
    protected $denyInsertFields = ['uid'];
    protected $validate
        = [
            ['username', 'required', '用户名不能为空', self::MUST_VALIDATE, self::MODEL_INSERT,],
            ['username', 'minlen:3', '用户名不能少于三位', self::MUST_VALIDATE, self::MODEL_INSERT],
            [
                'username',
                'regexp:/^[a-z][\w@]+$/i',
                '用户名必须是字母与数字组成',
                self::EXIST_VALIDATE,
                self::MODEL_BOTH,
            ],
            ['username', 'unique', '用户名已经存在', self::EXIST_VALIDATE, self::MODEL_BOTH,],
            ['password', 'required', '密码不能为空', self::EXIST_VALIDATE, self::MODEL_UPDATE,],
            ['password', 'required', '密码不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT,],
            ['password', 'minlen:5', '密码不能少于五位', self::EXIST_VALIDATE, self::MODEL_BOTH,],
            ['password2', 'confirm:password', '两次密码输入不一致', self::EXIST_VALIDATE, self::MODEL_BOTH,],
            ['groupid', 'regexp:/^\d+$/', '用户组不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['qq', 'regexp:/^\d+$/', '请输入正确的QQ号', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH,],
            ['qq', 'unique', 'QQ号已经被使用', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH,],
            ['email', 'email', '邮箱格式错误', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH,],
            ['email', 'unique', '邮箱已经被注册', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH,],
            ['mobile', 'regexp:/^\d{11}$/', '手机号格式错误', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH,],
            ['mobile', 'unique', '手机号已经被其他用户注册', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH,],
        ];

    protected $auto
        = [
            ['groupid', 'autoGroupId', 'method', self::EMPTY_AUTO, self::MODEL_INSERT,],
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH,],
            ['regtime', 'time', 'function', self::EMPTY_AUTO, self::MODEL_INSERT,],
            ['regip', 'clientIp', 'function', self::EMPTY_AUTO, self::MODEL_INSERT,],
            ['lasttime', 'time', 'function', self::MUST_AUTO, self::MODEL_INSERT,],
            ['lastip', 'clientIp', 'function', self::EMPTY_AUTO, self::MODEL_INSERT,],
            ['starttime', 'time', 'function', self::EMPTY_AUTO, self::MODEL_INSERT,],
            ['endtime', 'time', 'function', self::EMPTY_AUTO, self::MODEL_INSERT,],
            ['qq', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['realname', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['mobile', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['email', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['mobile_valid', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['email_valid', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['remark', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];
    protected $filter
        = [
            ['password', self::EMPTY_FILTER, self::MODEL_BOTH],
        ];

    /**
     * 获取默认组
     */
    protected function autoGroupId()
    {
        return v('config.register.groupid');
    }

    /**
     * 修改密码
     *
     * @param int    $uid      用户编号
     * @param string $password 密码
     *
     * @return mixed
     */
    public function changePassword($uid, $password)
    {
        $info             = $this->getPasswordAndSecurity($password);
        $user             = self::find($uid);
        $user['password'] = $info['password'];
        $user['security'] = $info['security'];

        return $user->save();
    }

    /**
     * 根据密码获取密钥与加密后的密码数据及确认密码
     *
     * @param string $password 密码
     *
     * @return array
     */
    public static function getPasswordAndSecurity($password)
    {
        $data             = [];
        $data['security'] = substr(md5(time()), 0, 10);
        $data['password'] = md5($password . $data['security']);

        return $data;
    }

    /**
     * 会员组表关联
     *
     * @return mixed
     */
    public function userGroup()
    {
        return $this->belongsTo('system\model\UserGroup', 'groupid');
    }

    /**
     * 系统临时关闭显示提示信息
     *
     * @return mixed
     */
    public function systemIsClose()
    {
        /**
         * 站点关闭检测,系统管理员忽略检测
         */
        if ( ! User::isSuperUser() && ! v('config.site.is_open')) {
            Session::flush();
            die(view('app/system/view/entry/site_close.php'));
        }
    }

    /**
     * 超级管理员检测
     *
     * @param int $uid 会员编号
     *
     * @return bool
     */
    public static function isSuperUser($uid = 0)
    {
        if (self::loginAuth() == false) {
            return false;
        }
        $uid  = $uid ?: v("user.info.uid");
        $user = self::find($uid);

        return $user && $user['groupid'] == 0;
    }

    /**
     * 是否为站长
     * 当前帐号是否拥有站长权限
     *
     * @param int $siteId 站点编号
     * @param int $uid    用户编号 默认使用当前登录的帐号
     *
     * @return bool
     */
    public function isOwner($siteId = 0, $uid = 0)
    {
        static $cache = [];
        if ($this->loginAuth() == false) {
            return false;
        }
        $siteId = $siteId ?: SITEID;
        $uid    = $uid ?: v("user.info.uid");
        if ( ! isset($cache[$uid])) {
            if ($this->isSuperUser($uid)) {
                return true;
            }

            $cache[$uid] = Db::table('site_user')->where('siteid', $siteId)->where('uid', $uid)
                             ->where('role', 'owner')
                             ->get() ? true
                : false;
        }

        return $cache[$uid];
    }

    /**
     * 站点管理员检测
     * 是否拥有管理员及以上权限(网站所有者,系统管理员)
     *
     * @param int $siteId 站点编号
     * @param int $uid    用户编号 默认使用当前登录的帐号
     *
     * @return bool|string
     */
    public static function isManage($siteId = 0, $uid = 0)
    {
        static $cache = [];
        if (self::loginAuth() == false) {
            return false;
        }
        $siteId    = $siteId ?: SITEID;
        $uid       = $uid ?: v("user.info.uid");
        $cacheName = $uid . $siteId;
        if ( ! isset($cache[$cacheName])) {
            if (self::isSuperUser($uid)) {
                return true;
            }
            $cache[$cacheName] = Db::table('site_user')->where('siteid', $siteId)
                                   ->where('uid', $uid)
                                   ->WhereIn('role', ['manage', 'owner'])->get();
        }

        return $cache[$cacheName];
    }


    /**
     * 站点操作员权限检测
     * 是否拥有操作员及以上权限
     *
     * @param int $siteId 站点编号
     * @param int $uid    用户编号 默认使用当前登录的帐号
     *
     * @return bool|string
     */
    public static function isOperate($siteId = 0, $uid = 0)
    {
        static $cache = [];
        if (self::loginAuth() == false) {
            return false;
        }
        $siteId = $siteId ?: SITEID;
        $uid    = $uid ?: v("user.info.uid");
        if ( ! isset($cache[$uid])) {
            if (self::isSuperUser($uid, 'return')) {
                return true;
            }

            $cache[$uid] = Db::table('site_user')->where('siteid', $siteId)->where('uid', $uid)
                             ->WhereIn(
                                 'role', ['owner', 'manage', 'operate',]
                             )->get();
        }

        return $cache[$uid];
    }


    /**
     * 帐号注册
     *
     * @param $data
     *
     * @return bool
     * @throws \Exception
     */
    public function register($data)
    {
        $User             = new self();
        $User['username'] = $data['username'];
        //用户组过期时间
        $daylimit        = Db::table('user_group')->where('id', v('config.register.groupid'))
                             ->pluck('daylimit');
        $User['endtime'] = time() + $daylimit * 3600 * 24;
        //获取密码与加密密钥
        $info             = $User->getPasswordAndSecurity($data['password']);
        $User['password'] = $info['password'];
        $User['security'] = $info['security'];
        $User['email']    = $data['email'];
        $User['qq']       = $data['qq'];
        $User['mobile']   = $data['mobile'];
        $User['groupid']  = v('config.register.groupid');
        $User['status']   = v('config.register.audit') ? 0 : 1;

        return $User->save();
    }

    /**
     * 用户登录
     *
     * @param array $data 登录数据
     *
     * @return bool|array
     */
    public function login(array $data)
    {
        $user = Db::table('user')->where('username', $data['username'])->first();
        if (empty($user)) {
            return '帐号不存在';
        }
        if ( ! $this->checkPassword($data['password'], $user['username'])) {
            return '密码输入错误';
        }

        if ( ! $user['status']) {
            return '您的帐号正在审核中';
        }
        //更新登录状态
        $data             = [];
        $data['lastip']   = Request::ip();
        $data['lasttime'] = time();
        Db::table('user')->where('uid', $user['uid'])->update($data);
        Session::set("admin_uid", $user['uid']);

        return true;
    }

    /**
     * 初始用户信息
     *
     * @return bool
     */
    public static function initUserInfo()
    {
        $adminUid = Session::get("admin_uid");
        if ($adminUid) {
            if ( ! v('user')) {
                $user                         = [];
                $user['info']                 = Db::table('user')->find($adminUid);
                $user['group']                = Db::table('user_group')
                                                  ->where('id', $user['info']['groupid'])->first();
                $user['system']['super_user'] = $user['group']['id'] == 0;
                v('user', $user);
            }
        }

        return v('user.info.uid') ? true : false;
    }

    /**
     * 验证密码是否正确
     *
     * @param string $password 登录密码
     * @param string $username 用户名
     *
     * @return bool
     */
    public function checkPassword($password, $username)
    {
        $user = Db::table('user')->where('username', $username)->first();

        return $user && $user['password'] == md5($password . $user['security']);
    }

    /**
     * 登录验证
     *
     * @return bool
     */
    public static function loginAuth()
    {
        return self::initUserInfo();
    }

    /**
     * 后台登录地址
     *
     * @return string
     */
    public static function getLoginUrl()
    {
        return __ROOT__ . '/index.php/' . q('session.system.login', 'hdcms');
    }

    /**
     * 后台用户登录站点着陆页
     *
     * @return mixed|string
     */
    public static function adminEntryPage()
    {
        $url = u('system.site.lists');
        if (Session::get('system.login') == 'admin') {
            //站点管理平台
            $site = Db::table('module_domain')->where('domain', $_SERVER['SERVER_NAME'])->first();
            if ($site) {
                $url = __ROOT__ . '?s=site/entry/home&siteid=' . $site['siteid'];
            }
        }

        return $url;
    }

    /**
     * 超级管理员验证
     * 异步请求会返回json数据否则直接回调页面
     *
     * @param int $uid
     *
     * @return bool
     */
    public static function superUserAuth($uid = 0)
    {
        $uid = $uid ?: v("user.info.uid");
        if ( ! self::isSuperUser($uid)) {
            return false;
        }

        return true;
    }

    /**
     * 验证后台管理员帐号在当前站点的权限
     * 如果当前有模块动作时同时会验证帐号访问该模块的权限
     *
     * @param string $permission 模块权限标识
     *
     * @return bool
     */
    public static function auth($permission = '')
    {
        //操作员检测
        if (self::isOperate() != true) {
            return false;
        }
        $module = v('module.name');
        if (v('module.is_system') == 1 && User::isManage()) {
            return true;
        } elseif ($module && v('module.is_system') == 0) {
            //验证能否使用该模块
            if (self::authModule($module) == false) {
                return false;
            }
            //没有设置权限标识时如果是模块的业务动作即控制器/方法访问时,定义权限标识然后与权限表比对
            if (empty($permission) && $action = Request::get('action')) {
                $permission = strtolower($action);
            }
        } elseif ($menuId = Request::get('mi')) {
            //系统动作权限标识
            $permission = Db::table('menu')->where('id', $menuId)->pluck('permission');
        }
        if ( ! empty($permission)) {
            return self::authIdentity($permission);
        }

        return true;
    }

    /**
     * 验证帐号是否可以使用模块
     * 但不验证权限标识
     *
     * @param string $module 模块名称
     *
     * @return bool
     */
    public static function authModule($module = '')
    {
        static $cache = [];
        $module = $module ?: v('module.name');

        //存在缓存时使用缓存处理
        if ( ! isset($cache[$module])) {
            //用户允许使用的模块数据
            $allowModule    = Modules::getBySiteUser();
            $cache[$module] = isset($allowModule[$module]);
        }

        if ( ! $cache[$module]) {
            return false;
        }

        return $cache[$module];

    }

    /**
     * 根据标识验证模块的访问权限
     * 系统模块时使用 system标识验证,因为所有系统模块权限是统一管理的
     * 插件模块是独立设置的,所以针对插件使用插件名标识进行验证
     *
     * @param string $identify 权限标识
     *
     * @return bool
     */
    public static function authIdentity($identify)
    {
        if ( ! self::isOperate()) {
            return false;
        }
        $type   = v('module.is_system') ? 'system' : v('module.name');
        $Module = new Modules();
        //扩展模块且这个权限标识不需要验证
        if ($type != 'system' && ! $Module->hasAuthIdentity($type, $identify)) {
            return true;
        }

        $permission = Db::table('user_permission')->where('siteid', siteid())
                        ->where('uid', v("user.info.uid"))->get();
        if (empty($permission)) {
            return true;
        }

        foreach ($permission as $v) {
            $access = Arr::valueCase(explode('|', $v['permission']), 0);
            if ($v['type'] == $type && in_array($identify, $access)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 模块访问验证
     * 当前站点不能使用这个模块或用户没有管理权限时
     * 验证将失败
     */
    public function moduleVerify()
    {
        $Module = new Modules();
        if ( ! $this->isOperate() || ! $Module->hasModule()) {
            return false;
        }

        return true;
    }

    /**
     * 获取站点管理员角色
     *
     * @param array $role   角色类型：owner: 所有者 manage: 管理员  operate: 操作员
     * @param int   $siteId 站点编号
     *
     * @return mixed
     */
    public function getSiteRole(array $role, $siteId = 0)
    {
        $siteId = $siteId ?: SITEID;
        $field  = 'uid,groupid,username,role';
        $users  = $this->join('site_user', 'user.uid', '=', 'site_user.uid')
                       ->whereIn('role', $role)->where('siteid', $siteId)->lists($field);

        return $users ?: [];

    }

    /**
     * 获取站长信息
     *
     * @param int $siteId 站点编号
     *
     * @return mixed
     */
    public function getSiteOwner($siteId = 0)
    {
        $siteId = $siteId ?: SITEID;
        static $cache = [];
        if ( ! isset($cache[$siteId])) {
            $uid = SiteUser::where('siteid', $siteId)->where('role', 'owner')->pluck('uid');
            if ($uid) {
                $cache[$siteId] = Db::table('user')->find($uid);
            }
        }

        return $cache[$siteId] ?: [];
    }

    /**
     * 获取站点管理所有用户
     *
     * @param int $siteId 站点编号
     *
     * @return mixed
     */
    public static function getSiteUser($siteId = 0)
    {
        $siteId = $siteId ?: SITEID;

        return Db::table('site_user')->join('user', 'user.uid', '=', 'site_user.uid')
                 ->where('siteid', $siteId)->get();
    }

    /**
     * 删除用户
     *
     * @param int $uid 会员编号
     *
     * @return bool
     */
    public function remove($uid)
    {
        $relationDeleteTable = [
            'user',//用户表
            'site_user',//站点管理员
            'user_permission',//用户管理权限
            'user_profile',//用户字段信息
            'log',//日志记录
        ];
        foreach ($relationDeleteTable as $table) {
            Db::table($table)->where('uid', $uid)->delete();
        }

        return true;
    }

    /**
     * 获取用户拥有的站点数量
     *
     * @param $uid
     *
     * @return mixed
     */
    public static function siteNums($uid = 0)
    {
        $uid = $uid ?: v("user.info.uid");

        return Db::table('site_user')->where('uid', $uid)->where('role', 'owner')->count() * 1;
    }

    /**
     * 检测当前帐号是否能添加站点
     *
     * @param int $uid 用户编号
     *
     * @return bool
     */
    public static function hasAddSite($uid = 0)
    {
        $uid  = $uid ?: v('user.info.uid');
        $user = Db::table('user')->find($uid);
        if ($user) {
            //系统管理员不受限制
            if (self::isSuperUser($user['uid'])) {
                return true;
            } else {
                //普通用户检查
                $maxsite = Db::table('user_group')->where('id', $user['groupid'])->pluck('maxsite');

                return $maxsite - self::siteNums($uid) > 0 ? true : false;
            }
        }
    }

    /**
     * 获取用户在站点角色中文描述
     *
     * @param $siteid
     * @param $uid
     *
     * @return string
     */
    public function getRoleTitle($siteid, $uid)
    {
        if ($this->isSuperUser()) {
            return '系统管理员';
        }
        $role = $this->where('siteid', $siteid)->where('uid', $uid)->pluck(
            'role'
        );
        $data = ['owner' => '所有者', 'manage' => '管理员', 'operate' => '操作员'];

        return $role ? $data[$role] : '';
    }

    /**
     * 设置站点的站长
     * 站长拥有所有权限
     *
     * @param int $siteId 站点编号
     * @param int $uid    用户编号
     *
     * @return int 自增主键
     */
    public function setSiteOwner($siteId, $uid)
    {
        return SiteUser::setSiteOwner($siteId, $uid);
    }

    /**
     * 获取用户的用户组信息
     *
     * @param int $uid 用户编号
     *
     * @return mixed
     */
    public function getUserGroup($uid = 0)
    {
        $uid      = $uid ?: v('user.info.uid');
        $group_id = Db::table('user')->where('uid', $uid)->pluck('groupid');

        return Db::table('user_group')->find($group_id);
    }

    /**
     * 获取为用户在站点独立设置的权限
     *
     * @param int $siteId 站点编号
     * @param int $uid    用户编号
     *
     * @return mixed
     */
    public function getUserAtSiteAccess($siteId = 0, $uid = 0)
    {
        $siteId     = $siteId ?: SITEID;
        $uid        = $uid ?: v('user.info.uid');
        $permission = Db::table('user_permission')->where('siteid', $siteId)
                        ->where('uid', $uid)->lists('type,permission') ?: [];
        foreach ($permission as $m => $p) {
            $permission[$m] = explode('|', $p);
        }

        return $permission;
    }
}