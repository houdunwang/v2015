<?php namespace module\ucenter\system;

use houdunwang\request\Request;

class Tag
{
    /**
     * 会员中心头部
     *
     * @param $attr
     *
     * @return string
     */
    public function header($attr)
    {
        if (Request::isMobile()) {
            $url = v('module.name') == 'ucenter' ? url('member.index', [], 'ucenter') : (__HISTORY__ ?: __ROOT__);
            $url = isset($attr['url']) ? $attr['url'] : $url;
            $php
                 = <<<str
<div class="container">
		<nav class="navbar navbar-default navbar-fixed-top uc-header">
			<div class="navbar-header">
				<a class="navbar-brand" href="{$url}" style="position: absolute;">
					<i class="fa fa-chevron-left"></i>
				</a>
				<p class="navbar-text navbar-right text-center">{$attr['title']}</p>
			</div>
		</nav>
	</div>
	<div style="height: 55px"></div>
str;

            return $php;
        }
    }

    //会员卡底部
    public function ticket_footer($attr)
    {
        if (Request::isMobile()) {
            return <<<str
<link rel="stylesheet" href="{{__ROOT__}}/module/ucenter/system/css/ticket_footer.css">
<div style="height:60px;"></div>
	<nav class="navbar navbar-default navbar-fixed-bottom card_footer">
		<a href="{!! url('ticket/convert') !!}&type={$_GET['type']}">
			<i class="fa fa-credit-card" aria-hidden="true"></i> 兑换
		</a>
		<a href="{!! url('member/index') !!}">
			<i class="fa fa-user"></i> 会员中心
		</a>
	</nav>
str;
        }

    }

    //拥有菜单的模块列表
    public function menu_module($attr, $content)
    {
        $php
             = <<<str
<?php
	if ( IS_MOBILE ) {
		//读取移动端菜单
		\$_db = Db::table( 'navigate' )->where( 'entry', 'profile' )->where( 'siteid', siteid() );
	} else {
		//读取桌面个人中心菜单
		\$_db = Db::table( 'navigate' )->where( 'entry', 'member' )->where( 'siteid', siteid() );
	}
	\$_modules_name = \$_db->where('status',1)->lists('module');
	
	\$_modules = \$_modules_name?Db::table('modules')->whereIn('name',\$_modules_name)->get():[];
	foreach(\$_modules as \$field){?>
str;
        $php .= $content;

        return $php.'<?php }?>';
    }

    //会员中心菜单列表必须配置memu_module标签使用
    public function menu($attr, $content)
    {
        $php
             = <<<str
<?php
	if ( IS_MOBILE ) {
		//读取移动端菜单
		\$_db = Db::table( 'navigate' )->where( 'entry', 'profile' );
	} else {
		//读取桌面个人中心菜单
		\$_db = Db::table( 'navigate' )->where( 'entry', 'member' );
	}
	\$_menus = \$_db->where( 'siteid', SITEID )->where('module',\$field['name'])->get();
	if ( \$_menus ) {
		foreach ( \$_menus as \$k => \$v ) {
			\$_menus[ \$k ]['css'] = json_decode( \$v['css'], true );
		}
	}
	foreach(\$_menus as \$field){?>
str;
        $php .= $content;

        return $php.'<?php }?>';
    }
}