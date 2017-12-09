<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <if value="!empty($_GET['rid'])">
            <li role="presentation">
                <a href="{{site_url('site.rule.lists')}}">管理{{v('module.title')}}</a>
            </li>
            <li role="presentation">
                <a href="{{site_url('site.rule.post')}}">
                    <i class="fa fa-plus"></i> 添加{{v('module.title')}}
                </a>
            </li>
            <li role="presentation" class="active">
                <a href="#"><i class="fa fa-plus"></i> 编辑{{v('module.title')}}</a>
            </li>
            <else/>
            <li role="presentation">
                <a href="{{site_url('site.rule.lists')}}">管理{{v('module.title')}}</a>
            </li>
            <li role="presentation" class="active">
                <a href="#"><i class="fa fa-plus"></i> 添加{{v('module.title')}}</a>
            </li>
        </if>
    </ul>
    <form action="" method="post" class="form-horizontal" onsubmit="post(event)">
        <include file="app/site/view/rule/keyword.php"/>
        {!! $moduleForm !!}
        <button class="btn btn-default">保存</button>
    </form>
    <script>
        function post(e) {
            e.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit({successUrl: '{!! site_url("site.rule.lists") !!}'});
            })
        }
    </script>
</block>