<?php namespace app\system\controller;

use houdunwang\route\Controller;
use Backup as BackupServe;
use Request;

class Backup extends Controller
{
    /**
     * @return mixed
     */
    public function lists()
    {
        $dirs = BackupServe::getBackupDir('backup');

        return view('', compact('dirs'));
    }

    /**
     * 执行备份
     */
    public function run()
    {
        $config = [
            //分卷大小单位KB
            'size' => 200,
            //备份目录
            'dir'  => 'backup/'.date("Ymdhis"),
        ];
        $status = BackupServe::backup($config, function ($result) {
            if ($result['status'] == 'run') {
                //备份进行中
                die(view('message',['content'=>$result['message']]));
            } else {
                //备份执行完毕
                die($this->setRedirect('lists')->success($result['message']));
            }
        });
        if ($status === false) {
            //备份过程出现错误
            die($this->setRedirect('lists')->error(BackupServe::getError()));
        }
    }

    /**
     * 执行备份还原
     */
    public function recovery()
    {
        //要还原的备份目录
        $config = ['dir' => 'backup/'.Request::get('dir')];
        $status = BackupServe::recovery($config, function ($result) {
            if ($result['status'] == 'run') {
                //还原进行中
                die(view('message',['content'=>$result['message']]));
            } else {
                //还原执行完毕
                die($this->setRedirect('lists')->success($result['message']));
            }
        });
        if ($status === false) {
            //还原过程出现错误
            die($this->setRedirect('lists')->error(BackupServe::getError()));
        }
    }

    /**
     * 删除备份目录
     *
     * @return array
     */
    public function remove()
    {
        $dir = Request::get('dir');
        if (Dir::del('backup/'.$dir)) {
            return $this->setRedirect('lists')->success('备份目录删除成功');
        }

        return $this->error('备份目录删除失败，您可以手动删除或修改目录权限后操作');
    }
}
