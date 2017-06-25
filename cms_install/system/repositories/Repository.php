<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system;

use houdunwang\framework\App;
use houdunwang\model\Model;

/**
 *
 * Class Repository
 *
 * @package system
 */
abstract class Repository implements RepositoryInterface
{
    private $app;
    private $model;

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
        return $this->model->get($columns);
    }

    public function paginate($page = 15, $columns = ['*'])
    {
        return $this->model->paginate($page, $columns);
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function find($id, $columns = ['*'])
    {
        // TODO: Implement find() method.
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        // TODO: Implement findBy() method.
    }

}