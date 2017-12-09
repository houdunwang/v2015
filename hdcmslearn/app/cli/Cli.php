<?php namespace app\cli;

use houdunwang\cli\build\Base;
use Curl;
use Dir;

/**
 * 命令处理
 * Class Cms
 *
 * @package app
 */
class Cli extends Base
{
    use Make;
    //编译工作目录
    protected $savePath = '/Users/xj/Desktop/hdcms';

    //软件目录
    protected $hdcmsDir;
    //不进行打包的文件或目录
    protected $filters
        = [
            'cert',
            'theme/hdcms',
            'theme/hdphp',
            'theme/houdunwang',
            'node_modules',
            'tests',
            '.git',
            'addons',
            'data',
            'install',
            'storage',
            'attachment',
            'node_modules',
            '.babelrc',
            '.gitignore',
        ];

    public function __construct()
    {
        $this->hdcmsDir = realpath('.');
    }

    //不生成到更新压缩包的文件
    protected $filterUpgradeFiles = ['data/database.php',];

    /**
     * 同时生成完整与更新压缩包
     */
    public function make()
    {
        $this->full();
        $this->upgrade();
    }

    /**
     * 生成版本编号
     */
    public function version($type)
    {
        //最新的标签
        exec("git tag -l", $tags);
        $newTag          = array_pop($tags);
        $data['version'] = $newTag;
        $data['build']   = date("YmdHis");
        //更新日志
        exec("git log -1", $logs);
        $logs = array_splice($logs, 4);
        array_walk($logs, function (&$v) {
            $v = trim($v);
        });
        $data['logs']    = implode('####', $logs);
        $data['type']    = $type;
        $data['explain'] = '';
        file_put_contents('version.php', "<?php return ".var_export($data, true).';');
    }

    /**
     * 生成完整包
     */
    public function full()
    {
        $this->version('full');
        //复制目录
        Dir::copy('.', $this->savePath);
        foreach ($this->filters as $d) {
            $file = $this->savePath.'/'.$d;
            is_dir($d) ? Dir::del($file) : Dir::delFile($file);
        }
        //创建压缩包
        exec("git tag -l", $tags);
        $newVersion = array_pop($tags);
        Zip::create(dirname($this->savePath).'/hdcms.full.zip', [$this->savePath]);
        exec('rm -rf '.$this->savePath);
    }

    /**
     * 生成HDCMS更新压缩包
     *
     * @param string $oldVersion 上版本号
     */
    public function upgrade($oldVersion = '')
    {
        $this->version('upgrade');
        exec("git tag -l", $tags);
        $newVersion = array_pop($tags);
        $oldVersion = $oldVersion ?: array_pop($tags);
        exec("git diff $oldVersion $newVersion --name-status ", $files);
        $files = $this->format($files);
        if ( ! empty($files)) {
            //复制文件
            foreach ($files as $f) {
                Dir::copyFile($f['file'], $this->savePath.'/'.$f['file']);
            }
            Dir::copyFile('version.php', $this->savePath.'/version.php');
            foreach ($this->filters as $d) {
                $file = $this->savePath.'/'.$d;
                is_dir($d) ? Dir::del($file) : Dir::delFile($file);
            }
            file_put_contents($this->savePath.'/upgrade_files.php', "<?php return ".var_export($files, true).';?>');
            Zip::create(dirname($this->savePath).'/hdcms.upgrade.'.$newVersion.'.zip', [$this->savePath]);
            exec('rm -rf '.$this->savePath);
        }
    }

    /**
     * 格式化文件数据
     * 移除不存在的文件
     *
     * @param $files 版本差异中受影响的文件
     *
     * @return array
     */
    protected function format($files)
    {
        //组合后的文件
        $format = [];
        foreach ($files as $k => $f) {
            preg_match('/\w+\s+([^\s]+)/', $f, $file);
            if ( ! in_array($file[1], $this->filterUpgradeFiles)) {
                if (is_file($file[1])) {
                    if (in_array($file[0], ['A', 'M'])) {
                        $format[] = ['file' => $file[1], 'state' => $file[0]];
                    } else {
                        $format[] = ['file' => $file[1], 'state' => 'M'];
                    }
                } else {
                    $format[] = ['file' => $file[1], 'state' => 'D'];
                }
            }
        }

        return $format;
    }
}