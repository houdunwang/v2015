<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">更新站点缓存</a></li>
    </ul>
    <div class="alert alert-info">
        <strong class="text-danger">
            <i class="fa fa-info-circle"></i> 更新缓存会重新记录站点的模块信息、配置信息等有关数据<br>
        </strong>
        <i class="fa fa-info-circle"></i> 为了考虑性能站点全部数据都使用缓存控制,所以如果手动更新表结构后,必须要更新缓存才会有效<br>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">更新站点缓存</h3>
        </div>
        <div class="panel-body">
            <form onsubmit="post(event)">
                <button type="submit" class="btn btn-default">开始执行更新</button>
            </form>
        </div>
    </div>
</block>
<script>
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({successUrl: ''});
        })
    }
</script>