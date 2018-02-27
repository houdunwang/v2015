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

use houdunwang\db\Db;

/**
 * 回复关键字
 * Class RuleKeyword
 *
 * @package system\model
 */
class RuleKeyword extends Common
{
    protected $table = 'rule_keyword';

    protected $denyInsertFields = ['id'];

    protected $allowFill = ['*'];

    protected $validate
        = [
            ['rid', 'required', '规则编号不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['content', 'required', '关键词内容不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['type', 'regexp:/^[1-4]$/', '关键词类型只能为1~4的数字', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['rank', 'regexp:/^[0-255]$/', '排序只能为0~255的数字', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['status', 'regexp:/^[0-1]$/', '状态只能为1或0', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['rank', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['type', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['status', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 根据规则编号检测关键词是否已经被其他规则使用
     *
     * @param string $content 关键词
     * @param int    $rid     规则编号
     *
     * @return array
     */
    public static function checkWxKeywordByRid($content, $rid = 0)
    {
        $db = Db::table('rule_keyword')->join('rule', 'rule.rid', '=', 'rule_keyword.rid')
                ->where('rule_keyword.siteid', siteid())->where('rule_keyword.content', $content);
        if ($rid) {
            //编辑时当前规则拥有的词不检测
            $db->where('rule.rid', '<>', $rid);
        }
        if ($res = $db->field('rule.module')->first()) {
            $module  = Modules::where('name', $res['module'])->first();
            $message = "关键字[$content]已经在 <b>" . "{$module['title']}</b> 模块中定义";
        }

        return $res ? $message : true;
    }

    /**
     * 批量检测关键词
     *
     * @param array $data
     *
     * @return array|bool
     */
    public static function checkWxKeywordByRidAsArray($data)
    {
        $rid = empty($data['rid']) ? 0 : $data['rid'];
        if (isset($data['keywords'])) {
            foreach ($data['keywords'] as $keyword) {
                $result = self::checkWxKeywordByRid($keyword['content'], $rid);
                if ($result !== true) {
                    return $result;
                }
            }
        }

        return true;
    }

    /**
     * 根据规则编号获取关键词
     *
     * @param int $rid 规则编号
     *
     * @return array
     */
    public function getKeywordByRid($rid)
    {
        $keyword = [];
        if ($rule = Rule::find($rid)) {
            $keyword = self::orderBy('id', 'asc')->where('rid', $rid)->get();
        }

        return $keyword;
    }

    /**
     * 检测关键词是否已经在其他规则中定义
     * 主要用于封面回复等关键词的检测
     * 封面回复使用链接的hash值做为name，比如文章模块中的关键词处理
     *
     * @param string $name    当前模块的规则名称
     * @param string $content 关键词
     *
     * @return array
     */
    public static function checkKeywordHByName($name, $content)
    {
        $name = v('module.name') . '#' . $name;
        $res  = Db::table('rule_keyword')
                  ->join('rule', 'rule.rid', '=', 'rule_keyword.rid')
                  ->where('rule_keyword.siteid', siteid())
                  ->where('rule.name', '<>', $name)
                  ->where('rule_keyword.content', $content)->field('rule.module')->first();
        //查找使用关键词的模块
        if ($res) {
            $module  = Modules::where('name', $res['module'])->first();
            $message = "该关键字已经在 <b>" . "{$module['title']}</b> 模块中定义";
        }
        if ($res) {
            return ['valid' => 0, 'message' => $message];
        } else {
            return ['valid' => 1, 'message' => '关键词可以使用'];
        }
    }
}