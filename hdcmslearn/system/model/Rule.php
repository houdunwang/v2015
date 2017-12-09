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

/**
 * 微信回复规则
 * Class Rule
 *
 * @package system\model
 */
class Rule extends Common
{
    protected $table = 'rule';
    protected $denyInsertFields = ['rid'];
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['rank', 'num:0,255', '排序数字在0~255之间', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['name', 'required', '规则名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['name', 'unique', '规则名称已经存在', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['module', 'required', '模块字段不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['rid', 'validateRid', '回复规则不属于本网站', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];

    protected function validateRid($field, $val)
    {
        $rule = Db::table('rule')->where('rid', $val)->first();
        if ( ! empty($rule) && $rule['siteid'] != SITEID) {
            return false;
        }

        return true;
    }

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['status', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['rank', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 根据关键词内容获取规则
     *
     * @param string $content 关键词内容
     *
     * @return array
     */
    public static function getByKeyword($content)
    {
        $content = trim($content);
        $sql     = "SELECT * FROM ".tablename('rule').' AS r INNER JOIN '.tablename('rule_keyword')
                   ." as k ON r.rid = k.rid WHERE k.status=1 AND k.siteid=".SITEID
                   ." ORDER BY k.rank DESC,type DESC";
        $rules   = Db::query($sql);
        $content = strtolower($content);
        foreach ($rules as $rule) {
            $rule['content'] = strtolower($rule['content']);
            switch ($rule['type']) {
                case 1:
                    //完全匹配
                    if ($content == $rule['content']) {
                        return $rule;
                    }
                    break;
                case 2:
                    //部分匹配
                    if (strpos($content, $rule['content']) !== false) {
                        return $rule;
                    }
                    break;
                case 3:
                    //正则匹配
                    if (preg_match('/'.$rule['content'].'/i', $content)) {
                        return $rule;
                    }
                    break;
            }
        }
    }

    /**
     * 根据规则编号获取规则
     * 饮食关键词信息
     *
     * @param int $rid 规则编号
     *
     * @return array
     */
    public function getRuleByRid($rid)
    {
        if ($data = self::where('rid', $rid)->first()) {
            $data['keyword'] = (new RuleKeyword())->getKeywordByRid($rid);
        }

        return $data;
    }

    /**
     * 按规则标识删除微信规则与回复关键字
     *
     * @param $name 规则标识
     *
     * @return bool
     */
    public function delRuleByName($name)
    {
        $rid = $this->where('name', $name)->pluck('rid');

        return WeChat::removeRule($rid);
    }

    /**
     * 根据规则标识获取规则编号
     *
     * @param $name 规则标识
     *
     * @return int
     */
    public function getRidByName($name)
    {
        return self::where('siteid', siteid())->where('name', $name)->pluck('rid') ?: 0;
    }

    /**
     * 获取模块回复规则根据状态
     *
     * @param string $module 模块标识
     * @param int    $status 1 启用 0 禁用
     *
     * @return array
     */
    public function moduleRuleByStatus($module = '', $status = 1)
    {
        $module = $module ?: v('module.name');

        return self::where('siteid', siteid())->where('module', $module)->orderBy('rid', 'DESC')
                   ->where('status', $status)->get() ?: [];
    }

    public function keywords()
    {
        return $this->hasMany(RuleKeyword::class, 'rid', 'rid');
    }
}