<?php namespace app\system\controller\part;

/**
 * 创建模块配置片段
 * Class Config
 *
 * @package app\system\controller\part
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Config
{
    public static function make($data)
    {
        if ($data['setting']) {
            self::php($data);
            self::html($data);
        }
    }

    protected static function php($data)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\system;

/**
 * 模块配置管理
 * 用于管理当前模块的配置项
 * 每个模块配置是独立管理的互不影响
 * @author {$data['author']}
 * @url http://www.hdcms.com
 */
use module\HdConfig;
use View;
use Request;
class Config extends HdConfig {
	public function settingsDisplay() {
		if ( IS_POST ) {
			//将新配置数据保存
			\$this->saveConfig( Request::post() );
			return message( '配置项保存成功', 'refresh', 'success' );
		}
		//分配
		View::with('field', \$this->config);

		return view( \$this->template . '/config' );
	}
}
php;
        $file = "addons/{$data['name']}/system/Config.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }

    protected static function html($data)
    {
        $tpl
              = <<<html
<extend file="resource/view/site"/>
<block name="content">
	<div class="panel panel-default">
    	  <div class="panel-heading">
    			<h4 class="panel-title">模块配置</h4>
    	  </div>
    	  <div class="panel-body">
              <form action="" method="post" class="form-horizontal" role="form">
                  <div class="form-group">
                      <label class="col-sm-2 control-label">标题</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" name="title" value="{{\$field['title']}}">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-sm-10 col-sm-offset-2">
                          <button type="submit" class="btn btn-primary">保存配置项</button>
                      </div>
                  </div>
              </form>
    	  </div>
    </div>
</block>
html;
        $file = "addons/{$data['name']}/system/template/config.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}