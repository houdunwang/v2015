<?php namespace app\system\controller;

use houdunwang\request\Request;
use houdunwang\wechat\WeChat;
use system\model\Modules;
use system\model\SiteModules;
use system\model\SitePackage;
use system\model\SiteTemplate;
use system\model\SiteUser;
use system\model\SiteWeChat;
use system\model\Site as SiteModel;
use system\model\User;
use system\model\Package;
use system\model\Template;

/**
 * 站点管理
 * Class Site
 *
 * @package app\system\controller
 */
class Site extends Admin
{
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 站点列表
     *
     * @return mixed
     */
    public function lists()
    {
        $where = [];
        //按网站名称搜索
        if ($sitename = Request::post('sitename')) {
            $where[] = ['name', 'like', "%{$sitename}%"];
        }
        $sites = SiteModel::getSiteByCondition($where);
        $user  = User::find(v('user.info.uid'));

        return view('', compact('sites', 'user'));
    }

    //网站列表页面,获取站点包信息
    public function package()
    {
        //根据站长所在会员组获取套餐
        $pids    = \Package::getSiteAllPackageIds(siteid());
        $package = [];
        if (in_array(-1, $pids)) {
            $package[] = "所有服务";
        } else if ( ! empty($pids)) {
            $package = Db::table('package')->whereIn('id', $pids)->lists('name');
        }
        //获取模块
        $modules = \Module::getSiteAllModules();

        return ['package' => $package, 'modules' => $modules];
    }

    /**
     * 为站点设置权限/默认站点使用站长的权限
     * 但我们可以为站点独立添加一些权限
     *
     * @param \system\model\User     $user
     * @param \system\model\Package  $package
     * @param \system\model\Site     $site
     * @param \system\model\Template $template
     * @param \system\model\Modules  $module
     *
     * @return mixed|string
     */
    public function access_setting(User $user, Package $package, SiteModel $site, Template $template, Modules $module)
    {
        //非系统管理员直接跳转到第四步,只有系统管理员可以设置用户扩展套餐与模块
        if ($user->superUserAuth() === false) {
            return message('没有操作权限', '', 'error');
        }
        if (IS_POST) {
            //站点允许使用的空间大小
            $model                = SiteModel::find(siteid());
            $model['allfilesize'] = Request::post('allfilesize');
            $model->save();
            //删除站点旧的套餐
            SitePackage::where('siteid', siteid())->delete();
            if ($packageIds = Request::post('package_id', [])) {
                foreach ($packageIds as $id) {
                    SitePackage::insert(
                        ['siteid' => siteid(), 'package_id' => $id,]
                    );
                }
            }
            //添加扩展模块
            SiteModules::where('siteid', siteid())->delete();
            if ($modules = Request::post('modules', [])) {
                foreach ($modules as $name) {
                    SiteModules::insert(
                        ['siteid' => siteid(), 'module' => $name,]
                    );
                }
            }
            //添加扩展模板
            SiteTemplate::where('siteid', siteid())->delete();
            if ($templates = Request::post('templates', [])) {
                foreach ($templates as $name) {
                    SiteTemplate::insert(
                        ['siteid' => siteid(), 'template' => $name,]
                    );
                }
            }
            //设置站长
            if ($uid = Request::post('uid', 0, 'intval')) {
                SiteUser::setSiteOwner(siteid(), $uid);
            }
            $site->updateCache();

            return message('站点信息修改成功');
        }

        //获取站长信息
        return view('access_setting')->with(
            [
                'systemAllPackages' => $package->getSystemAllPackageData(),
                'extPackage'        => $package->getSiteExtPackageIds(),
                'defaultPackage'    => $package->getSiteDefaultPackageIds(),
                'extModule'         => $module->getSiteExtModules(siteid()),
                'extTemplate'       => $template->getSiteExtTemplates(siteid()),
                'user'              => $user->getSiteOwner(siteid()),
                'site'              => SiteModel::find(siteid()),
            ]
        );
    }

