<?php namespace system\model;

use houdunwang\validate\Validate;

/**
 * 积分记录
 * Class CreditsRecord
 *
 * @package system\model
 */
class CreditsRecord extends Common
{
    protected $table = 'credits_record';

    protected $allowFill = ['*'];

    protected $validate = [];

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['module', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
            ['operator', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
            ['createtime', 'time', 'function', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
            ['remark', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
        ];

    /**
     * 会员积分中文名称
     *
     * @param string $creditType 积分类型
     *
     * @return string
     */
    public static function title($creditType)
    {
        return v('site.setting.creditnames.'.$creditType.'.title');
    }

    /**
     * 更改会员积分或余额
     *
     * @param array $data
     *  array(
     *  'uid'=>会员编号,//不设置时取当前会员
     *  'credittype'=>积分类型,如credit1
     *  'num'=>数量,负数为减少
     *  'remark'=>说明
     *  );
     *
     * @return bool
     */
    public static function change(array $data)
    {
        Validate::make([
            ['credittype', 'required', '积分类型不能为空', Validate::MUST_VALIDATE],
        ], $data);

        $data['remark'] = isset($data['remark']) ? $data['remark'] : '';
        $data['num']    = isset($data['num']) ? intval($data['num']) : 0;
        $data['uid']    = isset($data['uid']) ? $data['uid'] : v('member.info.uid');
        $data['module'] = v('module.name');
        //检测用户
        $member = Member::where('uid', $data['uid'])->where('siteid', siteid())->first();
        if (empty($member)) {
            return '当前站点不存在该用户';
        }
        if (empty($member[$data['credittype']])) {
            return '积分类型不存在';
        }
        //动作增加或减少
        $action = $data['num'] > 0 ? 'increment' : 'decrement';
        //用户原积分数量
        $userTickNum = $member[$data['credittype']];
        //减少时不能小于用户现有积分
        if ($action == 'decrement' && $userTickNum < abs($data['num'])) {
            return self::title($data['credittype']).'数量不够';
        }
        $num = $data['num'] > 0 ? $data['num'] : abs($data['num']);
        if ( ! Member::where('uid', $data['uid'])->where('siteid', siteid())->$action($data['credittype'], $num)) {
            return '修改会员 '.self::title($data['credittype'])." 失败";
        }
        //记录变量日志
        self::log($data);
        /**
         * 系统设置根据积分变动用户组时变更之
         * 用户积分大于组积分的组
         */
        $group = MemberGroup::where('credit', '<=', $member['credit1'])->orderBy('credit', 'DESC')->first();
        switch (v('site.setting.grouplevel')) {
            case 2:
                //根据总积分多少自动升降
                if ($group) {
                    $member['group_id'] = $group['id'];
                    $member->save();
                }
                break;
            case 3:
                //根据总积分多少只升不降
                $userGroupCredit = MemberGroup::where('id', $member['group_id'])->pluck('credit');
                if ($group && $group['credit'] > $userGroupCredit) {
                    $member['group_id'] = $group['id'];
                    $member->save();
                }
                break;
        }

        return true;
    }

    /**
     * 记录积分变量日志
     *
     * @param $data
     *
     * @return bool
     */
    protected static function log($data)
    {
        $model               = new self();
        $model['siteid']     = siteid();
        $model['uid']        = $data['uid'];
        $model['num']        = $data['num'];
        $model['remark']     = $data['remark'];
        $model['credittype'] = $data['credittype'];
        $model['module']     = $data['module'];
        $model['operator']   = v('user.info.uid') ?: 0;

        return $model->save();
    }
}