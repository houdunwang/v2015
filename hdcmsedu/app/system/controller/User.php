<?php namespace app\system\controller;

use system\model\User as UserModel;
use system\model\Site;
use system\model\Package;
use Session;
use Request;
use Middleware;
use houdunwang\validate\Validate;
use houdunwang\db\Db;

/**
 * 用户管理
 * Class User
 *
 * @package app\system\controller
 */
class User extends Admin
{
    public function __construct(UserModel $user)
    {
        Middleware::set('superUserAuth', ['except' => ['info', 'password']]);
    }

    /**
     * 用户列表
     *
     * @param \system\model\User $user
     *
     * @return mixed
     */
    public function lists(UserModel $user)
    {
        $users = $user->leftJoin('user_group', 'user.groupid', '=', 'user_group.id')
                      ->where('user.groupid', '>', '0')->paginate(10);

        return view()->with(compact('users'));
    }


    /**
     * 添加用户
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function add(UserModel $user)
    {
        if (IS_POST) {
            Validate::make([
                ['password', 'confirm:password2', '两次密码输入不一致'],
            ]);
            $info             = $user->getPasswordAndSecurity(Request::post('password'));
            $user['password'] = $info['password'];
            $user['security'] = $info['security'];
            $user['status']   = 1;
            //用户组过期时间
            $daylimit         = Db::table('user_group')->where('id', Request::post('groupid'))
                                  ->pluck('daylimit');
            $user['endtime']  = time() + $daylimit * 3600 * 24;
            $user['groupid']  = Request::post('groupid');
            $user['username'] = Request::post('username');
            $user['remark']   = Request::post('remark');
            $user->save();
            record('添加了新用户' . $user['username']);

            return message('添加新用户成功', 'lists');
        }
        //获取用户组
        $groups = Db::table('user_group')->get();

        if (IS_AJAX) {
            return view('app/system/view/user/block/add_user.php')->with(compact('groups'));
        }

        return view()->with(compact('groups'));
    }

    /**
     * 编辑用户资料
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function edit(UserModel $user)
    {
        $uid  = Request::get('uid');
        $user = $user->find($uid);
        if (IS_POST) {
            if (Request::post('password')) {
                Validate::make([
                    ['password', 'confirm:password2', '两次密码输入不一致'],
                ]);
                //存在密码时设置密码
                $info             = UserModel::getPasswordAndSecurity(Request::post('password'));
                $user['password'] = $info['password'];
                $user['security'] = $info['security'];
            }
            $user['endtime']  = strtotime(Request::post('endtime'));
            $user['groupid']  = Request::post('groupid');
            $user['remark']   = Request::post('remark');
            $user['qq']       = Request::post('qq');
            $user['mobile']   = Request::post('mobile');
            $user['realname'] = Request::post('realname');
            $user->save();
            Site::updateSiteCacheByUid($uid);

            return message('用户资料修改成功', 'lists');
        }
        //会员组
        $groups = Db::table('user_group')->get();

        return view()->with(compact('groups', 'user'));
    }

    /**
     * 锁定或解锁用户
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function updateStatus(UserModel $user)
    {
        $model = $user->find(Request::get('uid'));
        if ($user->isSuperUser($model->uid)) {
            return message('管理员帐号不允许操作');
        }
        $model['status'] = Request::get('status', 0);
        $model->save();

        return message('操作成功');
    }

    /**
     * 删除用户
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function remove(UserModel $user)
    {
        if ( ! $user->remove(Request::post('uid'))) {
            return message('用户删除失败');
        }

        return message('删除用户成功');
    }

    /**
     * 查看用户权限
     *
     * @return mixed
     */
    public function permission(UserModel $user, Site $site, Package $package)
    {
        $model = $user::find(Request::get('uid'));
        //获取用户组信息
        $group = $model->userGroup();
        //获取用户站点信息
        $sites = $site->getUserAllSite($model['uid']);
        //用户套餐
        $packages = $package->getUserGroupPackageLists($model['groupid']);

        return view()->with(compact('group', 'packages', 'sites'));
    }

    /**
     * 修改后台帐号密码
     *
     * @return mixed
     */
    public function info()
    {
        $this->auth();
        if (IS_POST) {
            $user             = UserModel::find(v('user.info.uid'));
            $user['realname'] = Request::post('realname');
            $user['qq']       = Request::post('qq');
            $user['email']    = Request::post('email');
            $user['mobile']   = Request::post('mobile');
            $user->save();

            return message('个人资料修改成功');
        }

        return view();
    }

    /**
     * 修改密码
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function password(UserModel $user)
    {
        if (IS_POST) {
            Validate::make([
                ['password', 'required', '密码不能为空'],
                ['password', 'confirm:password2', '两次密码输入不一致'],
            ]);
            if ($user->changePassword(v('user.info.uid'), Request::post('password'))) {
                return message('密码修改成功');
            }

            return $this->withErrors($user->getError());
        }

    }
}