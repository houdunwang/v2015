<?php namespace module\article\model;

use houdunwang\model\Model;
use Db;

/**
 * 文章模型
 * Class WebModel
 *
 * @package module\article\model
 */
class WebModel extends Model
{
    protected $table = 'web_model';
    protected $denyInsertFields = ['mid'];
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['model_title', 'required', '模型名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['model_name', '/[a-z]+/', '模型表名只能为英文字母', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['model_name', 'checkName', '模型标识已经被使用了,请更换', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH],
        ];
    protected $filter
        = [
            //更新时过滤模型标签不允许修改
            ['model_name', self::MUST_FILTER, self::MODEL_UPDATE],
        ];

    //验证模型表是否已经存在
    protected function checkName($field, $value, $params, $data)
    {
        $table = "web_content_{$value}".SITEID;
        if ( ! Schema::tableExists($table)) {
            return true;
        }
    }

    //创建模型表
    public function createModelTable($name, $siteid = 0)
    {
        $siteid = $siteid ?: siteid();
        $table  = "web_content_{$name}".$siteid;
        if ( ! Schema::tableExists($table)) {
            $sql
                = <<<sql
CREATE TABLE `hd_{$table}` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL,
  `mid` int(11) DEFAULT NULL COMMENT '模型编号',
  `cid` int(10) unsigned NOT NULL COMMENT '栏目编号',
  `uid` int(10) unsigned NOT NULL COMMENT '会员编号',
  `keyword` varchar(30) NOT NULL COMMENT '微信回复关键词',
  `iscommend` tinyint(1) unsigned NOT NULL COMMENT '推荐',
  `ishot` tinyint(1) unsigned NOT NULL COMMENT '头条',
  `title` varchar(145) NOT NULL COMMENT '标题',
  `click` mediumint(8) unsigned NOT NULL COMMENT '点击数',
  `thumb` varchar(300) NOT NULL COMMENT '缩略图',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` mediumtext NOT NULL COMMENT '内容',
  `source` varchar(45) NOT NULL COMMENT '来源',
  `author` varchar(45) NOT NULL COMMENT '作者',
  `orderby` tinyint(3) unsigned NOT NULL COMMENT '排序',
  `linkurl` varchar(145) NOT NULL COMMENT '外部链接地址',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `template` varchar(300) NOT NULL DEFAULT '' COMMENT '模板文件',
  PRIMARY KEY (`aid`),
  KEY `siteid` (`siteid`),
  KEY `category_cid` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章模块内容表';
sql;
            Db::execute($sql);
        }
    }

    /**
     * 删除模型并删除模型表
     *
     * @return bool
     */
    public function delModel()
    {
        $table = "web_content_".$this['name'].SITEID;
        if (Schema::tableExists($table)) {
            if ( ! Schema::drop($table)) {
                $this->error = '删除模型表失败';

                return false;
            }
        }

        return $this->destory();
    }

    /**
     * 获取当前站点的模型列表
     *
     * @return mixed
     */
    public static function getLists()
    {
        return Db::table('web_model')->where('siteid', SITEID)->get();
    }

    /**
     * 根据mid获取模型的表名
     *
     * @param $mid
     *
     * @return string
     */
    public function getModelTable($mid)
    {
        static $cache = [];
        if ( ! isset($cache[$mid])) {
            $name        = Db::table('web_model')->where('mid', $mid)->where('siteid', SITEID)->pluck('model_name');
            $cache[$mid] = "web_content_".$name.SITEID;
        }

        return $cache[$mid];
    }
}