    /**
     * 设置站点微信公众号
     *
     * @param \system\model\User $user
     * @param \system\model\Site $site
     *
     * @return mixed|string
     */
    public function wechat(User $user, SiteModel $site)
    {
        if ($user->isManage() == false) {
            return message('您不是网站管理员无法操作');
        }
        switch (Request::get('step')) {
            //修改微信公众号
            case 'wechat':
                //微信帐号管理
                if (IS_POST) {
                    if ($weid = SiteWechat::where('siteid', siteid())->pluck('weid')) {
                        //编辑站点
                        $SiteWechatModel = SiteWechat::find($weid);
                    } else {
                        //新增公众号
                        $SiteWechatModel = new SiteWechat();
                    }
                    $SiteWechatModel['siteid']    = siteid();
                    $SiteWechatModel['wename']    = Request::post('wename');
                    $SiteWechatModel['account']   = Request::post('account');
                    $SiteWechatModel['original']  = Request::post('original');
                    $SiteWechatModel['level']     = Request::post('level');
                    $SiteWechatModel['appid']     = Request::post('appid');
                    $SiteWechatModel['appsecret'] = Request::post('appsecret');
                    $SiteWechatModel['qrcode']    = Request::post('qrcode');
                    $SiteWechatModel['icon']      = Request::post('icon');
                    $weid                         = $SiteWechatModel->save();
                    //设置站点微信记录编号
                    $site         = SiteModel::find(siteid());
                    $site['weid'] = $weid;
                    $site->save();
                    //更新站点缓存
                    $site->updateCache();

                    return message('保存成功');
                }
                $wechat = SiteWeChat::where('siteid', siteid())->first();
                //更新站点缓存
                $site->updateCache(siteid());

                return view()->with('field', $wechat);
            case 'explain':
                //引导页面
                $wechat = SiteWechat::where('siteid', siteid())->first();
                if ($wechat) {
                    return view('explain')->with(compact('wechat'));
                } else {
                    return message('您还没有设置公众号信息', 'back', 'warning');
                }
        }
    }

    /**
     * 删除站点
     *
     * @param \system\model\User $user
     * @param \system\model\Site $site
     *
     * @return mixed|string
     */
    public function remove(User $user, SiteModel $site)
    {
        if ($user->isManage() == false) {
            return message('你不是站长不可以删除网站', 'with');
        }
        $site->remove(siteid());

        return message('网站删除成功', 'with');
    }

    /**
     * 编辑站点
     *
     * @param \system\model\User $user
     *
     * @return mixed|string
     */
    public function edit(User $user)
    {
        if ($user->isManage() == false) {
            return message('你没有编辑站点的权限', '', 'error');
        }
        if (IS_POST) {
            //更新站点数据
            $site = SiteModel::find(siteid());
            $site->save(Request::post());
            $site->updateCache();

            return message('网站数据保存成功', 'back', 'success');
        }
        $site = SiteModel::find(siteid());

        return view('', compact('site'));
    }

    /**
     * 添加站点
     *
     * @param \system\model\Site $site
     *
     * @return mixed|string
     */
    public function addSite(SiteModel $site)
    {
        if (IS_POST) {
            $site->addSite(Request::post());

            return message('站点添加成功', 'lists');
        }

        return view('site_setting');
    }

    /**
     * 公众号连接测试
     */
    public function connect()
    {
        //与微信官网通信绑定验证
        $status = WeChat::getAccessToken();
        SiteWechat::where('siteid', siteid())->update(['is_connect' => $status ? 1 : 0]);
        if ($status) {
            return ['valid' => true, 'message' => '恭喜, 微信公众号接入成功'];
        } else {
            return ['valid' => false, 'message' => '公众号接入失败'];
        }
    }

    /**
     * 移除站长
     * 只有系统管理员可以操作这个功能
     *
     * @param \system\model\User $UserModel
     * @param \system\model\Site $siteModel
     *
     * @return mixed|string
     */
    public function delOwner(User $UserModel, SiteModel $siteModel)
    {
        if ($UserModel->superUserAuth() != true) {
            return message('您不是系统管理员，不允许操作', '', 'error');
        }
        SiteUser::where('siteid', siteid())->where('role', 'owner')->delete();
        $siteModel->updateCache();

        return message('删除站长成功', 'back', 'success');
    }

    /**
     * 获取拥有桌面主面访问的模块列表
     */
    public function getModuleHasWebPage()
    {
        $modules = \Module::getModuleHasWebPage();

        return view()->with('modules', $modules);
    }
}