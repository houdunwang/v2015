<?php namespace system\model;

use Carbon\Carbon;
use houdunwang\db\Db;
use houdunwang\model\Model;

class MemberToken extends Model
{
    //数据表
    protected $table = "member_token";

    //允许填充字段
    protected $allowFill = ['*'];

    //禁止填充字段
    protected $denyFill = [];

    //自动验证
    protected $validate
        = [
            //['字段名','验证方法','提示信息',验证条件,验证时间]
        ];

    //自动完成
    protected $auto
        = [
            //['字段名','处理方法','方法类型',验证条件,验证时机]
            ['siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH],
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;

    /**
     * 设置会员接口令牌
     *
     * @param int $uid    会员编号
     * @param int $expire 过期时间，单位天
     *
     * @return bool
     * @throws \Exception
     */
    public function token($uid, $expire = 100)
    {
        $user = Member::find($uid);
        if (empty($user)) {
            $this->setError('会员不存在');

            return false;
        }

        $token = self::where('siteid', SITEID)->where('uid', $uid)->first();
        if ( ! $token) {
            $token          = new static();
            $token['uid']   = $uid;
            $token['token'] = md5(time() * mt_rand(1, 1000));
        }
        $token['expire_time'] = Carbon::now()->addDay($expire);

        return $token->save();
    }
}