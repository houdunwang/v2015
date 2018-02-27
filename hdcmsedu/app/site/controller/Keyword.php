<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller;

use houdunwang\request\Request;
use system\model\RuleKeyword;
use houdunwang\db\Db;
/**
 * 模块回复关键词处理
 * Class keyword
 *
 * @package site\controller
 */
class Keyword extends Admin
{
    /**
     * 检测微信关键词是否已经使用
     *
     * @return array
     */
    public function checkWxKeyword()
    {
        $keyword = Request::request('content');
        $rid     = Request::request('rid');

        $res = RuleKeyword::checkWxKeywordByRid($keyword, $rid);
        if ($res === true) {
            return ['valid' => 1, 'message' => '关键词可以使用'];
        } else {
            return ['valid' => 0, 'message' => $res];
        }
    }

    /**
     * 获取关键词
     *
     * @return mixed
     */
    public function getKeywords()
    {
        $key = Request::post('key');
        $db  = Db::table('rule_keyword')->where('siteid', SITEID)->where('status', 1)->limit(10);
        if ($key) {
            $db->where("content LIKE '%$key%'");
        }

        return $db->get();
    }
}