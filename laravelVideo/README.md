# Laravel&VueJs 开发移动与桌面平台视频播放项目

> 希望大家为本项目加个 Star，给我们提供继续坚持录制高质量视频的动力。


## 开发环境

### 开发工具

mac+phpstorm+sequelPro

### 程序语言

laravel+mysql+php+bootstrap+require.js+阿里云oss+阿里云sms+axios+vuejs+vuex...

## 插件

### ideHelper
是一个帮助提高laravel代码提示功能的插件

```
#安装插件
composer require barryvdh/laravel-ide-helper

#在 config/app.php 文件中的providers 配置段中添加以下
Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class

#生成辅助文件
php artisan ide-helper:generate
```
### laracasts/flash
laracasts/flash用于控制消息显示处理

```
#安装
composer require laracasts/flash

#在 config/app.php 文件中的providers 配置段中添加以下
'providers' => [
    Laracasts\Flash\FlashServiceProvider::class,
];

#生成模板
php artisan vendor:publish --provider="Laracasts\Flash\FlashServiceProvider"
```

#### 模板中定义

```
 @include('flash::message')
 <script>
     $('#flash-overlay-modal').modal();
 </script>
```

## 解决mysql5.7以下出错的问题

在 app\Providers\AppServiceProvider.php 文件里的 boot 方法里设置一个默认值

```
public function boot(){
 Schema::defaultStringLength(191);
}
```

## 解决ajax跨域访问

默认情况下前台发送Ajax是允许跨域请求的。我们可以在后台进行相关设置然后允许前台跨域请求。

允许单个域名访问 header('Access-Control-Allow-Origin:http://www.houdunwang.com');

允许多个域名
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : ''; $allow_origin = array( 	'http://www.houdunren.com', 	'http://www.houdunwang.com' ); if(in_array($origin, $allow_origin)){ 	header('Access-Control-Allow-Origin:'.$origin); }

允许所有域名请求
header('Access-Control-Allow-Origin:*');