<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">添加用户</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('lists') !!}">用户列表</a></li>
        <li role="presentation" class="active"><a href="{!! u('add') !!}">添加用户</a></li>
    </ul>
    <h5 class="page-header">添加新用户</h5>
    <include file="app/system/view/user/block/add_user.php"/>
</block>