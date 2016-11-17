<?php
namespace Home\Controller;
use Addons\Article\Site;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
	    (new Site())->show();
    }
}