<?php
use Workerman\Worker;
use Workerman\Lib\Timer;

// watch Applications catalogue
$monitor_dir = realpath(__DIR__.'/..');

// worker
$worker = new Worker();
$worker->name = 'FileMonitor';
$worker->reloadable = false;
$last_mtime = time();

$worker->onWorkerStart = function()
{
    global $monitor_dir;
    // watch files only in daemon mode
    if(!Worker::$daemonize)
    {
        // chek mtime of files per second 
        Timer::add(1, 'check_files_change', array($monitor_dir));
    }
};

// check files func
function check_files_change($monitor_dir)
{
    global $last_mtime;
    // recursive traversal directory
    $dir_iterator = new RecursiveDirectoryIterator($monitor_dir);
    $iterator = new RecursiveIteratorIterator($dir_iterator);
    foreach ($iterator as $file)
    {
        // only check php files
        if(pathinfo($file, PATHINFO_EXTENSION) != 'php')
        {
            continue;
        }
        // check mtime
        if($last_mtime < $file->getMTime())
        {
            echo $file." update and reload\n";
            // send SIGUSR1 signal to master process for reload
            posix_kill(posix_getppid(), SIGUSR1);
            $last_mtime = $file->getMTime();
            break;
        }
    }
}
