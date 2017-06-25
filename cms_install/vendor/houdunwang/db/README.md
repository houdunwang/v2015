# 数据库

数据库管理组件提供了丰富的数据操作功能，使用我们在开发中快速的管理数据。

##安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/db
```
> HDPHP 框架已经内置此组件，无需要安装

##开始使用
####设置全局配置

```
\houdunwang\config\Config::set( 'database', [
    //调试模式
    'debug'    => true,
    //读库列表
	'read'     => [ ],
	//写库列表
	'write'    => [ ],
	//表字段缓存目录
	'cacheDir' => 'storage/field',
	//开启读写分离
	'proxy'    => false,
	//主机
	'host'     => 'localhost',
	//类型
	'driver'   => 'mysql',
	//帐号
	'user'     => 'root',
	//密码
	'password' => 'admin888',
	//数据库
	'database' => 'demo',
	//表前缀
	'prefix'   => ''
] );
```

####重设所有配置
```
$config='配置项';//请参考上面的配置项
Db::config($config);
```

####设置独立配置
```
Db::config('password','admin888');
```

#核心操作

数据库查询构造器 (query builder) 提供方便、流畅的接口，用来建立及执行数据库查找语法。在你的应用程序里面，它可以被使用在大部分的数据库操作，而且它在所有支持的数据库系统上都可以执行。

> 注意: HDPHP 查询构造器使用 PDO 参数绑定，以保护应用程序免于 SQL 注入，因此传入的参数不需额外转义特殊字符。


##预准备操作
组件支持使用预准备查询，可以完全避免SQL注入。

####修改操作
```
\houdunwang\db\Db::execute("update news set total=:total where id=:id",[':total'=>5,':id'=>1]);
```

##查询操作

#####使用标识名
```
Db::query("select * from site where siteid=:siteid AND name=:name",
[':siteid'=>36,':name'=>'后盾']);
```

#####使用占位符
```
Db::query("select * from news where title like ?",['%后盾网%']) 
```

##常用操作 
####查找

下面是使用原生 SQL 语句进行查询，更灵活的方式请查看 查询构造器 部分

``` 
Db::table('user')->where('id','>',1)->get();
```

####新增
```
Db::table('user')->insert(['username'=>'向军','qq'=>'2300071698']);
//数组数据会过滤掉非法字段
```

####不存在时新增
```
$user =$User->firstOrCreate(['username' => '李四'],['username'=>'李四','age'=>22]);

//如果不存在叫 “李四” 的用户就新增用户
```

####替换
```
Db::table('user')->replace(['id'=>1,'username'=>'向军','qq'=>'2300071698']);
//如果字段中有主键或唯一索引，并且数据存在，replace操作将执行替换当前记录的操作
```

####添加并获取自增主键
如果数据表有自动递增的ID，可以使用 insertGetId 添加数据并返回该 ID
```
Db::table('user')-> insertGetId(['username'=>'向军','qq'=>'2300071698']);
```

####更新
```
Db::table('user')->where("id",1)->update(['username'=>'后盾网']);
//数组数据会过滤掉非法字段
```

####删除
```
Db::table('user')->where('id',1)->delete();
//删除指定的主键值
Db::table('user')->delete(1);
Db::table('user')->delete([2,3,5]);
```

####自增一个字段值
将total字段值加2
```
Db::table("user")->where('id',1)->increment('total',2);
```

####自减一个字段值
```
Db::table("user")->where('id',1)->decrement('total',2);
将total字段减少2
```

####获取自增主键
```
$db = Db::table( 'news' );
$db->insert( [ 'title' => '后盾网' ] );
echo $db->getInsertId();
```

####获取受影响条数
```
$db = Db::table( 'news' );
$db->update( [ 'title' => '后盾人' ] );
echo $db->getAffectedRow();
```

#查询构造器

[TOC]

####从数据表中取得所有的数据列

```
Db::table('user')->get();
```
 
####取得指定的字段
```
Db::table('user')->get(['username','age']);
```

####从数据表中取得单一数据列
```
Db::table('user')->where('username','向军')->first();

//取出指定主键的值
Db::table('user')->first(2);
```

####从数据表中取得单一数据列的单一字段
```
Db::table('user')->where('username', '向军')->pluck('username');

