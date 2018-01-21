<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">更新缓存</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="{!! u('lists') !!}">更新缓存</a></li>
    </ul>
    <form action="" class="form-horizontal" method="post" onsubmit="post(event)">
        <div class="form-group">
            <label class="col-sm-1 control-label">缓存类型</label>
            <div class="col-sm-10">
                <label class="checkbox-inline">
                    <input type="checkbox" name="cache" value="1" checked="checked"> 删除文件缓存数据
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="view" value="1" checked="checked"> 删除模板编译文件
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="log" value="1" checked="checked"> 删除网站日志文件
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="weixin" value="1" checked="checked"> 微信TOKEN数据
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="site" value="1" checked="checked"> 站点数据表缓存
                </label>
            </div>
        </div>
        <button class="btn btn-primary col-sm-offset-1">提交更新</button>
    </form>
    <script>
        function post(event){
            event.preventDefault();
            require(['hdjs'],function(hdjs){
                hdjs.submit({successUrl:'refresh'});
            })
        }
    </script>
</block>