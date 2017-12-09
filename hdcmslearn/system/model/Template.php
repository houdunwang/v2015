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

use houdunwang\container\Container;
use houdunwang\dir\Dir;

/**
 * 模板
 * Class Template
 *
 * @package system\model
 * @author  向军
 */
class Template extends Common
{
    protected $table = 'template';
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['name', 'regexp:/^[a-z]+$/', '模板标识符只能由字母组成', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['title', 'maxlen:10', '模板名称不能超过10个字符', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['resume', 'required', '模板简述不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['author', 'required', '作者不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['url', 'required', '发布url不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['industry', 'required', '模板类型不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['author', 'required', '作者不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['thumb', 'required', '模板封面图片不能为空!', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];
    protected $auto
        = [
            ['position', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['is_system', 0, 'string', self::MUST_AUTO, self::MODEL_INSERT],
            ['is_default', 0, 'string', self::MUST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 获取站点扩展模板数据
     *
     * @param int $siteId 网站编号
     *
     * @return array
     */
    public function getSiteExtTemplates($siteId)
    {
        $template = SiteTemplate::where('siteid', $siteId)->lists('template');

        return $template ? $this->whereIn('name', $template)->get() : [];
    }

    /**
     * 获取站点扩展模板
     *
     * @param int $siteId 站点编号
     *
     * @return array
     */
    public function getSiteExtTemplateName($siteId = 0)
    {
        $siteId = $siteId ?: SITEID;

        return Db::table('site_template')->where('siteid', $siteId)->lists('template');
    }

    /**
     * 获取站点所有模板
     *
     * @param int    $siteId   站点编号
     * @param string $industry 模板类型
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function getSiteAllTemplate($siteId = 0, $industry = '')
    {
        $siteId = $siteId ?: SITEID;
        if (empty($siteId)) {
            throw new \Exception('站点编号不存在');
        }

        static $cache = [];
        if (isset($cache[$siteId])) {
            return $cache[$siteId];
        }
        //系统模板默认包含
        $db = Db::table('template')->where('tid', '>', 0)->whereNotEmpty('industry', $industry)->orWhere('is_system', 1);
        //获取站点可使用的所有套餐
        $PackageModel = new Package();
        $package      = $PackageModel->getSiteAllPackageData($siteId);
        if ( ! empty($package) && $package[0]['id'] == -1) {
            $templates = $db->get();
        } else {
            $templateNames = [];
            foreach ((array)$package as $p) {
                $templateNames = array_merge($templateNames, $p['template']);
            }
            $templateNames = array_merge($templateNames, $this->getSiteExtTemplateName($siteId));
            if ( ! empty($templateNames)) {
                $db->whereIn('name', $templateNames);
            }
            $templates = $db->get();
        }
        return $cache[$siteId] = $templates;
    }

    /**
     * 获取模板位置数据
     *
     * @param $tid 模板编号
     *
     * @return array
     * array(
     *  1=>'位置1',
     *  2=>'位置2',
     * )
     */
    public function getPositionData($tid)
    {
        $position = Db::table('template')->where('tid', $tid)->pluck('position');
        $data     = [];
        if ($position) {
            for ($i = 1; $i <= $position; $i++) {
                $data[] = ['position' => $i, 'title' => '位置'.$i];
            }
        }

        return $data;
    }

    /**
     * 获取模板类型
     *
     * @return array
     */
    public static function getTitleLists()
    {
        return [
            'often'       => '常用模板',
            'rummery'     => '酒店',
            'car'         => '汽车',
            'tourism'     => '旅游',
            'drink'       => '餐饮',
            'realty'      => '房地产',
            'medical'     => '医疗保健',
            'education'   => '教育',
            'cosmetology' => '健身美容',
            'shoot'       => '婚纱摄影',
            'other'       => '其他',
        ];
    }

    /**
     * 获取文章模块的使用的模板数据
     *
     * @param string $industry 模板类型
     *
     * @return mixed
     */
    public function getTemplateData($industry = '')
    {
        $name = Db::table('web')->where('siteid', SITEID)->whereNotEmpty('industry', $industry)->pluck('template_name');
        if ($name) {
            return Db::table('template')->where('name', $name)->first();
        }

        return Db::table('template')->where('name', 'default')->first();
    }

    /**
     * 是否为系统模板
     *
     * @param $name
     *
     * @return bool
     */
    public function isSystemTemplate($name)
    {
        $model = $this->where('name', $name)->first();

        return $model && $model['is_system'] == 1;
    }

    /**
     * 删除模板
     *
     * @param string $name 模板标识
     *
     * @return bool
     */
    public function remove($name)
    {
        if ($this->isSystemTemplate($name)) {
            $this->setError('系统模板不允许删除');

            return false;
        }
        //云模板时删除目录
        if (is_file("theme/{$name}/cloud.php")) {
            if ( ! Dir::del("theme/{$name}")) {
                $this->setError('云模板删除失败');

                return false;
            }
        }
        //更新套餐数据
        (new Package())->removeTemplate($name);
        $this->where('name', $name)->delete();

        //更新站点缓存
        Container::callMethod(Site::class, 'updateAllCache');

        return true;
    }

}