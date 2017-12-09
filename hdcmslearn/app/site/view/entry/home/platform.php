<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">微信功能</a></li>
    </ul>
    <div class="page-header">
        <h4><i class="fa fa-comments"></i> 微信功能</h4>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">数据统计</h3>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>类型</th>
                <th>数量</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>关键词数量</td>
                <td>{{Db::table('rule_keyword')->where('siteid',SITEID)->count()}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">素材统计</h3>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>素材类型</th>
                <th>数量</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>图片</td>
                <td><?php echo Db::table('material')->where('siteid', SITEID)->where('type', 'image')->count(); ?></td>
            </tr>
            <tr>
                <td>图文</td>
                <td><?php echo Db::table('material')->where('siteid', SITEID)->where('type', 'news')->count(); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</block>
<style>
    table {
        table-layout: fixed;
    }
</style>