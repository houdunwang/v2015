<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\backup\build;

use houdunwang\cookie\Cookie;
use houdunwang\database\Schema;
use houdunwang\db\Db;
use houdunwang\dir\Dir;

/**
 * 数据库备份类
 * Class Base
 *
 * @package houdunwang\backup\build
 */
class Base
{
    //错误信息
    protected $error;
    //配置项
    protected $config;

    //获取目录，如果目录中不含有lock.php为不合法目录（比如备份中断）
    public function getBackupDir($dir)
    {
        $data = [];
        if (is_dir($dir)) {
            foreach (Dir::tree($dir) as $d) {
                if ($d['type'] == 'dir' && is_file($d['path'].'/_lock.php')) {
                    $data[] = $d;
                }
            }
        }

        return $data;
    }

    //删除失效的备份目录
    public function deleteFailureDir($dir)
    {
        foreach (Dir::tree($dir) as $d) {
            if ( ! is_file($d['path'].'/_lock.php')) {
                if ( ! \Dir::del($d['path'])) {
                    $this->error = $d['path']."删除失败";

                    return false;
                }
            }
        }

        return true;
    }


    //还原数据
    public function recovery($config, \Closure $callback = null)
    {
        if ( ! is_dir($config['dir'])) {
            $this->error = '目录不存在';

            return false;
        }
        //还原的文件编号
        if (is_file($config['dir'].'/_recovery.php')) {
            $this->config = include $config['dir'].'/_recovery.php';

            return $this->recoveryRun($callback);
        } else {
            $file = [];
            foreach (Dir::tree($config['dir']) as $f) {
                //不运行执行的文件
                if (in_array(
                    $f['basename'],
                    ['_config.php', '_structure.php', '_lock.php']
                )) {
                    continue;
                } else {
                    $file[] = $f['path'];
                }
            }
            //所有文件
            $this->config['file'] = $file;
            //当前要还原的文件
            $this->config['current_file'] = current($file);
            //文件总数
            $this->config['totalfile'] = count($file);
            $this->config['config']    = $config;
            $this->saveConfig('_recovery.php');
            //还原表结构
            require $config['dir'].'/_structure.php';

            return $callback(
                ['message' => '表结构还原成功,准备开始还原数据', 'status' => 'run']
            );
        }
    }

    //执行还原
    protected function recoveryRun(\Closure $callback)
    {
        $config = $this->config;
        foreach ($config['file'] as $id => $f) {
            require $f;
            unset($this->config['file'][$id]);
            //完成比例
            $bl = (intval(
                ($config['totalfile'] - count($config['file']))
                / $config['totalfile'] * 100
            ));
            $this->saveConfig('_recovery.php');

            return $callback(['message' => $bl.'%还原完毕', 'status' => 'run']);
        }
        Dir::delFile($this->config['config']['dir'].'/_recovery.php');

        return $callback(['message' => '所有分卷还原完毕', 'status' => 'success']);
    }

    /**
     * 备份配置
     *
     * @param array         $config   配置
     * @param \Closure|null $callback 间隔备份后的回调函数
     *
     * @return bool
     */
    public function backup(array $config, \Closure $callback = null)
    {
        //备份文件夹
        $dir           = Cookie::get('houdunwang_backup_dir') ?: $config['dir'];
        $config['dir'] = $dir;
        if (is_file($dir.'/lock.php')) {
            $this->error = '备份完成了,不允许重复备份相同目录';

            return;
        }
        if (is_file($dir.'/_config.php')) {
            $this->config = include $dir.'/_config.php';

            return $this->backupRun($callback);
        } else {
            //创建目录
            if ( ! Dir::create($dir) || ! is_readable($dir)) {
                $this->error = '目录创建失败';

                return false;
            }
            Cookie::set('houdunwang_backup_dir', $dir);
            $tables = Schema::getAllTableInfo();
            foreach ($tables['table'] as $d) {
                //limit起始数
                $tables['table'][$d['tablename']]['first'] = 0;
                //文件编号
                $tables['table'][$d['tablename']]['fileId'] = 1;
                //表备份完成
                $tables['table'][$d['tablename']]['complete'] = false;
            }
            $cache['table']  = $tables['table'];
            $cache['config'] = $config;
            $this->config    = $cache;
            //写入配置
            $this->saveConfig('_config.php');
            //备份表结构
            $tables = Schema::getAllTableInfo();
            $sql    = "<?php ".PHP_EOL;
            foreach ($tables['table'] as $table => $data) {
                $createSql = Db::query("SHOW CREATE TABLE $table");
                $sql       .= "\houdunwang\db\Db::execute(\"DROP TABLE IF EXISTS {$table}\");\n";
                $sql       .= "\houdunwang\db\Db::execute(\"{$createSql[0]['Create Table']}\");\n";
            }
            //表结构修改语句
            file_put_contents($config['dir'].'/_structure.php', $sql);

            return $this->backupRun($callback);
        }
    }

    //执行备份
    protected function backupRun(\Closure $callback)
    {
        $cache = $this->config;
        foreach ($cache['table'] as $table => $config) {
            if ($config['complete'] === true) {
                //此表已经备份完成
                continue;
            }
            $sql = '';
            do {
                $data                            = Db::table($table, true)
                                                     ->limit(
                                                         $cache['table'][$table]['first'],
                                                         20
                                                     )->get();
                $cache['table'][$table]['first'] += 20;
                //表中无数据
                if (empty($data)) {
                    if ( ! empty($sql)) {
                        $file = $cache['config']['dir'].'/'.$table.'_'
                                .$config['fileId'].'.php';
                        file_put_contents($file, "<?php \n".$sql);
                    }
                    $cache['table'][$table]['complete'] = true;
                    $this->config                       = $cache;
                    //保存配置
                    $this->saveConfig('_config.php');

                    return $callback(
                        [
                            'message' => "数据表 [$table] 备份完成",
                            'status'  => 'run',
                        ]
                    );

                } else {
                    foreach ($data as $d) {
                        $sql .= "\houdunwang\db\Db::table('{$table}',true)->replace("
                                .var_export($d, true).");\n";
                    }
                }
                //检测本次备份是否超出分卷大小
                if (strlen($sql) > $cache['config']['size'] * 1024) {
                    //写入备份
                    $file = $cache['config']['dir'].'/'.$table.'_'
                            .$config['fileId'].'.php';
                    file_put_contents($file, "<?php \n".$sql);
                    $cache['table'][$table]['fileId'] += 1;
                    $this->config                     = $cache;
                    //保存配置
                    $this->saveConfig('_config.php');

                    return $callback(
                        [
                            'message' => "数据表[$table] 第 {$cache['table'][$table]['fileId']} 卷备份完成",
                            'status'  => 'run',
                        ]
                    );
                }
            } while (true);
        }
        touch($cache['config']['dir'].'/_lock.php');
        Cookie::del('houdunwang_backup_dir');

        return $callback(['message' => "完成所有数据备份", 'status' => 'success']);
    }

    /**
     *
     *
     * @return int
     */
    /**
     * 保存配置配置
     * 备份/还原使用
     *
     * @param string $file 文件名
     *
     * @return int
     */
    protected function saveConfig($file)
    {
        return file_put_contents(
            $this->config['config']['dir'].'/'.$file,
            '<?php return '.var_export($this->config, true).';'
        );
    }

    //返回错误
    public function getError()
    {
        return $this->error;
    }
}