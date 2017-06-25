#XML处理

在 web 开发中经常大量用到 XML这种快速简便的数据传输格式, 本组件可用于创建与解析XML数据。

其他产品也可以使用该组件，请登录 [GITHUB](https://github.com/houdunwang/xml) 查看源代码与说明文档。

[TOC]

#开始使用

##安装
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/xml
```
> HDPHP 框架已经内置此组件，不需要安装

##复杂的XML操作
####生成XML
```
$data = array(
	'@attributes' => array(
		'type' => 'fiction'
	),
	'book'        => array(
		array(
			'@attributes' => array(
				'author' => 'houdunwang.com'
			),
			'title'       => 'houdunwang'
		),
		array(
			'@attributes' => array(
				'author' => 'hdcms'
			),
			'title'       => array( '@cdata' => 'version' ),
			'price'       => '$998'
		)
	)
);
header( 'Content-Type: application/xml' );
$xml = Xml::toXml('root_node', $data);
echo $xml;
```

**生成结果**

```
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
```

####解析XML
xml文件 hd.xml：
```
$xml=<<<str
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
```

##简单的XML操作

####生成xml字符
不能分析复杂的XML数据比如有属性的XML
```
$xml=['name'=>'houdunwang','url'=>'houdunwang.com'];
Xml::toSimpleXml($xml);
```

####解析XML
将xml转为array,不分析XML属性等数据
```
Xml::toSimpleArray($xml);
```