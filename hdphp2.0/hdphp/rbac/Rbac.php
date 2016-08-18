<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\rbac;

/** RBAC表
 * CREATE TABLE IF NOT EXISTS `access` (
 * `role_id` smallint(6) unsigned NOT NULL,
 * `node_id` smallint(6) unsigned NOT NULL,
 * KEY `role_id` (`role_id`),
 * KEY `nodeId` (`node_id`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 *
 * CREATE TABLE IF NOT EXISTS `node` (
 * `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
 * `name` varchar(20) NOT NULL,
 * `title` varchar(50) DEFAULT NULL,
 * `status` tinyint(1) DEFAULT 1,
 * `remark` varchar(255) DEFAULT NULL,
 * `sort` smallint(6) unsigned DEFAULT 100,
 * `pid` smallint(6) unsigned NOT NULL,
 * `level` tinyint(1) unsigned NOT NULL,
 * `show` tinyint(1) unsigned NOT NULL default 1,
 * PRIMARY KEY (`id`),
 * KEY `level` (`level`),
 * KEY `pid` (`pid`),
 * KEY `status` (`status`),
 * KEY `name` (`name`)
 * ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
 *
 * CREATE TABLE IF NOT EXISTS `user` (
 * `id` mediumint(9) unsigned DEFAULT NULL,
 * `username` char(20) DEFAULT NULL,
 * `password` char(32) DEFAULT NULL,
 * KEY `username` (`username`),
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 *
 * CREATE TABLE IF NOT EXISTS `role` (
 * `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
 * `name` varchar(20) NOT NULL,
 * `pid` smallint(6) DEFAULT NULL,
 * `status` tinyint(1) unsigned DEFAULT NULL,
 * `remark` varchar(255) DEFAULT NULL,
 * PRIMARY KEY (`id`),
 * KEY `pid` (`pid`),
 * KEY `status` (`status`)
 * ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
 *
 * CREATE TABLE IF NOT EXISTS `user_role` (
 * `role_id` mediumint(9) unsigned DEFAULT NULL,
 * `user_id` char(32) DEFAULT NULL,
 * KEY `group_id` (`role_id`),
 * KEY `user_id` (`user_id`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 */

class Rbac {

    protected $user_table;
    protected $role_table;
    protected $node_table;
    protected $user_role_table;
    protected $access_table;
    protected $auth_key;

    public function __construct() {
        $this->user_table      = C( 'database.prefix' ) . C( 'rbac.user_table' );
        $this->role_table      = C( 'database.prefix' ) . C( 'rbac.role_table' );
        $this->node_table      = C( 'database.prefix' ) . C( 'rbac.node_table' );
        $this->user_role_table = C( 'database.prefix' ) . C( 'rbac.user_role_table' );
        $this->access_table    = C( 'database.prefix' ) . C( 'rbac.access_table' );
        $this->auth_key        = C( 'rbac.auth_key' );
    }

    /**
     * 获取用户所有角色名称
     *
     * @param $id 会员id
     *
     * @return array
     */
    public function getRoleName( $id ) {
        $sql = "SELECT * FROM " . $this->user_role_table . " u " . " JOIN " . $this->role_table . " r ON ur.role_id = r.id " . " WHERE ur.user_id=" . $id;

        if ( $data = Db::select( $sql ) ) {
            foreach ( $data as $d ) {
                $r[] = $d['name'];
            }

            return $r;
        }
    }

    /**
     * 获取所有节点
     *
     * @return array
     */
    public function getLevelNode() {
        $sql = "SELECT * FROM " . $this->node_table . " n ORDER BY n.sort ASC ";

        $data = Db::select( $sql );
        if ( ! $data ) {
            return [ ];
        }

        return $this->formatNode( $data );
    }

    /**
     * 验证提供的"模块.控制器.动作"
     *
     * @param  string $action 模块.控制器.动作
     *
     * @return bool
     */
    public function authAction( $action ) {
        $info = explode( '.', $action );
        //        p($_SESSION);
        //权限检查
        foreach ( $_SESSION['__RBAC__'] as $app => $a ) {
            if ( $app == strtolower( $info[0] ) ) {
                if ( isset( $a['_NODE_'][ strtolower( $info[1] ) ] ) ) {
                    if ( isset( $a['_NODE_'][ strtolower( $info[1] ) ]['_NODE_'][ strtolower( $info[2] ) ] ) ) {
                        if ( isset( $a['_NODE_'][ strtolower( $info[1] ) ]['_NODE_'][ strtolower( $info[2] ) ]['_NODE_'][ strtolower( $info[3] ) ] ) ) {
                            return TRUE;
                        }
                    }
                }
            }
        }

        return FALSE;
    }

