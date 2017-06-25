<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests;


use houdunwang\code\Code;
use houdunwang\config\Config;
use houdunwang\request\Request;
use houdunwang\validate\Validate;
use PHPUnit\Framework\TestCase;

class ValidateTest extends TestCase
{
    public function setUp()
    {
        Config::loadFiles('tests/config');
    }

    public function test_validate()
    {
        $data = ['mobile' => ''];
        $res  = Validate::make([
            ['mobile', 'phone', '手机号格式错误', Validate::MUST_VALIDATE],
            ['mobile', 'required', '手机号不能为空', Validate::MUST_VALIDATE],
        ], $data);
        $this->assertFalse($res);
        $this->assertEquals(['手机号格式错误', '手机号不能为空'], Validate::getError());

        $data = ['mobile' => '18600278888'];
        $res  = Validate::make([
            ['mobile', 'phone', '手机号格式错误', Validate::MUST_VALIDATE],
            ['mobile', 'required', '手机号不能为空', Validate::MUST_VALIDATE],
        ], $data);
        $this->assertTrue($res);
    }

    public function atest_callback()
    {
        $data = ['num' => 50];
        $res  = Validate::make([
            [
                'num',
                function ($value) {
                    return $value > 100;
                },
                '域名不能为空',
                3,
            ],
        ], $data);
        $this->assertFalse($res);

        $data = ['num' => 300];
        $res  = Validate::make([
            [
                'num',
                function ($value) {
                    return $value > 100;
                },
                '域名不能为空',
                3,
            ],
        ], $data);
        $this->assertTrue($res);
    }

    public function test_unique()
    {
        $data = ['qq' => '2300071698', 'id' => 1];
        $res  = Validate::make([
            ['qq', 'unique:user,id', 'qq已经存在', Validate::MUST_VALIDATE],
        ], $data);
        $this->assertTrue($res);
    }

    public function test_captcha()
    {
        Code::make();
        Request::set('post.code', Code::get());
        $res = Validate::make([
            ['code', 'captcha', '验证码输入错误', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_extend()
    {
        Validate::extend('checkUser', function ($field, $value, $params) {
            //返回值为true时验证通过
            return true;
        });
        $res = Validate::make([
            ['code', 'checkUser', '用户验证失败', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }
}