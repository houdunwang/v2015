<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">设置站点基本信息</li>
    </ol>

    <form action="" method="post" role="form" class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">设置站点基本信息</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">站点名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="如: 后盾人" required="required">
                        <span class="help-block">站点中显示的站点名称,可以使用中文等任意字符</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">站点描述</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" cols="30" rows="5" required="required"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</block>
<script>
    function post(event){
        event.preventDefault();
        require(['hdjs'],function(hdjs){
            hdjs.submit();
        })
    }
</script>