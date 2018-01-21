<?php
$_CACHE['apps'] = array (
  1 => 
  array (
    'appid' => '1',
    'type' => 'DISCUZ',
    'name' => 'Discuz!',
    'url' => 'http://localhost/test/dz',
    'ip' => '',
    'viewprourl' => '',
    'apifilename' => 'uc.php',
    'charset' => 'gbk',
    'dbcharset' => 'gbk',
    'synlogin' => '1',
    'recvnote' => '1',
    'extra' => false,
    'tagtemplates' => '<?xml version="1.0" encoding="ISO-8859-1"?>
<root>
	<item id="template"><![CDATA[<a href="{url}" target="_blank">{subject}</a>]]></item>
	<item id="fields">
		<item id="subject"><![CDATA[标题]]></item>
		<item id="uid"><![CDATA[用户 ID]]></item>
		<item id="username"><![CDATA[发帖者]]></item>
		<item id="dateline"><![CDATA[日期]]></item>
		<item id="url"><![CDATA[主题地址]]></item>
	</item>
</root>',
  ),
  2 => 
  array (
    'appid' => '2',
    'type' => 'OTHER',
    'name' => 'phpsso',
    'url' => 'http://www.phpsso.cn',
    'ip' => '',
    'viewprourl' => '',
    'apifilename' => 'uc.php',
    'charset' => '',
    'dbcharset' => '',
    'synlogin' => '1',
    'recvnote' => '1',
    'extra' => false,
    'tagtemplates' => '<?xml version="1.0" encoding="ISO-8859-1"?>
<root>
	<item id="template"><![CDATA[]]></item>
</root>',
  ),
  3 => 
  array (
    'appid' => '3',
    'type' => 'UCHOME',
    'name' => '个人家园',
    'url' => 'http://localhost/test/uchome',
    'ip' => '',
    'viewprourl' => '',
    'apifilename' => 'uc.php',
    'charset' => 'gbk',
    'dbcharset' => 'gbk',
    'synlogin' => '1',
    'recvnote' => '1',
    'extra' => false,
    'tagtemplates' => '<?xml version="1.0" encoding="ISO-8859-1"?>
<root>
	<item id="template"><![CDATA[<a href="{url}" target="_blank">{subject}</a>]]></item>
	<item id="fields">
		<item id="subject"><![CDATA[日志标题]]></item>
		<item id="uid"><![CDATA[用户 ID]]></item>
		<item id="username"><![CDATA[用户名]]></item>
		<item id="dateline"><![CDATA[日期]]></item>
		<item id="spaceurl"><![CDATA[空间地址]]></item>
		<item id="url"><![CDATA[日志地址]]></item>
	</item>
</root>',
  ),
);

?>