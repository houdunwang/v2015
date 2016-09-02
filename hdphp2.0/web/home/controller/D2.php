<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace web\home\controller;

class D2{
    //动作
	public function index(){
		//此处书写代码...
//		$id=intval($_GET['id']);
//		$id = q('get.id','','intval');
//		$sql = "select * from user where id=:id";
		//1 or id>0
//		$data=[':username'=>'向军',':mail'=>'230071698@qq.com'];
//		Db::execute("INSERT INTO hd_user set username=:username ,mail=:mail",$data);
//		$data=[':username'=>'后盾网论坛',':mail'=>'houdunwang@126.com'];
//		Db::execute("UPDATE hd_user set username=:username ,mail=:mail WHERE id=1",$data);

//		$res = Db::query("SELECT * FROM hd_user WHERE id>=:id",["id"=>1]);
//		p($res);
//		$res = Db::query("SELECT * FROM hd_user WHERE id>=? and username=?",[1,'向军']);
//		p($res);

//		$d = Db::table('user')->get();
//		p($d);
//		$d = Db::table('user')->insertGetId(['username'=>'后盾网论坛','abc'=>'aaa','mail'=>'2378283@sds.com','total'=>100]);
//		var_dump($d);
//		$d = Db::table('user')->replace(['id'=>9,'username'=>'腾讯','mail'=>'2378283@sds.com','total'=>300]);
//		var_dump($d);
//		$d = Db::table('user')->where('id',9)->update(['username'=>'雅虎','mail'=>'2378283@sds.com','total'=>300]);
//		var_dump($d);
//		$d=  Db::table('user')->delete([3,4,6]);
//		var_dump($d);

//		Db::table("user")->where('id',1)->decrement('total',30);
//		$db = Db::table('user');
//		$db->insert(['username'=>'小白兔']);
//		echo $db->getInsertId();
//		echo Db::table('user')->insertGetId(['username'=>'小白兔']);
//		$db = Db::table('user');
//		$db->where('id','>',3)->update(['username'=>'小苹果']);
//		echo $db->getAffectedRow();
	}
}
