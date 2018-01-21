<?php namespace module\member\system;

use module\HdProcessor;
use system\model\Member;
use system\model\MemberAuth;

/**
 * 会员关注时添加会员资料
 * Class Processor
 *
 * @package module\member\system
 */
class Processor extends HdProcessor
{
    //规则编号
    public function handle($rid = 0)
    {
        if ($this->message->isSubscribeEvent()) {
            $FromUserName = $this->content->FromUserName;
            if ( ! MemberAuth::where('wechat', $FromUserName)->first()) {
                $member = new Member();
                $uid    = $member->save();
                $auth   = new MemberAuth();
                $auth->save([
                    'uid'    => $uid,
                    'wechat' => $FromUserName,
                ]);
            }
        }
    }
}