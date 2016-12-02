##AngularJs+RequireJs+Gulp 开发移动应用
开发前需要安装nodejs bower

[https://bower.io/](https://bower.io/)     [http://nodejs.org/](http://nodejs.org/)

## 目录结构

```
├── app.js  		应用配置
├── main.js 		RequireJs配置文件
├── gulpfile.js  	 GulpJs配置文件
├── dist 			编译目录（此目录生成通过GulpJs编译后的js、css文件）
├── node_modules	第三方依赖包如gulp插件等
├── src			   项目源文件
│   ├── controllers	控制器文件目录
│   ├── directives	指令文件目录
│   ├── servers		服务文件目录
│   ├── templates	指令模板目录
│   ├── static	    静态文件目录
│      ├── images	图片
│      ├── less	    样式
│   ├── view	    路由模板目录
│   ├── route.js	路由配置

```

## 环境配置
**安装前端库**

```
bower install jquery bootstrap
```

**安装gulp**

```
npm install -g gulp
```

**安装Gulp插件**

```
npm install --save-dev gulp-uglify gulp-minify-css gulp-concat jshint gulp-jshint gulp-rename  gulp-connect  gulp-less
```

**gulp配置文件**

```
// 定义依赖项
var gulp = require('gulp'),
// 定义压缩js的插件
minjs = require('gulp-uglify'),
// 定义压缩css的插件
mincss = require('gulp-minify-css'),
babel = require('gulp-babel'),
// 定义合并插件
concat = require('gulp-concat'),
// 定义检查js代码的插件
jshint = require('gulp-jshint'),
// 定义重命名插件
rename = require('gulp-rename'),
// 定义刷新页面的插件
connect = require('gulp-connect'),
// 定义编译less的插件
less = require('gulp-less');

//js编译任务
gulp.task('js', function () {
    // 找到我们要操作的文件
    gulp.src('src/**/*.js')
        //执行检测js的插件
        //.pipe(jshint())
        //对代码进行报错提示
        .pipe(jshint.reporter('default'))
        //执行合并插件给合并完成的文件起一个名字
        .pipe(concat('main.js'))
        //执行压缩插件
        //.pipe(minjs())
        //监听更改
        .pipe(connect.reload())
        //把我执行完以上操作的文件放到js1/js文件夹内
        .pipe(gulp.dest('build'));
    });

//less编译任务
gulp.task('less', function () {
    //文件路径
    gulp.src('src/**/*.less')
        //执行编译less的插件
        .pipe(less())
        .pipe(concat('main.css'))
        //执行压缩
        //.pipe(mincss())
        //监听更改
        .pipe(connect.reload())
        //将编译完成的文件放到css文件夹中
        .pipe(gulp.dest('build'));
    })

gulp.task('html', function () {
    //监听更改
    gulp.src('**/*.html').pipe(connect.reload())
});

gulp.task('connect', function () {
    //连接服务器，也就是说用它来连接我们的浏览器
    connect.server({
        //开启这个服务，并随时监听代码的变化反馈给浏览器
        livereload: true
    });
});

gulp.task('watch', function () {
    //监听文件变动,刷新浏览器
    gulp.watch(['./src/**/*.js', './app.js'], ['js']);
    gulp.watch(['./src/**/*.less'], ['less','js']);
    gulp.watch('./**/*.html', ['html']);
});

gulp.task('default', ['watch', 'connect']);

```