<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>会员中心</title>
    <include file="resource/view/member"/>
    <link rel="stylesheet" type="text/css" href="{!! UCENTER_TEMPLATE_URL !!}/static/css/index.css"/>
</head>
<body>
<div class="NavBox">
    <div class="ciTop">
        <div class="ciTopCenter">
            <a href="{!! url('member.index',[],'ucenter') !!}" class="logo">
                <i class="fa fa-mixcloud"></i> <span>会员中心</span>
            </a>
            <div class="TopMenu">
                <a href="{{__ROOT__}}" target="_blank"> <i class="fa fa-home"></i> 网站首页</a>
                <a href="{{url('message.lists',['status'=>0],'ucenter')}}"> <i class="fa fa-rss-square"></i> 消息中心</a>
            </div>
        </div>
    </div>
    <!--次顶部菜单结束-->
    <!--主体部分开始-->
    <div class="CenterMain">
        <!--身体剧中部分-->
        <div class="CenterBody">
            <!--左侧部分开始-->
            <div class="BodyLeft">
                <!--头像部分开始-->
                <div class="BodyHeader">
                    <div class="HeaerTop">
                        <!--左侧头像开始-->
                        <div class="portrait">
                            <a href="{!! url('my.info',[],'ucenter') !!}"><img src="{{icon(v('member.info.icon'))}}"/></a>
                        </div>
                    </div>
                    <!--蓝色背景active-->
                    <div class="HeaerBottom">
                        <?php if (in_array(v('site.setting.login.type'), [1, 3])): ?>
                            <if value="v('member.info.mobile_valid')">
                                <a href="{!! url('my.mobile') !!}" class="active"><span class="glyphicon glyphicon-phone"></span></a>
                                <else/>
                                <a href="{!! url('my.mobile') !!}" class=""><span class="glyphicon glyphicon-phone"></span></a>
                            </if>
                        <?php endif; ?>
                        <?php if (in_array(v('site.setting.login.type'), [2, 3])): ?>
                            <if value="v('member.info.email_valid')">
                                <a href="{!! url('my.mail') !!}" class="active"><span class="glyphicon glyphicon-envelope"></span></a>
                                <else/>
                                <a href="{!! url('my.mail') !!}" class=""><span class="glyphicon glyphicon-envelope"></span></a>
                            </if>
                        <?php endif; ?>
                        <if value="v('member.info.icon')">
                            <a href="{!! url('my.info') !!}" class="active"><span class="glyphicon glyphicon-picture"></span></a>
                            <else/>
                            <a href="{!! url('my.info') !!}" class=""><span class="glyphicon glyphicon-picture"></span></a>
                        </if>
                    </div>
                </div>
                <!--头像部分结束-->
                <!--左侧菜单部分开始-->
                <div class="BodyLeftBottom">
                    <!--会员中心开始-->
                    <div class="MemberCenter ">
                        <!--<a href=""><span class="glyphicon glyphicon-user"></span>会员中心</a>-->
                    </div>
                    <!--会员中心结束-->
                    <!--账号管理开始-->
                    <?php $MemberMenu = \system\model\Menu::moduleMenus('member', v('member.info.group_id')); ?>
                    <foreach from="$MemberMenu" value="$v">
                        <div class="AccountManagementBox">
                            <div class="AccountManagement">
                                <a href="">{{$v['module']['title']}}</a>
                            </div>
                            <ul>
                                <foreach from="$v['menus']" value="$d">
                                    <li>
                                        <a href="{{$d['url']}}">
                                            {{$d['name']}}
                                        </a>
                                    </li>
                                </foreach>
                            </ul>
                        </div>
                    </foreach>
                    <div class="AccountManagementBox">
                        <div class="AccountManagement">
                            <a href="">资产中心</a>
                        </div>
                        <ul>
                            <li>
                                <a href="{!! url('pay.lists',[],'ucenter') !!}">商品订单</a>
                            </li>
                            <li>
                                <a href="{!! url('credit.lists',['type'=>'credit1'],'ucenter') !!}">积分余额</a>
                            </li>
                            <li>
                                <a href="{!! url('account.balance',[],'ucenter') !!}">余额充值</a>
                            </li>
                        </ul>
                    </div>
                    <div class="AccountManagementBox">
                        <div class="AccountManagement">
                            <a href="">我的资料</a>
                        </div>
                        <ul>
                            <li>
                                <a href="{!! url('my.info',[],'ucenter') !!}">基本资料</a>
                            </li>
                            <li>
                                <a href="{!! url('my.password',[],'ucenter') !!}">修改密码</a>
                            </li>
                            <?php if (in_array(v('site.setting.login.type'), [1, 3])): ?>
                                <li>
                                    <a href="{!! url('my.mobile',[],'ucenter') !!}">手机验证</a>
                                </li>
                            <?php endif; ?>
                            <?php if (in_array(v('site.setting.login.type'), [2, 3])): ?>
                                <li>
                                    <a href="{!! url('my.mail',[],'ucenter') !!}">邮箱验证</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="AccountManagementBox">
                        <div class="AccountManagement">
                            <a href="">其他设置</a>
                        </div>
                        <ul>
                            <li>
                                <a href="{!! url('message/lists',['status'=>0],'ucenter') !!}">站内消息</a>
                            </li>
                            <li>
                                <a href="{!! url('entry/out',['from'=>__ROOT__],'ucenter') !!}">退出登录</a>
                            </li>
                        </ul>
                    </div>
                    <!--账号管理结束-->
                    <!--我的超客开始-->
                    <!--<div class="MyCKBox">-->
                    <!--<div class="MyCK">-->
                    <!--<a href=""><span class="glyphicon glyphicon-phone-alt"></span>我的超客</a>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--我的超客结束-->
                </div>
                <!--左侧菜单部分结束-->
            </div>
            <!--左侧部分结束-->
            <!--右侧部分开始-->
            <div class="BodyRight">
                <blade name="content"/>
            </div>
            <!--右侧部分结束-->
        </div>
        <!--身体剧中部分-->
    </div>
    <!--主体部分结束-->
</div>

</body>
</html>
