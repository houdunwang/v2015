<?php namespace module\member\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use houdunwang\request\Request;
use module\HdController;
use system\model\CreditsRecord;
use system\model\Member;
use system\model\MemberFields;
use system\model\MemberGroup;
use system\model\Site as SiteModel;
use Db;

/**
 * 会员中心
 * Class site
 *
 * @package module\member\controller
 */
class Site extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth();
    }

    /**
     * 会员列表
     *
     * @return mixed
     */
    public function memberLists()
    {
        $db = Db::table('member')->join('member_group', 'member.group_id', '=', 'member_group.id')
                ->where('member.siteid', SITEID)->orderBy('uid', 'DESC');
        if ($username = Request::post('username')) {
            $db->where(Request::post('user_type'), 'like', "%{$username}%");
        }
        $data = $db->paginate(20, 8);

        return view($this->template.'/member_lists')->with('data', $data);
    }

    /**
     * 编辑用户信息
     *
     * @param \system\model\MemberGroup $memberGroup
     *
     * @return mixed|string
     */
    public function memberEdit(MemberGroup $memberGroup)
    {
        $model = Member::find(Request::get('uid'));
        if (IS_POST) {
            foreach (Request::post() as $k => $v) {
                $model[$k] = $v;
            }
            $model->save();

            return message('编辑用户资料成功', url('member_lists'));
        }

        return view($this->template.'/member_edit', [
            'user'  => $model,
            'group' => $memberGroup->getSiteAllMemberGroup(),
        ]);
    }

    /**
     * 添加会员
     *
     * @param \system\model\Member      $model
     * @param \system\model\MemberGroup $MemberGroup
     *
     * @return mixed|string
     */
    public function memberPost(Member $model, MemberGroup $MemberGroup)
    {
        if (IS_POST) {
            Validate::make([
                ['password', 'confirm:password2', '两次密码输入不一致'],
            ]);
            //保存到模型数据
            foreach (Request::post() as $k => $v) {
                $model[$k] = $v;
            }
            //密码处理
            $passInfo          = $model->getPasswordAndSecurity(Request::post('password'));
            $model['password'] = $passInfo['password'];
            $model['security'] = $passInfo['security'];
            $uid               = $model->save();

            return message('添加会员成功', url('site.MemberEdit', ['uid' => $uid]), 'success');
        }
        $group = $MemberGroup->getSiteAllMemberGroup();

        return view($this->template.'/member_post')->with(compact('group'));
    }

    /**
     * 修改密码
     *
     * @param \system\model\Member $Member
     *
     * @return mixed|string
     */
    public function changePassword(Member $Member)
    {
        Validate::make([
            ['password', 'required', '密码不能为空'],
            ['password', 'confirm:password2', '两次密码不一致'],
        ]);
        $passInfo          = $Member->getPasswordAndSecurity(Request::post('password'));
        $model             = $Member->find(Request::post('uid'));
        $model['password'] = $passInfo['password'];
        $model['security'] = $passInfo['security'];
        $model->save();

        return message('密码更新成功', url('site.member_lists'));
    }

    /**
     * 删除用户
     *
     * @return mixed|string
     */
    public function doSiteDelete()
    {
        $uids   = Request::post('uid', []);
        $member = new Member();
        foreach ($uids as $uid) {
            $user = $member->where('siteid', SITEID)->find($uid);
            $user->destory();
        }

        return message('删除用户成功', 'back', 'success');
    }

    /**
     * 会员字段管理
     *
     * @return mixed
     */
    public function fieldlists()
    {
        if (IS_POST) {
            foreach (Request::post('member_fields') as $id => $d) {
                $d['id']      = $id;
                $d['status']  = intval($d['status']) ? 1 : 0;
                $d['orderby'] = min(255, intval($d['orderby']));
                Db::table('member_fields')->update($d);
            }

            return message('更新会员字段成功', 'refresh', 'success');
        }
        $data = Db::table('member_fields')->orderBy('orderby', 'DESC')->orderBy('id', 'ASC')->get();

        return view($this->template.'/fields_lists')->with('data', $data);;
    }

    /**
     * 会员字段编辑
     *
     * @return mixed
     */
    public function fieldPost()
    {
        $model = MemberFields::find(Request::get('id'));
        if (empty($model)) {
            return message('字段不存在', 'back', 'error');
        }
        if (IS_POST) {
            $model['orderby'] = Request::post('orderby');
            $model['title']   = Request::post('title');
            $model['status']  = Request::post('status');
            $model->save();

            return message('修改字段成功', url('site.fieldLists'), 'success');
        }

        return view($this->template.'/field_post')->with('field', $model);
    }

    /**
     * 会员组列表
     *
     * @param \system\model\Site        $siteModel
     * @param \system\model\MemberGroup $memberGroup
     *
     * @return mixed|string
     */
    public function groupLists(SiteModel $siteModel, MemberGroup $memberGroup)
    {
        if (IS_POST) {
            foreach (Request::post('id') as $k => $id) {
                $model           = $memberGroup::find($id);
                $model['title']  = $_POST['title'][$k];
                $model['credit'] = $_POST['credit'][$k];
                $model['rank']   = min(255, intval($_POST['rank'][$k]));
                $model->save();
            }
            //更改会员组变更设置
            $data = [
                'grouplevel' => Request::post('grouplevel'),
            ];
            Db::table('site_setting')->where('siteid', siteid())->update($data);

            $siteModel->updateCache();

            return message('更改会组资料更新成功');
        }
        $sql        = "SELECT count(*) as user_count,m.uid,g.* FROM ".tablename('member_group')
                      ." g LEFT JOIN ".tablename('member')." m ON g.id=m.group_id WHERE g.siteid="
                      .SITEID." GROUP BY g.id ORDER BY g.rank DESC,g.id";
        $groups     = Db::query($sql);
        $grouplevel = v('site.setting.grouplevel');

        return view($this->template.'/group_lists')->with(compact('groups', 'grouplevel'));
    }

    /**
     * 删除会员组
     *
     * @return mixed|string
     */
    public function delGroup()
    {
        $id    = Request::get('id');
        $model = MemberGroup::find($id);
        if ($model['isdefault'] == 1) {
            return message('默认组不能删除', 'back', 'error');
        }

        //更改用户默认组
        $data = ['group_id' => MemberGroup::getDefaultGroup()];
        Db::table('member')->where('siteid', siteid())->where('group_id', $id)->update($data);
        $model->destory();

        return message('删除组成功', '', 'success');
    }

    /**
     * 添加会员组
     *
     * @param \system\model\MemberGroup $memberGroup
     *
     * @return mixed|string
     */
    public function groupPost(MemberGroup $memberGroup)
    {
        $id    = Request::get('id');
        $model = $id ? $memberGroup->find($id) : $memberGroup;
        if (IS_POST) {
            $model['title']  = Request::post('title');
            $model['credit'] = Request::post('credit');
            $model->save();

            return message('会员组资料保存成功', url('site.groupLists'));
        }

        return view($this->template.'/group_post')->with('field', $model);
    }

    /**
     * 设置默认组
     *
     * @return mixed|string
     */
    public function setDefaultGroup()
    {
        $id    = Request::get('id');
        $model = MemberGroup::where('siteid', siteid())->where('id', $id)->first();
        if (empty($model)) {
            return message('会员组不存在', '', 'error');
        }
        if ($model['credit'] != 0) {
            return message('默认会员组初始积分必须为0', '', 'error');
        }
        Db::table('member_group')->where('siteid', siteid())->update(['isdefault' => 0]);
        $model['isdefault'] = 1;
        $model->save();

        return message('默认会员组设置成功');
    }

    /**
     * 修改会员积分/余额
     *
     * @param \system\model\CreditsRecord $CreditsRecord
     *
     * @return mixed|string
     */
    public function trade(CreditsRecord $CreditsRecord)
    {
        //会员编号
        $uid = Request::get('uid');
        //1 积分 2 余额
        $type = Request::get('type');
        if (IS_POST) {
            Validate::make([
                ['num', 'regexp:/^\-?\d+$/', '积分数量不能为空'],
                ['remark', 'required', '备注不能为空'],
            ]);
            //更改数量
            $data               = [];
            $data['uid']        = $uid;
            $data['credittype'] = $type;
            $data['num']        = Request::post('num');
            $data['remark']     = Request::post('remark');
            if (($message = $CreditsRecord::change($data)) !== true) {
                return message($message, '', 'error');
            }

            return message(v("setting.creditnames.$type.title").'更改成功', '', 'success');
        }

        return view($this->template.'/trade')->with(['uid' => $uid, 'type' => $type]);
    }
}