# 备份
backup组件可轻松完成数据备份与恢复操作

[TOC]
###安装组件
使用 composer 命令进行安装或下载源代码使用。
```
composer require houdunwang/backup
```
> HDPHP 框架已经内置此组件不需要安装

###备份
```
$config = [
	'size' => 20,//分卷大小单位KB
	'dir'  => 'backup/' . date( "Ymdhis" ),//备份目录
];

$status = \houdunwang\backup\Backup::backup( $config, function ( $result ) {
	if ( $result['status'] == 'run' ) {
		//备份进行中
		echo $result['message'];
		//刷新当前页面继续下次
		echo "<script>setTimeout(function(){location.href='{$_SERVER['REQUEST_URI']}'},1000);</script>";
	} else {
		//备份执行完毕
		echo $result['message'];
	}
} );
if ( $status === false ) {
	//备份过程出现错误
	echo \houdunwang\backup\Backup::getError();
}
```

### 还原
```
$obj    = new \houdunwang\backup\Backup();
$status = $obj->recovery( $config, function ( $result ) {
	if ( $result['status'] == 'run' ) {
		//还原进行中
		echo $result['message'];
		//刷新当前页面继续执行
		echo "<script>setTimeout(function(){location.href='{$_SERVER['REQUEST_URI']}'},1000);</script>";
	} else {
		//还原执行完毕
		echo $result['message'];
	}
} );
if ( $status === false ) {
	//还原过程出现错误
	echo $obj->getError();
}
```

###获取备份
备份成功的目录会创建lock.php文件，使用以下方法可以获取正确的备份目录。
```
$dirs = \houdunwang\backup\Backup::getBackupDir('backup');
```

###删除失效备份
```
\houdunwang\backup\Backup::deleteFailureDir('backup');
```