    /**
     * 获取用户的所有权限节点
     */
    public function getUserNode( $id ) {
        $sql = "SELECT n.id,n.name,n.pid,n.level,n.title,n.show FROM " . $this->user_role_table . " ur" . " JOIN " . $this->role_table . " r ON ur.role_id = r.id " . " JOIN " . $this->access_table . " a ON a.role_id=r.id " . " JOIN " . $this->node_table . " n ON n.id = a.node_id" . " WHERE ur.user_id=" . $id . " AND n.status=1 AND r.status=1" . " GROUP BY a.node_id" . " ORDER BY n.sort ASC";

        $data = Db::select( $sql );
        if ( ! $data ) {
            return [ ];
        }

        return $this->formatNode( $data );
    }

    /**
     * 登录检测
     */
    public function isLogin() {
        return isset( $_SESSION[ $this->auth_key ] );
    }

    /**
     * 验证权限
     *
     * @return [type] [description]
     */
    public function verify() {
        //检查不需要验证的动作
        foreach ( C( 'rbac.no_auth' ) as $noAuth ) {
            if ( strtolower( $noAuth ) == strtolower( APP . '.' . MODULE . '.' . CONTROLLER . '.' . ACTION ) ) {
                return TRUE;
            }
        }

        if ( ! $this->isLogin() ) {
            return FALSE;
        }

        //检测超级管理员
        if ( $this->isSuperUser() ) {
            return TRUE;
        }

        //没有权限节点或时时验证时
        //都要从数据库中取权限节点信息
        if ( ! isset( $_SESSION['__RBAC__'] ) || C( 'rbac.type' ) == 1 ) {
            $node                 = $this->getUserNode( $_SESSION[ $this->auth_key ] );
            $_SESSION['__RBAC__'] = $node;
        }

        //权限检查
        foreach ( $_SESSION['__RBAC__'] as $app => $a ) {
            if ( strtolower( APP ) == strtolower( $app ) ) {
                foreach ( $_SESSION['__RBAC__'][ strtolower( APP ) ]['_NODE_'] as $module => $a ) {
                    if ( strtolower( $module ) == strtolower( MODULE ) ) {
                        foreach ( $a['_NODE_'] as $controller => $m ) {
                            if ( strtolower( $controller ) == strtolower( CONTROLLER ) ) {
                                if ( isset( $a['_NODE_'][ strtolower( CONTROLLER ) ]['_NODE_'][ strtolower( ACTION ) ] ) ) {
                                    return TRUE;
                                }
                            }
                        }
                    }
                }
            }
        }

        return FALSE;
    }

    /**
     * 超级管理员检测
     *
     * @return boolean [description]
     */
    public function isSuperUser() {
        if ( ! $this->isLogin() ) {
            return FALSE;
        }
        if ( isset( $_SESSION['__SUPER_USER__'] ) ) {
            return TRUE;
        }
        $username = Db::table( C( 'rbac.user_table' ) )->where( $this->auth_key, $_SESSION[ $this->auth_key ] )->pluck( 'username' );
        if ( $username == C( 'rbac.super_user' ) ) {
            $_SESSION['__SUPER_USER__'] = TRUE;

            return TRUE;
        }
    }

    /**
     * 格式化节点为层级结构
     *
     * @param  [type] $data [description]
     *
     * @return [type]       [description]
     */
    private function formatNode( $data ) {
        $node = [ ];
        foreach ( $data as $d ) {
            if ( $d['level'] == 1 ) {
                $node[ strtolower( $d['name'] ) ] = $d;
                foreach ( $data as $m ) {
                    if ( $m['pid'] == $d['id'] ) {
                        $node[ strtolower( $d['name'] ) ]['_NODE_'][ strtolower( $m['name'] ) ] = $m;
                        foreach ( $data as $n ) {
                            if ( $n['pid'] == $m['id'] ) {
                                $node[ strtolower( $d['name'] ) ]['_NODE_'][ strtolower( $m['name'] ) ]['_NODE_'][ strtolower( $n['name'] ) ] = $n;
                                foreach ( $data as $a ) {
                                    if ( $a['pid'] == $n['id'] ) {
                                        $node[ strtolower( $d['name'] ) ]['_NODE_'][ strtolower( $m['name'] ) ]['_NODE_'][ strtolower( $n['name'] ) ]['_NODE_'][ strtolower( $a['name'] ) ] = strtolower( $a['name'] );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $node;
    }
}





