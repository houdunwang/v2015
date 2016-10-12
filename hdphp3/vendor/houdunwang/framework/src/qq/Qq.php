<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\qq;

use hdphp\qq\org\QC;

class Qq {

    private $Qc;

    //构造函数
    public function __construct() {

        $this->Qc = new QC;
    }

    public function __call( $method, $args ) {
        return call_user_func_array( [ $this->Qc, $method ], $args );
    }
}