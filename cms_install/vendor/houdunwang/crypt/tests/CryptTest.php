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

use houdunwang\crypt\Crypt;

class CryptTest extends Base
{
    public function testBase()
    {
        $d         = Crypt::encrypt('后盾人  人人做后盾');
        $decrypted = Crypt::decrypt($d);
        $this->assertEquals($decrypted, '后盾人  人人做后盾');

        $d = Crypt::encrypt('后盾网  人人做后盾', md5('houdunwang.com'));

        $decrypted = Crypt::decrypt($d, md5('houdunwang.com'));
        $this->assertEquals($decrypted, '后盾网  人人做后盾');

        $d = encrypt('admin888');
        $this->assertEquals(decrypt($d), 'admin888');
    }
}