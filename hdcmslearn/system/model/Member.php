<?php namespace system\model;

use houdunwang\request\Request;
use houdunwang\validate\Validate;
use houdunwang\session\Session;
use houdunwang\wechat\WeChat;

/**
 * 会员管理
 * Class Member
 *
 * @package system\model
 */
class Member extends Common
{
    /**
     * @var string
     */
    protected $table = 'member';

    /**
     * @var array
     */
    protected $allowFill = ['*'];

    protected $timestamps = true;

    protected $filter
        = [
            ['uid', self::MUST_FILTER, self::MODEL_BOTH],
            ['password', self::EMPTY_FILTER, self::MODEL_BOTH],
        ];

    protected $validate
        = [
            ['password', 'required', '密码不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['password', 'minlen:5', '密码长度不能小于5位', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['email', 'email', '邮箱格式错误', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH],
            ['email', 'checkMail', '邮箱已经被使用', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH],
            ['mobile', 'checkMobile', '手机号已经被使用', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH],
            ['mobile', 'phone', '手机号格式错误', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH],
            ['uid', 'checkUid', '当前用户不属于站点', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['mobile', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['email', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['icon', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['credit1', 'intval', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
            ['credit2', 'intval', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
            ['credit3', 'intval', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
            ['credit4', 'intval', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
            ['credit5', 'intval', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
            ['createtime', 'time', 'function', self::MUST_AUTO, self::MODEL_BOTH],
            ['qq', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['nickname', '幸福小海豚', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['realname', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['telephone', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['vip', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['address', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['zipcode', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['alipay', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['msn', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['taobao', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['site', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['nationality', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['introduce', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['gender', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['graduateschool', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['height', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['weight', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['bloodtype', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['birthyear', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['birthmonth', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['birthday', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['resideprovince', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['residecity', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['residedist', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['access_token', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['group_id', 'getDefaultGroupId', 'method', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 手机号检测
     *
     * @param $field
     * @param $value
     * @param $params
     * @param $data
     *
     * @return bool
     */
    protected function checkMobile($field, $value, $params, $data)
    {
        $db = Db::table('member')->where('mobile', $value)->where('siteid', siteid());
        if ($this->action() == self::MODEL_UPDATE) {
            $db->where('uid', '<>', $this['uid']);
        }

        return $db->get() ? false : true;
    }

    /**
     * 邮箱检测
     *
     * @param $field
     * @param $value
     * @param $params
     * @param $data
     *
     * @return bool
     */
    protected function checkMail($field, $value, $params, $data)
    {
        $db = Db::table('member')->where('email', $value)->where('siteid', siteid());
        if ($this->action() == self::MODEL_UPDATE) {
            $db->where('uid', '<>', $this['uid']);
        }

        return $db->get() ? false : true;
    }

    /**
     * 表单验证用户编号
     *
     * @param $field
     * @param $value
     * @param $params
     * @param $data
     *
     * @return bool
     */
    public function checkUid($field, $value, $params, $data)
    {
        return Db::table($this->table)->where('uid', $value)->where('siteid', SITEID)->first() ? true : false;
    }

    /**
     * 自动完成默认组编号
     *
     * @return int|null
     */
    protected function getDefaultGroupId()
    {
        return MemberGroup::getDefaultGroup();
    }

    /**
     * 会员第三方帐号数据
     *
     * @return mixed
     */
    public function MemberAuth()
    {
        return $this->hasOne('system\model\MemberAuth', 'uid', 'uid');
    }

    /**
     * 根据邮箱或用户名获取用户信息
     *
     * @param string $username 邮箱或手机
     *
     * @return array
     */
    public function getUserByName($username)
    {
        $user = $this->where('siteid', siteid())->where('email', $username)->first();

        return $user ?: $this->where('siteid', siteid())->where('mobile', $username)->first();
    }

    /**
     * 用户登录检测
     *
     * @return bool
     */
    public static function isLogin()
    {
        return boolval(self::initMemberInfo());
    }

    /**
     * 初始用户信息
     *
     * @return bool
     */
    public static function initMemberInfo()
    {
        $member_uid = Session::get("member_uid");
        if (SITEID && $member_uid) {
            if ( ! v('member')) {
                $user          = [];
                $user['info']  = Db::table('member')->where('siteid', siteid())->find($member_uid);
                $user['group'] = Db::table('member_group')->where('id', $user['info']['group_id'])->first();
                $user['auth']  = Db::table('member_auth')->where('id', $user['info']['group_id'])->first();
                v('member', $user);
            }
        }

        return boolval(v('member.info.uid'));
    }

    /**
     * 会员组表关联
     *
     * @return mixed
     */
    public function group()
    {
        return $this->hasOne(MemberGroup::class, 'id', 'group_id');
    }

    /**
     * 判断当前uid的用户是否在当前站点中存在
     *
     * @param $uid 会员编号
     *
     * @return bool
     */
    public function hasUser($uid)
    {
        return self::where('siteid', siteid())->where('uid', $uid)->get() ? true : false;
    }

    /**
     * 微信扫码登录
     *
     * @param string $url 登录成功后的跳转地址
     */
    public function qrLogin($url = '')
    {
        WeChat::instance('Oauth')->qrLogin(function ($info) use ($url) {
            $auth = MemberAuth::where('wechat', $info['openid'])->first();
            if ( ! $auth) {
                //帐号不存在时使用openid添加帐号
                $user             = new MemberModel();
                $user['nickname'] = $info['nickname'];
                $user['icon']     = $info['headimgurl'];
                $user['group_id'] = $this->getDefaultGroupId();
                $user->save();
                $model           = new MemberAuth();
                $model['uid']    = $user['uid'];
                $model['wechat'] = $info['openid'];
                $model->save();
            }
            Session::set('member_uid', $auth['uid']);
            $url = $url
                ?: Session::get('from', url('member.index', '', 'ucenter'));
            Session::del('from');
            go($url);
        });
    }

    /**
     * 根据access_token获取用户信息
     *
     * @param $access_token
     *
     * @return bool | array
     */
    public function getUserInfoByAccessToken($access_token)
    {
        $res = Db::table('member')->where('access_token', $access_token)->first();

        return $res ?: false;
    }

    /**
     * 根据帐号获取用户信息
     *
     * @param string $username 邮箱或手机号
     *
     * @return array
     */
    public static function getUserByUsername($username)
    {
        $user = self::where('siteid', siteid())->where('email', $username)->first();

        return $user ?: self::where('siteid', siteid())->Where('mobile', $username)->first();
    }

    /**
     * 会员登录
     *
     * @param $data
     *
     * @return array
     */
    public static function login($data)
    {
        Validate::make([
            ['username', 'required', '帐号不能为空', Validate::MUST_VALIDATE],
            ['password', 'required', '密码不能为空', Validate::MUST_VALIDATE],
            ['code', 'captcha', '验证码输入错误', Validate::EXISTS_VALIDATE],
        ], $data);
        switch (v('site.setting.login.type')) {
            case 1:
                //手机号
                Validate::make([
                    ['username', 'phone', '请输入手机号', Validate::MUST_VALIDATE],
                ], $data);
                break;
            case 2:
                //邮箱
                Validate::make([
                    ['username', 'email', '请输入邮箱', Validate::MUST_VALIDATE],
                ], $data);
                break;
        }
        $user = self::getUserByUsername($data['username']);
        if (empty($user)) {
            return ['valid' => 0, 'message' => '帐号不存在'];
        }
        if (md5($data['password'].$user['security']) != $user['password']) {
            return ['valid' => 0, 'message' => '密码输入错误'];
        }
        Session::set('member_uid', $user['uid']);

        return ['valid' => 1, 'message' => '登录成功', 'uid' => $user['uid']];
    }

    /**
     * 微信登录
     *
     * @return bool|string
     * @throws \Exception
     */
    public function weChatLogin()
    {
        if (Request::isWeChat() && v('site.setting.login.mobile_wechat') > 0) {
            //认证订阅号或服务号,并且开启自动登录时获取微信帐户openid自动登录
            if ($info = WeChat::instance('oauth')->snsapiUserinfo()) {
                $auth = MemberAuth::where('wechat', $info['openid'])->first();
                if ( ! $auth) {
                    //帐号不存在时使用openid添加帐号
                    $this['nickname'] = $info['nickname'];
                    $this['icon']     = $info['headimgurl'];
                    $this['group_id'] = $this->getDefaultGroupId();
                    $this->save();
                    $auth           = new MemberAuth();
                    $auth['uid']    = $this['uid'];
                    $auth['wechat'] = $info['openid'];
                    $auth->save();
                }
                Session::set('member_uid', $auth['uid']);

                return true;
            }
        }

        return '微信登录失败,请检查微信公众号是否验证';
    }

    /**
     * 注册页面
     *
     * @param $data
     *
     * @return array
     * @throws \Exception
     */
    public static function register($data)
    {
        $model = new static();
        Validate::make([
            ['username', 'required', '帐号不能为空', Validate::MUST_VALIDATE],
            ['password', 'required|minlen:5', '密码长度不能小于5位', Validate::MUST_VALIDATE],
            ['code', 'captcha', '验证码输入错误', Validate::EXISTS_VALIDATE],
        ]);

        //批量添加字段
        foreach ($data as $k => $v) {
            $model[$k] = $v;
        }
        $info = static::getPasswordAndSecurity($data['password']);
        if (empty($info['password'])) {
            return ['valid' => 0, 'message' => '密码不能为空'];
        }
        if (isset($data['cpassword']) && $data['password'] !== $data['cpassword']) {
            return ['valid' => 0, 'message' => '两次密码输入不一致'];
        }
        $model['password'] = $info['password'];
        $model['security'] = $info['security'];

        switch (v('site.setting.register.type')) {
            case 1:
                //手机号注册
                if (empty($data['username']) || ! preg_match('/^\d{11}$/', $data['username'])) {
                    return ['valid' => 0, 'message' => '请输入手机号'];
                }
                $model['mobile'] = $data['username'];
                if (Db::table('member')->where('mobile', $data['mobile'])->where('siteid', siteid())->get()) {
                    return ['valid' => 0, 'message' => '手机号已经存在'];
                }
                break;
            case 2:
                //邮箱注册
                if (empty($data['username']) || ! preg_match('/\w+@\w+/', $data['username'])) {
                    return ['valid' => 0, 'message' => '请输入邮箱'];
                }
                $model['email'] = $data['username'];
                if (Db::table('member')->where('email', $data['email'])->where('siteid', siteid())->get()) {
                    return ['valid' => 0, 'message' => '邮箱已经存在'];
                }
                break;
            case 3:
                //二者都行
                if ( ! preg_match('/^\d{11}$/', $data['username']) && ! preg_match('/\w+@\w+/', $data['username'])) {
                    return ['valid' => 0, 'message' => '请输入邮箱或手机号'];
                } else if (preg_match('/^\d{11}$/', $data['username'])) {
                    $model['mobile'] = $data['username'];
                    if (empty($data['username']) || Db::table('member')->where('mobile', $data['mobile'])->where('siteid', siteid())->get()) {
                        return ['valid' => 0, 'message' => '手机号已经存在'];
                    }
                } else {
                    $model['email'] = $data['username'];
                    if (empty($data['username']) || Db::table('member')->where('email', $data['email'])->where('siteid', siteid())->get()) {
                        return ['valid' => 0, 'message' => '邮箱已经存在'];
                    }
                }
        }
        if (v('site.setting.register.auth')) {
            if (preg_match('/^\d{11}$/', $data['username'])) {
                $model['mobile_valid'] = 1;
            }
            if (preg_match('/\w+@\w+/', $data['username'])) {
                $model['email_valid'] = 1;
            }
        }
        $model->save();


        return ['valid' => 1, 'message' => '注册成功', 'uid' => $model['uid']];
    }

    /**
     * 验证密码
     *
     * @param string $password 密码
     *
     * @return bool
     */
    public function checkPassword($password)
    {
        if (md5($password.$this['security']) != $this['password']) {
            $this->setError('密码错误');

            return false;
        }

        return true;
    }

    /**
     * 修改密码
     *
     * @param array $data 新密码与确认密码
     *
     * @return bool
     */
    public function changePassword($data)
    {
        $info = static::getPasswordAndSecurity($data['password']);
        if (empty($info['password'])) {
            $this->setError('密码不能为空');

            return false;
        }
        if (isset($data['cpassword']) && $data['password'] !== $data['cpassword']) {
            $this->setError('两次密码输入不一致');

            return false;
        }
        $this['password'] = $info['password'];
        $this['security'] = $info['security'];

        return $this->save();
    }

    /**
     * 根据密码获取密钥与加密后的密码数据及确认密码
     *
     * @param $password 密码
     *
     * @return array
     */
    public static function getPasswordAndSecurity($password)
    {
        $data = ['security' => '', 'password' => ''];
        if (empty($password)) {
            return $data;
        }
        $data             = [];
        $data['security'] = substr(md5(time()), 0, 10);
        $data['password'] = md5($password.$data['security']);

        return $data;
    }
}