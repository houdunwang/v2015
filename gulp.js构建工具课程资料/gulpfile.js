	// 定义依赖项
var gulp = require('gulp'),
// 定义合并插件
concat = require('gulp-concat'),
// 定义压缩css的插件
mincss = require('gulp-minify-css'),
// 定义压缩js的插件
minjs = require('gulp-uglify'),
// 定义重命名插件
rename  = require('gulp-rename');

// 定义一个名字为css的任务
gulp.task('css',function(){
	// 操作css文件夹中所有的css文件
	gulp.src(['css/*.css'])
	// 执行合并插件并给合并完成文件起一个名字
	.pipe(concat('max.css'))
	// 执行压缩插件
	.pipe(mincss())
	// 执行重命名插件
	.pipe(rename({suffix:'.hd'}))
	// 把执行以上操作过后的文件放到css1文件夹内
	.pipe(gulp.dest('css1'));
})

// 定义一个名字为js的任务
gulp.task('js',function(){
	// 操作css文件夹中所有的css文件
	gulp.src(['js/a.js','js/index.js'])
	// 执行合并插件并给合并完成文件起一个名字
	.pipe(concat('max.js'))
	// 执行压缩插件
	.pipe(minjs())
	// 执行重命名插件
	.pipe(rename({suffix:'.hd'}))
	// 把执行以上操作过后的文件放到js文件夹内
	.pipe(gulp.dest('js'));
})






// 执行任务名为css的任务
gulp.task('default',['css','js']);

// 自动执行任务
gulp.watch('css/*.css',['css']);





