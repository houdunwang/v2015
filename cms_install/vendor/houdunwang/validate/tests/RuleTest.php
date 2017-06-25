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

class RuleTest extends TestCase
{
    public function setUp()
    {
        Config::loadFiles('tests/config');
    }

    public function test_required()
    {
        Request::set('post.username', 'hdxj');
        echo Request::post('username');
        $res = Validate::make([
            ['username', 'required', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_isnull()
    {
        $res = Validate::make([
            ['usernameBuild', 'isnull', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertFalse($res);
    }

    public function test_email()
    {
        Request::set('post.email', '2300071698@qq.com');
        $res = Validate::make([
            ['email', 'email', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_http()
    {
        Request::set('post.data', 'http://houdunwang.com');
        $res = Validate::make([
            ['data', 'http', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_tel()
    {
        Request::set('post.data', '010-65657676');
        $res = Validate::make([
            ['data', 'tel', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_phone()
    {
        Request::set('post.data', '18611566654');
        $res = Validate::make([
            ['data', 'phone', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_zipCode()
    {
        Request::set('post.data', 100011);
        $res = Validate::make([
            ['data', 'zipCode', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_num()
    {
        Request::set('post.data', 21);
        $res = Validate::make([
            ['data', 'num:20,60', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_range()
    {
        Request::set('post.data', 21121);
        $res = Validate::make([
            ['data', 'range:5,20', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_maxlen()
    {
        Request::set('post.data', 211211111);
        $res = Validate::make([
            ['data', 'maxlen:10', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_minlen()
    {
        Request::set('post.data', 1234);
        $res = Validate::make([
            ['data', 'minlen:3', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_regexp()
    {
        Request::set('post.data', 123456);
        $res = Validate::make([
            ['data', 'regexp:/^\d{5,20}$/', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_confirm()
    {
        Request::set('post.data', 123456);
        Request::set('post.password2', 123456);
        $res = Validate::make([
            ['data', 'confirm:password2', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_china()
    {
        Request::set('post.data', 'aa');
        $res = Validate::make([
            ['data', 'china', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertTrue($res);
    }

    public function test_exists()
    {
        Request::set('post.data', 'aa');
        $res = Validate::make([
            ['data', 'exists', '验证成功', Validate::MUST_VALIDATE],
        ]);
        $this->assertFalse($res);
    }
}