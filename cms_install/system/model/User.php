<?php namespace system\model;

use houdunwang\model\Model;

class User extends Model
{
    //数据表
    protected $table = "user";

    //允许填充字段
    protected $allowFill = [];

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
        ];

    //自动过滤
    protected $filter
        = [
            //[表单字段名,过滤条件,处理时间]
        ];

    //时间操作,需要表中存在created_at,updated_at字段
    protected $timestamps = true;

    /**
     * 管理员登录
     *
     * @param array $data
     *
     * @return array
     */
    public static function login(array $data)
    {
        if (empty($data['username']) || empty($data['password'])) {
            return ['valid' => 0, 'message' => '帐号或密码不能为空'];
        }
        $user = self::where('username', $data['username'])->first();
        if (empty($user)) {
            return ['valid' => 0, 'message' => '帐号不存在'];
        }
        if ( ! password_verify($data['password'], $user['password'])) {
            return ['valid' => 0, 'message' => '密码输入错误'];
        }
        Session::set('uid', $user['id']);

        return ['valid' => 1, 'message' => '登录成功'];
    }

    /**
     * 修改密码
     *
     * @param $data
     *
     * @return array
     */
    public static function changePassword($data)
    {
        if ($data['password'] != $data['password_confirm']) {
            return ['valid' => 0, 'message' => '两次密码输入不一致'];
        }
        $user             = self::find(v('user.id'));
        $user['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->save();

        return ['valid' => 1, 'message' => '密码修改成功'];
    }
}