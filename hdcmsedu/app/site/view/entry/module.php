<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="#">扩展功能概况 - {{v('module.title')}}</a>
        </li>
    </ul>
    <div class="page-body">
        <?php $moduleMenu = model('menu')->getModuleMenu(); ?>
        <foreach from="$moduleMenu['access']" key="$title" value="$menu">
            <if value="!empty($menu) && $title!='extPermissions'">
                <div class="menuLists clearfix">
                    <h4>{{$title}}</h4>
                    <foreach from="$menu" value="$m">
                        <a href="{{$m['url']}}&siteid={{SITEID}}&mi={{$m['_hash']}}&mt={{Request::get('mt')}}">
                            <i class="{{$m['ico']}}"></i>
                            <span>{{$m['title']}}</span>
                        </a>
                    </foreach>
                </div>
            </if>
        </foreach>
    </div>
</block>
<style>
    .menuLists h4 {
        font-size: 14px;
        background: #F5F5F5;
        padding: 10px 10px;

    }
    .menuLists a {
        display: block;
        float: left;
        text-align: center;
        margin-right: 1.2em;
        padding: 8px 5px;
        min-width: 7em;
        height: 6em;
        overflow: hidden;
        color: #333;
    }
    .menuLists a i {
        display: block;
        font-size: 2.5em;
        margin: .2em .2em;
    }
    .menuLists a span {
        font-size: 14px;
    }
</style>