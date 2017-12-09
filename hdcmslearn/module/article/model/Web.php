<?php namespace module\article\model;

use houdunwang\model\Model;

/**
 * 微站
 * Class Web
 *
 * @package system\model
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Web extends Model
{
    protected $table = 'web';
    protected $denyInsertFields = ['id'];
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['title', 'required', '站点名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['template_name', 'required', '请选择网站模板风格', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['status', 'num:0,1', '网站状态只能为1或0', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH],
            ['thumb', 'required', '封面图片不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH],
            ['status', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['is_default', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 获取站点模板
     *
     * @return string
     */
    public function getTemplate()
    {
        switch ($this['site_info']['template_type']) {
            case 1:
                return "theme/{$this['site_info']['template_name']}/";
            case 2:
                return "{$this['site_info']['template_path']}/";
        }
    }

    /**
     * 站点信息转为数组
     *
     * @return $this
     */
    public function info()
    {
        if ( ! is_array($this['site_info'])) {
            $this['site_info'] = json_decode($this['site_info'], true);
        }
        return $this;
    }
}