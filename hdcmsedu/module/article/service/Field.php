<?php namespace module\article\service;

use houdunwang\view\View;
use module\HdService;
use Db;
use Request;

/**
 * 字段管理服务
 * Class Field
 *
 * @package module\article\system
 */
class Field extends HdService
{
    /**
     * 生成字段表单
     *
     * @param array $data
     *
     * @return string
     */
    public function make($data = [])
    {
        $fields = Db::table('web_field')->where('mid', Request::get('mid'))->get();
        $html   = '';
        foreach ($fields as $f) {
            $value = $data ? $data[$f['name']] : '';
            $html  .= call_user_func_array([$this, '_'.$f['type']], [$f, $value]);
        }

        return $html;
    }

    protected function _string($field, $value)
    {
        $field['value'] = $value;
        $view           = new View();
        $view->with('field', $field);

        return $view->make($this->template.'/string.html');
    }

    protected function _text($field, $value)
    {
        $field['value'] = $value;
        $view           = new View();
        $view->with('field', $field);

        return $view->make($this->template.'/text.html');
    }

    protected function _int($field, $value)
    {
        $field['value'] = $value;
        $view           = new View();
        $view->with('field', $field);

        return $view->make($this->template.'/int.html');
    }

    protected function _image($field, $value)
    {
        $field['value'] = $value;
        $view           = new View();
        $view->with('field', $field);

        return $view->make($this->template.'/image.html');
    }
}