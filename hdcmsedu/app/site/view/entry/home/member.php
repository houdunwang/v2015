<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">会员粉丝</a></li>
    </ul>
    <div class="page-header">
        <h4><i class="fa fa-comments"></i> 会员粉丝</h4>
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
                <td>用户组</td>
                <td>{{Db::table('member_group')->where('siteid',SITEID)->count()}}</td>
            </tr>
            <tr>
                <td>会员数量</td>
                <td>{{Db::table('member')->where('siteid',SITEID)->count()}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</block>