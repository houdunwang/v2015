<?php namespace system\model;

use houdunwang\model\Model;
use module\article\model\WebCategory;
use module\article\model\WebModel;

/**
 * 文章模块站点
 * Class Web
 *
 * @package system\model
 */
class Web extends Model
{
    //数据表
    protected $table = "web";

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
    protected $timestamps = false;

    /**
     * 检测指定的官网编号是否属于当前站点
     *
     * @param int $id 站点编号
     *
     * @return bool
     */
    public function has($id)
    {
        return Db::table('web')->where('siteid', SITEID)->where('id', $id)->first() ? true : false;
    }

    /**
     * 删除文章站点
     *
     * @param $webId 站点编号
     *
     * @return bool
     */
    public function del($webId)
    {
        //删除栏目
        WebCategory::where('web_id', $webId)->delete();
        //删除文章表
        Db::table('web_article')->where('web_id', $webId)->delete();
        //删除站点
        Db::table('web')->where('id', $webId)->delete();
        //删除回复规则
        $rid = Db::table('reply_cover')->where('web_id', $webId)->pluck('rid');
        \Wx::removeRule($rid);

        return true;
    }
}