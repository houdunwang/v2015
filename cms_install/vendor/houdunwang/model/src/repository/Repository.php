<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\model\repository;

use houdunwang\framework\App;
use houdunwang\model\Model;

/**
 *
 * Class Repository
 *
 * @package system
 */
abstract class Repository implements RepositoryInterface, RuleInterface
{
    //应用实例
    protected $app;

    //模型
    protected $model;

    //规则集合
    protected $rules = [];

    //不使用规则
    protected $skipRule = false;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * @return Model
     * @throws \Exception
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if ( ! $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of houdunwang\\model\\Model");
        }

        return $this->model = $model;
    }

    public function all($columns = ['*'])
    {
        $this->applyRule();

        return $this->model->get($columns);
    }

    public function paginate($page = 15, $columns = ['*'])
    {
        $this->applyRule();

        return $this->model->paginate($page, $columns);
    }

    public function create(array $data)
    {
        return $this->model->save($data);
    }

    public function update(array $data, $id)
    {
        $model = $this->model->find($id);

        return $model->save($data);
    }

    public function delete($id)
    {
        $model = $this->model->find($id);

        return $model->destory();
    }

    public function find($id, $columns = ['*'])
    {
        $this->applyRule();

        return $this->model->field($columns)->find($id);
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        $this->applyRule();

        return $this->model->where('field', $value)->field($columns)->first();
    }

    public function resetRule()
    {
        return $this->skipRule(false);
    }

    public function skipRule($status = true)
    {
        $this->skipRule = $status;

        return $this;
    }

    public function getRule()
    {
        return $this->rules;
    }

    public function getByRule(Rule $Rule)
    {
        $this->model = $Rule->apply($this->model, $this);

        return $this;
    }

    public function pushRule(Rule $Rule)
    {
        $this->rules[] = $Rule;

        return $this;
    }

    public function applyRule()
    {
        if ($this->skipRule === true) {
            return $this;
        }
        foreach ($this->getRule() as $rule) {
            if ($rule instanceof Rule) {
                $this->model = $rule->apply($this->model, $this);
            }
        }

        return $this;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->model, $name], $arguments);
    }
}