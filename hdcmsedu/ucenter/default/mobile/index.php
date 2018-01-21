<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <link rel="stylesheet" href="{!! UCENTER_TEMPLATE_URL !!}/css/home.css">
    <div class="ucenter" >
        <div>
            <div class="header" style="background-image: url(resource/images/bg.jpg)">
                <div class="col-xs-3 ico">
                    <a href="{!! url('my.info') !!}"><img src="{!! pic(v('member.info.icon')) !!}"></a>
                </div>
                <div class="col-xs-7 user"><h2 class="col-xs-12">
                    <a href="{!! url('my.info') !!}">{!! v('member.info.nickname')?:'设置昵称' !!}</a>
                </h2>
                    <div class="col-xs-6">{!! v('member.group.title') !!} (uid:{!! v('member.info.uid') !!})</div>
                    <div class="col-xs-6">
                        <a href="{!! url('credit/lists') !!}&type=credit1">{!! v('member.info.credit1') !!}积分</a>
                    </div>
                </div>
                <div class="col-xs-2">
                    <a href="{!! url('my.info') !!}" class="pull-right setting">
                        <i class="fa fa-cog"></i>
                    </a>
                </div>
            </div>
            <div class="well pay clearfix">
                <div class="col-xs-3">
                    <a href="{!! url('ticket/lists') !!}&type=1&status=1">
                        <i class="fa fa-credit-card"></i> <span>折扣券</span>
                    </a>
                </div>
                <div class="col-xs-3">
                    <a href="{!! url('ticket/lists') !!}&type=2&status=1">
                        <i class="fa fa-diamond"></i> <span>代金券</span>
                    </a>
                </div>
                <div class="col-xs-3"><a href="{!! url('credit/lists') !!}&type=credit1">
                    <i class="fa fa-flag-o"></i> <span>积分</span>
                </a>
                </div>
                <div class="col-xs-3"><a href="{!! url('credit/lists') !!}&type=credit2">
                    <i class="fa fa-money"></i> <span>余额</span>
                </a>
                </div>
            </div>
        </div>

        <div class="list-group">
            <a href="{!! url('account/balance') !!}" class="list-group-item">
                <i class="fa fa-suitcase"></i> 余额充值 <i class="fa fa-angle-right pull-right"></i>
            </a>
        </div>
        <!--菜单列表-->
        <?php $MemberMenu = \system\model\Menu::moduleMenus('profile',v('member.info.group_id'));?>
        <foreach from="$MemberMenu" value="$v">
            <div class="list-group">
                <a href="#" class="list-group-item disabled">
                    {{$v['module']['title']}}
                </a>
                <foreach from="$v['menus']" value="$field">
                    <a href="{!! $field['url'] !!}" class="list-group-item">
                        <if value="$field['icontype'] == 1">
                            <i class="{!! $field['css']['icon'] !!}"></i>
                            {!! $field['name'] !!} <i class="fa fa-angle-right pull-right"></i>
                            <else/>
                            <img src="{!! __ROOT__ !!}/{!! $field['css']['image'] !!}" style="max-width: 50px;max-height: 35px;"> {!! $field['name'] !!}
                            <i class="fa fa-angle-right pull-right"></i>
                        </if>
                    </a>
                </foreach>
            </div>
        </foreach>
        <!--自定义内容-->
        {!! $uc['html'] !!}
        <!--菜单列表 end-->
        <div class="list-group">
            <a href="{!! url('my/mobile') !!}" class="list-group-item">
                <i class="fa fa-mobile"></i>
                修改手机号 <i class="fa fa-angle-right pull-right"></i>
            </a>
            <a href="{!! url('address/lists') !!}" class="list-group-item">
                <i class="fa fa-film"></i>
                地址管理 <i class="fa fa-angle-right pull-right"></i>
            </a>
            <a href="{!! __ROOT__ !!}" class="list-group-item">
                <i class="fa fa-home"></i>
                网站首页 <i class="fa fa-angle-right pull-right"></i>
            </a>
            <a href="{!! url('entry/out') !!}" class="list-group-item">
                <i class="fa fa-external-link"></i>
                退出系统 <i class="fa fa-angle-right pull-right"></i>
            </a>
        </div>
    </div>
    <parent name="copyright"/>
</block>