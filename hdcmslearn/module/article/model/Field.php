<?php namespace module\article\model;

use houdunwang\database\build\Blueprint;
use houdunwang\model\Model;
use houdunwang\request\Request;

/**
 * 字段管理
 * Class Field
 *
 * @package module\article\model
 */
class Field extends Model
{
    protected $table = 'web_field';
    protected $denyInsertFields = ['id'];
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['title', 'required', '字面名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['name', '/[a-z]+/', '字段标识只能为英文字母', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['name', 'checkName', '字段已经存在请更换字段标识', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH],
        ];
    protected $filter
        = [
            //更新时过滤模型标签不允许修改
            ['name', self::MUST_FILTER, self::MODEL_UPDATE],
        ];

    //验证字段是否已经存在
    protected function checkName($field, $value, $params, $data)
    {
        $status = Db::table('web_field')->where('siteid', siteid())
                    ->where('name', $value)->where('mid', Request::get('mid'))->get();
        if ( ! $status) {
            return true;
        }
    }

    /**
     * 获取模型表名
     *
     * @param int $mid 模型编号
     *
     * @return string
     */
    public function getModelTable($mid)
    {
        $name = Db::table('web_model')->where('mid', $mid)->pluck('model_name');

        return "web_content_{$name}".siteid();
    }

    /**
     * 向表中添加字段
     *
     * @param int   $mid     模型编号
     * @param array $options 字段选项
     *
     * @return mixed|string
     */
    public function createField($mid, $options)
    {
        $table = $this->getModelTable($mid);
        //字段不存在时创建
        if ( ! Schema::fieldExists($options['name'], $table)) {
            return call_user_func_array([$this, '_'.$options['type']], [$table, $options]);
        }
    }

    /**
     * 删除字段
     *
     * @return bool
     */
    public function delField()
    {
        $name  = Db::table('web_model')->where('mid', $this['mid'])->pluck('model_name');
        $table = "web_content_".$name.siteid();
        if (Schema::dropField($table, $this['name'])) {
            return $this->destory();
        }
        $this->error = '字段删除失败';

        return false;
    }

    /**
     * 创建字符串类型字段
     *
     * @param $table   表名
     * @param $options 字段选项
     */
    protected function _string($table, $options)
    {
        $table = new Blueprint($table);
        switch ($options['field']) {
            case 'varchar':
                $table->string($options['name'], $options['length']);
                break;
            case 'char':
                $table->char($options['name'], min($options['length'], 255));
                break;
        }

        return $table->comment($options['title'])->add();
    }

    //长文本,可用文本域或编辑器显示
    protected function _text($table, $options)
    {
        $table = new Blueprint($table);
        $table->text($options['name']);

        return $table->comment($options['title'])->add();
    }

    //数值
    protected function _int($table, $options)
    {
        $table = new Blueprint($table);
        switch ($options['field']) {
            case 'tinyInteger':
                $table->tinyInteger($options['name']);
                break;
            case 'smallint':
                $table->smallint($options['name']);
                break;
            case 'integer':
                $table->integer($options['name']);
                break;
        }

        return $table->comment($options['title'])->add();
    }

    //单图
    protected function _image($table, $options)
    {
        $table = new Blueprint($table);
        $table->string($options['name'], 300);

        return $table->comment($options['title'])->add();
    }
}