<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace app\home\controller;
class Database {
	//动作
	public function connect() {
		$d = \Db::table( 'news' )->get();
		p( $d );
	}

	public function core() {
		//		$d= Db::table('news')->insert(['title'=>'后盾人','qq'=>'2300071698']);
		//		p(Db::getQueryLog());
		//		dd($d);

		//		$d = Db::execute("update hd_news set click=? where id=?",[115,2]);
		//		dd($d);

		//		$d= Db::table('news')->get();
		//		p($d);

		//		Db::table('news')->replace(['title'=>'后盾云','click'=>88]);

		//		Db::table('news')->where("id",1)->update(['title'=>'后盾网论坛']);

		//		$d = Db::table('news')->delete([1,2]);
		//		dd($d);
		//		Db::table("news")->where('id',1)->decrement('click',99);
		//		$d = Db::table('news')->insertGetId(['title'=>'向军']);
		//		dd($d);
		$db = Db::table( 'news' );
		$db->delete( [ 1, 13 ] );
		dd( $db->getAffectedRow() );
	}

	//查询构造器
	public function query() {
		//		$d = Db::table('news')->get(['title']);
		//		p($d);
		//		$d=  Db::table('news')->where('id',1)->first();
		//		$d=  Db::table('news')->find(2);
		//		$d = Db::table('news')->where('id',2)->pluck('title');
		//		$d = Db::table( 'news' )->where( 'id', '>=', 1 )->lists( 'id,title,click' );
		//		$d = Db::table('news')->field('title as t')->get();
		//		p( $d );
		//		$d = Db::table('news')->getByTitle('后盾人');
		//		p($d);
		//		$db = Db::table('news')->field('click');
		//		$d=$db->where('id','>',1)->get();
		//		p($d);
		//		$d=Db::table('news')->where('id','>',1)->logic('and')->where('click','<',300)->get();
		//		p(Db::getQueryLog());
		//		p($d);
		//		$sql="select * from hd_news where click>1";
		//		$d = Db::query($sql);
		//		$d = Db::table('news')->whereRaw('click > ?', [1])->get();
		//		$d = Db::table('news')->WhereNotIn('click',[1,30])->get();
		//		$d = Db::table( 'news' )->WhereNotNull( 'author' )->where( 'id', '>=', 1 )->get();
		//ASC   DESC
		//		$d = Db::table( 'news' )->orderBy( 'click', 'ASC' )->get();
		//		$d  =Db::table('news')->limit(1,2)->orderBy('click','ASC')->get();


		//		$d = Db::table( 'news' )->groupBy('uid')->lists('uid');
		//		$d = Db::table( 'news' )->groupBy( 'uid' )->having( "count(*)", '>=', 2 )->pluck('uid');
		//		$d = Db::table( 'news' )->rightJoin( 'user', 'user.id', '=', 'news.uid' )->get();


		//		$d = Db::table( 'news' )->field('user.id uid,news.id nid,title,click')->join( 'user', 'user.id', '=', 'news.uid' )->where('username','向军')->get();
		$d = Db::table( 'news' )
		       ->join( 'user', 'user.id', '=', 'news.uid' )
		       ->groupBy( 'news.uid' )
		       ->having( 'count(*)', '>=', 2 )
		       ->pluck( 'username' );
		p( Db::getQueryLog() );
		p( $d );
	}

	public function schema() {
		//		$d = Schema::getFields('user');
		//		$d = Schema::getPrimaryKey( 'news' );
		//		dd(Schema::drop('demo'));
		//		dd(Schema::getTableSize('news'));
		//		Schema::lock('user');
		//		sleep(30);
		//		$d = Db::table('demo')->where('id','>',0)->delete();
		//		$d =Db::table('demo')->insert(['title'=>'新浪']);
		//		$d =Schema::truncate('demo');;
		//		dd($d);

		//		p(Schema::getAllTableInfo('hdphp3'));
		//		dd(Schema::fieldExists('atitle','news'));
		$sql
			= <<<EOF
    CREATE TABLE `hd_core_attachment` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uid` int(11) NOT NULL COMMENT '会员id',
    `filename` varchar(300) NOT NULL COMMENT '文件名',
    `path` varchar(300) NOT NULL COMMENT '相对路径',
    `type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
    `createtime` int(10) NOT NULL COMMENT '上传时间',
    `size` mediumint(9) NOT NULL COMMENT '文件大小',
    `user_type` tinyint(1) DEFAULT NULL COMMENT '1 管理员 0 会员',
    PRIMARY KEY (`id`),
    KEY `uid` (`uid`)
    ) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='附件';

    CREATE TABLE `hd_rule` (
    `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
    `name` varchar(45) DEFAULT NULL COMMENT '规则名称',
    `module` varchar(45) DEFAULT NULL COMMENT '模块名称',
    `rank` tinyint(3) unsigned DEFAULT NULL COMMENT '排序',
    `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否禁用',
    PRIMARY KEY (`rid`),
    KEY `fk_hd_rule_hd_site1_idx` (`siteid`)
    ) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='回复规则';
EOF;

		Schema::sql( $sql );
	}

	//事务处理
	public function transaction() {
//		Db::transaction( function () {
//			if ( ! Db::execute( 'DELETE FROM hd_news WHERE id=?', [ 1 ] ) ) {
//				throw new \Exception();
//			}
////			throw new \Exception();
//		});
		$sql = "select * from ".tablename('news');
		$d = Db::query($sql);
		p($d);
//		Db::beginTransaction();
//		Db::execute('DELETE FROM hd_news WHERE id=?', [ 1 ]);
//		DB::commit();
	}
}





























