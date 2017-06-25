#路由
路由是自定义url地址执行指定的控制器或闭包函数，良好的路由定义可以对seo起到很好的效果。

组件依赖 [Request组件](https://github.com/houdunwang/request) 和 [Cache组件](https://github.com/houdunwang/cache) 请查看GitHub文档配置后使用。

[TOC]

##安装
使用 composer 命令进行安装或下载源代码使用。
```
composer require houdunwang/route
```
> HDPHP 框架已经内置此组件，无需要安装

##配置

```
$config = [
    /*
    |--------------------------------------------------------------------------
    | 控制器命名空间前缀
    |--------------------------------------------------------------------------
    */
    'app'                => 'tests\app',

    /*
    |--------------------------------------------------------------------------
    | URL变量
    |--------------------------------------------------------------------------
    | 访问控制器方法时的GET变量
    */
    'url_var'            => 's',

    /*
    |--------------------------------------------------------------------------
    | 请求时没有明确控制器时默认使用的控制器
    |--------------------------------------------------------------------------
    */
    'default_controller' => \tests\app\controller\Entry::class,

    /*
    |--------------------------------------------------------------------------
    | 请求时没有明确方法时默认执行的方法
    |--------------------------------------------------------------------------
    */
    'default_action'     => 'home',

    /*
    |--------------------------------------------------------------------------
    | 是否对路由的解析结果进行缓存用于提高系统性能
    |--------------------------------------------------------------------------
    | 当开启DEBUG时是不会缓存的,这是为了让开发者可以即时看到修改效果
    */
    'route_cache'        => false,
];
\houdunwang\config\Config::batch($config);
```

#基础路由

# 基础路由

URL 路由器可隐藏网站物理文件结构提高安全性，美化 URL 地址便于 SEO。 您将在 system/routes.php 中定义应用中的大多数路由。 大多数基本的路由都只接受一个 URI 和 一个 闭包(Closure) 参数。

[TOC]

##GET 路由
/ 表示访问网站主页
```
Route::get('/',function(){
	return '后盾网 欢迎您';
});
```

设置路由路径
```
Route::get('show', function(){
    return 'Hello HDPHP';
});
```

##POST 路由
触发POST提交的场景很多，比如form标签设置methos='post' 或 jquery ajax提交设置type='POST'，都有可能触发POST路由。

我们来能过实例讲解一下，比如HTML 模板代码如下：
```
<form action="user/add" method="post">
	<input type="text" name="user">
	<input type="submit">
</form>
```

路由规则定义如下：
```
Route::post('user/add', function(){
    p($_POST);
});
```
当我们提交form表单时，因为数据提交方式为POST,并且提交地址与路由匹配，所以就会执行路由回调函数。

##PUT路由
当提交方式设置为PUT，比如jquery中我们可以设置type为PUT,如果是普通form表单提交，我们也可以在表单中添加隐藏域。

html表单定义如下：
```
<form action="user/add" method="post">
	<input type="text" name="user">
	<input type="hidden" name="_method" value="PUT">
	<input type="submit">
</form>
```

路由定义如下：
```
Route::put('user/add', function(){
    p($_POST);
});
```
PUT 提交的数据，我们还是使用$_POST获取

##DELETE 路由
DELETET 定义的路由与使用PUT定义是一样的，下面是表单的设置：
```
<form action="user/del" method="post">
	<input type="text" name="user">
	<input type="hidden" name="_method" value="DELETE">
	<input type="submit">
</form>
```

路由定义如下
```
Route::DELETE('user/del',function(){
	p($_POST);
});
```

##ANY路由
any 路由类型会识别所有有提交模式，而不是像GET模式，只能匹配GET提交
```
Route::any('user',function(){
	return '你好 后盾网';
});
```

##获取匹配成功的路由

用于获取本次请求匹配成功的路由规则。
```
Router::getMatchRoute();
```

##方法欺骗
HTML 表单没有支持 PUT 或 DELETE 请求。所以当定义 PUT 以及 DELETE 路由并在 HTML 表单中被调用的时候，您将需要添加隐藏 _method 字段在表单中。

发送的 _method 字段对应的值会被当做 HTTP 请求方法。举例来说：
```
<form action="user/api" method="POST">
    <input type="hidden" name="_method" value="PUT">
</form>
```

# 路由参数

[TOC]

##参数设置
####必须参数
```
Route::get('user/{id}', function($id){
    return 'User '.$id;
});
```

####可选择的路由参数
可选参数指参数有可能没有值，所以必须给闭包函数设置参数默认值，否则系统会报错。
```
Route::get('user/{name?}', function($name = '后盾网'){
    return $name;
});
```

##获取参数
####取得指定参数
如果需要取得路由解析后的参数，使用 Route::input 方法：
```
Route::get('{name}', function(){
    return Route::input('name');
});
```

####取得所有参数
input 方法中不传任何参数时将返回所有路由参数。
```
Route::get('user/{id}_{name}', function(){
    return Route::input();
});
```

# 参数检测

参数检测是对路由中的参数进行验证，如果验证不通过这条路由将被忽略。

[TOC]

####使用正则表达式限制参数
```
Route::get('user/{id}', function($id){
    return $id;
})->where('id', '[0-9]+');
```

####使用条件限制数组
```
Route::get('user/{id}/{name}', function($id, $name){
    echo $id,$name;
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
```

# 依赖注入

依赖注入IOC等特性贯穿于系统的各个层面，在路由操作提供了灵活的注入机制。

```
Route::get( 'user/{id}/{name}', function ($id, $f = '后盾人', \system\model\News $a, $name ) {
	echo $id, $name;
	dd( $f );
	dd( $a );
} )
```
上在的例子中闭包的 $id 与 路由参数同名，也就是说闭包参数 $id，无论放在任何位置系统都能识别到，不需要与路由中参数位置顺序一致。


# 控制器
控制器路由是用来访问网站控制器方法使用的，我们来看下面的代码：

[TOC]

##配置
####命名空间
路由加载控制器时使用 app.php配置文件中的 path配置项做为控制器类的起始命名空间。
比如我们使用  app\home\Entry 类，我们定义的路由如下:

```
Route::get('show','home\Entry@show');
```

系统使用 app\home\Entry 控制器类。

####默认方法
当所有路由都没有匹配成功时，可以使用 config/http.php 配置文件中,default_controller与default_action 定义的配置项执行默认控制器方法。

##基本使用
```
Route::get('foo', 'home\index@add');
```
当我们访问foo时调用 Home模块Index控制器的add方法

##参数传递
控制器接收路由参数时变量名要与路由定义的参数名一致，顺序不需要和路由参数顺序一致，更多的路由参数学习请参数 [路由参数](http://www.kancloud.cn/houdunwang/hdphp3/215178) 课程章节中的讲解。

####路由定义
执行Entry控制器中的show方法
```
Route::get('show/{id}_{cid}.html', 'home\entry@show')
```

####控制器定义
```
namespace app\home\controller; 
class Entry{
	public function show($id,$cid){
		echo "访问是 $id,$cid";
	}
}

```

##隐式控制器
HDPHP 让你能轻易地定义单一路由来处理控制器中的每一项行为。首先用 Route::controller 方法定义一个路由：
```
Route::controller('user', "home\Entry")
```

Controller 方法接受两个参数。第一个参数是控制器欲处理的 URI，第二个是控制器的类名称。接着只要在你的控制器中加入方法，并在名称前加上它们所对应的 HTTP 请求。
```
namespace app\home\controller;
class Entry{
	public function getIndex(){
		echo 'index';
	}
	public function getAdd(){
		echo 'add';
	}	
	public function postEdit(){
		echo 'edit';
	}
    public function putUpdate(){
		echo 'update';
	}
    public function deleteRemove(){
		echo 'delete';
	}
}
```

如果发送以下请求，将会执行 getAdd 方法
```
http://hdphp2.hd/user/add
```

# 分组路由

路由分组用于将拥有相同特性的路由放在一组中进行管理，相同特性包括路由前缀，中间件等等。
 
[TOC]

##路由前缀
使用 prefix 选项可以将拥有相同前缀的路由归纳到一个组中进行管理。
```
Route::group(['prefix' => 'admin'], function(){
    Route::get('add', function()
    {
        echo 'add';
    });
    
    Route::get('save', function()
    {
        echo 'save';
    });
});
```

比如我们访问admin/add方法后，会匹配到第一个路由定义

#RESTful 路由

REST(Representational State Transfer表述性状态转移)是一种针对网络应用的设计和开发方式，可以降低开发的复杂性，提高系统的可伸缩性。REST提出了一些设计概念和准则：

1. 网络上的所有事物都被抽象为资源（resource）；
2. 每个资源对应一个唯一的资源标识（resource identifier）；
3. 通过通用的连接器接口（generic connector interface）对资源进行操作；
4. 对资源的各种操作不会改变资源标识；
5. 所有的操作都是无状态的（stateless）

资源控制器可让你无痛建立和资源相关的 RESTful 控制器。例如，你可能希望创建一个控制器，它可用来处理针对你的应用程序所保存相片的 HTTP 请求。

[TOC]

##使用
####创建资源控制器
```
php hd make:controller home.photo resource
```

####设置路由规则
我们注册一个指向此控制器的资源路由：
```
Route::resource('photo', 'home/photo');
```

此单一路由声明创建了多个路由，用来处理各式各样和相片资源相关的 RESTful 行为。同样地，产生的控制器已有各种和这些行为绑定的方法，包含用来通知你它们处理了那些 URI 及动词。

##说明
####路由说明
由资源控制器处理的行为

```
动词			路径						 行为
GET			/photo                      索引
GET            /photo/create               创建
POST		   /photo                      保存
GET			/photo/{photo}              显示
GET            /photo/{photo}/edit         编辑
PUT            /photo/{photo}              更新
DELETE		 /photo/{photo}        		 删除
```

####代码
```
namespace app\home\controller;
class Photo{
    //GET /photo 索引
    public function index(){
        echo 'index';
    }

    //GET /photo/create 创建界面
    public function create(){
        echo 'create';
    }

    //POST /photo 保存新增数据
    public function store(){
        echo 'store';
    }

    //GET /photo/{photo} 显示文章
    public function show($id){
        echo 'show';
    }

    //GET /photo/{photo}/edit 更新界面
    public function edit($id){
        echo 'edit';
    }

    //PUT /photo/{photo} 更新数据
    public function update($id){
        echo 'update';
    }

    //DELETE /photo/{photo} 删除
    public function destroy($id){
        echo 'destroy';
    }
}
```

####伪造方法
由于HTML表单不能发起PUT、PATCH和DELETE请求，需要添加一个隐藏的 _method 字段来伪造HTTP请求方式，辅助函数 method_field 可以帮我们做这件事：

```
{{ method_field('PUT') }}
```
系统会生成表单

```
<input type="hidden" name="_method" value="PUT"/>
```