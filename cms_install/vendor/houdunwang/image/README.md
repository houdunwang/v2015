# 图像处理

图片组件提供了缩略图、水印等图像处理功能。

请 [查看在线手册](http://www.kancloud.cn/houdunwang/hdphp3/215235) 进行学习

####设置配置
```
$config = [
	//水印字体
	'font'       => '',
	//水印图像
	'image'      => '',
	//位置  1~9九个位置  0为随机
	'pos'        => 9,
	//透明度
	'pct'        => 60,
	//压缩比
	'quality'    => 80,
	//水印文字
	'text'       => 'houdunwang.com',
	//文字颜色
	'text_color' => '#f00f00',
	//文字大小
	'text_size'  => 12,
];
\houdunwang\config\Config::set( 'image', $config );
```