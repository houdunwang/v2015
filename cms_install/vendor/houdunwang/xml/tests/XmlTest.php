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


use houdunwang\xml\Xml;
use PHPUnit\Framework\TestCase;

class XmlTest extends TestCase
{
    public function test_toXml()
    {
        $data = [
            '@attributes' => [
                'type' => 'fiction',
            ],
            'book'        => [
                [
                    '@attributes' => [
                        'author' => 'houdunwang.com',
                    ],
                    'title'       => 'houdunwang',
                ],
                [
                    '@attributes' => [
                        'author' => 'hdcms',
                    ],
                    'title'       => ['@cdata' => 'version'],
                    'price'       => '$998',
                ],
            ],
        ];
        $xml  = Xml::toXml('root_node', $data);
        $eq
              = '<?xml version="1.0" encoding="UTF-8"?>
<root_node type="fiction">
  <book author="houdunwang.com">
    <title>houdunwang</title>
  </book>
  <book author="hdcms">
    <title><![CDATA[version]]></title>
    <price>$998</price>
  </book>
</root_node>
';
        $this->assertEquals($xml, $eq);
    }

    public function test_toArray()
    {
        $xml
                = <<<str
<?xml version="1.0" encoding="UTF-8"?>
<root_node type="fiction">
	<book author="houdunwang.com">
		<title>houdunwang</title>
	</book>
	<book author="hdcms">
		<title><![CDATA[version]]></title>
		<price>$998</price>
	</book>
</root_node>
str;
        $result = Xml::toArray($xml);
        file_put_contents('tests/demo.php',
            "<?php return ".var_export($result, true).";");
        $this->assertEquals($result, include 'tests/demo.php');
    }

    public function test_toSimpleXml()
    {
        $xml = ['name' => 'houdunwang', 'url' => 'houdunwang.com'];
        $res = Xml::toSimpleXml($xml);
        $eq
             = '<xml><name><![CDATA[houdunwang]]></name><url><![CDATA[houdunwang.com]]></url></xml>';
        $this->assertEquals($res, $eq);
    }

    public function test_toSimpleArray()
    {
        $xml
                = <<<str
<?xml version="1.0" encoding="UTF-8"?>
<root_node type="fiction">
	<book author="houdunwang.com">
		<title>houdunwang</title>
	</book>
	<book author="hdcms">
		<title><![CDATA[version]]></title>
		<price>$998</price>
	</book>
</root_node>
str;
        $result = Xml::toSimpleArray($xml);
        file_put_contents('tests/demo.php',
            "<?php return ".var_export($result, true).";");
        $this->assertEquals($result, include 'tests/demo.php');
    }
}