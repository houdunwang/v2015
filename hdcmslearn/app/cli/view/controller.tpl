<?php namespace {{NAMESPACE}};

use module\HdController;

class {{CLASS}} extends HdController
{
    public function __construct(){
        parent::__construct();
    }

    public function show(){
        //模板文件需要创建在 template/show.php 支持子目录模板文件创建
        return $this->view($this->template.'/show');
    }
}