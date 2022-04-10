<?php

namespace app\index\controller;

use think\Controller;

class Article extends Controller
{
    public function index(){
        return 'article index';
    }

    public function add(){
        return '我是展示添加文章模板的方法';
    }
}
