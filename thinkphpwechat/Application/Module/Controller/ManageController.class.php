<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace Module\Controller;


use Common\Controller\AdminController;
use Common\Model\ModuleModel;

class ManageController extends AdminController {
	//模块列表
	public function lists() {
		$modules = [ ];
		foreach ( glob( 'Addons/*' ) as $f ) {
			//合法模块检测
			if ( is_file( $f . '/manifest.php' ) ) {
				$modules[] = include $f . '/manifest.php';
			}
		}
		//查找所有已经安装的模块
		$has = ( new ModuleModel() )->getField( 'id,name' );
		$this->assign( 'has', $has );
		$this->assign( 'modules', $modules );
		$this->display();
	}

	//卸载模块
	public function uninstall() {
		$name = $_GET['name'];
		$db   = new ModuleModel();
		if ( $db->where( "name='$name'" )->delete() ) {
			$this->success( '卸载成功', u('lists') );
		} else {
			$this->error( '卸载失败', u('lists') );
		}

	}

	//安装模块
	public function install() {
		$name = $_GET['name'];
		$db   = new ModuleModel();
		if ( $db->where( "name='$name'" )->select() ) {
			$this->error( '模块已经安装,不允许重复安装' );
			exit;
		}
		$this->assign( 'has', $has );
		//开始安装模块
		$manifest = include 'Addons/' . $name . '/manifest.php';
		//  字符串  数值    xml  json
		$manifest['actions'] = json_encode( $manifest['actions'], JSON_UNESCAPED_UNICODE );
		$this->store( $db, $manifest );
	}

	//设计模块
	public function design() {
		if ( IS_POST ) {
			//创建出模块的目录和基本文件
			//模块是否存在的检测
			$name = ucfirst( $_POST['name'] );
			if ( is_dir( 'Addons/' . $name ) ) {
				$this->error( '模块已经存在,不允许重复创建' );
			} else {
				//创建模块的目录
				mkdir( 'Addons/' . $name . '/View', 0755, true );
				foreach ( glob( 'Data/Module/*.php' ) as $f ) {
					$content  = str_replace( '{NAME}', $_POST['name'], file_get_contents( $f ) );
					$fileName = 'Addons/' . $name . '/' . basename( $f );
					file_put_contents( $fileName, $content );
				}
				//创建配置文件
				$this->createManiFest();
				$this->success( '模块创建成功', 'lists' );
				exit;
			}
		}
		$this->display();
	}

	//格式化设置模块的数据
	protected function createManiFest() {
		$actions    = array_filter( preg_split( '@(\r|\n)@', $_POST['actions'] ) );
		$actionData = [ ];
		foreach ( $actions as $a ) {
			$info         = explode( '|', $a );
			$actionData[] = [ 'title' => $info[0], 'name' => $info[1] ];
		}
		$_POST['actions'] = $actionData;
		$manifest         = '<?php return ' . var_export( $_POST, true ) . ';?>';
		file_put_contents( 'Addons/' . ucfirst( $_POST['name'] ) . '/manifest.php', $manifest );
	}
}