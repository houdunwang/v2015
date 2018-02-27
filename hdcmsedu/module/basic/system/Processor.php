<?php namespace module\basic\system;

/**
 * 测试模块模块消息处理器
 *
 * @author 后盾人
 * @url http://open.hdcms.com
 */
use module\HdProcessor;
use houdunwang\db\Db;

class Processor extends HdProcessor
{
    //规则编号
    public function handle($rid = 0)
    {
        $sql = "SELECT * FROM ".tablename('reply_basic')." WHERE rid={$rid} ORDER BY rand()";
        if ($res = Db::query($sql)) {
            $this->text($res[0]['content']);
        }
    }
}