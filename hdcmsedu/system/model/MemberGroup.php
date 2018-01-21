<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\model;

use Db;

/**
 * 前台用户组
 * Class MemberGroup
 *
 * @package system\model
 */
class MemberGroup extends Common
{
    protected $table = 'member_group';

    protected $validate
        = [
            ['siteid', 'required', '站点编号不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['title', 'required', '会员组名称不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT],
            ['credit', 'num:0,99999', '请设置积分数量', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['rank', 'num:0,255', '排序数字为0~255', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['credit', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['rank', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['isdefault', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['is_system', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
        ];
    protected $filter
        = [
            ['is_system', self::MUST_FILTER, self::MODEL_BOTH],
        ];

    /**
     * 获取站点的默认会员组编号
     *
     * @return int|null
     */
    public static function getDefaultGroup()
    {
        return self::where('siteid', siteid())->where('isdefault', 1)->pluck('id');
    }

    /**
     * 获取站点的所有用户组
     *
     * @param int $siteid 站点编号
     *
     * @return mixed
     */
    public static function getSiteAllMemberGroup($siteid = 0)
    {
        $siteid = $siteid ?: siteid();

        return Db::table('member_group')->where('siteid', $siteid)->orderBy('id', 'DESC')->get();
    }

    /**
     * 获取会员组
     *
     * @param int $uid 会员编号
     *
     * @return string
     */
    public static function getGroupName($uid = 0)
    {
        $uid = $uid ?: v('user.uid');
        $sql = "SELECT title,id FROM ".tablename('member')." m JOIN ".tablename('member_group')
               ." g ON m.group_id = g.id WHERE m.uid={$uid}";
        $d   = Db::query($sql);

        return $d ? $d[0] : '';
    }
}