//返回第一条记录的 username 字段值
```

####取得单一字段值的列表
```
Db::table('user')->lists('username');

//满足条件记录的所有username字段
[
    [0] => admin
    [1] => hdxj
]
```

####返回一维数组，第一个字段做为键名使用，第 2 个字段做为键值
```
Db::table('user')->lists('id,username'); 

//id 字段做为键名使用
[
    [1] => admin
    [2] => hdxj
]
```

####多个字段返回二维数组，第一个字段值做为键名使用，其余字段做为键值
```
Db::table('user')->lists('id,username,age');

//返回值如下
[
    [1] => [
            [id] => 1
            [username] => admin
            [age] => 22
           ]

    [2] => [
            [id] => 2
            [username] => hdxj
            [age] => 67
           ]
]
```

####指定查询结果字段
```
Db::table('user')->field('username AS name,age')->get();

或

Db::table('user')->field(['username','age'])->get();
```

####根据某个字段查询
```
Db::table('user')->getByName("hdphp");
//返回一条记录
```

####增加查询子句到现有的查询中
```
$db = Db::table('user')->field('username AS name','age','id');
$db->where('id','>',2)->get();
```

####使用 where 及运算符
```
Db::table('user')->where('id','>',1)->get();
Db::table('user')->where('id','>',1)->where('id','<',10)->get();

```

####使用andwhere
```
Db::table('user')->where('id','>',1)->andwhere('id','<',10)->get();
```

####使用orwhere
```
Db::table('user')->where('id','>',1)->orwhere('id','<',10)->get();
```

####使用 logic 条件连接符
```
Db::table('user')->where('id','>',1)->logic('or')->where('id','<',22)->get();
```

####预准备whereRaw
```
Db::table('user')->whereRaw('age > ? and username =?', [1,'admin'])->get();
```

####使用 whereBetween
```
Db::table('user')->whereBetween('id',[10,30])->get();
```

####使用 WhereNotBetween
```
Db::table('user')->whereNotBetween('id',[10,30])->get();
```

####使用 WhereIn
```
Db::table('user')->whereIn('id',[2,3,9])->get();
```

####使用 WhereNotIn
```
Db::table('user')->whereNotIn('id',[3,5,6])->get();
```

####使用 WhereNull
```
Db::table('user')->whereNull('username')->get();
```

####使用 WhereNotNull
```
Db::table('user')->whereNotNull('id')->get();
```

####指定条件关系
```
Db::table('user')->where('id','>',1)->logic('AND')->whereBetween('id',[1,10])->get();
```

####排序(Order By)
```
Db::table('user')->orderBy('id','DESC')->get();
Db::table('user')->orderBy('id','DESC')->orderBy('rank','ASC')->get();
//多个排序条件
```

####分组GROUP BY
```
Db::table('user')->groupBy('age')->get();
```

####分组筛选HAVING
```
Db::table('user')->groupBy('age')->having('count(sex)','>',2)->get();
```

####取部分数据LIMIT
```
Db::table('user')->limit(2)->get();
Db::table('user')->limit(2,5)->get();
```

##聚合
```
Db::table("user")->count('id');
Db::table("user")->max('id');
Db::table("user")->min('id');
Db::table("user")->avg('id');
Db::table("user")->sum('id');
```

##JOIN多表关联

####多表关联INNER JOIN
```
Db::table('user')
	->join('class','user.cid','=','class.cid')
	->join('contacts','user.id','=','contacts.uid')
	->get()
```

####多表关联LEFT JOIN
```
Db::table('user')->leftJoin('class','user.cid','=','class.cid')->get();
```

####多表关联RIGHT JOIN
```
Db::table('user')->rightJoin('class','user.cid','=','class.cid')->get();
```

#日志记录
可以在内存里访问这次请求中所有的查找语句，用于分析SQL执行的情况。


####获取查询日志

```
Db::getQueryLog();
```

#分页处理

组件可以产生基于当前页面的智能「范围」链接，所产生的 HTML 兼容 Bootstrap CSS 框架.


##示例

```
$users = Db::table( 'user' )->paginate(3);
foreach ( $users as $f ) {
	p( $f['username'] );
}
//显示页码链接
dd($users->links());      
```
**paginate指令说明**

```
paginate( $row=10, $pageNum = 8 );
//$row 显示条数据
//$pageNum 页码数量
```


