<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
    </ol>
    <?php if ($user->isSuperUser()): ?>
        <h5 class="page-header">云服务</h5>
        <div class="clearfix">
            <a href="{!! u('system/cloud/upgrade') !!}" class="tile img-rounded">
                <i class="fa fa-cloud-download"></i>
                <span>一键更新</span>
            </a>
            <a href="{!! u('system/cloud/account') !!}" class="tile img-rounded">
                <i class="fa fa-globe"></i>
                <span>云帐号</span>
            </a>
            <a href="?s=system/shop/lists&type=module" class="tile img-rounded">
                <i class="fa fa-shopping-bag"></i>
                <span>模块商店</span>
            </a>
            <a href="?s=system/shop/lists&type=template" class="tile img-rounded">
                <i class="fa fa-shopping-cart"></i>
                <span>风格商店</span>
            </a>
        </div>
    <?php endif ?>
    <?php if ($user->isSuperUser()): ?>
        <h5 class="page-header">扩展</h5>
        <div class="clearfix">
            <a href="?s=system/module/installed" class="tile img-rounded">
                <i class="fa fa-cubes"></i>
                <span>模块</span>
            </a>
            <a href="?s=system/template/installed" class="tile img-rounded">
                <i class="fa fa-file-code-o"></i>
                <span>模板</span>
            </a>
        </div>
    <?php endif; ?>
    <h5 class="page-header">用户管理</h5>
    <div class="clearfix">
        <a href="?s=system/user/info" class="tile img-rounded">
            <i class="fa fa-briefcase"></i>
            <span>我的帐户</span>
        </a>
        <?php if ($user->isSuperUser()): ?>
            <a href="{!! u('system/user/lists') !!}" class="tile img-rounded">
                <i class="fa fa-user"></i>
                <span>用户管理</span>
            </a>
            <a href="{!! u('system/group/lists') !!}" class="tile img-rounded">
                <i class="fa fa-users"></i>
                <span>用户组管理</span>
            </a>
            <a href="{!! u('system/config/register') !!}" class="tile img-rounded">
                <i class="fa fa-soccer-ball-o"></i>
                <span>注册设置</span>
            </a>
        <?php endif; ?>
    </div>

    <h5 class="page-header">站点管理</h5>
    <div class="clearfix">
        <a href="?s=system/site/lists" class="tile img-rounded">
            <i class="fa fa-sitemap"></i>
            <span>站点列表</span>
        </a>
        <?php if ($user->isSuperUser()): ?>
            <a href="?s=system/package/lists" class="tile img-rounded">
                <i class="fa fa-comments-o"></i>
                <span>服务套餐</span>
            </a>
            <a href="?s=system/config/site" class="tile img-rounded">
                <i class="fa fa-tachometer"></i>
                <span>站点设置</span>
            </a>
        <?php endif; ?>
    </div>

    <?php if ($user->isSuperUser()): ?>
        <h5 class="page-header">系统管理</h5>
        <div class="clearfix">
            <a href="{!! u('menu/edit') !!}" class="tile img-rounded">
                <i class="fa fa-list"></i>
                <span>系统菜单</span>
            </a>
            <a href="?s=system/manage/updateCache" class="tile img-rounded">
                <i class="fa fa-refresh"></i>
                <span>更新缓存</span>
            </a>
        </div>
    <?php endif; ?>
</block>