<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace web\system\controller;

/**
 * 前端组件处理
 * Class component
 * @package system\controller
 * @author 向军
 */
class Component {
	//上传图片webuploader
	public function uploader() {
		$file = Upload::path( \Config::get( 'upload.path' ) . '/' . date( 'Y/m/d' ) )->make();
		if ( $file ) {
			$data = [
				'name'       => $file[0]['name'],
				'filename'   => $file[0]['filename'],
				'path'       => $file[0]['path'],
				'extension'  => strtolower( $file[0]['ext'] ),
				'createtime' => time(),
				'size'       => $file[0]['size'],
				'data'       => q( 'post.data', '' ),
				'hash'       => q( 'post.hash', '' )
			];
			Db::table( 'core_attachment' )->insert( $data );
			ajax( [ 'valid' => 1, 'message' => $file[0]['path'] ] );
		} else {
			ajax( [ 'valid' => 0, 'message' => \Upload::getError() ] );
		}
	}

	//获取文件列表webuploader
	public function filesLists() {
		$count = Db::table( 'core_attachment' )
		           ->where( 'hash', q( 'post.hash', '' ) )
		           ->whereIn( 'extension', explode( ',', strtolower( $_POST['extensions'] ) ) )
		           ->count();
		$page  = Page::row( 32 )->pageNum( 8 )->make( $count );
		$data  = Db::table( 'core_attachment' )
		           ->whereIn( 'extension', explode( ',', strtolower( $_POST['extensions'] ) ) )
		           ->where( 'hash', q( 'post.hash', '' ) )
		           ->limit( Page::limit() )
		           ->orderBy( 'id', 'DESC' )
		           ->get();
		foreach ( $data as $k => $v ) {
			$data[ $k ]['createtime'] = date( 'Y/m/d', $v['createtime'] );
			$data[ $k ]['size']       = get_size( $v['size'] );
		}
		ajax( [ 'data' => $data, 'page' => $page ] );
	}

	//删除图片delWebuploader
	public function removeImage() {
		$db   = Db::table( 'core_attachment' );
		$file = $db->where( 'id', $_POST['id'] )->first();
		if ( is_file( $file['path'] ) ) {
			unlink( $file['path'] );
		}
		$db->where( 'id', $_POST['id'] )->delete();
	}

	//百度编辑器
	public function ueditor() {
		$CONFIG = json_decode( preg_replace( "/\/\*[\s\S]+?\*\//", "", file_get_contents( "config.json" ) ), TRUE );
		$action = $_GET['action'];
		switch ( $action ) {
			case 'config':
				$result = json_encode( $CONFIG );
				break;
			/* 上传图片 */
			case 'uploadimage':
				/* 上传涂鸦 */
			case 'uploadscrawl':
				/* 上传视频 */
			case 'uploadvideo':
				/* 上传文件 */
			case 'uploadfile':
				$result = include( "action_upload.php" );
				break;
			/* 列出图片 */
			case 'listimage':
				$result = include( "action_list.php" );
				break;
			/* 列出文件 */
			case 'listfile':
				$result = include( "action_list.php" );
				break;

			/* 抓取远程文件 */
			case 'catchimage':
				$result = include( "action_crawler.php" );
				break;

			default:
				$result = json_encode( [
					'state' => '请求地址出错'
				] );
				break;
		}
		/* 输出结果 */
		if ( isset( $_GET["callback"] ) ) {
			if ( preg_match( "/^[\w_]+$/", $_GET["callback"] ) ) {
				echo htmlspecialchars( $_GET["callback"] ) . '(' . $result . ')';
			} else {
				echo json_encode( [
					'state' => 'callback参数不合法'
				] );
			}
		} else {
			echo $result;
		}
	}
}