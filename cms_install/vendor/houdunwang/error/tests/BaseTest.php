<?php

namespace tests;

use houdunwang\config\Config;
use houdunwang\error\Error;
use houdunwang\log\Log;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::set('log.dir', 'storage/log');
        //开启时直接显示错误信息
        Config::set('app.debug', true);
        $config = [
            //Notice类型错误显示
            'show_notice' => true,
            //错误提示页面
            'bug'         => 'resource/bug.php',
        ];
        Config::set('error', $config);
    }

    public function testBase()
    {
        Error::bootstrap();
        Log::write('333');
//        throw new \Exception('aa');
//        require ' a';
    }
}