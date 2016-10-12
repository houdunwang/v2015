<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\backup;

/**
 * 数据库备份类
 * Class Backup
 *
 * @package Hdphp\Backup
 * @author  向军 <2300071698@qq.com>
 */
class Backup {
	//错误信息
	protected $error;

	//获取目录，如果目录中不含有lock.php为不合法目录（比如备份中断）
	public function getBackupDir( $dir ) {
		$data = [ ];
		foreach ( Dir::tree( $dir ) as $d ) {
			if ( is_file( $d['path'] . '/lock.php' ) ) {
				$data[] = $d;
			}
		}

		return $data;
	}

	//删除失效的备份目录
	public function deleteFailureDir( $dir ) {
		foreach ( Dir::tree( $dir ) as $d ) {
			if ( ! is_file( $d['path'] . '/lock.php' ) ) {
				if ( ! \Dir::del( $d['path'] ) ) {
					$this->error = $d['path'] . "删除失败";

					return FALSE;
				}
			}
		}

		return TRUE;
	}


	//还原数据
	public function recoveryInit( $config ) {
		F( '_recovery_', '[del]' );
		if ( ! is_dir( $config['dir'] ) ) {
			$this->error = '目录不存在';

			return FALSE;
		}
		$file = [ ];
		foreach ( Dir::tree( $config['dir'] ) as $f ) {
			if ( $f['basename'] == 'structure.php' || $f['basename'] == 'lock.php' ) {
				//不运行执行的文件
				continue;
			} else {
				$file[] = $f['path'];
			}
		}
		$cache['config']    = $config;
		$cache['file']      = $file;
		$cache['totalfile'] = count( $file );
		F( '_recovery_', $cache );

		//还原表结构
		require $config['dir'] . '/structure.php';

		return TRUE;
	}

	//执行还原
	public function recovery() {
		$files = $cache = F( '_recovery_' );
		foreach ( $files['file'] as $id => $f ) {
			require $f;
			unset( $cache['file'][ $id ] );
			F( '_recovery_', $cache );
			//完成比例
			$bl = ( intval( ( $cache['totalfile'] - count( $cache['file'] ) ) / $cache['totalfile'] * 100 ) );
			message( $bl . '%还原完毕', __URL__, $cache['config']['time'], 'success' );
		}
		F( '_recovery_', '[del]' );
		message( '所有分卷还原完毕...', $cache['config']['url'], 1, 'success' );
	}

	//备份配置
	public function backupInit( $config ) {
		F( '_backup_', '[del]' );
		//创建目录
		if ( ! is_dir( $config['dir'] ) && ! mkdir( $config['dir'], 0755, TRUE ) ) {
			message( '目录创建失败', $config['url'], 'error' );
		}
		$table = Db::getAllTableInfo();
		$table = $table['table'];
		foreach ( $table as $d ) {
			//limit起始数
			$table[ $d['tablename'] ]['first'] = 0;
			//文件编号
			$table[ $d['tablename'] ]['fileId'] = 1;
		}
		$cache['table']  = $table;
		$cache['config'] = $config;

		//备份表结构
		$tables = Db::getAllTableInfo();
		$sql    = "<?php if(!defined('HDPHP_PATH'))EXIT;\n";
		foreach ( $tables['table'] as $table => $data ) {
			$createSql = Db::query( "SHOW CREATE TABLE $table" );
			$sql .= "Db::execute(\"DROP TABLE IF EXISTS {$table}\");\n";
			$sql .= "Db::execute(\"{$createSql[0]['Create Table']}\");\n";
		}

		if ( file_put_contents( $config['dir'] . '/structure.php', $sql ) ) {
			F( '_backup_', $cache );

			return TRUE;
		} else {
			F( '_backup_' . '[del]' );
			$this->error = '表结构备份失败';

			return FALSE;
		}
	}

	//执行备份
	public function backup() {
		$cache = F( '_backup_' );
		foreach ( $cache['table'] as $table => $config ) {
			$sql = "";
			do {
				$data = Db::table( $table, TRUE )->limit( $cache['table'][ $table ]['first'], 20 )->get();
				$cache['table'][ $table ]['first'] += 20;
				//表中无数据
				if ( empty( $data ) ) {
					if ( ! empty( $sql ) ) {
						$file = $cache['config']['dir'] . '/' . $table . '_' . $config['fileId'] . '.php';
						file_put_contents( $file, "<?php if(!defined('HDPHP_PATH'))EXIT;\n" . $sql );
					}
					unset( $cache['table'][ $table ] );
					F( '_backup_', $cache );

					message( "$table 备份完成", __URL__, $cache['config']['time'], 'success' );
				} else {
					foreach ( $data as $d ) {
						$sql .= "Db::table('{$table}',true)->replace(" . var_export( $d, TRUE ) . ");\n";
					}
				}
				//检测本次备份是否超出分卷大小
				if ( strlen( $sql ) > $cache['config']['size'] * 1024 ) {
					//写入备份
					$file = $cache['config']['dir'] . '/' . $table . '_' . $config['fileId'] . '.php';
					file_put_contents( $file, "<?php if(!defined('HDPHP_PATH'))EXIT;\n" . $sql );
					$cache['table'][ $table ]['fileId'] += 1;
					F( '_backup_', $cache );
					message( "$table 第{$cache['table'][$table]['fileId']}卷备份完成", __URL__, $cache['config']['time'], 'success' );
				}
			} while ( TRUE );
		}
		F( '_backup_', '[del]' );
		touch( $cache['config']['dir'] . '/lock.php' );
		message( '完成所有数据备份...', $cache['config']['url'], 'success' );
	}

	//返回错误
	public function getError() {
		return $this->error;
	}
}