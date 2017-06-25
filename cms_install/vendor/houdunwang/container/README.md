# IOC

IOC服务容器管理组件

##安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/container
```
> HDPHP 框架已经内置此组件，无需要安装

##使用
我们先定义一个测试类
```
class App{
    public function show(){return 'success';}
}
```

####注入单例对象
```
Container::instance('app', new App());
Container::make('app')->show();
```

####使用single注入单例
```
Container::single('app',function () {
        return new App();
});
Container::make('app')->show();
```

####使用bind注入到容器
```
Container::bind('app',function () {
    return new App();
});
Container::make('app')->show();
```

或可以真接创建容器对象进行注入

```
$container = new \houdunwang\container\build\Base();
$container->instance('app', new App());
$container['app']->show();
```

####调用类方法
调用类方法时组件会分析方法参数实现依赖注入
```
$res = Container::callMethod(App::class, 'show');
```

####调用函数
调用函数时组件会分析函数的参数实现依赖注入
```
$res = Container::callFunction(function (App $app) {
     return $app->show();
});
```